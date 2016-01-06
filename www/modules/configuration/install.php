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
    private $tableName = 'configuration';
    
    public function up() 
        {
        //Uninstall module befor install
        $this->down();
        
        //Create Table with fields
        Structure::createTable($this->tableName, [
            'module'    => ['type'=>'VARCHAR', 'size'=>'200'],
            'params'    => ['type'=>'TEXT'],
        ]);

        
        //Fill default data to DB table
        $params = [
            'site_name' => 'Callisto Site',
            'site_slogan' => 'My Site Slogan',
            'site_description' => 'My Site Description',
            'site_footer' => 'My Site Footer',
            'site_email' => 'admin@callisctocms.com',
            'site_dateformat' => 'Y-m-d',
            'site_timeformat' => 'g:i a',
            'site_offline_message' => 'This site is temporarily unavailable',
            'site_list_lenght' => 5,
            'user_default_group' => 'noindex, follow',
            'user_new_confirm' => 'noindex, nofollow',
            'site_seo_description' => 'SEO Description',
            'site_seo_keywords' => 'SEO Keywords',
            'site_seo_robots' => 'index, nofollow',
            'site_email_type' => 'smtp',
            'site_email_from' => 'admin@callisctocms.com',
            'site_email_sender' => 'Admin',
            'site_email_smtp_server' => 'smtp.gmail.com',
            'site_smtp_sec' => 'ssl',
            'site_email_smtp_port' => '465',
            'site_email_smtp_user' => 'admin@callisctocms.com',
            'site_email_smtp_password' => 'passwordforemail'
        ];
        $data = [
            ['module'=>'main', 'params'=>  serialize($params)],
        ];
        
        Structure::fillData($this->tableName, $data);
        
        return true;
        }
    
    public function down() 
        {
        //Drop Tables
        Structure::deleteTable($this->tableName);
        
        //Remove Module Cache
        Cache::deleteModuleAllCached('configuration');
        }
    }
