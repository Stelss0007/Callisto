<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SQLBuilder
 *
 * @author Ruslan
 */
namespace app\db\ActiveRecord;
use mysqli;

class SQLBuilder {
    
    private $connection;
    private $mysqli = null;
    private $operation = 'SELECT';
    private $table = [];
    private $select = [];
    private $joins = [];
    private $order = [];
    private $limit = 1000;
    private $offset = 0;
    private $group = [];
    private $having = [];
    private $update = [];
    // for where
    private $where = [];
    private $params = [];
    // for insert/update
    private $data = [];
    private $sequence = [];
    private $config = [];
    private $sqlString = '';
    private $resultArrayByField = null;
    private $sqlOperand = ['<', '>', '<=', '>=', '!=', '<>', 'like',  'not', 'is', 'is not'];
    
    
    protected $className = 'stdClass';
    
    function  __construct($table = '')
        {
        $this->setConfig();
        $this->connect();
        $this->table[] = $table;
        
        return $this;
        }
        
    function __destruct() 
        {
        $this->mysqli->close();
        }
    
    final private function setConfig()
        {
        global $appConfig;
        $this->config = & $appConfig;
        }
        
    private function connect() 
        {
        $this->mysqli = new mysqli($this->config['DB.Host'], $this->config['DB.UserName'], $this->config['DB.Password'], $this->config['DB.Name']);
        if ($this->mysqli->connect_error) 
            {
            die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
            }
        $this->mysqli->set_charset("utf8");
        }
    private function isTableFieldOperand($key, $value)
        {
        foreach($this->table as $table) 
            {
            $fieldFullName = $table.'.'.$key;
            if(strpos($value, $fieldFullName) !== false)
                {
                return true;
                }
            }
        return false;
        }
    //Build methods
    /**
     * Query Fields 
     * @param type $data
     */
    public function select($data)
        {
        if(is_array($data)) 
            {
            $this->select[] = implode(', ', $data);
            }
        else
            {
            $this->select[] = $data;
            }
        return $this;
        }

    public function from($data)
        {
        if(is_array($data)) 
            {
            $this->table[] = implode(', ', $data);
            }
        else
            {
            $this->table[] = $data;
            }
               
        return $this;
        }
        
    public function params($params)
        {
        if(!empty($params)) 
            {
            if (empty($this->params)) 
                {
                $this->params = $params;
                } 
            else 
                {
                foreach ($params as $name => $value) 
                    {
                    if (is_integer($name)) 
                        {
                        $this->params[] = $value;
                        } 
                    else 
                        {
                        $this->params[$name] = $value;
                        }
                    }
                }
        }
        return $this;
        }
        
    public function limit($limit)
        {
        $this->limit = $limit;
        }
        
    public function offset($offset)
        {
        $this->offset = $offset;
        }
        
    public function join($joinType, $tableName, $joinCondition = '', $params=[])
        {
        $joinCondition = trim($joinCondition);
        $joinCondition = ltrim($joinCondition, 'ON');
        $this->joins[] = $joinType.' '.$tableName.' ON ('.$joinCondition.')';
        
        $this->params($params);
        return $this;
        }
    public function leftJoin($tableName, $joinCondition = '', $params=[])
        {
        $this->join('LEFT JOIN', $tableName, $joinCondition, $params);
        return $this;
        }
        
    public function rightJoin($tableName, $joinCondition = '', $params=[])
        {
        $this->join('RIGHT JOIN', $tableName, $joinCondition, $params);
        return $this;
        }
        
    public function innerJoin($tableName, $joinCondition = '', $params=[])
        {
        $this->join('INNER JOIN', $tableName, $joinCondition, $params);
        return $this;
        }
        
    public function outerJoin($tableName, $joinCondition = '', $params=[])
        {
        $this->join('OUTER JOIN', $tableName, $joinCondition, $params);
        return $this;
        }
        
