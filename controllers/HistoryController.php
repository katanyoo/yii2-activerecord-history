<?php
namespace katanyoo\activerecordhistory\controllers;

use Yii;
use yii\web\Controller;
use katanyoo\activerecordhistory\ActiveRecordLogSearch;
/**
 * History Controller
 */
class HistoryController extends Controller {
	public function actionIndex() {
		$searchModel = new ActiveRecordLogSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('@vendor/katanyoo/yii2-activerecord-history/views/history/index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
}