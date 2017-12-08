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
                'only' => ['index', 'evaluacion', 'preguntas-usuario'],
                'rules' => [
                    [
                        'actions' => ['index', 'evaluacion', 'preguntas-usuario'],
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

    public function actionTest($token = null){
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

        $usuario = EntUsuarios::find()->where(['txt_token'=>$token])->one();
        if($usuario){
            if (Yii::$app->getUser ()->login ( $usuario )) {
                //return $this->goHome ();
                return $this->redirect('evaluacion');
            }
        }else{
            echo "Token invalido";
            //$this->render();
        }
    }

    public function actionEvaluacion(){
        $usuario = Yii::$app->user->identity;
        $empleados = EntUsuarios::find()->where(['id_area'=>$usuario->id_area])->all();
        $empleadosOtros = EntUsuarios::find()->where(['!=', 'id_area', $usuario->id_area])->all();

        if($empleados && $empleadosOtros){
            return $this->render('vista-empleados',[
                'empleados' => $empleados,
                'empleadosOtros' => $empleadosOtros
            ]);
        }
    }

    public function actionPreguntasUsuario($token = null){
        $usuario = Yii::$app->user->identity;
        $usuarioCuestionario = EntUsuarios::find()->where(['txt_token'=>$token])->one();

        $relUsuarioArea = RelUsuarioArea::find()->where(['id_usuario'=>$usuarioCuestionario->id_usuario])->one();
        $arrayRelCuestionarioArea = RelCuestionarioArea::find()->where(['id_area'=>$relUsuarioArea->id_area])->select('id_cuestionario');

        $relUsuarioCuest = RelUsuarioCuestionario::find()->where(['id_usuario'=>$usuario->id_usuario])->andWhere(['id_usuario_calificado'=>$usuarioCuestionario->id_usuario])->one();
        if($relUsuarioCuest == null){
            $cuestionario = EntCuestionario::find()->where(['in', 'id_cuestionario', $arrayRelCuestionarioArea])->one();
            
            $relUsuarioCuest = new RelUsuarioCuestionario;
            $relUsuarioCuest->id_usuario = $usuario->id_usuario;
            $relUsuarioCuest->id_usuario_calificado = $usuarioCuestionario->id_usuario;
            //$relUsuarioCuest->id_cuestionario = $cuestionario->id_cuestionario;
            $relUsuarioCuest->id_evaluacion = $cuestionario->id_evaluacion;

            $relUsuarioCuest->save();
        }

        $relUserResp = RelUsuarioRespuesta::find()->where(['id_usuario_cuestionario'=>$relUsuarioCuest->id_usuario_cuestionario])->select('id_respuesta');
        $preguntasContestadas = [];
        if($relUserResp){
            $preguntasContestadas = EntRespuestas::find()->where([ 
                'in', 'id_respuesta', $relUserResp,
            ])->select('id_pregunta');
        }

        $arrayCuestionario = EntCuestionario::find()->where(['in', 'id_cuestionario', $arrayRelCuestionarioArea])->select('id_cuestionario');
        $pregunta = EntPreguntas::find()->where(['in', 'id_cuestionario', $arrayCuestionario])->andWhere([ 
            'not in',
            'id_pregunta',
            $preguntasContestadas 
        ])->orderBy('id_pregunta')->one();
        
        if(isset($_POST['respuesta'])){
            $respuesta = new EntRespuestas;
            $respuesta->id_pregunta = $pregunta->id_pregunta;
            $respuesta->save();

            $nuevaRelUserResp = new RelUsuarioRespuesta;
            $nuevaRelUserResp->id_usuario_cuestionario = $relUsuarioCuest->id_usuario_cuestionario;
            $nuevaRelUserResp->id_respuesta = $respuesta->id_respuesta;
            $nuevaRelUserResp->id_respuesta = $respuesta->id_respuesta;
            $nuevaRelUserResp->txt_valor = $_POST['respuesta'];
            $nuevaRelUserResp->save();
            
            return $this->redirect(['preguntas-usuario?token='.$usuarioCuestionario->txt_token]);
        }

        return $this->render('vista-preguntas',[
            'usuario' => $usuario,
            'usuarioCuestionario' => $usuarioCuestionario,
            'pregunta' => $pregunta
        ]); 
    }

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

    public function actionGetcontrollersandactions()
    {
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[strtolower(substr($controller, 0, -14))][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;

        print_r($fulllist);
        exit;
        return $fulllist;
    }
}
