<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table
 *
 * @author Ruslan
 */

namespace app\db\ActiveRecord;
use ReflectionClass;

class Table extends SQLBuilder
{
    public $tableName;
    public $class;
    public $conn;
    public $pk;
    public $last_sql;
    // Name/value pairs of columns in this table
    public $columns = [];
    public static $cache = [];
    
    protected $className;
    
    private $localRelations = [];
    private $relationsArray = [];
    
    public static function load($modelClassName)
        {
        return new Table($modelClassName);
        // $this->class = new ReflectionClass($model_class_name);
        if (!isset(self::$cache[$modelClassName]))
            {
            self::$cache[$modelClassName] = new Table($modelClassName);
            //self::$cache[$model_class_name]->setAssociations();
            }
        return self::$cache[$modelClassName];
        }
        
    public function __construct($className)
	{
//        $this->class = Reflections::instance()->add($class_name)->get($class_name);
//        $this->reestablishСonnection(false);
//        $this->setTableName();
//        $this->getMetaData();
//        $this->setPrimaryKey();
//        $this->setSequenceName();
//        $this->setDelegates();
//        $this->setCache();
//        $this->setSettersAndGetters();
//        $this->callback = new CallBack($class_name);
//        $this->callback->register('before_save', function(Model $model) { $model->set_timestamps(); }, array('prepend' => true));
//        $this->callback->register('after_save', function(Model $model) { $model->reset_dirty(); }, array('prepend' => true));
        $this->className = $className;
        //echo $className::getStaticTableName();exit;
        $this->tableName = $className::getStaticTableName();//self::getTableNameByClassName($className);
        //$this->setFields();
        parent::__construct($this->tableName);
	}
        
    public function setPrimaryKey()
        {
        
        }
        
    public function setRelation($type, $rule)
        {
        $this->localRelations[$type] = $rule;
        }
        
    public function hasRelation()
        {
        return !empty($this->localRelations);
        }
        
    public static function getTableNameByClassName($className)
        {
        $tableName = $className;
        $parts = explode('\\',$tableName);
        $tableName = $parts[count($parts)-1];
        return strtolower($tableName);
        }   
        
    function setFields()
        {
        $fields = $this->getFields();
        if($fields)
            {
            foreach($fields as $field)
                {
                $this->columns[$field] = true;
                }
            }
        }
    function getFields($table=null)
        {
        if(empty($table))
            {
            $table = $this->tableName;
            }

        if(\Cache::isCached('dbTableFields', $table) && !\App::$config['debug.enabled'])
          {
          return \Cache::getCached('dbTableFields', $table);
          }

        $sql = 'SHOW COLUMNS FROM '.$table;
        $sqlBuilder = new SQLBuilder();
        $result = $sqlBuilder->executeQuery($sql,[],'array');

        $columns = array();
        foreach ($result as $value)
          {
          $columns[] = $value['Field'];
          }
        \Cache::setCached('dbTableFields', $table, $columns);

        return $columns;
        }
        
    public function hasField($field)
        {
        return in_array($field, $this->getFields(), true);
        }
    
    private function clearDataByTableFields($data) 
        {
        $this->setFields(); 
     
        if(empty($data))
            {
            return [];
            }
        foreach ($data as $key => $value)
            {
            if(!isset($this->columns[$key]))
                {
                unset($data[$key]);
                }
            }
            
        return $data;
        }
        
    public function insertData($data)
        {
        if(!isset($data['created_at']) && empty($data['created_at']))
            {
            $data['created_at'] = time();
            }
        if(!isset($data['updated_at'])  && empty($data['updated_at']))
            {
            $data['updated_at'] = time();
            }
            
        $data = $this->clearDataByTableFields($data);
        
        if(empty($data))
            {
            return false;
            }
            
        return $this->insert($this->tableName, $data);
        }
        
    public function updateData($data=[], $condition=[])
        {
        if(!isset($data['updated_at']) && empty($data['updated_at']))
            {
            $data['updated_at'] = time();
            }
            
        $data = $this->clearDataByTableFields($data);
       
        if(empty($data) || empty($condition))
            {
            return false;
            }
          
        return $this->update($this->tableName, $data, $condition);
        }
        
    public function deleteData($condition, $params=[])
        {
        return $this->delete($this->tableName, $condition, $params);
        }
    
    public function getValuesOfFieldByArray($arrayOfObject, $field)
        {
        if(empty($arrayOfObject) || empty($field) || !isset($arrayOfObject[0]->attributes[$field]))
            {
            return [];
            }
        $result = [];
     
        foreach($arrayOfObject as $object)
            {
            $result[] = $object->attributes[$field];
            }
        return $result;
        }
        
    public function with($withRelations=[])
        {
        $withRelations = (array) $withRelations;
        $this->relationsArray = $withRelations;
        
        if(empty($withRelations))
            {
            return $this;
            }
            
        $calssName = $this->className;
        
        if($withRelations[0] == 'all')
            {
            $this->localRelations = $calssName::$relations;
            }
            
        
        
        foreach($calssName::$relations as $relationType => $relationRules)
            {
            if($relationType != 'hasMany' && $relationType != 'hasOne')
                continue;
            
            foreach($relationRules as $relationField => $relation)
                {
                if(!in_array($relationField, $withRelations))
                    {
                    continue;
                    }
                    
                $this->setRelation($relationType, [$relationField => $relation]);
                }
            }
            
        return $this; 
        }
        
    private function allWithRelations()
        {
        $parentResult = parent::all();
        
        foreach($this->localRelations as $relationType => $relationRules)
            {
            if($relationType != 'hasMany' && $relationType != 'hasOne')
                continue;
  
            foreach($relationRules as $relationField => $relation)
                {
                $relationClass = $relation[0];
                $currentClass = $this->className;
                $foreignKey = (isset($relation[1])) ? $relation[1] : $currentClass::getStaticTableName().'_id';
                $localKey = (isset($relation[2])) ? $relation[2] : 'id';

                $localKeys = $this->getValuesOfFieldByArray($parentResult, $localKey);
                $relationFields = $relationClass::find()->where([$foreignKey => $localKeys])->with($this->relationsArray)->all();
                
                foreach($parentResult as $key=>$object)
                    {
                    $tempObjects = null;
                    foreach($relationFields as $relationObject)
                        {
                        if($relationObject->$foreignKey == $object->$localKey)
                            {
                            if($relationType == 'hasOne')
                                {
                                $tempObjects = $relationObject;
                                break;
                                }
                            else
                                {
                                $tempObjects[] = $relationObject;
                                }
                            }
                        }
                    $parentResult[$key]->$relationField = $tempObjects;
                    }
                }
            }
        return $parentResult;
        }
        
    public function one() {
        if($this->hasRelation())
            {
            return parent::one()->with($this->relationsArray);
            }
                
        return parent::one();
        }
  
    public function all() 
        {
        if(!$this->hasRelation())
            {
            return parent::all();
            }

        return $this->allWithRelations();
        }
   

}
