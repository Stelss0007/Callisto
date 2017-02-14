<?php
use app\db\ActiveRecord\Structure;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of install
 *
 * @author Ruslan
 */
class Install 
    {
    private $tableName = 'block';
    
    public function up() 
        {
        //Uninstall module befor install
        $this->down();
        
        //Create Table with fields
        Structure::createTable($this->tableName, [
            'weight'                => ['type'=>'INTEGER', 'size'=>'11', 'usigned'=>true, 'default'=>'0'],
            'name'                  => ['type'=>'VARCHAR', 'size'=>'60'],
            'displayname'           => ['type'=>'VARCHAR', 'size'=>'300'],
            'pattern'               => ['type'=>'VARCHAR', 'size'=>'300'],
            'content'               => ['type'=>'TEXT'],
            'position'              => ['type'=>'VARCHAR', 'size'=>'10'],
            'lang'                  => ['type'=>'VARCHAR', 'size'=>'10'],
            'css_class'             => ['type'=>'VARCHAR', 'size'=>'100'],
            'theme_id'              => ['type'=>'INTEGER', 'size'=>'11', 'usigned'=>true, 'default'=>'2'],
            'active'                => ['type'=>'TINYINT', 'size'=>'1', 'usigned'=>true, 'default'=>'0'],
        ]);
        
        //Create Indexes
        Structure::createIndex($this->tableName, 'weight');
        Structure::createIndex($this->tableName, 'position');
        Structure::createIndex($this->tableName, 'active');
        Structure::createIndex($this->tableName, 'lang');
        
        return true;
        }
    
    public function down() 
        {
        //Drop Tables
        Structure::deleteTable($this->tableName);
        
        //Remove Module Cache
        Cache::deleteModuleAllCached('blocks');
        }
    }