    public function orderBy($data)
        {
        if(is_array($data)) 
            {
            foreach ($data as $column => $type) 
                {
                if(is_numeric($column)) 
                    {
                    $this->order[] = $type;
                    }
                else
                    {
                    $this->order[] = $column.' '.$type;
                    }
                }
            }
        else 
            {
            $this->order[] = $data;
            }
        return $this;
        }
        
    public function groupBy($data)
        {
        if(is_array($data)) 
            {
            foreach ($data as $column) 
                {
                $this->group[] = $column;
                }
            }
        else 
            {
            $this->group[] = $data;
            }
            
        return $this;
        }
        
    public function where($condition, $params=[])
        {
        if(empty($condition))
            {
            return $this;
            }
            
        $this->where = [];
        $this->where[] = ['', $condition];
        
        $this->params($params);
        return $this;
        }
        
    public function andWhere($condition, $params=[])
        {
        if (empty($this->where)) 
            {
            $this->where[] = ['', $condition];
            } 
        else 
            {
            $this->where[] = ['AND', $condition];
            }
        
        $this->params($params);
        return $this;
        }
        
    public function orWhere($condition, $params=[])
        {
        if (empty($this->where)) 
            {
            $this->where[] = ['', $condition];
            } 
        else 
            {
            $this->where[] = ['OR',  $condition];
            }
        
        $this->params($params);
        return $this;
        }
    
        
    private function queryScalar($selectExpression)
        {
        $select = $this->select;
        $limit = $this->limit;
        $offset = $this->offset;

        $this->select = [$selectExpression];
        $this->limit = null;
        $this->offset = null;

        $result = $this->one();
        
        $this->select = $select;
        $this->limit = $limit;
        $this->offset = $offset;
        
        return ($result) ? $result->$selectExpression : null;
        }
        
    public function count($q = '*')
        {
        return $this->queryScalar("COUNT($q)");
        }
        
    public function sum($q)
        {
        return $this->queryScalar("SUM($q)");
        }
        
    public function average($q)
        {
        return $this->queryScalar("AVG($q)");
        }
        
    public function min($q)
        {
        return $this->queryScalar("MIN($q)");
        }
        
    public function max($q)
        {
        return $this->queryScalar("MAX($q)");
        }
        
    public function prepareValue($value)
        {
        if(is_array($value))
            {
            foreach($value as $k=>$v)
                {
                if(!get_magic_quotes_gpc())
                  {
                  $value[$k] = $this->mysqli->real_escape_string($value[$k]);
                  }

                $value[$k] = str_replace("\\r\\n",'<br>', $value[$k]);
                }
            }
          else
            {
            if(!get_magic_quotes_gpc())
              {
              $value = $this->mysqli->real_escape_string($value);
              }
            }
        return $value;
        }  
          
    public function prepareParam($param)
        {
        if(!is_array($param))
            {
            return $this->prepareValue($param);
            }
            
        foreach($param as $key => $value)
            {
            $param[$key] = $this->prepareValue($value);
            }
        return $param;
        }
        
    public function prepareParams($params)
        {
        foreach($params as $key => $param)
            {
            $params[$key] = $this->prepareParam($param);
            }
        return $params;
        }
        
    public function prepareSQL($sql) {
        $params = $this->prepareParams($this->params);
        
        if($params)
            {
            foreach ($params as $name => $val) 
                {
                $name = ltrim($name, ':');
                $sql = str_replace(":$name", "'" . $val . "'", $sql);
                }
            }
            
        return $sql;
    }
    
    public function getSQLString($prepareSQLParams = true)
        {
        $this->createCommand();
        if($prepareSQLParams)
            {
            return $this->prepareSQL($this->sqlString);
            }
        return $this->sqlString;
        }
        
    private function buildJoin()
        {
        return implode($this->joins, ' ');
        }
        
