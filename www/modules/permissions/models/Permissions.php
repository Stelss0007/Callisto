<?php

namespace app\modules\permissions\models;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Permissions extends \app\db\ActiveRecord\Model {

    public static $tableName = 'group_permission';

    public static function groupPermissionsList() 
    {
        $groupPermissions = self::find()
                ->orderBy('weight')
                ->all()
        ;

        //$this->query("SELECT * FROM {$this->table} ORDER BY {$this->table}_weight");
        return $groupPermissions;
    }

    public static function groupPermission($id) 
    {
        if (!is_numeric($id))
            return false;

        $groupPermission = self::find($id);
        return $groupPermission;
    }

    public static function permissionLevel($level = false) 
    {
        $levels = array();
        $levels[ACCESS_INVALID] = 'ACCESS INVALID';
        $levels[ACCESS_NONE] = 'ACCESS NONE';
        $levels[ACCESS_OVERVIEW] = 'ACCESS OVERVIEW';
        $levels[ACCESS_READ] = 'ACCESS READ';
        $levels[ACCESS_COMMENT] = 'ACCESS COMMENT';
        $levels[ACCESS_ADD] = 'ACCESS ADD';
        $levels[ACCESS_EDIT] = 'ACCESS EDIT';
        $levels[ACCESS_DELETE] = 'ACCESS DELETE';
        $levels[ACCESS_ADMIN] = 'ACCESS ADMIN';

        if ($level !== false && $levels[$level])
            return $levels[$level];

        return $levels;
    }

    function groupPermissionsCreate($data) 
    {
        $data["{$this->table}_weight"] = $this->weightMax() + 1;
        $this->insert($this->table, $data);
    }

    function groupPermissionsUpdate($data, $id) 
    {
        if (!is_numeric($id))
            return false;

        $this->update($this->table, $data, "id = '$id'");
    }

    function groupPermissionDelete($id) 
    {
        if (!is_numeric($id))
            return false;
        $group_permision = $this->groupPermission($id);
        $this->weightDelete($group_permision["{$this->table}_weight"], $where);
        $this->query("DELETE FROM {$this->table} WHERE id='$id'");
    }

    public static function getAccess($obj_name, $level) 
    {
        $ses_info = \app\lib\UserSession\UserSession::getInstance();
        $gid = $ses_info->userGid();
        $perms_list = self::groupPermsGetList($gid);

        if (empty($perms_list))
            return false;

        $tableName = self::$tableName;

        foreach ($perms_list as $key => $permission) {
            $this_pattern = $permission->pattern;
            $pattern = "/$this_pattern/Ui";
            if (preg_match($pattern, $obj_name)) {
                if ($level <= $permission->level) {
                    //print_r($perms_list[$key]);
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    /**
     * @desc Считаем уровень доступа текушего пользователя к тестируемому обьекту
     * @return integer
     * @param testobject string
     * @param ownerid int
     */
    public static function objectGetPermsLevel($object, $ownerid = -1) 
    {
        if (!$object) {
            die('$object is empty');
        }

        static $loaded = array();
        if (!empty($loaded["$object, $ownerid"]))
            return $loaded["$object, $ownerid"];

        $level = ACCESS_INVALID;

        $ses_info = \app\lib\UserSession\UserSession::getInstance();

        $gid = $ses_info->userGid();


        if (!isset($groups_perms_list)) {
            $groups_perms_list = self::groupPermsGetList($gid);
            appVarSetCached('core', 'groups_perms_list', $groups_perms_list);
        }

        if ($groups_perms_list) {
            foreach ($groups_perms_list as $permission) {
                if (($permission->gid != $gid) && ($permission->gid != -1))
                    continue;

                if (isset($permission->component) && $permission->component)
                    $pattern = "/^$permission->component::$permission->pattern/Ui";
                else
                    $pattern = "/^.*::$permission->pattern/Ui";
                if (preg_match($pattern, $object)) {
                    if ($permission->level > $level)
                        $level = $permission->level;
                    break;
                }
            }
        }


        //Права владельцев
        if (($ownerid > -1) && ($ownerid == $uid)) {
            $level = ACCESS_DELETE;
        }

        $loaded["$object, $ownerid"] = $level;

        return $level;
    }

    public static function groupPermsGetList($gid = null) 
    {
        $fieldGid = self::$tableName . "_gid";
        $fieldWeight = self::$tableName . "_weight";

        return self::find()
                        ->where(["gid" => $gid])
                        ->orderBy("weight")
                        ->all()
        ;

        //return $this->getList($params);
    }

    public function beforCreate() 
    {
        $this->weight = $this->weightMax() + 1;
    }

}
