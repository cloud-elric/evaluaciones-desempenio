<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\components\AccessControlExtend;
use app\models\CatAreas;


class AdminController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControlExtend::className(),
                'only' => ['index', 'send-email'],
                'rules' => [
                    [
                        'actions' => ['index', 'send-email'],
                        'allow' => true,
                        'roles' => ['administrador'],
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

    public function actionIndex(){        
        

        return $this->render("index");
    }
    
    public function actionAddUsersToList(){
        $users = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal"])->all();

        foreach($users as $user){
            $this->addUserToList($user->txt_email, $user->txt_username, $user->txt_apellido_paterno);
        }

        exit;
        
    }

    public function addUserToList($email, $firstName, $lastName){
        $username = Yii::$app->params ['madMimi'] ['username'];
        $apiKey = Yii::$app->params ['madMimi'] ['api_key'];
        $list = Yii::$app->params ['madMimi'] ['list_default'];

        $ch = curl_init ();
        
        curl_setopt ( $ch, CURLOPT_URL, "https://api.madmimi.com/audience_lists/".$list."/add" );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, "username=".$username."&api_key=".$apiKey."&email=".$email."&first_name=".$firstName."&last_name=".$lastName  );
        
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        
        $server_output = curl_exec ( $ch );
        
        curl_close ( $ch );
        echo $server_output;
        // further processing ....
        if ($server_output == "OK") {

        } else {
        }

        
    }

    public function actionSendEmail(){

        $users = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal"])->all();
        
        foreach($users as $user){
            $url = Yii::$app->urlManager->createAbsoluteUrl ( [
                'site/iniciar-evaluacion?token='.$user->txt_token
            ] );
            
            $this->sendEmailMadMimi($url, $user->txt_username, $user->txt_apellido_paterno,  $user->txt_email);
        }
        
        \Yii::$app->getSession()->setFlash('success', 'Emails enviados correctamente');
        return $this->redirect(["admin/index"]);
        
    }

    public function actionTest(){
        $username = Yii::$app->params ['madMimi'] ['username'];
        $apiKey = Yii::$app->params ['madMimi'] ['api_key'];
        $promotionName= "Evaluaciones";
        $name = "Alfredo";
        $lastName = "Elizondo";
        $email = "alfredo@2gom.com.mx";
        
        $string = Yii::$app->mailer->render('render/test', ['url' =>$url ], 'layouts/html.php');
        
        $ch = curl_init ();
        
        curl_setopt ( $ch, CURLOPT_URL, "https://api.madmimi.com/mailer" );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, "username=".$username."&api_key=".$apiKey."&promotion_name=".$promotionName."&recipient=".$name." ".$lastName." <".$email.">&subject=Evaluación&from=development@2gom.com.mx&raw_html=".urlencode($string)  );
        
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        
        $server_output = curl_exec ( $ch );
        
        curl_close ( $ch );
        //echo $server_output;
        // further processing ....
        if ($server_output == "OK") {
        } else {
        }
    }

    public function sendEmailMadMimi($url, $name, $lastName, $email){
        $username = Yii::$app->params ['madMimi'] ['username'];
        $apiKey = Yii::$app->params ['madMimi'] ['api_key'];
        $promotionName= "Evaluaciones";
        
        $string = Yii::$app->mailer->render('render/sendEmailEvaluacion', ['url' =>$url ], 'layouts/html.php');
        
        $ch = curl_init ();
        
        curl_setopt ( $ch, CURLOPT_URL, "https://api.madmimi.com/mailer" );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, "username=".$username."&api_key=".$apiKey."&promotion_name=".$promotionName."&recipient=".$name." ".$lastName." <".$email.">&subject=Evaluación&from=development@2gom.com.mx&raw_html=".urlencode($string)  );
        
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        
        $server_output = curl_exec ( $ch );
        
        curl_close ( $ch );
        //echo $server_output;
        // further processing ....
        if ($server_output == "OK") {
        } else {
        }
    }

}
