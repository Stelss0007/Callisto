<?php
namespace app\db\ActiveRecord;

/**
 * Description of Structure
 *
 * @author Ruslan Atamas
 */
class Structure extends SQLBuilder {
    private $fieldTypes = [
        //
        'TINYINT'   => ['size', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -128 to 127 / 0 to 255
        'SMALLINT'  => ['size', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -32768 to 32767  / 0 to 65535
        'MEDIUMINT' => ['size', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -8388608 to 8388607 / 0 to 16777215
        'INT'       => ['size', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -2147483648 to 2147483647 / 0 to 4294967295
        'INTEGER'   => ['size', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -2147483648 to 2147483647 / 0 to 4294967295
        'BIGINT'    => ['size', 'unsigned', 'notNull', 'comment', 'default', 'autoincrement', 'unique'],            // -9223372036854775808 to 9223372036854775807 / 0 to 18446744073709551615
        
        'FLOAT'     => ['size', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],                
        'DOUBLE'    => ['size', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],               
        'DECIMAL'   => ['size', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],              
        'DEC'       => ['size', 'unsigned', 'notNull', 'comment', 'default', 'decimals', 'unique'],    
        
        'DATE'      => ['notNull', 'comment', 'default', 'unique'],
        'DATETIME'  => ['notNull', 'comment', 'default', 'unique'],
        'TIMESTAMP' => ['notNull', 'comment', 'default', 'unique'],
        'TIME'      => ['notNull', 'comment', 'default', 'unique'],
        'YEAR'      => ['notNull', 'comment', 'default', 'unique'],
        
        'CHAR'      => ['size', 'notNull', 'comment', 'default', 'unique'],
        'VARCHAR'   => ['size', 'notNull', 'comment', 'default', 'unique'],
        'TINYTEXT'  => ['notNull', 'comment'],
        'TEXT'      => ['notNull', 'comment'],  
        'MEDIUMTEXT'=> ['notNull', 'comment'],
        'LONGTEXT'  => ['notNull', 'comment'],
        
        'TINYBLOB'  => ['notNull', 'comment'],
        'BLOB'      => ['notNull', 'comment'],
        'MEDIUMBLOB'=> ['notNull', 'comment'],
        'LONGBLOB'  => ['notNull', 'comment'],
        
        'ENUM'      => ['notNull', 'comment', 'values'],
        'SET'       => ['notNull', 'comment', 'values'],
        
    ];
    private $fieldProperties = [
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
    
    private $defaultID = ['id' => [
                                    'type' => 'INTEGER',
                                    'size' => '11',
                                    'notNull' => false,
                                    'unsigned' => true,
                                    'default' => 'NULL',
                                    'comment' => '',
                                    'autoincrement' => true,
                                    'unique' => true,
                                    'primary' => true
                                ]
                        ];
    
    private function prepareField($fieldName, $fieldOptions = [])
        {
        if(empty($fieldOptions) || !isset($fieldOptions['type']) || empty($fieldOptions['type']))
            {
            throw new Exception('Unknown field type for field "'.$fieldName.'"');
            }
        if(!isset($this->fieldTypes[$fieldOptions['type']]))
            {
            throw new Exception('Unknown field type "'.$fieldOptions['type'].'" for field "'.$fieldName.'"');
            }
            
        $availableOptions = $this->fieldTypes[$fieldOptions['type']];
        
        $options = $fieldOptions['type'];
        foreach($availableOptions as $option)
            {
            if(!isset($fieldOptions[$option]))
                {
                continue;
                }
                
            switch ($option)
                {
                case 'size':
                    $options .= "({$fieldOptions[$option]})";
                    break;

                case 'notNull':
                    $options .= ($fieldOptions[$option]) ? ' NOT NULL' : '';
                    break;

                case 'unsigned':
                    $options .= ($fieldOptions[$option]) ? ' UNSIGNED' : '';
                    break;
                
                case 'default':
                    $options .= ($fieldOptions[$option]) ? " DEFAULT '".$fieldOptions[$option]."'" : '';
                    break;
                
                case 'comment':
                    $options .= ($fieldOptions[$option]) ? " COMMENT '".$fieldOptions[$option]."'" : '';
                    break;
                
                case 'autoincrement':
                    $options .= ($fieldOptions[$option]) ? " AUTO_INCREMENT" : '';
                    break;
                }
            }

        }
        
    private function prepareFieldsString($fields=[])
        {
        $result = '';
        
        if(empty($fields))
            {
            return $result;
            }
        
        if(empty($fields['id']))
            {
            $fields['id'] = [
                'type' => 'INTEGER',
                'size' => '11',
                'notNull' => false,
                'unsigned' => false,
                'default' => 'NULL',
                'comment' => 'NULL',
                ];
            }
            
        foreach($fields as $fieldName => $fieldOptions)
            {
            $result = $this->prepareField($fieldName, $fieldOptions);
            }
        }
        
    public function createTable($tableName, $fields = [], $primaryKeys = ['id'])
        {
        
        
        $tableQuery = "CREATE TABLE `$tableName` ()";
        $this->executeQuery($tableQuery);
        return true;
        }
    
    public function install() 
        {
        return true;
        }
    
    public function uninstall()
        {
        return true;
        }
        
    public function data() 
        {
        return true;
        }
        
}
