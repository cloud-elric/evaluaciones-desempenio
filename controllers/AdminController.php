<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\components\AccessControlExtend;
use app\models\CatAreas;
use app\models\CatNiveles;
use yii\web\Response;
use app\models\EntCuestionario;
use app\models\EntRespuestas;


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
                'only' => ['index', 'send-email', 'reporte-por-niveles'],
                'rules' => [
                    [
                        'actions' => ['index', 'send-email', 'reporte-por-niveles'],
                        'allow' => true,
                        'roles' => ['administrador'],
                    ],

                ],
            ],
        ];
    }
    

    public function actionIndex(){    
        #Yii::$app->response->format = Response::FORMAT_JSON;
        $niveles = CatNiveles::find()->where(["b_habilitado"=>1])->all();
        $resultados = [];
        foreach($niveles as $nivel){
            
            $cuestionariosNivel = $nivel->relCuestionarioNiveles;

            $nombreCuestionarios = [];
            $puntuacionPromedio = 0;
            foreach($cuestionariosNivel as $cuestionarioNivel){
                $cuestionario = $cuestionarioNivel->idCuestionario;
                $preguntas = $cuestionario->entPreguntas;
                $respuestas = $cuestionario->getEntRespuestasByNivel($nivel->id_nivel)->all();
                $puntuacionPromedio = $cuestionarioNivel->num_puntuacion;

                $respuestasUsuarios = [];
                foreach($respuestas as $respuesta){
                    $respuestasUsuarios = $respuesta->relUsuarioRespuestas;

                }

                $textoPreguntas = [];
                foreach($preguntas as $pregunta){
                    $respuestasValores=[];
                    $promedio = 0;
                    $total = 0;
                    $numPreguntas = 0;
                    foreach($respuestasUsuarios as $respuestaUsuario){
                        if($respuestaUsuario->id_pregunta == $pregunta->id_pregunta){
                            $numPreguntas++;
                            $total += $respuestaUsuario->txt_valor;
                        }
                        
                    }

                    $promedio = $total/$numPreguntas;

                    $textoPreguntas[] = [
                        'texto_pregunta'=>$pregunta->txt_pregunta,
                        'promedio'=>$promedio,
                        'total'=>$total,
                        'numPreguntas'=>$numPreguntas
                        
                    ];
                }

                $nombreCuestionarios[] = [
                    'nombre_cuestionario' =>$cuestionario->txt_nombre,
                    'identificador'=>$cuestionario->id_cuestionario.$nivel->id_nivel,
                    'preguntas'=>$textoPreguntas,
                    'puntuacionPromedio'=>$puntuacionPromedio
                ];
            }


            $resultados[$nivel->id_nivel] = [
                'nombre_nivel'=>$nivel->txt_nombre,
                'cuestionarios'=>$nombreCuestionarios,
                
            ];
        }

        // return $resultados;

        // exit;

        return $this->render("index", ["resultados"=>$resultados]);
    }
    
    public function actionResultadosPorCompetencias(){
        //Yii::$app->response->format = Response::FORMAT_JSON;
        $resultados = [];
        $cuestionarios = EntCuestionario::find()->all();

        foreach($cuestionarios as $cuestionario){
            $preguntasRel = $cuestionario->entPreguntas;
            $preguntas = [];
            foreach($preguntasRel as $preguntaRel){
                $respuestasRel = $preguntaRel->relUsuarioRespuestas;

                $promedio = 0;
                $total = 0;
                $numPreguntas = count($respuestasRel);
                foreach($respuestasRel as $respuestaRel){
                    $total +=$respuestaRel->txt_valor;
                }
                
                $promedio = $total/$numPreguntas;

                $preguntas[]=[
                    'texto_pregunta'=>$preguntaRel->txt_pregunta,
                    'promedio'=>round($promedio, 1),
                    'total'=>$total,
                ];
            } 


            $resultados[$cuestionario->id_cuestionario]=[
                'nombre_cuestionario'=>$cuestionario->txt_nombre,
                'identificador'=>$cuestionario->id_cuestionario,
                'preguntas'=>$preguntas,

            ];
        }

        return $this->render("resultados-por-competencia", ["resultados"=>$resultados]);
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
        Yii::$app->response->format = Response::FORMAT_JSON;
        $users = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal"])->all();
        
        $respuesta['status'] = "success";
        $respuesta['message'] = "Correos enviados correctamente";
        foreach($users as $user){
            $url = Yii::$app->urlManager->createAbsoluteUrl ( [
                'site/iniciar-evaluacion?token='.$user->txt_token
            ] );
            
            $this->sendEmailMadMimi($url, $user->txt_username, $user->txt_apellido_paterno,  $user->txt_email);
        }

        return $respuesta;
    }

    public function sendEmailMadMimi($url, $name, $lastName, $email){
        $username = Yii::$app->params ['madMimi'] ['username'];
        $apiKey = Yii::$app->params ['madMimi'] ['api_key'];
        $promotionName= "Evaluaciones";
        
        $string = Yii::$app->mailer->render('render/sendEmailEvaluacion', ['url' =>$url, 'nombre'=>$name." ".$lastName ], 'layouts/html.php');
        
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

    public function actionResultadosPorEmpleados(){
        #Yii::$app->response->format = Response::FORMAT_JSON;

        $empleados = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal"])->orderBy("txt_username, txt_apellido_paterno")->all();
        $resultados = [];

        foreach($empleados as $empleado){
            $nivel = $empleado->idNivel;

            $cuestionariosRel = $nivel->relCuestionarioNiveles;
            $cuestionarios = [];
            $totalEmpleado = 0;
            foreach($cuestionariosRel as $cuestionarioRel){

                $respuestas = EntRespuestas::find()->where(["id_cuestionario"=>$cuestionarioRel, "id_usuario_evaluado"=>$empleado->id_usuario])->all();

                $promedio = 0;
                $total = 0;
                $numValores = 0;
                
                foreach($respuestas as $respuesta){
                    $respuestasValores = $respuesta->relUsuarioRespuestas;

                    foreach($respuestasValores as $respuestaValor){
                        $numValores++;
                        $total +=$respuestaValor->txt_valor;
                    }
                }

                if($numValores>0){
                    $promedio = round(($total / $numValores), 1);
                }
                
                $totalEmpleado = $totalEmpleado + $promedio;

                $cuestionarios[]=[
                    'nombreCuestionario'=>$cuestionarioRel->idCuestionario->txt_nombre,
                    'promedio'=>$promedio
                ];
            }
            
            $promedioEmpleado = $totalEmpleado / count($cuestionariosRel);

            $resultados[$empleado->id_usuario] = [
                'nombre'=>$empleado->nombreCompleto,
                'promedio'=>round($promedioEmpleado, 1),
                'cuestionarios'=>$cuestionarios,
                //'totalEmpleado'=>$totalEmpleado
            ];
        }

        #return $resultados;
        return $this->render("resultados-por-empleados", ['resultados'=>$resultados]);
    }

    public function actionResultadosPorArea(){
        // Yii::$app->response->format = Response::FORMAT_JSON;

        // $areas = CatAreas::find()->where(['b_habilitado'=>1])->all();
        // $resultados = [];
        // $areasNombre = [];

        // foreach($areas as $area){
        //     $respuestas = $area->entRespuestas;
        //     foreach($respuestas as $respuesta){
        //         $respuestasValores = $respuesta->relUsuarioRespuestas;

        //         foreach($respuestasValores as $respuestaValores){

        //         }
        //     }
           

        //     $resultados[$area->id_area] = [
        //         'nombreArea'=>$area->txt_nombre,
                

        //     ];
        // }

        
        
        // return $resultados;
        return $this->redirect(["site/construccion"]);
        return $this->render("reporte-por-niveles");
    }


}
