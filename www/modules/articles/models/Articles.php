<?php

namespace app\modules\articles\models;

use app\db\ActiveRecord\Model;
use app\modules\users\models\Users;

class Articles extends Model {
    
    public static $tableName = 'article';
     
    public static $relations = [
           'hasOne' => [
                'user' => [Users::class, 'id', 'article_user_id'],
            ],
    ];


    public static function getList($full = false, $filter = [], $limit = false, $sort = '') 
        {
        if ($filter) {
            //Уберем с фильтра все ненужное
            foreach ($filter as $key => $value) {
                if ($value == '0' && $key != 'active') {
                    unset($filter[$key]);
                } elseif ($key == 'active' && $value == '-1') {
                    unset($filter[$key]);
                } 
            }
        }

        $articles = self::findPaginationAll($filter);
         
        if ($full)
            return $articles;

        foreach ($articles as $article) {
            $result[$article['id']] = $article['article_title'];
        }

        return $result;
        }

    function articleCreate($data) {
        return $this->insert($this->table, $data);
    }

    function articleUpdate($data, $id) {
        if (!is_numeric($id))
            return false;

        $this->update($this->table, $data, "id = '$id'");
    }

}
