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

class ActiveRecord 
    {
    static $connection;
    static $db;
    static $tableName;
    static $primaryKey;

    static $attributes  = [];
    static $attrAccessible = [];
    static $attrProtected = [];
    static $delegate = [];
        
    public function __construct(array $attributes=[], $guardAttributes=true)
	{
        $this->setAttributesByArray($attributes, $guardAttributes);

        $this->invoke_callback('after_construct',false);
	}
        
    public function setAttributesByArray(array &$attributes, $guardAttributes)
        {
        $connection = static::connection();
        $table = static::table();
        $exceptions = array();
        $attrAccessible = !empty(static::$attrAccessible);
        $attrProtected = !empty(static::$attrProtected);
        
        foreach ($attributes as $name => $value)
            {
            // is a normal field on the table
            if (array_key_exists($name, $table->columns))
                {
                $value = $table->columns[$name]->cast($value, $connection);
                $name = $table->columns[$name]->inflected_name;
                }
            if ($guardAttributes)
                {
                if ($attrAccessible && !in_array($name,static::$attrAccessible))
                    {
                    continue;
                    }
                if ($attrProtected && in_array($name,static::$attrProtected))
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
                // ignore OciAdapter's limit() stuff
                if ($name == 'ar_rnum__')
                    continue;
                // set arbitrary data
                $this->setAttribute($name, $value);
                }
            }
        if (!empty($exceptions))
            throw new UndefinedPropertyException(get_called_class(), $exceptions);
        }
        
    public function setAttribute($name, $value)
	{
        $table = static::table();
        if (!is_object($value)) 
            {
            if (array_key_exists($name, $table->columns)) 
                {
                $value = $table->columns[$name]->cast($value, static::connection());
                } 
            else 
                {
                $col = $table->getColumnByInflectedName($name);
                if (!is_null($col))
                    {
                    $value = $col->cast($value, static::connection());
                    }
                }
            }
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
        
    public static function table()
	{
		return Table::load(get_called_class());
	}    
        
    public static function find(/* $type, $options */)
        {
 
        
        }

    }