    private function buildWhere()
        {
        if(empty($this->where))
            return false;
        $where = '';
        foreach ($this->where as $key => $whereValue) 
            {
            $condition = $whereValue[1];
            if(is_array($condition))
                {
                $conditionStr = '';
                foreach($condition as $key1 => $value1)
                    {
                    $key1 = strtolower($key1);
                    if(in_array($key1, $this->sqlOperand)) 
                        {
                        if($key1 == 'like')
                            {
                            foreach($value1 as $key2 => $value2)
                                {
                                if(stripos($value1, '%') === false)
                                    {
                                    $value2 = '%'.$value2.'%';
                                    }
                                $conditionStr .= " AND $key2 LIKE '$value2' ";
                                }
                            }
                        else 
                            {
                            foreach($value1 as $key2 => $value2)
                                {
                                $conditionStr .= " AND $key2 $key1 $value2";
                                }
                            }
                        }
                    else
                        {
                        if(is_array($value1))
                            {
                            $conditionStr .= " AND $key1 IN ('".implode("', '", $value1)."') ";
                            }
                        else
                            {
                            $conditionStr .= " AND $key1 = '$value1' ";
                            }
                        }
                    }
                $condition = ltrim($conditionStr, ' AND ');
                }
            $where .= ' '.$whereValue[0].' ('.$condition.') '; 
            }
        return $where;
        }
        
    private function buildSelect()
        {
        $select = implode($this->select, ', ');
        $from   = implode($this->table, ', ');
        $join   = implode($this->joins, ' ');
        $order  = implode($this->order, ', ');
        $group  = implode($this->group, ', ');
        $where  = $this->buildWhere();

        $this->sqlString .= ($select)   ? ' '.$select   : ' * ';
        $this->sqlString .= ($from)     ? ' FROM '.$from     : '';
        $this->sqlString .= ($join)     ? ' '.$join     : '';
        $this->sqlString .= ($where)    ? ' WHERE '.$where     : '';
        $this->sqlString .= ($group)    ? ' GROUP BY '.$group    : '';
        $this->sqlString .= ($order)    ? ' ORDER BY '.$order    : '';
        $this->sqlString .= ($this->limit)    ? ' LIMIT '.$this->limit : '';
        $this->sqlString .= ($this->offset)    ? ' OFFSET '.$this->offset : '';
        }
        
    private function buildInsert()
        {
        $table   = implode($this->table, ', ');
         
        $keys = '';
        $values = '';

        foreach($this->data as $key=>$value)
            {
            if ($value === '')
                {
                continue;
                }

            $keys .= $key.',';

            $value = $this->prepareValue($value);

            $values .=  "'".$value."',";
            }
          
        $values = rtrim($values, ',');
        $keys = rtrim($keys, ',');

        $this->sqlString = "INSERT INTO $table ($keys) VALUES ($values)";
        }
        
    private function buildUpdate()
        {
        $table   = implode($this->table, ', ');
         
        $keys = '';
        $values = '';

        foreach($this->data as $key=>$value)
            {
            if ($value === '')
                {
                continue;
                }

            $keys .= $key.',';

            $value = $this->prepareValue($value);

            if($this->isTableFieldOperand($key, $value))
                {
                $values .=  " $key = $value,";
                }
            else
                {
                $values .=  " $key = '$value',";
                }
            }
          
        $values = rtrim($values, ',');
        $keys = rtrim($keys, ',');
        
        $where  = $this->buildWhere();

        $this->sqlString = "UPDATE $table SET $values";
        $this->sqlString .= ($where) ? ' WHERE '.$where : ' ';
        }
        
    private function buildDelete()
        {
        $table   = implode($this->table, ', ');
        
        $where  = $this->buildWhere();

        $this->sqlString = "DELETE FROM $table";
        $this->sqlString .= ($where) ? ' WHERE '.$where : ' ';
        }
        
