<?php

namespace app\controllers;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\modules\ModUsuarios\models\EntUsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * EntUsuariosController implements the CRUD actions for EntUsuarios model.
 */
class EntUsuariosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EntUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntUsuarios model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EntUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntUsuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EntUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EntUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EntUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EntUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntUsuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBuscarEmpleado($q = null, $page = 0)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      
        if ($page > 1) {
            $page--;
        }

        
        $empleados = EntUsuarios::find()
            ->where(['like', 'txt_username', $q])
            ->orWhere(['like', 'txt_apellido_paterno', $q])
            ->andWhere(['txt_auth_item'=>"usuario-normal"]);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $empleados,
             'pagination'=>[
                 'pageSize' =>30,
                 'page' => $page
             ],
            'sort' => [
                'defaultOrder' => [
                    'txt_username' => \SORT_ASC,
                    'txt_apellido_paterno'=> \SORT_ASC,
                ]
            ],
            
        ]);
        $response['results'] = null;
        $response['total_count'] = $dataProvider->getTotalCount();

        $resultados = $dataProvider->getModels();
        if (count($resultados) == 0) {
            $response['results'][0] = ['id' => '', "txt_nombre" => ''];
        }

        foreach ($resultados as $model) {
            
                $response['results'][] = [
                    'id' => $model->id_usuario, 
                    "txt_nombre" => $model->nombreCompleto];    
            }    

           
            // else{
            //     $response['results'][] = ['id' => $model->id_equipo, "txt_nombre" => $model->txt_nombre, "cantidad" => 0];
            // }    
              

        return $response;
    }
}
