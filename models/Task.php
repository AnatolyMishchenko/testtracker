<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Task
 * @package app\models
 * @property $statusName
 * @property $companyName
 * @property $generatePdf
 * @property $dateBegin
 * @property $dateEnd
 * @property $statusTask
 * @property $companyTask
 *
 */
class Task extends ActiveRecord
{

    public $statusName;
    public $companyName;
    public $dateBegin;
    public $dateEnd;
    public $statusTask;
    public $companyTask;
    public $generatePdf;
    public $taskIdArr;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status', 'company', 'pay_per_hour'], 'required'],
            [['link', 'project'], 'string', 'max' => 300],
            [['created_at', 'completed_at', 'dateBegin', 'dateEnd'], 'string'],
            [['status', 'company', 'user_id'], 'integer', 'max' => 10],
            [['price', 'base_price'], 'integer', 'max' => 500000],
            [['work_time', 'pay_per_hour'], 'integer', 'max' => 10000],
            [['pay_per_hour'], 'integer', 'max' => 10000],
            [['title', 'body'], 'string', 'max' => 2500]
        ];
    }

    /**
     * @return array task form labels
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Задача',
            'status' => 'Статус',
            'pay_per_hour' => 'Ставка за час',
            'work_time' => 'Потраченное время',
            'base_price' => 'Сумма за задачу',
            'price' => 'Итоговая сумма',
            'company' => 'Контора',
            'project' => 'Проект',
            'link' => 'Ссылка',
            'body' => 'Описание',
            'created_at' => 'Дата создания',
            'completed_at' => 'Дата сдачи',
            'dateBegin' => 'От',
            'dateEnd' => 'До',
            'generatePdf' => 'Cгенерировать отчет в PDF',
            'arrTasks' => 'Выбранные задачи',
            'statusTask' => 'Статус'
        ];
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getAllTasks($filters = false)
    {
        $userIdTask = \Yii::$app->user->identity->id;
        if ($filters) {
            if ($filters['dateBegin']) {
                $curMonthBeginDate = $filters['dateBegin'];
            } else {
                $curMonthBeginDate = date('Y-m-1');
            }
            if ($filters['dateEnd']) {
                $curMonthEndDate = $filters['dateEnd'];
            } else {
                $curMonthEndDate = date('Y-m-d',strtotime(date('Y-m-1',strtotime('next month')).'-1 day'));
            }
        } else {
            $curMonthBeginDate = date('Y-m-1');
            $curMonthEndDate = date('Y-m-d',strtotime(date('Y-m-1',strtotime('next month')).'-1 day'));
        }
        $tasks = self::find()->where(['between', 'created_at', $curMonthBeginDate, $curMonthEndDate ])
            ->select([
                'task.*',
                'status_task.name as statusName',
                'company.name as companyName'
            ])
            ->innerJoin('status_task', 'status_task.id=task.status')
            ->innerJoin('company', 'company.id=task.company');
        if ($filters) {
            if ((int) $filters['status'] !== 0) {
                $tasks = $tasks->andWhere(['=', 'status', (int) $filters['status']]);
            }
            if ((int) $filters['company'] !== 0) {
                $tasks = $tasks->andWhere(['=', 'company', (int) $filters['company']]);
            }
        }
        $tasks = $tasks->andWhere(['=', 'user_id', (int) $userIdTask]);
        $tasks = $tasks->orderBy(['task.id' => SORT_DESC])->all();

        return $tasks;
    }

    /**
     * @param $id
     * @return array|ActiveRecord[]
     */
    public function getTask($id)
    {
        $userIdTask = \Yii::$app->user->identity->id;
        $task = self::find()
            ->select([
                'task.*',
                'status_task.name as statusName',
                'company.name as companyName'
            ])
            ->innerJoin('status_task', 'status_task.id=task.status')
            ->innerJoin('company', 'company.id=task.company')
            ->where(['task.id' => $id])
            ->andWhere(['task.user_id' => $userIdTask])
            ->all();

        return $task;
    }

    /**
     * total price and work time
     * @return array
     */
    public static function getTotal($filters = false)
    {
        $userIdTask = \Yii::$app->user->identity->id;
        if ($filters) {
            if ($filters['dateBegin']) {
                $curMonthBeginDate = $filters['dateBegin'];
            } else {
                $curMonthBeginDate = date('Y-m-1');
            }
            if ($filters['dateEnd']) {
                $curMonthEndDate = $filters['dateEnd'];
            } else {
                $curMonthEndDate = date('Y-m-d',strtotime(date('Y-m-1',strtotime('next month')).'-1 day'));
            }
        } else {
            $curMonthBeginDate = date('Y-m-1');
            $curMonthEndDate = date('Y-m-d',strtotime(date('Y-m-1',strtotime('next month')).'-1 day'));
        }
        $allWorkTime = self::find()->where(['between', 'created_at', $curMonthBeginDate, $curMonthEndDate ]);
        if ($filters) {
            if ((int) $filters['status'] !== 0) {
                $allWorkTime = $allWorkTime->andWhere(['=', 'status', (int) $filters['status']]);
            } else {
                $allWorkTime = $allWorkTime->andWhere(['status' => 3]);
            }
            if ((int) $filters['company'] !== 0) {
                $allWorkTime = $allWorkTime->andWhere(['=', 'company', (int) $filters['company']]);
            }
        } else {
            $allWorkTime = $allWorkTime->andWhere(['status' => 3]);
        }
        $allWorkTime = $allWorkTime->andWhere(['user_id' => $userIdTask]);
        $allWorkTime = $allWorkTime->sum('work_time');
        $allPrice = self::find()->where(['between', 'created_at', $curMonthBeginDate, $curMonthEndDate ]);
        if ($filters) {
            if ((int) $filters['status'] !== 0) {
                $allPrice = $allPrice->andWhere(['=', 'status', (int) $filters['status']]);
            } else {
                $allPrice = $allPrice->andWhere(['status' => 3]);
            }
            if ((int) $filters['company'] !== 0) {
                $allPrice = $allPrice->andWhere(['=', 'company', (int) $filters['company']]);
            }
        } else {
            $allPrice = $allPrice->andWhere(['status' => 3]);
        }
        $allPrice = $allPrice->andWhere(['user_id' => $userIdTask]);
        $allPrice = $allPrice->sum('price');
        $total = ['allWorkTime' => $allWorkTime, 'allPrice' => $allPrice];

        return $total;
    }

    /**
     * @param $dataForUpdate
     * @throws \yii\db\Exception
     */
    public function updateTasksEvent($dataForUpdate)
    {
        $idTasksArr = explode(',', $dataForUpdate['DynamicModel']['arrTasks']);
        $status = $dataForUpdate['DynamicModel']['statusTask'];
        foreach ($idTasksArr as $idTasksArrKey => $idTasksArrValue) {
            \Yii::$app->db
                ->createCommand()
                ->update(self::tableName(),
                    ['status' => $status],
                    'id = '. $idTasksArrValue .'')
                ->execute();
        }
    }
}