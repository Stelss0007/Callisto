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
    private $tableName = 'group';
    
    public function up() 
        {
        //Uninstall module befor install
        $this->down();
        
        //Create Table with fields
        Structure::createTable($this->tableName, [
            'id'            => ['type'=>'INTEGER', 'size'=>'11', 'autoincrement'=>true, 'unique'=>true],
            'name'          => ['type'=>'VARCHAR', 'size'=>'60'],
            'description'   => ['type'=>'VARCHAR', 'size'=>'255'],
        ]);

        
        //Fill default data to DB table
        $data = [
            ['id'=>'-1', 'name'=>'Незарегистрированные', 'description'=>'Незарегистрированные либо не авторизированные пользователи'],
            ['id'=>'1',  'name'=>'Администраторы', 'description'=>'Администраторы сайта'],
            ['id'=>'2',  'name'=>'Зарегистрированные', 'description'=>'Зарегистрированные пользователи'],
            ['id'=>'3',  'name'=>'Модераторы', 'description'=>'Модераторы сайта'],
        ];
        
        Structure::fillData($this->tableName, $data);
        
        return true;
        }
    
    public function down() 
        {
        //Drop Tables
        Structure::deleteTable($this->tableName);
        
        //Remove Module Cache
        Cache::deleteModuleAllCached('group');
        }
    }
