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
class SQLBuilder {
    
    private $connection;
    private $mysqli;
    private $operation = 'SELECT';
    private $table = [];
    private $select = [];
    private $joins = [];
    private $order = [];
    private $limit = 1000;
    private $offset = 1;
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
    
    function    __construct($table = '')
        {
        $this->setConfig();
        $this->connect();
        $this->table = $table;
        
        return $this;
        }
    
    final private function setConfig()
        {
        global $appConfig;
        $this->config = & $appConfig;
        }
        
    private function connect() 
        {
        $this->mysqli = new mysqli($this->config['DB.Host'], $this->config['DB.UserName'], $this->config['DB.Password'], $this->config['DB.Name']);
        if ($mysqli->connect_error) 
            {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
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
        $this->joins[] = $joinType.' '.$tableName.' ON '.$joinCondition;
        
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
       $this->where = ['', $condition];
        
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
        
        $command = $this->createCommand();

        $this->select = $select;
        $this->limit = $limit;
        $this->offset = $offset;
        
        return $this->one();
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
                  $value[$k] = addslashes($value[$k]);
                  }

                $value[$k] = str_replace("\\r\\n",'<br>', $value[$k]);
                }
            }
          else
            {
            if(!get_magic_quotes_gpc())
              {
              $value = addslashes($value);
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
        
    public function prepareSQL($sql, $params) {
        foreach ($params as $name => $val) 
            {
            $name = ltrim($name, ':');
            $sql = str_replace(":$name", "'" . $val . "'", $sql);
            }
        return $sql;
    }
    
    public function getSQLString()
        {
        $this->createCommand();
        return $this->sqlString;
        }
        
    private function buildJoin()
        {
        
        }
        
    private function buildWhere()
        {
        if(empty($this->where))
            return false;
        $where = '';
        foreach ($this->where as $key => $whereValue) 
            {
            $where .= ' '.$whereValue[0].' ('.$whereValue[1].') '; 
            }
        return $where;
        }
        
    private function createCommand()
        {
        $this->sqlString = $this->operation;
        
        $params = $this->prepareParams($this->params);
      
        switch ($this->operation) {
            case 'SELECT':
                
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
                $this->sqlString .= ($order)    ? ' OREDR BY '.$order    : '';
                $this->sqlString .= ($this->limit)    ? ' LIMIT '.$this->limit : '';
                $this->sqlString .= ($this->offset)    ? ' OFFSET '.$this->offset : '';
                break;

            default:
                break;
        }
        
        $this->sqlString = $this->prepareSQL($this->sqlString, $params);
        
        return $this;
        
        
        }
}
