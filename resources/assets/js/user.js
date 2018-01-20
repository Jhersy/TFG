
/* Método para descargar el archivo de subtítulos */
function download(id_video){
    document.myform.id_video.value = id_video;
    return true;
}

/* Inicializa el carousel */
$(document).ready(function() {
    $('#Carousel').carousel({
        interval: 10000
    })
    $('[data-toggle="tooltip"]').tooltip();   
});

/* Inserta comentario */
function insertComment(id_video, param){
    var parametros = {
        "id_video" : id_video,
        "textComment" : $('#textarea').val()
    };
    $.ajax({
            data:  parametros,
            url:   'comentarios.php',
            type:  'post',
            success:  function () {
                window.location.href = "video_player.php?id_video=" + id_video + param;
            }
    });
}

/* Resetea el campo de comentar */
function cancelComment(){
    $('#textarea').val("");
}