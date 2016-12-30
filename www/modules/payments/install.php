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
    private $tableName1  = 'user_bank_info';
    private $tableName2  = 'user_bank_transaction';
    
    public function up() 
        {
        //Uninstall module befor install
        $this->down();
        
        //Create Table 'user_bank_info' with fields
        Structure::createTable($this->tableName1, [
            'user_id'       => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                                ],
            'pin'           => ['type'=>'VARCHAR', 'size'=>'32'],
            'phone'         => ['type'=>'VARCHAR', 'size'=>'16'],
            'mime'          => ['type'=>'VARCHAR', 'size'=>'16'],

            'email'         => ['type'=>'VARCHAR', 'size'=>'160'],
            'first_name'    => ['type'=>'VARCHAR', 'size'=>'60'],
            'last_name'     => ['type'=>'VARCHAR', 'size'=>'60' ],
            'middle_name'   => ['type'=>'VARCHAR', 'size'=>'60' ],
            'middle_name'   => ['type'=>'VARCHAR', 'size'=>'60' ],
            'displayname'   => ['type'=>'VARCHAR', 'size'=>'50'],
            
            'postal'       => ['type'=>'VARCHAR', 'size'=>'20'],
            'country'      => ['type'=>'VARCHAR', 'size'=>'3'],
            'city'         => ['type'=>'VARCHAR', 'size'=>'100'],
            'address'      => ['type'=>'VARCHAR', 'size'=>'300'],
            

            'active'       => [
                                'type'=>'ENUM',
                                'values' => ['1','0'], 
                                'default' => '0', 
                                'notNull'=>true
                              ],
            
            'addtime'       => ['type'=>'INTEGER', 'unsigned'=>true],
            
            'balance'       => ['type'=>'INTEGER', 'unsigned'=>true, 'default'=>'0'],
            
        ]);
        
        //Create Indexes
        Structure::createIndex($this->tableName1, 'user_id');
        Structure::createIndex($this->tableName1, 'pin');
        Structure::createIndex($this->tableName1, 'phone');
        Structure::createIndex($this->tableName1, 'email');
        Structure::createIndex($this->tableName1, ['phone', 'pin']);
        
        
        
        Structure::createTable($this->tableName2, [
            'sender_id'     => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                               ],
            'recipient_id'  => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                                ],
            'transaction_id'=> [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                                ],
            
            'addtime'       => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                                ],
            
            'type'          => [
                                'type'=>'ENUM',
                                'values' => ['0','1','2'], 
                                'default' => '0', 
                                'notNull'=>true
                                ],
            
            'summ'          => [
                                'type'=>'INTEGER',
                                'unsigned'=>true,
                                'notNull'=>true
                                ],
            
            'status'        => [
                                'type'=>'ENUM',
                                'values' => ['pending','success','canceled'], 
                                'default' => 'pending', 
                                'notNull'=>true
                                ],
            
        ]);
        
        //Fill default data to DB table
//        $data = [
//            ['gid'=>'1', 'login'=>'admin', 'pass'=>md5('admin'), 'active'=>'1', 'addtime'=>time(), 'mail'=>'stelss1986@gmail.com', 'displayname'=>'Administrator']
//        ];
//        
//        Structure::fillData($this->tableName, $data);
        
        return true;
        }
    
    public function down() 
        {
        //Drop Tables
        Structure::deleteTable($this->tableName1);
        Structure::deleteTable($this->tableName2);
        //Remove Module Cache
        Cache::deleteModuleAllCached('users');
        }
    }
