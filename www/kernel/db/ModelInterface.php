<?php

namespace app\db\ActiveRecord;

interface ModelInterface
{
    public static  function connection();
    public static function getStaticTableName();
    public function getTableName();
    public function getPrimaryKey();
    public function setAttributesByArray(array &$attributes, $guardAttributes);
    public function setAttribute($name, $value);
    public function getAttributes();
    public function getAttribute($attrName=null);
    public static function find($primaryKeyValue=null);
    public static function findOne($condition, $params=[]);
    public static function findAll($condition=[], $params=[]);
    public static function findPaginationAll($condition=[], $params=[]);
    public function validate();
    public function insert($validate = true);
    public function update($validate = true);
    public function updateAll($data = [], $condition = []);
    public function save($validate = true);
    public function delete();
    public static function deleteAll($condition, $params=[]);
    public function with($withRelations=[]);
}
