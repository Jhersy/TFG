<?php
require_once('scraping.php');
require_once('src/logic/Categorias.php');
require_once('src/logic/Videos.php');
require_once('src/App.php');

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
// Archivo para realizar el scraping y llenar la bbdd de todos los contenidos del blog
// También se edita el upload_max_filesize para tratar con archivos de mayor tamaño
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

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
             if($_POST['ejecutar'] == 'recopilar')
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

    /*************************************************************************/
    /* EDICIÓN DEL UPLOAD_MAX_FILE_SIZE PARA TRATAR CON ARCHIVOS DE MAYOR TAMAÑO */


    if(isset($_POST['ejecutar'])){
        if($_POST['ejecutar'] == 'recopilar'){
            // Obtener cada línea en un array:
            $aLineas = file("../../php/php_test.ini");
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
                $archivo = fopen("../../php/php_test.ini", "w+b");
                // Guardar los cambios en el archivo:
                foreach( $aLineas as $linea ){
                    fwrite($archivo, $linea);
                }
            }
        }

    }

    /*************************************************************************/



    
?>

