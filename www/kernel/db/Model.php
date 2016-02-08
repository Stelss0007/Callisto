<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveRecord
 *
 * @author Ruslan
 */
namespace app\db\ActiveRecord;

class Model 
    {
    static $tableName = null;
    static $primaryKey = 'id';

    public $attributes  = [];
    
    static $attrAccessible = [];
    static $attrProtected = [];
    static $delegate = [];
    
    /**
     *
     * Example:
     * static $validators = [
     *      ['field1', 'required', 'min'=>10, 'max'=>20, ....]
     *      [['field1', 'field2', 'field3',...], 'required', 'min'=>10, 'max'=>20, ....]
     * ];
     * @var array 
     */
    static $validators = [];
    
    /**
     *
     * Example:
     * static $relations = [
     *      'hasMany' => [
     *          [$fieldName => [$className::className(), $foreignKey, $localKey]],
     *      ],
     *      'hasOne' => [
     *          [$fieldName => [$className::className(), $foreignKey, $localKey]],
     *      ],
     * ];
     * @var array 
     */
    static $relations = [];


    private $validateErrors = [];
    
    public static  $elementAtPage = 10;
    public static  $pagination = null;
    
    public static function getClassName()
        {
        return get_called_class();
        }
    
    public function __construct(array $attributes=[], $guardAttributes = true)
	{
        $this->setAttributesByArray($attributes, $guardAttributes);

        //$this->invoke_callback('after_construct',false);
	}
        
    public function __set($name, $value)
	{
//        if(property_exists($this, $name))
//            {
//            $this->$name = $value;
//            return true;
//            }
//            
//        if (method_exists($this,"set_$name"))
//            {
//            $name = "set_$name";
//            return $this->$name($value);
//            }
        
        if ($name == 'id')
            return $this->setAttribute($this->getPrimaryKey(), $value);
        
        //$this->$name = $value;
        return $this->setAttribute($name, $value);
        
//        foreach (self::$delegate as &$item)
//            {
//            if (($delegated_name = $this->is_delegated($name,$item)))
//                return $this->$item['to']->$delegated_name = $value;
//            }
	}  
        
    public function __get($name) 
        {
        // check for attribute
        if (array_key_exists($name, $this->attributes))
            {
            return $this->attributes[$name];
            }
        elseif(property_exists($this, $name))
            {
            return $this->$name;
            }
        throw new \UndefinedPropertyException(get_called_class(), $name);
        }
    
    public static  function connection()
        {
        return true;
        }
    
    public static function getStaticTableName()
        {
        if(!empty(static::$tableName)) 
            {
            return static::$tableName;
            }
            
        $parts = explode('\\', self::getClassName());
        $tableName = $parts[count($parts)-1];
        return strtolower($tableName);    
        }
        
    public function getTableName()
        {
        if(!empty(static::$tableName)) 
            {
            return static::$tableName;
            }
        
        $tableName = get_class($this);
        $parts = explode('\\',$tableName);
        $tableName = $parts[count($parts)-1];
        return $tableName;
        }
        
        
    public function getPrimaryKey()
        {
        if(!empty(static::$primaryKey)) 
            {
            return static::$primaryKey;
            }
        
        return null;
        }
        
    public function setAttributesByArray(array &$attributes, $guardAttributes)
        {
        $exceptions = array();
        $attrAccessible = !empty(static::$attrAccessible);
        $attrProtected = !empty(static::$attrProtected);
     
        foreach ($attributes as $name => $value)
            {
            if ($guardAttributes)
                {
                if ($attrAccessible && !in_array($name, static::$attrAccessible))
                    {
                    continue;
                    }
                if ($attrProtected && in_array($name, static::$attrProtected))
                    {
                    continue;
                    }
                try 
                    {
                    $this->$name = $value;
                    } 
                catch (UndefinedPropertyException $e) 
                    {
                    $exceptions[] = $e->getMessage();
                    }
                }
            else
                {
                // set arbitrary data
                $this->setAttribute($name, $value);
                }
            }
        if (!empty($exceptions))
            throw new UndefinedPropertyException(get_called_class(), $exceptions);
        }
        
    public function setAttribute($name, $value)
	{
        // convert php's \DateTime to ours
        if ($value instanceof \DateTime)
            {
            $value = new DateTime($value->format('Y-m-d H:i:s T'));
            }
            // make sure DateTime values know what model they belong to so
            // dirty stuff works when calling set methods on the DateTime object
        if ($value instanceof DateTime)
            {
            $value->attribute_of($this, $name);
            }

        $this->attributes[$name] = $value;
        return $value;
	}
    
    public function getAttributes()
        {
        return $this->attributes;
        }
        
    public function getAttribute($attrName=null)
        {
        if(empty($attrName))
            {
            return null;
            }
        return isset($this->attributes[$attrName]) ? $this->attributes[$attrName] : null;
        }
        
    public static function table()
	{
        return Table::load(get_called_class());
	}   
        
    public static function executeQuery($sql = null, $params=[], $fetchType='object')
        {
        if(!$sql)
            {
            throw new Exception('First param \'$sql\' is required!');
            }
        return static::table()->executeQuery($sql, $params, $fetchType);
        }


    public static function find($primaryKeyValue=null)
        {
        
        if($primaryKeyValue === null)
            {
            return static::table();        
            }
       
//        if(!is_int($primaryKeyValue)) 
//            {
//            throw new Exception('param `primaryKeyValue` is not integer!');
//            }
            
        return static::table()->where([static::$primaryKey => $primaryKeyValue])->one();
        }
    
    final public static function findOne($condition, $params=[])
        {
        if(is_int($condition))
            {
            $condition = [static::$primaryKey => $condition];
            }
        return static::table()->where($condition)->params($params)->with('all')->one();
        }
        
    final public static function findAll($condition=[], $params=[])
        {
        return static::table()->where($condition)->params($params)->with('all')->all();
        }
        
    final public static function findPaginationAll($condition=[], $params=[])
        {
        return static::table()->where($condition)->params($params)->with('all')->pagination()->all();
        }
        
    final public function validate()
        {
        if(\Validator::validateModel($this) == true)
            {
            return true;
            }
            
        $this->validateErrors =  \Validator::getErrors();   
        return false;
        }
        
    final public function validateGetErrors()
        {
        return $this->validateErrors;
        }
        
    final public function insert($validate = true)
        {
        if($validate && !$this->validate())
            {
            return false;
            }
            
        $this->beforCreate();    
        $result = static::table()->insertData($this->attributes);
        $this->attributes[static::$primaryKey] = $result;
        $this->afterSave();
        
        return $result;
        }
        
    final public function update($validate = true)
        {
        if($validate && !$this->validate())
            {
            return false;
            }
            
        $this->beforUpdate();
        $result = static::table()->updateData($this->attributes, [static::$primaryKey => $this->attributes[static::$primaryKey]]);
        $this->afterUpdate();
        
        return $result;
        }
        
    /**
     * Update all data
     * @param array $date  Array field=>value
     * @param arra $condition Array field=>value
     * @return boolean
     */    
    final public function updateAll($data = [], $condition = [])
        {
        if(empty($data))
            {
            return false;
            }

        $result = static::table()->updateData($data, $condition);
        
        return $result;
        }
        
    final public function save($validate = true)
        {
        $this->beforSave();
        $result = false;

        if(isset($this->attributes[static::$primaryKey]) && !empty($this->attributes[static::$primaryKey])) 
            {
            $result = $this->update();
            }
        else 
            {
            $result = $this->insert();
            }
        $this->afterSave();    
        return $result;
        }
        
    final public function delete()
        {
        $this->beforDelete();
        if(!isset($this->attributes[static::$primaryKey])) 
            {
            return false;
            }
            
        $result = static::table()->deleteData([static::$primaryKey => $this->attributes[static::$primaryKey]]);
        
        $this->afterDelete();
        
        return $result;
        }
        
    final public static function deleteAll($condition, $params=[])
        {
        if(is_int($condition))
            {
            $condition = [static::$primaryKey => $condition];
            }
        return static::table()->deleteData($condition, $params);
        }
        
    final public function with($withRelations=[])
        {
        $withRelations = (array) $withRelations;
        
        foreach($this::$relations as $relationType => $relationRules)
            {
            if($relationType != 'hasMany' && $relationType != 'hasOne')
                continue;
            
            foreach($relationRules as $relationField => $relation)
                {
                if(!in_array($relationField, $withRelations))
                    {
                    continue;
                    }
                    
                $relationClass = $relation[0];
                $foreignKey = (isset($relation[1])) ? $relation[1] : $this->getTableName().'_id';
                $localKey = (isset($relation[2])) ? $relation[2] : 'id';
                
                if($relationType == 'hasMany')
                    {
                    $this->$relationField = $relationClass::find()->where([$foreignKey => $this->$localKey])->all();
                    }
                elseif($relationType == 'hasOne')
                    {
                    $this->$relationField = $relationClass::find()->where([$foreignKey => $this->$localKey])->one()->with($withRelations);
                    }
                }
            }
            
        return $this;    
        }
        
   
        
    public static function activation($id)
        {
        if(empty($id))
            {
            return false;
            }
        
        if(static::table()->hasField('active'))
            {
            
            $obj = static::table()->where([static::$primaryKey => $id])->one();
            if($obj)
                {
                $obj->active = ($obj->active) ? '0' : '1';
                $obj->save();
                return true;
                }
            }
            return false;
        }
        
    public static function activate($id = null)
        {
        if(empty($id))
            {
            return false;
            }
         
        if(static::table()->hasField('active'))
            {
            $obj = static::table()->where([static::$primaryKey => $id])->one();
            if($obj)
                {
                $obj->active = '1';
                $obj->save();
                return true;
                }
            }
            return false;
        }
        
    public static function deactivate($id = null)
        {
        if(empty($id))
            {
            return false;
            }
        
        if(static::table()->hasField('active'))
            {
            $obj = static::table()->where([static::$primaryKey => $id])->one();
            if($obj)
                {
                $obj->active = '0';
                $obj->save();
                return true;
                }
            }
            return false;
        }
        
    public static function groupActionActivate($ids)
        {
        if(empty($ids))
          return false;
        
        if(static::table()->hasField('active'))
            {
            $result = static::table()->updateData(['active'=>1], [static::$primaryKey => $ids]);
            }
        }
        
    public static function groupActionDeactivate($ids)
        {
        if(empty($ids))
          return false;
        
        if(static::table()->hasField('active'))
            {
            $result = static::table()->updateData(['active'=>0], [static::$primaryKey => $ids]);
            }
        }
        
    public static function groupActionDelete($ids)
        {
        if(empty($ids))
          return false;

        return static::table()->deleteData([static::$primaryKey => $ids]);
        }
        
        
    public static function weightMax($condition = []) 
        {
        $maxWeightObj = static::find()
                ->orderBy(['weight' => 'DESC']);
        
        if($condition)
            {
            $maxWeightObj = $maxWeightObj->where($condition);
            }
        
        $maxWeightObj = $maxWeightObj->one();
        
        return $maxWeightObj->weight;
        }
        
    public function weightUp($condition = []) 
        {
        if($this->weight < 2)
            {
            return false;
            }
            
        $this->weight = $this->weight - 1;
        
        $condition['weight'] = $this->weight;
        
        $prevObj = $this->findOne($condition);
        $prevObj->weight = $prevObj->weight + 1;
        $prevObj->save();
        
        $this->save();
        
        return true;
        }
        
    public function weightDown($condition = []) 
        {
        if($this->weight >= $this->weightMax())
            {
            return false;
            }
            
        $this->weight = $this->weight + 1;
        
        $condition['weight'] = $this->weight;
        
        $prevObj = $this->findOne($condition);
        $prevObj->weight = $prevObj->weight - 1;
        $prevObj->save();
        
        $this->save();
        
        return true;
        }
        
    public function weightSet($weightNew = 0, $condition = [])
        {
        if ($weightNew == 0)
            {
            return false;
            }
            
        $this->updateAll(['weight'=>static::$tableName.'.weight-1'], ['>' => ['weight'=> $this->weight]] + $condition);
        $this->updateAll(['weight'=>static::$tableName.'.weight+1'], ['>=' => ['weight'=> $weightNew]] + $condition);
        
        $this->weight = $weightNew;
        $this->save();
    
        return true;
        }
        
    public function weightDelete($condition = [])
        {
        $this->updateAll(['weight'=>static::$tableName.'.weight-1'], ['>' => ['weight'=> $this->weight]] + $condition);

        return true;
        }
    
    
          
    /* Befor/After Functions */
        
    public function beforDelete()
        {
        return true;
        }
        
    public function afterDelete()
        {
        return true;
        }

    public function beforCreate()
        {
        return true;
        }
        
    public function afterCreate()
        {
        return true;
        }

    public function beforUpdate()
        {
        return true;
        }
        
    public function afterUpdate()
        {
        return true;
        }

    public function beforSave()
        {
        return true;
        }
        
    public function afterSave()
        {
        return true;
        }
    }