    private function createCommand()
        {
        $this->sqlString = $this->operation;

        switch ($this->operation) {
            case 'SELECT':
                $this->buildSelect();
                break;
            case 'INSERT':
                $this->buildInsert();
                break;
            case 'UPDATE':
                $this->buildUpdate();
                break;
            case 'DELETE':
                $this->buildDelete();
                break;

            default:
                break;
        }
        
        return $this;
        }
        
    public function resultArrayByField($field=null)
        {
        $this->resultArrayByField = $field;
        return $this;
        }
        
    public function executeQuery($sql = null, $params=[], $fetchType='object')
        {
        global $appConfig;
  
        $mysqlResult = null;
      
        if(!$sql) {
            $sql = $this->sqlString;
        }
        $this->params($params);
        
        $sql = $this->prepareSQL($sql);
        
        
        if($appConfig['debug.enabled'])
            {
            \Debuger::start();
            $mysqlResult = $this->mysqli->query($sql);
            \Debuger::end();
            \Debuger::logMySQL($sql, $mysqlResult);
            }
        else
            {
            $mysqlResult = $this->mysqli->query($sql);
            }
        
 
        if($this->mysqli->error)
            {
            if(!empty($this->config['debug.enabled']))
                {
                echo $this->mysqli->error. ' QUERY: '. $sql;
                exit;
                }
            else
                {
                echo 'SQL Error';
                }
            }
        if($this->operation == 'INSERT')
            {
            return $this->mysqli->insert_id;
            }
            
        if($this->operation == 'UPDATE' || $this->operation == 'DELETE' || is_bool($mysqlResult))
            {
            //appDebug($sql);
            return true;
            }
            
        $values = [];
        
      
        if($mysqlResult->num_rows === 0)
            {
            $mysqlResult->free();
            $mysqlResult->close(); 
            return null;
            }
    
        switch ($fetchType)
            {
            case 'object':
                if($this->resultArrayByField)
                    {
                    $field = $this->resultArrayByField;
                    while($obj = $mysqlResult->fetch_object($this->className)) 
                        {
                        $values[$obj->$field] = $obj;
                        }
                    }
                else
                    {
                     while($obj = $mysqlResult->fetch_object($this->className)) 
                        {
                        $values[] = $obj;
                        }
                    }
                break;
                
            case 'array':
                while($obj = $mysqlResult->fetch_assoc()) 
                    {
                    $values[] = $obj;
                    }
                break;
            }
       
        $this->operation = 'SELECT';
        
        /* Освобождаем память */ 
        $mysqlResult->free();
        $mysqlResult->close(); 
      
        return $values;
        }
        
    public function all()
        {
        $this->createCommand();
        return $this->executeQuery();
        }
        
    public function one()
        {
        $limit = $this->limit;
        $offset = $this->offset;
        
        $this->limit = 1;
        $this->offset = 0;
        
        $this->createCommand();
        $result = $this->executeQuery();
        
        $this->limit = $limit;
        $this->offset = $offset;
        
        return ($result) ? $result[0] : null;
        }
        
    public function getArray($param=null) 
        {
        $this->createCommand();
        return $this->executeQuery(null, [], 'array');
        }
        
    public function insert($table, $data)
        {
        $this->operation = 'INSERT';
        $this->table = [];
        $this->table[] = $table;
        
        $this->data = $data;
        $this->createCommand();
        
        return $this->executeQuery();
        }
        
    public function update($table, $data, $condition)
        {
        $this->operation = 'UPDATE';
        $this->table = [];
        $this->table[] = $table;
        
        $this->where($condition);
        
        $this->data = $data;
        $this->createCommand();
        
        return $this->executeQuery();
        }
        
    public function delete($table, $condition=[], $params=[])
        {
        $this->operation = 'DELETE';
        $this->table = [];
        $this->table[] = $table;
        
        $this->where($condition);
        
        $this->params($params);
        
        $this->createCommand();
        
        return $this->executeQuery();
        }
        
        
   

}
