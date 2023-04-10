<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
class Fruit extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
}