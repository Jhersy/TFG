<?php
/*



*/ 



define('SRT_STATE_SUBNUMBER', 0);
define('SRT_STATE_TIME', 1);
define('SRT_STATE_TEXT', 2);
define('SRT_STATE_BLANK', 3);

/*
//Para cuando el usuario suba un archivo, este php se pueda usar como validador de subtitulo srt
$lines = file('test.srt');
*/


$servername = "localhost";
$username = "user_tfg";
$password = "user_tfg";


try {
    $conn = new PDO("mysql:host=$servername;dbname=tfg;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


    try {
        $sql = "SELECT archivo FROM subtitulos";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }



$subs = array();
$state = SRT_STATE_SUBNUMBER;
$subNum = 0;
$subText = '';
$subTime = '';



$separator = "\r\n";

$subject = $res[0]['archivo'];

foreach (preg_split("/((\r?\n)|(\r\n?))/", $subject) as $line) {
    switch ($state) {
        case SRT_STATE_SUBNUMBER:
            $subNum = trim($line);
            $state = SRT_STATE_TIME;
        break;
        case SRT_STATE_TIME:
            $subTime = trim($line);
            $state = SRT_STATE_TEXT;
        break;
        case SRT_STATE_TEXT:
            if(trim($line) == ''){
                $sub = new stdClass();
                $sub->number = $subNum;
                list($sub->startTime, $sub->stopTime) = explode(' --> ', $subTime);
                $sub->text = $subText;
                $subText = '';
                $state = SRT_STATE_SUBNUMBER;

                $subs[] = $sub;
            } else{
                $subText .= $line;
            }
        break;
    }
}
if($state == SRT_STATE_TEXT){
    $sub->text = $subText;
    $subs[] = $sub;
}

//var_dump($subs);

/*******************************************
 * BUSCAR EN EL ARRAY GENERADO
 *  ***************************************/

$resultado = array();


foreach ($subs as $key => $value) {
    //if($value->text == 'consideraba<font color="#E5E5E5"> un tema digno de estudio</font>'){
    if(strpos($value->text, 'es un')){
        //$resultado = $value->startTime;
        array_push($resultado, $value->startTime);
    }
}

//echo $resultado;
var_dump($resultado);

?>