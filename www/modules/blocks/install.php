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

        
        //Fill default data to DB table
        $data = [
            ['id'=>'1', 'weight'=>'1', 'menu_parent_id'=>'0', 'menu_item_type'=>'3', 'menu_subitem_counter'=>'2', 'menu_title'=>'Test Frontend Menu', 'menu_description'=>'Test Frontend Menu Description', 'menu_content'=>'', 'menu_active'=>'1', 'menu_path'=>'0::1'],
            ['id'=>'2', 'weight'=>'1', 'menu_parent_id'=>'1', 'menu_item_type'=>'3', 'menu_subitem_counter'=>'0', 'menu_title'=>'Главня Страница', 'menu_description'=>'Главня Страница Описание', 'menu_content'=>'/', 'menu_active'=>'1', 'menu_path'=>'0::1::2'],
            ['id'=>'3', 'weight'=>'2', 'menu_parent_id'=>'1', 'menu_item_type'=>'3', 'menu_subitem_counter'=>'0', 'menu_title'=>'Статьи', 'menu_description'=>'Страница Статьи Описание', 'menu_content'=>'/articles', 'menu_active'=>'1', 'menu_path'=>'0::1::3'],
        ];
        
        Structure::fillData($this->tableName, $data);
        
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
