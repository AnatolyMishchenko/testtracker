<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Company
 * @package app\models
 */
class Company extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }
}