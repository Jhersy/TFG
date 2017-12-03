<?php
/*



*/ 





/*
//Para cuando el usuario suba un archivo, este php se pueda usar como validador de subtitulo srt
$lines = file('test.srt');
*/


// $servername = "localhost";
// $username = "user_tfg";
// $password = "user_tfg";


// try {
//     $conn = new PDO("mysql:host=$servername;dbname=tfg;charset=utf8", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     }
// catch(PDOException $e)
//     {
//     echo "Connection failed: " . $e->getMessage();
//     }


//     try {
//         $sql = "SELECT archivo FROM subtitulos WHERE archivo LIKE '%". $query . "%'";
//         $stmt = $conn->prepare($sql);
//         $stmt->execute();
//         $res = $stmt->fetchAll();
//     } catch(PDOException $e) {
//         echo "ERROR: " . $e->getMessage();
//     }

define('SRT_STATE_SUBNUMBER', 0);
define('SRT_STATE_TIME', 1);
define('SRT_STATE_TEXT', 2);
define('SRT_STATE_BLANK', 3);

require_once("src/logic/Subtitulos.php");

$caption = new Subtitulos();

$result = array();
$query = "lenguaje";
$result =  $caption->findInCaption($query);


$subs = array();
$state = SRT_STATE_SUBNUMBER;
$subNum = 0;
$subText = '';
$subTime = '';

$resultTotal = array();

for ($i=0; $i < count($result); $i++) { 
    $captions = array();
    $subject = $result[$i]['archivo'];
    $k = 0;
    foreach (preg_split("/((\r?\n)|(\r\n?))/", $subject) as $line) {
        switch ($state) {
            case SRT_STATE_SUBNUMBER:
                //$subNum = trim($line);
                $state = SRT_STATE_TIME;
            break;
            case SRT_STATE_TIME:
                $subTime = trim($line);
                $state = SRT_STATE_TEXT;
            break;
            case SRT_STATE_TEXT:
                if(trim($line) == ''){
                    $sub = new stdClass();
                    //$sub->number = $subNum;
                    //list($sub->startTime, $sub->stopTime) = explode(' --> ', $subTime);
                    $sub->startTime = explode(' --> ', $subTime)[0];
                    $sub->text = $subText;
                    $subText = '';
                    $state = SRT_STATE_SUBNUMBER;
    

                    if(strpos(quitar_tildes($sub->text), quitar_tildes($query)) !== FALSE){
                        //array_push($resultado,  getSeconds(explode(",", $sub->startTime)[0]));
                        /*$resultado = new stdClass();
                        $resultado->idVideo = $i;
                        $resultado->second = getSeconds(explode(",", $sub->startTime)[0]);

                        $resultArchivo[] = $resultado;
                        */
                        $captions[] = getSeconds(explode(",", $sub->startTime)[0]) . "|" .  strip_tags($sub->text);
                    }
                    
                    

                    //$subs[] = $sub;
                } else{
                    $subText .= $line;
                }
            break;
        }
        $k++;
    }
    /*
    if($state == SRT_STATE_TEXT){
        $sub->text = $subText;
        $subs[] = $sub;
    }*/
    $resultado = new stdClass();
    $resultado->idVideo = $result[$i]['id_subtitulo'];
    $resultado->subtitulos = implode(",", $captions);// $captions
    $resultTotal[$i] = $resultado;
}
var_dump($resultTotal);

/*******************************************
 * BUSCAR EN EL ARRAY GENERADO
 *  ***************************************/

/* 
$resultado = array();


foreach ($subs as $key => $value) {
    //if($value->text == 'consideraba<font color="#E5E5E5"> un tema digno de estudio</font>'){
    if(strpos(quitar_tildes($value->text), $query) !== FALSE){
        //$resultado = $value->startTime;
        array_push($resultado,  getSeconds(explode(",", $value->startTime)[0]));
    }
}

//echo $resultado;
var_dump($resultado);
*/
function getSeconds($time){
    return strtotime($time) - strtotime('TODAY');
}

function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
    }

?>