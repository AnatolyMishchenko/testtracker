<?php

namespace app\controllers;

use yii;
use app\models\Task;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \yii\base\DynamicModel;

/**
 * Class TaskController
 * @package app\controllers
 */
class TaskController extends Controller
{

    /**
     * show all
     * @return string
     */
    public function actionIndex()
    {
        $model = new Task();
        $modelMassEvent = new DynamicModel(['arrTasks', 'statusTask']);
        $modelMassEvent->addRule(['arrTasks', 'statusTask'], 'required')
            ->addRule(['arrTasks'], 'string')
            ->addRule(['statusTask'], 'integer');
        if ($modelMassEvent->load(Yii::$app->request->post())) {
            $dataForUpdate = Yii::$app->request->post();
            Task::updateTasksEvent($dataForUpdate);

            $this->refresh();
        }
        if ($model->load(Yii::$app->request->post())) {
            $filters = Yii::$app->request->post();
            $tasks = Task::getAllTasks($filters['Task']);
            $total = Task::getTotal($filters['Task']);
            if ($filters['Task']['generatePdf'] == 1) {
                Yii::$app->response->format = 'pdf';
                $this->layout = 'pdf';

                return $this->render('summary', [
                    'tasks' => $tasks,
                    'total' => $total,
                    'model' => $model,
                    'filters' => $filters['Task']
                ]);
            }
        } else {
            $tasks = Task::getAllTasks();
            $total = Task::getTotal();
        }

        return $this->render('index', [
            'tasks' => $tasks,
            'total' => $total,
            'model' => $model,
            'modelMassEvent' => $modelMassEvent
        ]);
    }

    public function actionView($id)
    {
        $task = Task::getTask($id);

        return $this->render('view', ['task' => $task]);
    }

    /**
     * create
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Task();
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->created_at)
                $model->created_at = date('Y-m-d');
            if ($model->status == 3) {
                $model->price = round($model->pay_per_hour*($model->work_time/60), 0);
                if (!$model->completed_at)
                    $model->completed_at = date('Y-m-d');
            }
            $model->user_id = \Yii::$app->user->identity->id;
            $model->save();

            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * edit
     * @param $id
     * @return string|yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEdit($id)
    {
        $model = Task::find()->where(['id' => $id])->one();
        if ($model === null)

            throw new NotFoundHttpException('Страница не существует');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->status == 3) {
                $model->price = round($model->pay_per_hour*($model->work_time/60), 0);
                if (!$model->completed_at)
                    $model->completed_at = date('Y-m-d');
            }
            $model->save();

            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }

    /**
     * delete
     * @param $id
     * @return yii\web\Response
     * @throws NotFoundHttpException
     * @throws yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = Task::findOne($id);
        if ($model === null)

            throw new NotFoundHttpException('The requested page does not exist.');
        $model->delete();

        return $this->redirect(['index']);
    }
}