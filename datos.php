<?php
require_once('scraping.php');
require_once('src/logic/Categorias.php');
require_once('src/logic/Videos.php');
require_once('src/App.php');
require_once('config/config.php');

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
// Archivo para realizar el scraping y llenar la bbdd de todos los contenidos del blog
// También se edita el upload_max_filesize para tratar con archivos de mayor tamaño
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    /*************************************************************************/
        /* CREACIÓN DE LA BASE DE DATOS */
    $existDB = "";
        
    if(isset($_POST['ejecutar'])){
        if($_POST['ejecutar'] == 'recopilar'){
            try {
                $dbh = new PDO("mysql:host=" . DB_HOST , DB_ROOT, DB_ROOT_PASS);

                $queryExistDB = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'";
                $stmt = $dbh->prepare($queryExistDB);
                $stmt->execute();
                $existDB = $stmt->fetch();

                if(!$existDB){
                    $dbh->exec("CREATE DATABASE " . DB_NAME . ";
                            GRANT ALL PRIVILEGES ON " . DB_NAME .".* TO '" . DB_USER ."'@'localhost' IDENTIFIED BY '" .  DB_USER_PASS ."';
                            FLUSH PRIVILEGES;") 
                    or die(print_r($dbh->errorInfo(), true));

                }
            
            } catch (PDOException $e) {
                die("DB ERROR: ". $e->getMessage());
            }
            
    /*************************************************************************/
        /* IMPORTACIÓN DE LAS TABLAS EN LA BASE DE DATOS */

            if(!$existDB){
                $connection = mysqli_connect(DB_HOST, DB_USER, DB_USER_PASS, DB_NAME);
                if (mysqli_connect_errno())
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $fp = fopen(DB_FILE, 'r');
                // Loop through each line
                while (($line = fgets($fp)) !== false) {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;
                    // Add this line to the current segment
                    $templine .= $line;
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';') {
                        // Perform the query
                        if(!mysqli_query($connection, $templine)){
                            print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                        }
                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
                mysqli_close($connection);
                fclose($fp);
            }
        }
    }
    /*************************************************************************/
    /* SCRAPING PARA RELLENAR LAS TABLAS DE VÍDEOS Y CATEGORÍAS DE LA BASE DE DATOS */

    //Se obtienen todas las categorías del blog Zaragoza lingüística a la carta
     $categorias = array();
     $categorias = getAllCategories();

    // Clases para inserción en BBDD
     $categoriaBBDD = new Categorias();
     $videosBBDD = new Videos();

    /* Se resetan los índices por si se quedan con algún valor */
     $videosBBDD->resetAutoIncrement();
     $categoriaBBDD->resetAutoIncrement();

     $videosCategoria = array();
     $i = 0;
     $j = 1;
     foreach ($categorias as $categoria) {
         //Inserta las categorías del blog 
         if(isset($_POST['ejecutar'])){
             if($_POST['ejecutar'] == 'recopilar' && !$existDB)
                $categoriaBBDD->setCategory($categoria, '1');
         }

         //Recopilamos los IDs de los vídeos de cada categoría del blog Zaragoza lingüística a la carta
         $videosCategoria = getIDsVideos($i);

         foreach ($videosCategoria as $videoCategoria) {
            // Inserta los vídeos de cada categoría del blog        
             $videosBBDD->setVideosCategory($j, $videoCategoria[0], $videoCategoria[1]);
         }
        
         $i++;
         $j++;
     }

     /*************************************************************************/
    /* EDICIÓN DEL UPLOAD_MAX_FILE_SIZE PARA TRATAR CON ARCHIVOS DE MAYOR TAMAÑO */

    if(isset($_POST['ejecutar'])){
        if($_POST['ejecutar'] == 'recopilar'){
            // Obtener cada línea en un array:
            $aLineas = file("../../php/php.ini");
            // Mostrar el contenido del archivo:
            $i = 0;
            $j = 0;
            $editar = false;
            foreach( $aLineas as $linea ){
                if(preg_match("/upload_max_filesize=2M/i", $linea)){
                    $j = $i;
                    $editar = true;
                }
                $i++;
            }
            if($editar){
                // Borrar el tercer elemento del array (la tercera línea):
                array_splice($aLineas, $j , 1 , 'upload_max_filesize=130M ');
                // Abrir el archivo:
                $archivo = fopen("../../php/php.ini", "w+b");
                // Guardar los cambios en el archivo:
                foreach( $aLineas as $linea ){
                    fwrite($archivo, $linea);
                }
            }
        }

    }
    
?>

