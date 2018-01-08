<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="icon" href="https://secure.gravatar.com/blavatar/3455840a986cc52bce4a312622afb6b5?s=32" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
    $( document ).ready(function() {
        waitingDialog.show('Se está recolectando la información necesaria para ejecutar la aplicación. Cuando esto termine se le redigirá a la página principal de la aplicación.', {dialogSize: 'm', progressType: 'danger'});
        setTimeout(function () {waitingDialog.show();}, 400000);

    });


var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h4 style="margin:0;"></h4></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		/**
		 * Opens our dialog
		 * @param message Custom message
		 * @param options Custom options:
		 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
		 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
		 */
		show: function (message, options) {
			// Assigning defaults
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Loading';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null // This callback runs after the dialog was hidden
			}, options);

			// Configuring dialog
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h4').text(message);
			// Adding callbacks
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
			// Opening dialog
			$dialog.modal();
		},
		/**
		 * Closes dialog
		 */
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);    
    </script>
</head>
</html>
<?php
require_once('scraping.php');
require_once('src/logic/Categorias.php');
require_once('src/logic/Videos.php');
require_once('src/App.php');

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
         $categoriaBBDD->setCategory($categoria, '1');

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
    /*************************************************************************/

    redirect('index.php');


    
?>

