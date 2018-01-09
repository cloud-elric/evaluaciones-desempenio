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
use yii\data\ActiveDataProvider;


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
                $promedioCuestionario = 0;
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

                    if($numPreguntas>0){
                        $promedio = $total/$numPreguntas;
                    }
                    $promedioCuestionario += $promedio;

                    $textoPreguntas[] = [
                        'texto_pregunta'=>$pregunta->txt_pregunta,
                        'promedio'=>$promedio,
                        'total'=>$total,
                        'numPreguntas'=>$numPreguntas
                        
                    ];
                }

                 if(count($preguntas) > 0){
                    $promedioCuestionario = round(($promedioCuestionario / count($preguntas)), 1);
                 }

                $nombreCuestionarios[] = [
                    'nombre_cuestionario' =>$cuestionario->txt_nombre,
                    'identificador'=>$cuestionario->id_cuestionario.$nivel->id_nivel,
                    'preguntas'=>$textoPreguntas,
                    'puntuacionPromedio'=>$puntuacionPromedio,
                    'promedioCuestionario'=>$promedioCuestionario
                ];
            }


            $resultados[$nivel->id_nivel] = [
                'nombre_nivel'=>$nivel->txt_nombre,
                'cuestionarios'=>$nombreCuestionarios,
                
            ];
        }

         #return $resultados;

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
            $promedioTotal = 0;
            foreach($preguntasRel as $preguntaRel){
                $respuestasRel = $preguntaRel->relUsuarioRespuestas;

                $promedio = 0;
                $total = 0;
                $numPreguntas = count($respuestasRel);
                foreach($respuestasRel as $respuestaRel){
                    $total +=$respuestaRel->txt_valor;
                }
                
                if($numPreguntas>0){
                    $promedio = $total/$numPreguntas;
                }
                
                $promedioTotal += $promedio;
                $preguntas[]=[
                    'texto_pregunta'=>$preguntaRel->txt_pregunta,
                    'promedio'=>round($promedio, 1),
                    'total'=>$total,
                ];
            } 

            if(count($preguntasRel)>0){
                $promedioTotal = $promedioTotal / count($preguntasRel);
            }

            $resultados[$cuestionario->id_cuestionario]=[
                'nombre_cuestionario'=>$cuestionario->txt_nombre,
                'identificador'=>$cuestionario->id_cuestionario,
                'preguntas'=>$preguntas,
                'promedioTotal'=>$promedioTotal

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
        $users = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal", "id_status"=>2])->all();
        
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
        $subjectEmail = "Evaluación del desempeño 2018";
        $ch = curl_init ();
        
        curl_setopt ( $ch, CURLOPT_URL, "https://api.madmimi.com/mailer" );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, "username=".$username."&api_key=".$apiKey."&promotion_name=".$promotionName."&recipient=".$name." ".$lastName." <".$email.">&subject=".$subjectEmail."&from=evaluaciones@2gom.com.mx&raw_html=".urlencode($string)  );
        
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        
        $server_output = curl_exec ( $ch );
        
        curl_close ( $ch );
        //echo $server_output;
        // further processing ....
        if ($server_output == "OK") {
        } else {
        }
    }

    public function actionResultadosPorEmpleados($us=null){
        #Yii::$app->response->format = Response::FORMAT_JSON;

        if(!$us){
            $empleados = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal"]);
        }else{
            $empleados = EntUsuarios::find()->where(['txt_auth_item'=>"usuario-normal", "id_usuario"=>$us]);
        }    
       
        $dataProvider = new ActiveDataProvider([
            'query' => $empleados,
             'pagination'=>[
                 'pageSize' =>30,
             ],
            'sort' => [
                'defaultOrder' => [
                    'txt_username' => \SORT_ASC,
                    'txt_apellido_paterno'=> \SORT_ASC,
                ]
            ],
            
        ]);

        #return $resultados;
        return $this->render("resultados-por-empleados", ['dataProvider'=>$dataProvider]);
    }

    public function actionResultadosPorArea(){
         #Yii::$app->response->format = Response::FORMAT_JSON;
         $areas = CatAreas::find()->where(["b_habilitado"=>1])->all();
         $cuestionarios = EntCuestionario::find()->all();
         
         $resultados = [];
         
         foreach($areas as $area){
            $respuestas = [];
            $cuestionariosArea = [];
            
            foreach($cuestionarios as $cuestionario){
                $respuestas = EntRespuestas::find()
                    ->where(['id_area'=>$area->id_area, 'id_cuestionario'=>$cuestionario->id_cuestionario])
                    ->all();

                $promedioTotal = 0;
                $numPreguntas = 0;    

                foreach($respuestas as $respuesta){
                    $preguntas = $respuesta->idCuestionario->entPreguntas;
                    $numPreguntas = count($preguntas);
                    $preguntaTexto = [];
                    $respuestasValores = $respuesta->relUsuarioRespuestas;

                    $promedio = 0;
                    $total = 0;
                    $numRespuesta = 0;
                    foreach($preguntas as $pregunta){
                        foreach($respuestasValores as $respuestaValor){
                            if($respuestaValor->id_pregunta==$pregunta->id_pregunta){
                                $numRespuesta++;
                                $total +=$respuestaValor->txt_valor;
                            }
                        }
                        $promedio = $total/$numRespuesta;
                        $promedioTotal += $promedio;
                        $preguntaTexto[] = [
                            'textoPregunta'=>$pregunta->txt_pregunta,
                            'promedio'=>round($promedio, 1),
                        ];
                    }

                    if($numPreguntas>0){
                        $promedioTotal = $promedioTotal/$numPreguntas;
                    }
                    $cuestionariosArea[] = [
                        'cuestionarioNombre'=>$cuestionario->txt_nombre,
                        'preguntas'=>$preguntaTexto,
                        'promedioTotal'=>$promedioTotal,
                        'identificador'=>$area->id_area.$cuestionario->id_cuestionario.$respuesta->id_respuesta,
                    ];
                }    

            }

             $resultados[$area->id_area] = [
                'nombreArea'=>$area->txt_nombre = $area->txt_nombre,
                'cuestionarios'=>$cuestionariosArea,
                
             ];
             
         }
 
          #return $resultados;
        #return $this->redirect(["site/construccion"]);
        return $this->render("resultados-por-areas", ['resultados'=>$resultados]);
    }

    

}
