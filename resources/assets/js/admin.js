/*Función que llama al archivo php que insertará en la bbdd */
function insertAdmin() {
    var password = $("#password1").val();
    var repeatPass = $("#confirm_password").val();
    var usuario = $("#usernametext").val().trim();
    if (usuario == "") {
        alert('El usuario no puede ser vacío');
    } else if (password == "" || repeatPass == "") {
        alert('Las contraseñas no pueden ser vacías');
    } else if (password != repeatPass) {
        alert('Las contraseñas no son iguales');
    } else {
        var parametros = {
            "user": usuario,
            "pass": password
        }
        $.ajax({
            data: parametros,
            url: 'add_administrator.php',
            type: 'post',
            success: function(data) {
                window.alert(data);
                window.location.href = "anadir_administrador.php";
            }
        });
    }
}

/*Función que llama al archivo php que eliminará en la bbdd */
function deleteAdmin() {

    if ($("input:checkbox:checked").length < 0) {
        alert('No has seleccionado ningún administrador');
    } else {
        var nameAdmins = "";
        $("input:checkbox:checked").each(function() {
            nameAdmins += $(this).attr("id") + '|';
        });

        var parametros = {
            "nameAdmins": nameAdmins
        }

        $.ajax({
            data: parametros,
            url: 'add_administrator.php',
            type: 'post',
            success: function(data) {
                window.alert(data);
                window.location.href = "anadir_administrador.php";
            }
        });

    }

}

/*Función que añade la categoría*/
function guardarCategoria(){

    if($('#nombreCategoria').val().trim() == ""){
        alert("El nombre de la categoría no puede ser vacía");
    }else if ($("input:checkbox:checked").length == 0){
        alert("Seleccione un vídeo para crear la categoría")
    }else{
        var aceptar = confirm("Recuerda que puede haber vídeos que pertenezcan a otra categoría. En este caso, los vídeos seleccionados pasarán a formar parte de la nueva");
        if(aceptar){
            var $ids = "";
            var $names = "";
            $("input:checkbox:checked").each(function(){    
            var $this = $(this);    
                $ids += $this.attr("id") + "|";
                $names += $this.next().text() + "|";                    
            });

            var parametros = {
                    "nombreCategoria" : $('#nombreCategoria').val().trim(),
                    "IdsVideos" : $ids,
                    "nombreVideo" : $names
            };
            $.ajax({
                    data:  parametros,
                    url:   'nueva_categoria.php',
                    type:  'post',
                    success:  function () {
                        $('#myModal').hide();
                        alert('Categoría creada con éxito!');
                        window.location.href = "conjunto_categorias.php";
                    }
            });
        }
    }
}

/*Activa o desactiva la categoría en la página principal */
function editarCategoria($id_categoria, $accion){
    var parametros = {
        "id_categoria" : $id_categoria,
        "accion" : $accion
    }
    $.ajax({
        data:  parametros,
        url:   'editar_categoria.php',
        type:  'post',
        success:  function (data) {
            alert(data);
            window.location.href = "conjunto_categorias.php";
        }
    });
}

function ayudaCategoria(){
    alert('Si se selecciona vídeos que estaban en otra categoría, éstos pasarán a formar parte de la nueva categoría.');
}

/* Método  de llamada para insertar información extra */

function subirInformacion(){
    if($("input:checkbox:checked").length != 1 || $("#videoUploadFile")[0].files.length == 0 || $( "#select_tipo option:selected" ).val() == "" ){
        alert('Selecciona un vídeo y un tipo de archivo');
    }else{
        var id = "";
        var title = "";
        var tipo = $( "#select_tipo option:selected" ).val();
        var archivo = $("#videoUploadFile").prop('files')[0];
        var form_data = new FormData(); 
        form_data.append('file', archivo);
        $("input:checkbox:checked").each(function(){    
            id = $(this).attr("id");         
            title = $(this).next().text();   
        });


        var archivo = $("#videoUploadFile").prop('files')[0];
        var form_data = new FormData(); 
        form_data.append('file', archivo);
        $.ajax({
            data:  form_data, 
            contentType: false,
            processData: false,
            url:   'upload_info.php?id=' + id + '&title=' + title + "&tipo=" + tipo,
            type:  'post',
            success:  function (response) {
                $('#myModal').hide();
                window.alert(response);
                window.location.href = "subir_informacion.php";
            }
        });
    }
}

function ayudaInformacion(){
    alert('Recuerde que solo se puede subir un archivo por vídeo. Se podrán subir archivos de menos de 130 MB y de formato (.jpg, .png, .pdf, .txt, .zip)');
}