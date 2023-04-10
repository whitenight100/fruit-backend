<?php

namespace app\commands;

use yii\console\Controller;
use yii\httpclient\Client;
use yii\db\Connection;

class FruitController extends Controller
{
    public $message;
    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    public function actionIndex()
    {
        $yourdb = new Connection([
            'dsn' => 'mysql:host=localhost;dbname=fruity',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]); 

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://fruityvice.com/api/fruit/all')
            ->send();
        if ($response->isOk) {
            // echo $response->data[0]['genus'];
            $data = $response->data;
            foreach($data as $fruit) {

                $yourdb->createCommand()->upsert('fruit', [
                    'id' => $fruit['id'], 
                    'genus' => $fruit['genus'],
                    'name' => $fruit['name'],
                    'family' => $fruit['family'],
                    'order' => $fruit['order'],
                    'carbohydrates' => $fruit['nutritions']['carbohydrates'],
                    'protein' => $fruit['nutritions']['protein'],
                    'fat' => $fruit['nutritions']['fat'],
                    'calories' => $fruit['nutritions']['calories'],
                    'sugar' => $fruit['nutritions']['sugar']
                ])->execute();

            }

            ////////////////// Ucomment this after purchasing and configuring mail service ////////////////////

            // Yii::$app->mailer->compose()
            //     ->setFrom('from@domain.com')
            //     ->setTo('to@domain.com')
            //     ->setSubject('Message subject')
            //     ->setTextBody('Plain text content')
            //     ->setHtmlBody('<b>HTML content</b>')
            //     ->send();

            ////////////////////////////////////////////////////////////////////////////////////////////////////
            
        }
    }
}