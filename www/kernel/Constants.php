<?php
define('DS', DIRECTORY_SEPARATOR );

define('MODULE_STATE_NA', 0);
define('MODULE_STATE_UNINITIALISED', 10);
define('MODULE_STATE_INACTIVE', 20);
define('MODULE_STATE_ACTIVE', 30);
define('MODULE_STATE_MISSING', 40);
define('MODULE_STATE_UPGRADED', 50);


define('ACCESS_INVALID', -1);
define('ACCESS_NONE', 0);
define('ACCESS_OVERVIEW', 10);
define('ACCESS_READ', 20);
define('ACCESS_COMMENT', 30);
define('ACCESS_ADD', 40);
define('ACCESS_EDIT', 50);
define('ACCESS_DELETE', 60);
define('ACCESS_ADMIN', 70);


define('BAD_PARAM', 1);
define('DATABASE_ERROR', 2);
define('ID_NOT_EXIST', 3);
define('NO_PERMISSION', 4);
define('MODULE_NOT_EXIST', 5);
define('MODULE_FILE_NOT_EXIST', 6);
define('MODULE_FUNCTION_NOT_EXIST', 7);
define('BLOCK_NOT_EXIST', 8);
define('BLOCK_FILE_NOT_EXIST', 9);
define('BLOCK_FUNCTION_NOT_EXIST', 10);

define('RELATION_TYPE_ONE_TO_ONE', 1);
define('RELATION_TYPE_ONE_TO_MANY', 2);
define('RELATION_TYPE_MANY_TO_MANY', 3);

define('RELATION_ACTION_NONE', 0);
define('RELATION_ACTION_CASCADE', 1);
define('RELATION_ACTION_RESTRICT', 2);

define('MESSAGE_INFO', 'info');
define('MESSAGE_WARNING', 'warning');
define('MESSAGE_ERROR', 'error');

