<?php 

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
class FruitController extends ActiveController {
    public $modelClass = 'app\models\Fruit';
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page', 'X-Pagination-Current-Page', 'X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Per-Page'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
}