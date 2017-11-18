<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }
  require_once __DIR__ . '/vendor/autoload.php';
  

  define('SRT_STATE_SUBNUMBER', 0);
  define('SRT_STATE_TIME', 1);
  define('SRT_STATE_TEXT', 2);
  define('SRT_STATE_BLANK', 3);
  
  require_once("src/logic/Subtitulos.php");
  $query = "lingüística";
  
  if(!is_null($query/*$_POST['query']*/)){
  
      session_start();
      
      $OAUTH2_CLIENT_ID = '88517581272-gu071qtdg26cg9oqbu8v3pmifgg6jogv.apps.googleusercontent.com';
      $OAUTH2_CLIENT_SECRET = '4xobKsbsIv2nFo7XOhcadA6V';
      
    
      $client = new Google_Client();
      $client->setClientId($OAUTH2_CLIENT_ID);
      $client->setClientSecret($OAUTH2_CLIENT_SECRET);
      
    
      $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
      $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
          FILTER_SANITIZE_URL);
      $client->setRedirectUri($redirect);
      
      // Define an object that will be used to make all API requests.
      $youtube = new Google_Service_YouTube($client);
      
      $tokenSessionKey = 'token-' . $client->prepareScopes();
      
      if (isset($_GET['code'])) {
        if (strval($_SESSION['state']) !== strval($_GET['state'])) {
          die('The session state did not match.');
        }
      
        $client->authenticate($_GET['code']);
        $_SESSION[$tokenSessionKey] = $client->getAccessToken();
        header('Location: ' . $redirect);
      }
      
      if (isset($_SESSION[$tokenSessionKey])) {
        $client->setAccessToken($_SESSION[$tokenSessionKey]);
      }
      
      
      if ($client->getAccessToken()) {
          //$videoId = "wisbrPN9fbI";
      
          $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'q' => $query,
            'channelId' => 'UCG_fXqOLea9FSTLoWZieaqw',
            'maxResults' => '25',
          ));
  
          
          $resultSearchYoutube = array();
          $arrayBBDD = array();
          $arrayBBDD = buscarSubtitulos($query);
      
          // Add each result to the appropriate list, and then display the lists of
          // matching videos, channels, and playlists.
          foreach ($searchResponse['items'] as $searchResult) {
            switch ($searchResult['id']['kind']) {
              case 'youtube#video':
                $videos = new stdClass();
                $videos->thumnail = $searchResult['snippet']['thumbnails']['default']['url'];
                $videos->title = $searchResult['snippet']['title'];
                $videos->idVideo = $searchResult['id']['videoId'];

               $videos->subtitulos = searchInCaption($videos->idVideo, $arrayBBDD);

                array_push($resultSearchYoutube , $videos);

                break;
            }
          }
      
        //   $htmlBody =   "<h3>Videos</h3><ul>$videos</ul>";
          var_dump($resultSearchYoutube);
          var_dump($arrayBBDD);
      }else{
          $state = mt_rand();
          $client->setState($state);
          $_SESSION['state'] = $state;
      
          $authUrl = $client->createAuthUrl();
          echo $authUrl;  
      }
  }



  function buscarSubtitulos($query){

    $resultTotal = array();
    $caption = new Subtitulos();

    $result = array();
    $result =  $caption->findInCaption($query);


    $subs = array();
    $state = SRT_STATE_SUBNUMBER;
    $subNum = 0;
    $subText = '';
    $subTime = '';


    for ($i=0; $i < count($result); $i++) { 
        $captions = array();
        $subject = $result[$i]['archivo'];
        
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $subject) as $line) {
            switch ($state) {
                case SRT_STATE_SUBNUMBER:
                    $state = SRT_STATE_TIME;
                break;
                case SRT_STATE_TIME:
                    $subTime = trim($line);
                    $state = SRT_STATE_TEXT;
                break;
                case SRT_STATE_TEXT:
                    if(trim($line) == ''){
                        $sub = new stdClass();
                        $sub->startTime = explode(' --> ', $subTime)[0];
                        $sub->text = $subText;
                        $subText = '';
                        $state = SRT_STATE_SUBNUMBER;
        

                        if(strpos(quitar_tildes($sub->text), quitar_tildes($query)) !== FALSE){
                            $captions[] =  getSeconds(explode(",", $sub->startTime)[0]);
                        }
                    } else{
                        $subText .= $line;
                    }
                break;
            }
        }
        $resultado = new stdClass();
        $resultado->idVideo = $result[$i]['id_subtitulo'];
        $resultado->subtitulos = implode(",", $captions);// $captions
        $resultTotal[$i] = $resultado;
    }

    return $resultTotal;
  }

/*Función que con el ID del vídeo de Youtube comprueba si la palabra buscada también aparece en los subtítulos de la BBDD */
  function searchInCaption($idVideo, &$array){
      $subtitulos = "";
        for ($i=0; $i < count($array) ; $i++) { 
            if($array[$i]->idVideo === $idVideo){
                $subtitulos = $array[$i]->subtitulos;
                array_splice($array, $i, 1);
            }
        }
        
    return $subtitulos;
  }
 
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