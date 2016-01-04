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
class Install {
    private $tableName = 'user2';
    
    public function up() {
        //Uninstall module befor install
        $this->down();
        
        Structure::createTable($this->tableName, [
            'gid'           => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                                ],
            'login'         => ['type'=>'VARCHAR'],
            'pass'          => ['type'=>'VARCHAR', 'size'=>'40'],
            'active'        => [
                                'type'=>'ENUM',
                                'values' => ['1','0'], 
                                'default' => '0', 
                                'notNull'=>true
                                ],
            'addtime'       => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                ],
            'last_visit'    => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                ],
             'mail'         => ['type'=>'VARCHAR', 'size'=>'40'],
             'displayname'  => ['type'=>'VARCHAR', 'size'=>'50'],
        ]);
        
        Structure::createIndex($this->tableName, 'pass');
        Structure::createIndex($this->tableName, 'login');
        Structure::createIndex($this->tableName, ['login', 'pass']);
        
        $data = [
            ['gid'=>'1', 'login'=>'admin', 'pass'=>md5('admin'), 'active'=>'1', 'addtime'=>time(), 'mail'=>'stelss1986@gmail.com', 'displayname'=>'Administrator']
        ];
        
        Structure::fillData($data);
        
        return true;
    }
    
    public function down() {
        Structure::deleteTable($this->tableName);
    }
}
