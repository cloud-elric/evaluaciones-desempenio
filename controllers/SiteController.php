<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\AccessControlExtend;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\models\RelUsuarioArea;
use app\models\EntPreguntas;
use app\models\EntCuestionario;
use app\models\RelUsuarioCuestionario;
use app\models\EntRespuestas;
use app\models\RelUsuarioRespuesta;
use app\models\RelCuestionarioArea;
use app\modules\ModUsuarios\models\Utils;
use app\models\CatAreas;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControlExtend::className(),
                'only' => ['index', 'evaluacion', 'preguntas-usuario', 'niveles'],
                'rules' => [
                    [
                        'actions' => ['index', 'evaluacion', 'preguntas-usuario', 'niveles'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionTest($token = null)
    {
        //$auth = Yii::$app->authManager;
    
        //  // add "updatePost" permission
        //  $updatePost = $auth->createPermission('about');
        //  $updatePost->description = 'Update post';
        //  $auth->add($updatePost);
        //         // add "admin" role and give this role the "updatePost" permission
        // // as well as the permissions of the "author" role
        // $admin = $auth->createRole('test');
         //$auth->add($admin);
        // $auth->addChild($admin, $updatePost);

        $usuario = EntUsuarios::find()->where(['txt_token' => $token])->one();
        if ($usuario) {
            if (Yii::$app->getUser()->login($usuario)) {
                //return $this->goHome ();
                return $this->redirect('evaluacion');
            }
        } else {
            echo "Token invalido";
            //$this->render();
        }
    }

    public function actionEvaluacion()
    {

        $usuario = Yii::$app->user->identity;
        if ($usuario->txt_auth_item == "admin"/*Yii::$app->user->can('admin')*/ ) {
            $niveles = CatAreas::find()->all();

            return $this->render('vista-admin');
        }

        $usuariosCalificar = RelUsuarioCuestionario::find()->where(['id_usuario' => $usuario->id_usuario])->all();

        return $this->render('vista-empleados', [
            'usuariosCalificar' => $usuariosCalificar,
        ]);

    }

    public function actionPreguntasUsuario2($token = null)
    {
        $usuario = Yii::$app->user->identity;
        $usuarioCuestionario = EntUsuarios::find()->where(['txt_token' => $token])->one();

        $relUsuarioArea = RelUsuarioArea::find()->where(['id_usuario' => $usuarioCuestionario->id_usuario])->one();
        $arrayRelCuestionarioArea = RelCuestionarioArea::find()->where(['id_area' => $relUsuarioArea->id_area])->select('id_cuestionario');

        $cuestionarios = EntCuestionario::find()->where(['in', 'id_cuestionario', $arrayRelCuestionarioArea])->all();

        return $this->render('vista-preguntas2', [
            'usuario' => $usuario,
            'usuarioCuestionario' => $usuarioCuestionario,
            'cuestionarios' => $cuestionarios
        ]);
    }

    public function actionPreguntasUsuario($token = null)
    {
        $usuario = Yii::$app->user->identity;
        $usuarioAEvaluar = EntUsuarios::find()->where(['txt_token' => $token])->one();

        $cuestionariosEvaluados = [];
        $cuestionariosCompletos = EntRespuestas::find()
            ->where(['id_usuario' => $usuario->id_usuario])
            ->andWhere(['id_usuario_evaluado' => $usuarioAEvaluar->id_usuario])->all();

        foreach ($cuestionariosCompletos as $cuestionario) {
            $cuestionariosEvaluados[] = $cuestionario->id_cuestionario;

        }
        $cuestionarios = RelCuestionarioArea::find()
            ->where(['id_area' => $usuarioAEvaluar->id_area])
            ->andWhere(['not in', 'id_cuestionario', $cuestionariosEvaluados])
            ->all();

        return $this->render('vista-preguntas', [
            'cuestionarios' => $cuestionarios,
            'eva' => $token
        ]);
    }

    /*public function actionNiveles()
    {
        $niveles = CatAreas::find()->all();

        return $this->render('vista-niveles', [
            'niveles' => $niveles
        ]);
    }*/

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
        // $usuario = Yii::$app->user->identity;
        // $auth = \Yii::$app->authManager;
        // $authorRole = $auth->getRole('test');
        // $auth->assign($authorRole, $usuario->getId());

        return $this->render('index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $this->layout = null;
        return $this->renderAjax('about');
    }

    public function actionGuardarPreguntasCuestionario($token = null, $eva = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response['status'] = 'error';
        $response['message'] = 'Ocurrio un problema al guardar';
        $cuestionario = EntCuestionario::find()->where(["id_cuestionario" => $token])->one();
        $usuarioEvaluar = EntUsuarios::find()->where(['txt_token' => $eva])->one();
        $usuario = Yii::$app->user->identity;

        $respuesta = new EntRespuestas();
        $respuesta->id_cuestionario = $cuestionario->id_cuestionario;
        $respuesta->id_usuario_evaluado = $usuarioEvaluar->id_usuario;
        $respuesta->fch_creacion = Utils::getFechaActual();
        $respuesta->id_usuario = $usuario->id_usuario;
        $respuesta->id_area = $usuarioEvaluar->id_area;
        $transaction = EntRespuestas::getDb()->beginTransaction();
        $error = false;
        $errores = [];
        try {
            if ($respuesta->save()) {


                foreach ($_POST['respuesta'] as $index => $value) {
                    $respuestasUsuarios = new RelUsuarioRespuesta();
                    $respuestasUsuarios->id_respuesta = $respuesta->id_respuesta;
                    $respuestasUsuarios->id_pregunta = $index;
                    $respuestasUsuarios->txt_valor = $value;

                    if (!$respuestasUsuarios->save()) {
                        $error = true;
                        $errores = $respuestasUsuarios->errors;
                    }
                }

                if ($error) {
                    $response['message'] = 'No se pudo guardar alguna pregunta';
                    $response['errors'] = $errores;
                } else {
                    $transaction->commit();
                    $response['status'] = 'success';
                    $response['message'] = 'Cuestionario guardado';
                }

            } else {
                $transaction->rollBack();
            }


        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $response;
    }

    public function actionPrueba(){
        $areas = CatAreas::find()->all();
        $datos = [];
        foreach ($areas as $area){
            $datos[$area->id_area]['nombreArea'] = $area->txt_nombre;
            //$datos[$area->id_area]['nombreCuestionario']['resultados'] = null;                            
            for ($index = 1; $index <= 5; $index++){
                $datos[$area->id_area]['resultados'][$index] = 0;                                
            }
            //$respuestas = $area->entRespuestas;
            $relCuestionariosArea = RelCuestionarioArea::find()->where(['id_area'=>$area->id_area])->all();
            foreach($relCuestionariosArea as $relCuestionarioArea){
                $cuestionario =$relCuestionarioArea->idCuestionario;
                $datos[$area->id_area]['resultados']['nombreCuestionario'] = $cuestionario->id_cuestionario;
                $respuestas = $area->getEntRespuestasByCuestionario($cuestionario->id_cuestionario);
                foreach ($respuestas as $respuesta) {
                    $respuestaValores = $respuesta->relUsuarioRespuestas;
                    foreach ($respuestaValores as $respuestaValor){
                        switch ($respuestaValor->txt_valor){
                            case '1':
                                # code...
                                $datos[$area->id_area]['resultados'][$respuestaValor->txt_valor] += 1;
                                break;
                            case '2':
                                # code...
                                $datos[$area->id_area]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            case '3':
                                # code...
                                $datos[$area->id_area]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            case '4':
                                # code...
                                $datos[$area->id_area]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            case '5':
                                # code...
                                $datos[$area->id_area]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
            }
        }
        print_r($datos);
    }

    public function actionNiveles(){
        $areas = CatAreas::find()->all();
        $datos = [];
        foreach ($areas as $area){
            $datos[$area->id_area]['nombreArea'] = $area->txt_nombre;
            //$datos[$area->id_area]['nombreCuestionario']['resultados'] = null;                            
            
            //$respuestas = $area->entRespuestas;
            $relCuestionariosArea = RelCuestionarioArea::find()->where(['id_area'=>$area->id_area])->all();
            foreach($relCuestionariosArea as $relCuestionarioArea){
                $cuestionario =$relCuestionarioArea->idCuestionario;

                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario] = ['resultados' => null ];
                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['nombre'] = $cuestionario->txt_nombre;
                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['idCuestionario'] = $cuestionario->id_cuestionario;
                for ($index = 1; $index <= 5; $index++){
                    $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['resultados'][$index] = 0;                                
                }
                $respuestas = $area->getEntRespuestasByCuestionario($relCuestionarioArea->id_cuestionario);
                foreach ($respuestas as $respuesta){
                    $respuestaValores = $respuesta->relUsuarioRespuestas;
                    foreach ($respuestaValores as $respuestaValor){
                        switch ($respuestaValor->txt_valor){
                            case '1':
                                # code...
                                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['resultados'][$respuestaValor->txt_valor] += 1;
                                break;
                            case '2':
                                # code...
                                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            case '3':
                                # code...
                                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            case '4':
                                # code...
                                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            case '5':
                                # code...
                                $datos[$area->id_area]['cuestionario'][$cuestionario->id_cuestionario]['resultados'][$respuestaValor->txt_valor] += 1;                            
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
            }
        }
        return $this->render('vista-niveles2', [
            'datos' => $datos
        ]);
        //print_r($datos);
    }
}
