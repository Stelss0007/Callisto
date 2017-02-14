<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 08.02.17
 * Time: 16:31
 */

$fullURL = parse_url($_SERVER["REQUEST_URI"]);
// Разбиваем внутренний путь на сегменты.
$segments = explode('/', trim($fullURL['path'], '/'));
array_shift($segments);
$action = array_shift($segments);

$method = strtolower($_SERVER['REQUEST_METHOD']);

$functionName = $method.ucfirst($action);

if (!function_exists($functionName)) {
    echo json_encode(['status'=>'error', 'message'=>'Action not found']);
    exit;
}

echo json_encode(call_user_func_array($functionName, $segments));
exit;



function getUserlist()
{
    $result = [
        [
            'name' => 'TestName1',
            'secondName' => 'TestSecondName1',
        ],
        [
            'name' => 'TestName2',
            'secondName' => 'TestSecondName2',
        ],
        [
            'name' => 'TestName3',
            'secondName' => 'TestSecondName3',
        ],
        [
            'name' => 'TestName5',
            'secondName' => 'TestSecondName5',
        ],
        [
            'name' => 'TestName6',
            'secondName' => 'TestSecondName6',
        ],
        [
            'name' => 'TestName7',
            'secondName' => 'TestSecondName7',
        ]
    ];

    return $result;
}

