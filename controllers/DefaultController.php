<?php

namespace podtserkovsky\userdblog\controllers;

use podtserkovsky\userdblog\models\UserDbLogSearch;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `user-db-log` module
 */
class DefaultController extends Controller
{
    /**
     * Table of all users modifications.
     * 
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserDbLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    
    }
}
