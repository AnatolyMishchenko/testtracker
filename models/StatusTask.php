<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Status
 * @package app\models
 */
class StatusTask extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_task';
    }
}