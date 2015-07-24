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
        if(!empty(self::$tableName)) 
            {
            return self::$tableName;
            }
            
        $parts = explode('\\', self::getClassName());
        $tableName = $parts[count($parts)-1];
        return strtolower($tableName);    
        }
        
    public function getTableName()
        {
        if(!empty(self::$tableName)) 
            {
            return self::$tableName;
            }
        
        $tableName = get_class($this);
        $parts = explode('\\',$tableName);
        $tableName = $parts[count($parts)-1];
        return $tableName;
        }
        
        
    public function getPrimaryKey()
        {
        if(!empty(self::$primaryKey)) 
            {
            return self::$primaryKey;
            }
        
        return null;
        }
        
    public function setAttributesByArray(array &$attributes, $guardAttributes)
        {
        $exceptions = array();
        $attrAccessible = !empty(self::$attrAccessible);
        $attrProtected = !empty(self::$attrProtected);
     
        foreach ($attributes as $name => $value)
            {
            if ($guardAttributes)
                {
                if ($attrAccessible && !in_array($name,self::$attrAccessible))
                    {
                    continue;
                    }
                if ($attrProtected && in_array($name,self::$attrProtected))
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
        
    public static function find($primaryKeyValue=0)
        {
        
        if(empty($primaryKeyValue))
            {
            return static::table();        
            }
        
        if(!is_int($primaryKeyValue)) 
            {
            throw new Exception('param `primaryKeyValue` is not integer!');
            }
            
        return static::table()->where([self::$primaryKey => $primaryKeyValue])->one();
        }
    
    final public static function findOne($condition, $params=[])
        {
        if(is_int($condition))
            {
            $condition = [self::$primaryKey => $condition];
            }
        return static::table()->where($condition)->params($params)->with('all')->one();
        }
        
    final public static function findAll($condition=[], $params=[])
        {
        return static::table()->where($condition)->params($params)->with('all')->all();
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
        $result = self::table()->insertData($this->attributes);
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
        $result = self::table()->updateData($this->attributes, [self::$primaryKey => $this->attributes[self::$primaryKey]]);
        $this->afterUpdate();
        
        return $result;
        }
        
    final public function save($validate = true)
        {
        $this->beforSave();
        $result = false;
        if(isset($this->attributes[self::$primaryKey])) 
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
        if(!isset($this->attributes[self::$primaryKey])) 
            {
            return false;
            }
            
        $result = self::table()->deleteData([self::$primaryKey => $this->attributes[self::$primaryKey]]);
        
        $this->afterDelete();
        
        return $result;
        }
        
    final public static function deleteAll($condition, $params)
        {
        if(is_int($condition))
            {
            $condition = [self::$primaryKey => $condition];
            }
        return static::table()->where($condition)->params($params)->delete();
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

