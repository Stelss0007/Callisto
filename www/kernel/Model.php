<?php

class Model extends DBConnector
{
    public $type = '';

    public $vars = [];

    public $table = 'object';

    public $config = null;

    public $session = null;

    public $relations = [];

    private $used_relations = [];

    public $elementAtPage = 10;

    //////////////////////////////////////////////////////////////////////////////
    public function __construct($guid = 0)
    {
        $this->setConfig();
        //echo "host=".$coreConfig['DB.Host'];
        $this->errors =& ErrorHandler::getInstance();

        $this->Host = $this->config['DB.Host'];
        $this->User = $this->config['DB.UserName'];
        $this->Password = $this->config['DB.Password'];
        $this->Database = $this->config['DB.Name'];

        $this->connect();

//    $this->query('SELECT * FROM test');
//    print_r($this->fetch_array());exit;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getModelTable($model_name)
    {
        appUsesModel($model_name);
        $model = new $model_name();

        return $model->getTable();

    }

    //////////////////////////////////////////////////////////////////////////////
    public function __destruct()
    {
        //$this->disconnect();
    }

    //////////////////////////////////////////////////////////////////////////////
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;

            return true;
        }
        $this->vars[$name] = $value;

        return true;
    }


    public final function setConfig()
    {
        $this->config = &\App::$config;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function getObject($guid = 0)
    {
        if (empty($guid)) {
            return false;
        }
        //Получим основную инфу о бъекте
        $sql = "SELECT SQL_CACHE  t.type as type,
                              o.guid,
                              o.owner_id,
                              o.time_create,
                              o.time_update,
                              o.active
            FROM `object` o
            LEFT JOIN object_type t ON (t.id = o.type)
            WHERE o.guid = '%d'";
        $this->query($sql, $guid);
        $res_main = $this->fetchArray();

        //Выведим все поля и значения принадлежащие объекту
        $sql = "SELECT SQL_CACHE f.`field`, 
                             v.`value` 
            FROM `object_value` v
            LEFT JOIN `object_field` f ON (f.`id` = v.`field_id`)
            WHERE v.`guid` = '%d'";

        $this->query($sql, $guid);
        $res_fields = $this->fetchArray();

        $result = [];

        //Соберем свойства объекта сначала с главной таблицы(главная инфа)
        foreach ($res_main[0] as $key => $val) {
            $result[$key][] = $val;
        }
        //Соберем свойства объекта с таблицы значений объекта(второстепенная инфа)
        foreach ($res_fields as $key => $val) {
            $result[$val['field']][] = $val['value'];
        }

        foreach ($result as $key => $val) {
            if (sizeof($val) == 1) {
                $result[$key] = $val[0];
            }
        }

        return $result;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function getObjectsList($where_array = [], $order = ['time_create' => 'asc'], $offset = 0, $limit = 20)
    {
        $left_join = '';
        $right_join = '';
        $order_by = '';
        $where = '';

        $left_join_shablon = "LEFT JOIN `object_value` v%d ON (v%d.guid = o.`guid` and v%d.`field_id` = '%d')";
        $right_join_shablon = "RIGHT JOIN `object_value` w%d ON (w%d.guid = o.`guid`)";
        $where_shablon = " and w%d.`field_id` = '%d' and w%d.value IN (%s)";
        ////////////////////////////////////////////////////////////////////////////
        //Сортировка, соберем переменные для сортировки
        if (empty($order)) {
            $order = ['time_create' => 'asc'];
        }
        $num = 1;
        foreach ($order as $key => $value) {
            if ($key == 'time_create') {
                $order_by .= "{$key} {$value}, ";
            } else {
                $fid = $this->getFieldId($key);
                $left_join .= " " . sprintf($left_join_shablon, $num, $num, $num, $fid);
                $order_by .= "v{$num}.value {$value}, ";
            }
            $num++;
        }

        if (!empty($order_by)) {
            $order_by = "ORDER BY " . rtrim($order_by, ', ');
        }


        ////////////////////////////////////////////////////////////////////////////
        //Обработка WHERE
        $num_where = 1;
        if (empty($where_array)) {
            $where_array = [];
        }

        foreach ($where_array as $key => $value) {
            if ($key == 'time_create') {

            } else {
                $fid_w = $this->getFieldId($key);
                $right_join .= " " . sprintf(
                        $right_join_shablon,
                        $num_where,
                        $num_where,
                        $num_where,
                        $fid_w,
                        $num_where,
                        $value
                    );

                $where .= ' ' . sprintf($where_shablon, $num_where, $fid_w, $num_where, $value);
            }
            $num_where++;
        }
        ////////////////////////////////////////////////////////////////////////////


        //Получим объекты
        $type_id = $this->getTypeId($this->type);

        $where = ltrim($where, 'and ');
        if (!empty($where_shablon)) {
            $where = 'WHERE ' . $where;
        }

        $sql = "SELECT SQL_NO_CACHE o.guid 
            FROM object o
            $right_join
            $left_join
            $where
            $order_by
            LIMIT %d, %d";

        $this->query($sql, $offset, $limit);
        $objects_result = $this->fetchArray();


        $guids = [];
        foreach ($objects_result as $value) {
            $guids[] = $value['guid'];
        }

        $guids_str = implode("','", $guids);

        //Получим поля к объектам
        $sql = "SELECT SQL_NO_CACHE  v.`guid`, 
                              f.`field`,
                              v.`value`,
                              o.*
            FROM object_value v
            LEFT JOIN `object_field` f ON (f.`id` = v.`field_id`)
            LEFT JOIN `object` o ON (o.`guid` = v.`guid`)
            WHERE v.guid IN ('$guids_str') ORDER BY FIELD(v.`guid`, '$guids_str')";

        $this->query($sql);
        $objects_result = $this->fetchArray();

        $object_list = [];

        //Это типа когда у одного поля может біть несколько значений, мы для всех задаем что поле массив,
        //Потом лишнее преобразуем обратно
        foreach ($objects_result as $key => $value) {
            $object_list["{$value['guid']}"]["{$value['field']}"][] = $value['value'];
        }

        //Теперь разберем, какое поле массив, а какое не масив
        foreach ($object_list as $key1 => $result) {
            foreach ($result as $key => $val) {
                if (sizeof($val) == 1) {
                    $object_list["$key1"][$key] = $val[0];
                }
            }
        }

        return $object_list;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function createObject()
    {
        $fields = [];
        $values = [];
        $guid = 0;
        $curent_time = time();

        $type_id = $this->getTypeId($this->type);
        $guid = $this->insert(
            'object',
            [
                'type' => $type_id,
                'time_create' => $curent_time,
                'time_update' => $curent_time,
                'active' => '1',
            ]
        );

        foreach ($this->vars as $key => $value) {
            $field_id = $this->getFieldId($key);

            $this->insert(
                'object_value',
                [
                    'guid' => $guid,
                    'type_id' => $type_id,
                    'field_id' => $field_id,
                    'value' => $value,
                ]
            );

        }

        return $guid;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function updateObject($guid = 0)
    {
        if (empty($guid)) {
            return false;
        }

        $fields = [];
        $values = [];
        $curent_time = time();

        $this->query("START TRANSACTION");
        $this->update('object', ['time_update' => $curent_time], "WHERE guid = '$guid'");

        foreach ($this->vars as $key => $value) {
            $field_id = $this->getFieldId($key);

            $this->query("DELETE FROM object_value WHERE guid='%d' AND field_id = '%d'", $guid, $field_id);
            $this->insert(
                'object_value',
                [
                    'guid' => $guid,
                    'field_id' => $field_id,
                    'value' => $value,
                ]
            );

        }
        $this->query("COMMIT");

        return $guid;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function deleteObject($id)
    {
        $this->beforDelete();

        if (is_array($id)) {
            $id = "'" . implode("', '", $id) . "'";
        } else {
            $id = "'$id'";
        }
        $sql1 = "DELETE FROM object WHERE guid IN ($id)";
        $sql2 = "DELETE FROM object_value WHERE guid IN ($id)";

        $this->query("START TRANSACTION");
        $this->query($sql1);
        $this->query($sql2);
        $this->query("COMMIT");

        $this->afterDelete();

        return true;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function save($guid = 0)
    {
        if ($this->table == 'object') {
            if (empty($guid) && empty($this->vars['guid'])) {
                $this->beforCreate();
                $result = $this->createObject();
                $this->afterCreate();

                return $result;
            } else {
                $id = (isset($this->vars['guid'])) ? $this->vars['guid'] : 0;
                if (!empty($guid)) {
                    $id = $guid;
                }

                $this->beforUpdate();
                $result = $this->updateObject($id);
                $this->afterUpdate();

                return $result;
            }
        } else {
            if (empty($guid) && empty($this->vars['id'])) {
                $this->beforCreate();
                $result = $this->insert($this->table, $this->vars);
                $this->afterCreate();

                return $result;
            } else {
                $id = (isset($this->vars['id'])) ? $this->vars['id'] : 0;
                if (!empty($guid)) {
                    $id = $guid;
                }

                $this->beforUpdate();
                $this->update($this->table, $this->vars, "id = '{$id}'");
                $this->afterUpdate();

                return $id;
            }

        }
    }

    public function delete($id)
    {
        if ($this->table == 'object') {
            $this->deleteObject($id);
        } else {
            $this->beforDelete($id);
            if (is_array($id)) {
                $this->prepareValue($id);
                $id = implode("','", $id);
                $this->query("DELETE FROM {$this->table} WHERE id IN ('%d')", $id);
            } else {
                $this->query("DELETE FROM {$this->table} WHERE id = '%d'", $id);
            }

            $this->afterDelete($id);
        }
    }

    //////////////////////////////////////////////////////////////////////////////
    public function getTypeId($type = '')
    {
        if (empty($type)) {
            return false;
        }
        $type_id = 0;

        $this->query("SELECT SQL_CACHE id FROM object_type WHERE type='%s'", $type);
        $result = $this->fetchArray();

        if (!empty($result[0])) {
            return $result[0]['id'];
        }

        return $this->insert('object_type', ['type' => $type]);
    }

    //////////////////////////////////////////////////////////////////////////////
    public function getFieldId($field = '')
    {
        if (empty($field)) {
            return false;
        }
        $field_id = 0;

        $this->query("SELECT SQL_CACHE id FROM object_field WHERE field = '%s'", $field);
        $result = $this->fetchArray();

        if (!empty($result[0])) {
            return $result[0]['id'];
        }

        return $this->insert('object_field', ['field' => $field]);
    }

    //////////////////////////////////////////////////////////////////////////////
    public function __call($name, $arguments)
    {
        if (preg_match('/^get(.*)/simu', $name, $matches)) {
            if ($this->table == 'object') {
                return $this->objectTypeORM($name, $arguments);
            } else {
                return $this->modelTypeORM($name, $arguments);
            }
        }

    }

    public function objectTypeORM($name, $arguments)
    {
        $limit = 1000;
        $offset = 0;

        if (preg_match('/^get_(\d+)_(\d+)_(.*)/simu', $name, $matches)) {
            $offset = $matches[1];
            $limit = $matches[2];
            $name = 'get' . $matches[3];
        } elseif (preg_match('/^get_(\d+)_(.*)/simu', $name, $matches)) {
            $limit = $matches[1];
            $name = 'get' . $matches[2];
        }
        preg_match('/^getBy(.*)OrderBy(.*)/simu', $name, $matches);
        if ($matches) {
            $field = strtolower($matches[1]);
            $value = $arguments[0];
            $order = $matches[2];

            return $this->getObjectsList([$field => $value], [$order => 'asc'], $offset, $limit);
        }
        preg_match('/^getBy(.*)/simu', $name, $matches);
        if ($matches) {
            $field = strtolower($matches[1]);
            $value = $arguments[0];

            return $this->getObjectsList([$field => $value], '', $offset, $limit);
        }
    }

    public function modelTypeORM($name, $arguments)
    {

        $columns = $this->tableFieldList();

        $limit = 1000;
        $offset = 0;

        if (preg_match('/^get_(\d+)_(\d+)_(.*)/simu', $name, $matches)) {
            $offset = $matches[1];
            $limit = $matches[2];
            $name = 'get' . $matches[3];
        } elseif (preg_match('/^get_(\d+)_(.*)/simu', $name, $matches)) {
            $limit = $matches[1];
            $name = 'get' . $matches[2];
        }

        preg_match('/^getBy(.*)OrderBy(.*)/simu', $name, $matches);
        if (isset($matches) && $matches) {
            $field = strtolower($matches[1]);
            $value = $arguments[0];
            $order = $matches[2];

            return $this->select(
                $this->table,
                '*',
                "WHERE $field IN($value) ORDER BY $order ASC LIMIT $offset, $limit",
                true
            );
            //return $this->getObjectsList(array($field => $value), array($order => 'asc'), $offset, $limit);
        }

        preg_match('/^getBy(.*)/simu', $name, $matches);
        if (isset($matches) && $matches) {
            $field = strtolower($matches[1]);
            $value = $arguments[0];

            return $this->select($this->table, '*', "WHERE $field IN($value) LIMIT $offset, $limit", true);
            //return $this->getObjectsList(array($field => $value), '', $offset, $limit);
        }
    }

    public function tableFieldList($table = null)
    {
        if (empty($table)) {
            $table = $this->table;
        }
        //Проверяем если есть в кеше возвращаем из кеша
        $cached_columns = appVarGetCached('core', 'columns');
        if ($cached_columns[$table]) {
            return $cached_columns[$table];
        }

        $this->query('SHOW COLUMNS FROM ' . $table);
        $columns = $this->fetchArray();

        $result = [];
        foreach ($columns as $value) {
            $result[$table][] = $value['Field'];
        }

        //Кладем в кеш
        appVarSetCached('core', 'columns', $result);

        return $result[$table];
    }

    public function weightMax($where = '')
    {
        if ($this->table != 'object') {
            $where = str_replace('WHERE', '', $where);
            if (!empty($where)) {
                $where = ' WHERE ' . $where;
            }
            $this->query("SELECT MAX({$this->table}_weight) as max FROM {$this->table}" . $where);
            $result = $this->fetchArray();
            $maxweight = $result[0]['max'];

            return $maxweight;
        }
    }

    public function weightDelete($weight, $where = '')
    {
        if ($this->table != 'object') {
            $where = str_replace('WHERE', '', $where);

            if ($where != '') {
                $where = " AND $where";
            };

            $this->query(
                "UPDATE {$this->table} SET {$this->table}_weight = {$this->table}_weight-1 WHERE {$this->table}_weight > '$weight' $where"
            );

            return true;
        }
    }

    public function weightUp($weight = 0, $where = '')
    {
        if ($weight < 2) {
            return true;
        }

        if ($this->table != 'object') {
            $where = str_replace('WHERE', '', $where);
            if ($where != '') {
                $where = " AND $where";
            }

            $next_weight = $weight--;
            $this->query(
                "SELECT * FROM {$this->table} WHERE {$this->table}_weight IN ('$weight', '$next_weight') $where ORDER BY {$this->table}_weight LIMIT 2"
            );
            $dbresult = $this->fetchArray();

            //????????????
            $dbresult[0]["{$this->table}_weight"]++;
            $dbresult[1]["{$this->table}_weight"]--;

            foreach ($dbresult as $newresult) {
                $this->query(
                    "UPDATE {$this->table} SET {$this->table}_weight = '" . $newresult["{$this->table}_weight"] . "' WHERE id = '$newresult[id]'"
                );
            }

            return true;
        }
    }

    public function weightDown($weight = 0, $where = '')
    {
        $MaxWeight = $this->weightMax();
        if ($weight == $MaxWeight || $weight == 0) {
            return true;
        }

        if ($this->table != 'object') {
            $where = str_replace('WHERE', '', $where);
            if ($where != '') {
                $where = " AND $where";
            }

            $next_weight = $weight++;
            $this->query(
                "SELECT * FROM {$this->table} WHERE {$this->table}_weight IN ('$weight', '$next_weight') $where ORDER BY {$this->table}_weight LIMIT 2"
            );
            $dbresult = $this->fetchArray();

            //????????????
            $dbresult[0]["{$this->table}_weight"]++;
            $dbresult[1]["{$this->table}_weight"]--;

            foreach ($dbresult as $newresult) {
                $this->query(
                    "UPDATE {$this->table} SET {$this->table}_weight = '" . $newresult["{$this->table}_weight"] . "' WHERE id = '$newresult[id]'"
                );
            }

            return true;
        }
    }

    public function weightSet($id, $weightOld = 0, $weightNew = 0, $position = '')
    {
        $MaxWeight = $this->weightMax();
        if ($weightNew == 0 || $position == '') {
            return true;
        }

        if ($this->table != 'object') {
//      if($weightOld > $weightNew)
//        {
            $this->query(
                "UPDATE {$this->table} SET {$this->table}_weight = {$this->table}_weight-1 WHERE {$this->table}_weight > $weightOld AND {$this->table}_position = '$position'"
            );
            $this->query(
                "UPDATE {$this->table} SET {$this->table}_weight = {$this->table}_weight+1 WHERE {$this->table}_weight >= $weightNew AND {$this->table}_position = '$position'"
            );

            $this->query("UPDATE {$this->table} SET {$this->table}_weight = $weightNew WHERE id = $id");
//        }
//      elseif($weightOld < $weightNew)
//        {
//        $this->query("UPDATE {$this->table} SET {$this->table}_weight = {$this->table}_weight-1 WHERE {$this->table}_weight > $weightOld AND {$this->table}_position = '$position'");
//        $this->query("UPDATE {$this->table} SET {$this->table}_weight = {$this->table}_weight+1 WHERE {$this->table}_weight >= $weightNew AND {$this->table}_position = '$position'");
//        
//        $this->query("UPDATE {$this->table} SET {$this->table}_weight = $weightNew WHERE id = $id");
//        }
            return true;
        }
    }


    ///////////////////////////// FINDING ///////////////////////////////////////

    final private function prepareCondition($conditions = [], $params = [])
    {
        $offset = 0;
        $limit = 1000;
        $where = '';

        $result = [];
        $result['where'] = '';
        $result['group'] = '';
        $result['order'] = '';
        $result['fields'] = '';
        $result['limit'] = '';
        $result['join'] = '';


        if (isset($conditions['fields']) && !empty($conditions['fields'])) {
            $result['fields'] = $conditions['fields'];
        } else {
            $result['fields'] = [];
        }

        if (isset($conditions['condition']) && !empty($conditions['condition'])) {
            //If array of condition
            if (is_array($conditions['condition'])) {
                $where_ = '';
                foreach ($conditions['condition'] as $key => $value) {
                    if (is_array($value)) {
                        $value = implode("' , '", $value);
                        if ($value) {
                            $value = "('$value')";
                            $where_ .= " AND $key IN $value ";
                        }
                    } else {
                        preg_match_all("/^([<>=!]+|like).*$/is", $value, $operator);

                        if (isset($operator[1][0]) && $operator[1][0]) {
                            $value = trim(preg_replace("/^(<>|<|>|!=|like)(.*)$/is", "$2", $value));
                            //print_r($operator);exit;
                            $curret_operator = $operator[1][0];

                            if (strtoupper($curret_operator) != 'LIKE') {
                                $value = $this->prepareValue($value);
                            }

                            $where_ .= " AND $key $curret_operator $value ";
                        } else {
                            $value = $this->prepareValue($value);
                            $where_ .= " AND $key = '$value' ";
                        }
                    }
                }

                if (!empty($where_)) {
                    $where = " WHERE " . ltrim($where_, ' AND ');
                }
            } elseif (is_string($conditions['condition'])) {
                $where = str_ireplace('WHERE', '', trim($conditions['condition']));
                $where = " WHERE " . $where;
            }

            if (isset($conditions['params']) && !empty($conditions['params'])) {
                $search = array_keys($conditions['params']);
                $replace = $this->prepareValue(array_values($conditions['params']));

                $where = str_replace($search, $replace, $where);
            }
        }

        //Set join tables
        if (isset($conditions['join']) && $conditions['join']) {
            $join = $conditions['join'];
        } else {
            $join = '';
        }

        //Set where hight priority
        if (isset($conditions['where']) && !empty($conditions['where'])) {
            $where = str_ireplace('WHERE', '', trim($conditions['where']));
            $where = " WHERE " . $where;
        }

        //Set offset
        if (isset($conditions['offset']) && !empty($conditions['offset'])) {
            $offset = $conditions['offset'];
        }

        //Set limit
        if (isset($conditions['limit']) && !empty($conditions['limit'])) {
            $limit = $conditions['limit'];
        }

        //Set order by
        if (isset($conditions['order']) && !empty($conditions['order'])) {
            $result['order'] = " ORDER BY {$conditions['order']}";
        }

        //Set group by
        if (isset($conditions['group']) && !empty($conditions['group'])) {
            $result['group'] = " GROUP BY {$conditions['group']}";
        }


        $result['join'] = $join;
        $result['where'] = $where;
        $result['limit'] = " LIMIT $offset, $limit";

        return $result;
    }


    /**
     *
     * @param array $conditions
     * @param array $params
     * @return array
     *
     *     $params = array(
     *                 'fields' => array('id', 'login'),
     *                 'limit' => 4,
     *                 'offset' => 0,
     *                 'order' => 'id',
     *                 'condition' => "id > :id1 and id < :id2",
     *                 'condition' => array('id'=>array('4', '8')),
     *                 'params' => array(':id1'=>5, ':id2'=>10)
     *                 );
     */
    public final function getList($conditions = [], $params = [])
    {
        $condition = $this->prepareCondition($conditions, $params);
        $where = "{$condition['join']} {$condition['where']} {$condition['group']} {$condition['order']} {$condition['limit']}";

        $result = $this->select($this->table . ' as t', $condition['fields'], $where, true);
        $this->getRelations($result);

        return $result;
    }

    /**
     *
     * @param array $conditions
     * @param array $params
     * @return array
     *
     *     $params = array(
     *                 'fields' => array('id', 'login'),
     *                 'limit' => 4,
     *                 'offset' => 0,
     *                 'order' => 'id',
     *                 'condition' => "id > :id1 and id < :id2",
     *                 'condition' => array('id'=>array('4', '8')),
     *                 'params' => array(':id1'=>5, ':id2'=>10)
     *                 );
     */
    public final function getListPagination($conditions = [], $params = [])
    {
        $condition = $this->prepareCondition($conditions, $params);
        $where = "{$condition['join']} {$condition['where']} {$condition['group']} {$condition['order']}";

        $this->preparePagination($where, $sql_limit);
        $where .= $sql_limit;

        $result = $this->select($this->table . ' as t', $condition['fields'], $where, true);
        $this->getRelations($result);

        return $result;
    }

    public final function getById($id)
    {
        $params['limit'] = 1;
        $params['condition'] = ['id' => $id];

        $result = $this->getList($params);

        return isset($result[0]) ? $result[0] : [];
    }

    public final function getCount($params)
    {
        $params['fields'] = 'COUNT(*) as count';
        $result = $this->getList($params);

        return $result[0]['count'];
    }

    public final function getFirst($params)
    {
        $params['limit'] = 1;
        $params['order'] = 'id';

        $result = $this->getList($params);

        return $result[0];
    }

    public final function getLast($params)
    {
        $params['limit'] = 1;
        $params['order'] = 'id DESC';

        $result = $this->getList($params);

        return $result[0];
    }

    public final function deleteAll($conditions = [], $params = [])
    {
        $this->beforDelete();
        $condition = $this->prepareCondition($conditions, $params);
        $where = "{$condition['join']} {$condition['where']} {$condition['limit']}";
        $this->query("DELETE FROM {$this->table} $where)");
        $this->afterDelete();
    }

    //...........СВЯЗИ.................
    public final function prepareRelations()
    {

    }

    public final function with()
    {
        if ($relations = func_get_args()) {
            foreach ($relations as $relation) {
                if (isset($this->relations[$relation])) {
                    $this->used_relations[$relation] = $this->relations[$relation];
                }
            }
        }

        return $this;
    }

    public final function getRelations(&$model_result = [])
    {
        if (empty($model_result) || empty($this->used_relations)) {
            return;
        }

        $foreign_keys = [];
        $id_keys = [];

        foreach ($this->used_relations as $key => $value) {
            if ($value['type'] == RELATION_TYPE_ONE_TO_ONE && !isset($model_result[0]["{$value['foreign_key']}"])) {
                unset($this->used_relations[$key]);
                continue;
            }

            $foreign_keys["{$value['foreign_key']}"][] = $key;
        }

        $relation_ids = [];
        foreach ($model_result as $result) {
            $id_keys[] = $result['id'];
            foreach ($foreign_keys as $foreign_key => $val) {
                $relation_ids[$foreign_key][] = $result[$foreign_key];
            }
        }


        foreach ($this->used_relations as $key => $value) {
            switch ($value['type']) {
                case RELATION_TYPE_ONE_TO_ONE:
                    if (empty($relation_ids[$value['foreign_key']])) {
                        continue;
                    }

                    $keys = implode("', '", $relation_ids[$value['foreign_key']]);
                    $relations_result[$key] = $this->select(
                        $value['table'],
                        [],
                        "WHERE id IN ('$keys')",
                        true,
                        '',
                        'id'
                    );

                    foreach ($model_result as $result_key => $result_value) {
                        $model_result[$result_key][$key] = ($relations_result[$key][$result_value[$value['foreign_key']]][0]) ? $relations_result[$key][$result_value[$value['foreign_key']]][0] : [];
                    }
                    break;

                case RELATION_TYPE_ONE_TO_MANY:
                    $keys = implode("', '", $id_keys);
                    $relations_result[$key] = $this->select(
                        $value['table'],
                        [],
                        "WHERE {$value['foreign_key']} IN ('$keys')",
                        true,
                        '',
                        $value['foreign_key']
                    );

                    foreach ($model_result as $result_key => $result_value) {
                        $model_result[$result_key][$key] = ($relations_result[$key][$result_value['id']]) ? $relations_result[$key][$result_value['id']] : [];
                    }
                    break;

                default:
                    break;
            }
        }

        return true;
    }

    public final function validate()
    {
//    define('VALIDATOR_DIR',APP_DIRECTORY.'/lib/validateForm/');
//    require_once(VALIDATOR_DIR.'validateForm.class.php');
        appUsesLib('validateForm');

        $form = new validateForm($_POST);
    }


    public final function beforDelete()
    {
        return true;
    }

    public final function afterDelete()
    {
        return true;
    }

    public final function beforCreate()
    {
        return true;
    }

    public final function afterCreate()
    {
        return true;
    }

    public final function beforUpdate()
    {
        return true;
    }

    public final function afterUpdate()
    {
        return true;
    }

    public final function beforSave()
    {
        return true;
    }

    public final function afterSave()
    {
        return true;
    }

    public function activation($id)
    {
        $has_field = $this->hasTableField($this->table, ['active', $this->table . '_active']);

        if (!is_numeric($id)) {
            return false;
        }

        $this->query("UPDATE {$this->table} SET $has_field = IF($has_field ='1','0','1') WHERE id='$id'");
    }
    // Груповые операции

    /**
     * Рруповое удаление
     * @param type $ids
     * @return boolean
     */
    public function groupActionDelete($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids = implode("','", $ids);
        $this->query("DELETE FROM {$this->table} WHERE id in ('$ids')");
    }

    public function groupActionActivate($ids)
    {
        $field = 'active';
        $has_field = $this->hasTableField($this->table, ['active', $this->table . '_active']);

        if (empty($ids) || !$has_field) {
            return false;
        }

        $ids = implode("','", $ids);
        $this->query("UPDATE {$this->table} SET $has_field = '1' WHERE id in ('$ids')");
    }

    public function groupActionDeactivate($ids)
    {
        $field = 'active';
        $has_field = $this->hasTableField($this->table, ['active', $this->table . '_active']);

        if (empty($ids) || !$has_field) {
            return false;
        }

        $ids = implode("','", $ids);
        $this->query("UPDATE {$this->table} SET $has_field = '0' WHERE id in ('$ids')");
    }

    public function groupActionInstall($ids)
    {

    }

    /**
     *
     */
    public function preparePagination($where, &$sql_limit)
    {
        global $mod_controller;

        //Формируем строку лимитов для sql запроса
        $limit['page'] = $this->getInput('page', 1);
        $limit['element_at_page'] = $this->elementAtPage;

        if (!isset($sql_limit)) {
            $sql_limit = '';
        }

        if (!empty($limit)) {
            $result_array['page'] = (int)$limit['page'];
            $result_array['element_at_page'] = (int)$limit['element_at_page']; //Количество авторы на страницу
            $result_array['element_start_num'] = (int)($limit['page'] - 1) * $result_array['element_at_page']; //Номер авторы с которого начинается список
            $sql_limit = "LIMIT {$result_array['element_start_num']}, {$result_array['element_at_page']}";
            $result_array['element_start_num']++;

            //Cчитаем суммарное число записей подпадающих под фильтр
            $total = $this->count("`{$this->table}`", $where);
            $result_array['element_total_count'] = $total;
            $result_array['element_end_num'] = $result_array['element_start_num'] + $result_array['element_at_page'] - 1;
            if ($result_array['element_end_num'] > $result_array['element_total_count']) {
                $result_array['element_end_num'] = $result_array['element_total_count'];
            }
            $result_array['page_total'] = ceil($result_array['element_total_count'] / $result_array['element_at_page']);

            $this->pagination = $result_array;
            $mod_controller->paginate($this);
        }

        return [$result_array['element_start_num'], $result_array['element_at_page']];
    }
}

