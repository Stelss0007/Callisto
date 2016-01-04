<?php
namespace app\db\ActiveRecord;
use app\db\ActiveRecord\SQLBuilder;

/**
 * Description of Structure
 *
 * @author Ruslan Atamas
 */
class Structure  {
    private static $fieldTypes = [
        //
        'TINYINT'   => ['size'=>'4', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -128 to 127 / 0 to 255
        'SMALLINT'  => ['size'=>'6', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -32768 to 32767  / 0 to 65535
        'MEDIUMINT' => ['size'=>'9', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -8388608 to 8388607 / 0 to 16777215
        'INT'       => ['size'=>'11', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -2147483648 to 2147483647 / 0 to 4294967295
        'INTEGER'   => ['size'=>'11', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -2147483648 to 2147483647 / 0 to 4294967295
        'BIGINT'    => ['size'=>'20', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -9223372036854775808 to 9223372036854775807 / 0 to 18446744073709551615
        
        'FLOAT'     => ['size'=>'9', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],                
        'DOUBLE'    => ['size'=>'15', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],               
        'DECIMAL'   => ['size'=>'11', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],              
        'DEC'       => ['size'=>'11', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],    
        
        'DATE'      => ['notNull', 'comment', 'default', 'unique'],
        'DATETIME'  => ['notNull', 'comment', 'default', 'unique'],
        'TIMESTAMP' => ['notNull', 'comment', 'default', 'unique'],
        'TIME'      => ['notNull', 'comment', 'default', 'unique'],
        'YEAR'      => ['notNull', 'comment', 'default', 'unique'],
        
        'CHAR'      => ['size'=>'20', 'notNull', 'comment', 'default', 'unique'],
        'VARCHAR'   => ['size'=>'20', 'notNull', 'comment', 'default', 'unique'],
        'TINYTEXT'  => ['notNull', 'comment'],
        'TEXT'      => ['notNull', 'comment'],  
        'MEDIUMTEXT'=> ['notNull', 'comment'],
        'LONGTEXT'  => ['notNull', 'comment'],
        
        'TINYBLOB'  => ['notNull', 'comment'],
        'BLOB'      => ['notNull', 'comment'],
        'MEDIUMBLOB'=> ['notNull', 'comment'],
        'LONGBLOB'  => ['notNull', 'comment'],
        
        'ENUM'      => ['values', 'notNull', 'default', 'comment'],
        'SET'       => ['values', 'notNull', 'default', 'comment'],
        
    ];
    private static $fieldProperties = [
                                    'type'      => 'INTEGER',
                                    'size'      => '11',
                                    'notNull'   => false,
                                    'unsigned'  => true,
                                    'default'   => 'NULL',
                                    'comment'   => '',
                                    'decimals'  => '3',
                                    'values'    => [],
                                    'autoincrement' => false,
                                    'unique' => false,
                                    'primary' => false
                                ];
    
    private static $defaultID = ['id' => [
                                    'type' => 'INTEGER',
                                    'size' => '11',
                                    'notNull' => false,
                                    'unsigned' => true,
                                    'default' => 'NULL',
                                    'comment' => '',
                                    'autoincrement' => true,
                                    'unique' => true,
                                    'primary' => true,
                                    'autoincrement' => true,
                                ]
                        ];
    
    private static function prepareField($fieldName, $fieldOptions = [])
        {
        if(empty($fieldOptions) || !isset($fieldOptions['type']) || empty($fieldOptions['type']))
            {
            throw new Exception('Unknown field type for field "'.$fieldName.'"');
            }
        if(!isset(self::$fieldTypes[$fieldOptions['type']]))
            {
            throw new Exception('Unknown field type "'.$fieldOptions['type'].'" for field "'.$fieldName.'"');
            }
            
        $availableOptions = self::$fieldTypes[$fieldOptions['type']];
    
        $options = "`$fieldName` ".$fieldOptions['type'];
  
        foreach($availableOptions as $key => $option)
            {
            if($key === 'size')
                {
                $size = ($fieldOptions['size']) ?  $fieldOptions['size'] : $option;
                $options .= "({$size})";
                continue;
                }
            
            
            if(!isset($fieldOptions[$option]))
                {
                continue;
                }
                
            switch ($option)
                {
                case 'size':
                    break;

                case 'notNull':
                    $options .= ($fieldOptions[$option]) ? ' NOT NULL' : '';
                    break;

                case 'unsigned':
                    $options .= ($fieldOptions[$option]) ? ' UNSIGNED' : '';
                    break;
                
                case 'default':
                    if($fieldOptions[$option] == 'NULL') 
                        {
                        $options .= ' DEFAULT NULL';
                        }
                    else
                        {
                        $options .= (isset($fieldOptions[$option])) ? " DEFAULT '".$fieldOptions[$option]."'" : '';
                        }
                    break;
                
                case 'comment':
                    $options .= ($fieldOptions[$option]) ? " COMMENT '".$fieldOptions[$option]."'" : '';
                    break;
                
                case 'autoincrement':
                    $options .= ($fieldOptions[$option]) ? " AUTO_INCREMENT" : '';
                    break;
                
                case 'values':
                    $options .= ($fieldOptions[$option]) ? "('".implode("','", $fieldOptions[$option])."')" : '';
                    break;
                }
            }
        return $options;
        }
        
    private static function prepareFieldsString($fields=[])
        {
        $result = '';
        
        if(empty($fields))
            {
            return $result;
            }
        
        if(empty($fields['id']))
            {
            $fields = ['id' => [
                'type' => 'INTEGER',
                'size' => '11',
                'notNull' => false,
                'unsigned' => true,
                'default' => 'NULL',
                'comment' => '',
                'autoincrement' => true,
                ]] + $fields;
            }
      
        $fieldsStr = '';
        foreach($fields as $fieldName => $fieldOptions)
            {
            $fieldsStr .= self::prepareField($fieldName, $fieldOptions) . ', ';
            }
            
        return $fieldsStr;
        }
        
    public static function createTable($tableName, $fields = [], $primaryKeys = ['id'])
        {
        $fieldsStr = self::prepareFieldsString($fields);
        $primaryKeysStr = implode('`,', $primaryKeys);
        
        $tableQuery = "CREATE TABLE `$tableName` ($fieldsStr PRIMARY KEY(`$primaryKeysStr`) );";
//        appDebugExit($tableQuery);    
        self::execute($tableQuery);
        return true;
        }

        
    public static function deleteTable($tableName)
        {
        $tableQuery = "DROP TABLE IF EXISTS `$tableName`;";
        
        self::execute($tableQuery);
        return true;
        }
        
    public static function createIndex($tableName, $fields = null, $type=null)
        {
        if(!$tableName)
            {
            throw new Exception("Param 'TableName' can't be empty!");
            }
        if(!$fields)
            {
            throw new Exception("Param 'Fields' can't be empty!");
            }
        
        if(is_array($fields)) 
            {
            $fieldsStr = implode(', ', $fields); 
            $indexName = implode('_', $fields);
            }
        else
            {
            $fieldsStr = $indexName = $fields;
            }
            
        $tableQuery = "CREATE {$type} INDEX $indexName ON `$tableName` ($fieldsStr);";
        
        self::execute($tableQuery);
        return true;
        }
        
    public static function fillData($tableName, $data)
        {
        if(!$tableName)
            {
            throw new Exception("Param 'TableName' can't be empty!");
            }
        if(!$data)
            {
            throw new Exception("Param 'data' can't be empty!");
            }
            
        $keys = '';
        $values = '';
        
        foreach($data as $key=>$value)
            {
            if ($value === '')
                {
                continue;
                }

            $keys .= $key.',';

            $value = $this->prepareValue($value);

            $values .=  "'".$value."',";
            }
          
        $values = rtrim($values, ',');
        $keys = rtrim($keys, ',');

        $sql = "INSERT INTO $tableName ($keys) VALUES ($values)";
        
        self::execute($sql);
        }

    private static function execute($sql)
        {
        $sqlBuilder =  new SQLBuilder();
        return $sqlBuilder->executeQuery($sql);
        }
}
