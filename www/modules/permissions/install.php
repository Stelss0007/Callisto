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
    private $tableName = 'group_permission';
    
    public function up() 
        {
        //Uninstall module befor install
        $this->down();
        
        //Create Table with fields
        Structure::createTable($this->tableName, [
            'gid'           => ['type'=>'INTEGER', 'size'=>'11'],
            'weight'        => ['type'=>'INTEGER', 'size'=>'11', 'unsigned'=>true],
            'level'         => ['type'=>'SMALLINT', 'size'=>'6', 'unsigned'=>true],
            'pattern'       => ['type'=>'VARCHAR', 'size'=>'250'],
            'description'   => ['type'=>'VARCHAR', 'size'=>'300'],
        ]);

        //Create Indexes
        Structure::createIndex($this->tableName, 'weight');
        
        //Fill default data to DB table
        $data = [
            ['id'=>'1',  'gid'=>'1', 'level'=>'70', 'pattern'=>'.*', 'description'=>'Права для администраторов системы. Разрешено все'],
            ['id'=>'2',  'gid'=>'-1', 'level'=>'0', 'pattern'=>'.*::admin::.*', 'description'=>'Запещаем неавторизированым пользователям доступ к админке'],
            ['id'=>'3',  'gid'=>'-1', 'level'=>'20', 'pattern'=>'.*', 'description'=>'Незарегистрированые/Неавторзированые пользователи могут просматривать всю информацию'],
        ];
        
        Structure::fillData($this->tableName, $data);
        
        return true;
        }
    
    public function down() 
        {
        //Drop Tables
        Structure::deleteTable($this->tableName);
        
        //Remove Module Cache
        Cache::deleteModuleAllCached('permissions');
        }
    }
