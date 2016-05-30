<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use frontend\models\Keywords;

class TestController extends Controller
{
    public function actionIndex()
    {
		$postDatas = Yii::$app->request->post();
		print_r($postDatas);
		$dataProvider = new ActiveDataProvider([
			'query' => Keywords::find(),
			'pagination' => [
				'pageSize' => 20,
			],
		]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
	
	public function actionAdd()
    {
        $model = new Keywords;
		$postDatas = Yii::$app->request->post();
		$model->type = $postDatas['type'];
		$model->keyword_en = $postDatas['keyword_en'];
		$model->keyword_fr = $postDatas['keyword_fr'];
		if ($model->insert()) {
			$msg = 'Adding a new item succesful!';
			return json_encode(['id'=>$model->id,'datas'=>['id'=>$model->id,'type'=>$model->type,'keyword_en'=>$model->keyword_en,'keyword_fr'=>$model->keyword_fr],'status'=>true,'msg'=>$msg]);
        }
		$msg = 'Adding a new item failed!';
		return json_encode(['status'=>false,'msg'=>$msg]);
    }
	
	public function actionEdit()
    {
		$postDatas = Yii::$app->request->post();
		$id = $postDatas['id'];
        $model = new Keywords;
		$model = $model::findOne($id);
		$model->type = $postDatas['type'];
		$model->keyword_en = $postDatas['keyword_en'];
		$model->keyword_fr = $postDatas['keyword_fr'];
        if ($model->save()) {
			$msg = 'Updating an item succesful!';
			return json_encode(['id'=>$model->id,'datas'=>['id'=>$model->id,'type'=>$model->type,'keyword_en'=>$model->keyword_en,'keyword_fr'=>$model->keyword_fr],'status'=>true,'msg'=>$msg]);
        }
		$msg = 'Updating an item failed!';
		return json_encode(['status'=>false,'msg'=>$msg]);
    }
	
	public function actionDelete()
    {
		$postDatas = Yii::$app->request->post();
		$id = $postDatas['id'];
        $model = new Keywords;
		$model = $model::findOne($id);
        if($model->delete()){
			$msg = 'Deleting an item succesful!!';
			return json_encode(['status'=>true,'msg'=>$msg]);
		}
		$msg = 'Deleting an item succesful!';
		return json_encode(['status'=>false,'msg'=>$msg]);
    }
}
