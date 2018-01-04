<?php



// class MyException extends Exception { }
// class ExcepcionArchivo extends Exception { }


// $fileName = $_FILES['file']['name'];
// $fileType = $_FILES['file']['type'];
// $fileError = $_FILES['file']['error'];
// $filesize = $_FILES['file']['size'];
// // $fileId = $_FILES['id_video'];
// // $fileContent = file_get_contents($_FILES['file']['tmp_name']);
// //$lines = file($_FILES['file']['tmp_name']);



// $message = "";

// switch( $fileError ) {
//     case UPLOAD_ERR_OK:
//         $message = false;
//         break;
//     case UPLOAD_ERR_INI_SIZE:
//     case UPLOAD_ERR_FORM_SIZE:
//         $message .= ' - file too large (limit of '. ini_get('upload_max_filesize').' bytes).';
//         break;
//     case UPLOAD_ERR_PARTIAL:
//         $message .= ' - file upload was not completed.';
//         break;
//     case UPLOAD_ERR_NO_FILE:
//         $message .= ' - zero-length file uploaded.';
//         break;
//     default:
//         $message .= ' - internal error #'.$_FILES['newfile']['error'];
//         break;
// }

// if( !$message ) { 

    // echo "Tamaño de archivo: " .   $filesize;
    // echo "Tamaño máximo php: " . ini_get('upload_max_filesize');
    // $lines = file($_FILES['file']['tmp_name']);
    // var_dump(file_get_contents($_FILES['file']['tmp_name']));


    // $entrada = "ENTRADA";

    // try {
        try{
        $conn = new PDO('mysql:host=localhost;dbname=test', 'user_tfg', 'user_tfg');

        $sql = "SELECT audio FROM podcast WHERE id_audio = '13'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        // $sql = "INSERT INTO podcast (id_audio,  audio) VALUES ('13' ,'"  . file_get_contents($_FILES['file']['tmp_name'])   . "')";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // $id = $conn->lastInsertId();

        //  echo 'insertado!' . $id;

        $texto = base64_encode($res[0]['audio']);


         echo '<a download="file_downloaded_via_data_URL.txt" href="data:text/plain;base64,' . $texto . '">
             Download text file
         </a>';






        

        } catch(PDOException $e) {
            echo 'ERROR AL INSERTAR';    
        }

// }
    // } catch (PDOException $e) {
    //     print "¡Error!: " . $e->getMessage() . "<br/>";
    //     die();
    // }
    
    // $filename = "yourfile.mp3";
    // $content = file_get_contents($_FILES['file']['tmp_name']);
    // $f = fopen($filename, 'w');
    // fwrite($f, $content);
    // fclose($f);
    
    // header("Cache-Control: public");
    // header("Content-Description: File Transfer");
    // header("Content-Length: ". filesize("$filename").";");
    // header("Content-Disposition: attachment; filename=$filename");
    // header("Content-Type: application/octet-stream; "); 
    // header("Content-Transfer-Encoding: binary");
    
    // readfile($filename);
 
    //         $videos = new Videos();
    //         $videos->insertNewVideo($id_video, $title_video);

    //         $subtitulos = new Subtitulos();
    //         $subtitulos->newCaption($id_video, file_get_contents($_FILES['file']['tmp_name']), $idioma);
    //         echo "Subtítulo subido con éxito";

// }else{
//     echo  $message;
// }



?>
