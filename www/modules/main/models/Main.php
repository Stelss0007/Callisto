<?php
/** 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @Table('111') 
 */
namespace app\modules\main\models;

class Main extends \app\db\ActiveRecord\Model
    {
  /**
   *
   * @Column(type='string', default='1', primaryKey = true) 
   * @Index(type='integer')
   */
    public static $tableName = '`main`';
    }

