function Ejecutar(accion){
    var ejecuta = accion;
    var mensaje = '';
    var redirigir = '';
    if(accion == 'recopilar'){
        mensaje = 'Estamos recopilando toda la información necesaria para el correcto funcionamiento de la aplicación. Este procedimiento tardará unos segundos...'
        redirigir = 'index.php';
    }else if(accion == 'actualizar'){
        mensaje = 'Estamos actualizando toda la información nueva para el correcto funcionamiento de la aplicación. Este procedimiento tardará unos segundos...'
        redirigir = 'administracion.php';
    }
    waitingDialog.show(mensaje, {dialogSize: 'm', progressType: 'danger'});
    setTimeout(function () {waitingDialog.show();}, 400000);
    var parametros = { 
        "ejecutar" : ejecuta
    }

    $.ajax({
        data:  parametros,
        url:   'datos.php',
        type:  'post',
        success:  function (data) {
            waitingDialog.hide();
            window.location.href = redirigir;
        }
    });
}

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
