<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

define('APP_DIRECTORY', __DIR__);

//phpinfo();exit;
include_once __DIR__.'/vendor/autoload.php';
include_once __DIR__.'/kernel/Exceptions.php';
include_once __DIR__.'/kernel/ErrorHandler.php';
$errors = ErrorHandler::getInstance();

date_default_timezone_set('America/New_York');

include_once __DIR__.'/kernel/Globals.php';
include_once __DIR__.'/kernel/App.php';
include_once __DIR__.'/kernel/AppObject.php';
include_once __DIR__.'/kernel/Request.php';
include_once __DIR__.'/kernel/core.php';

include_once __DIR__.'/kernel/Router.php';
include_once __DIR__.'/kernel/Controller.php';
include_once __DIR__.'/kernel/Model.php';

include_once __DIR__.'/kernel/Validator.php';
include_once __DIR__.'/kernel/db/SQLBuilder.php';
include_once __DIR__.'/kernel/db/ModelInterface.php';
include_once __DIR__.'/kernel/db/Model.php';
include_once __DIR__.'/kernel/db/Table.php';
include_once __DIR__.'/kernel/db/Structure.php';
include_once __DIR__.'/kernel/Cache.php';

App::init();

$router = new Router();
$router->run();

//$query = new SQLBuilder();
//$result = $query->from('article')
//        ->select(['article_title', 'id', 'article_description'])
//        ->andWhere(['like'=>['name1'=>'%rus', 'name2'=>'bad']])
//        ->andWhere(['id'=>'10', 'LIKE'=>['name'=>'rus']])
//        ->andWhere(['id'=>['10','20','30']])
//        ->andWhere(['name'=>'ruslan'])
//        ->getSQLString();
//print_r($result);



//require('kernel/debuger.php');
//$debuger = \Debuger::getInstance();
////$debuger->startRenderPage();
////
//class Test2 extends \app\db\ActiveRecord\Model
//{
//    static $relations = [
//        'hasMany' => [
//            'testField' => ['\Test3']
//        ]
//    ];
//}
////
//class Test3 extends \app\db\ActiveRecord\Model
//{
//
//}
////
////
//class Test extends \app\db\ActiveRecord\Model
//{
//    static $validators = [
//        'description' => ['date'=>'Y/m/d', 'min'=>10]
//    ];
//
//    static $relations = [
//        'hasMany' => [
//            'testField' => ['\Test2']
//        ]
//    ];
//
//
//    public function testing()
//        {
//        echo ' 2222222222 ';
//        }
//}
//
////$model = new Test();
//
////print_r(Test::find()->all());
////if(!$article = Test::find(15))
////    $article = new Test();//Article::find(1);
////$article->name = 4444;
////$article->save();
//
//
//$article = Test::find(1)->with('testField');
//$articles = Test::find()->with('testField')->all();
//print_r($articles);exit;

//appDebug(Test::findAll());

//$article->description = '2010/14/10';
//if(!$article->save())
//    {
//    print_r($article->validateGetErrors());
//    }

//$articles = Test::find()->all();
//print_r($articles);

//print_r(Test::findOne(['id'=>'2']));

//foreach ($articles as $article)
//    {
//    echo $article->name;
//    $article->description = 'Updated 2';
//    $article->save();
//    print_r($article->description);
//    //$article->save();
//    //$article->test();
//    }
//throw new ErrorException('wwwww');
//$debuger->endRenderPage();
//$debuger->render(); 
    
exit;



