$(document).ready(function() {
    $("#widgets").load("../ajax/carga_widgets.php");
    load(1);
});

function load(page) {
    var range = $("#range").val();
    var parametros = {
        "action": "ajax",
        "page": page,
        'range': range
    };
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../ajax/ver_cxc_fer_ajax.php',
        data: parametros,
        beforeSend: function(objeto) {
            $("#loader").html("<img src='../../img/ajax-loader.gif'>");
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $("#loader").html("");
        }
    })
}

$('#dataDelete_abono').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var id = button.data('id') // Extraer la información de atributos de datos
    //console.log(id);
    var modal = $(this)
    modal.find('#id_abono').val(id)
})
$("#eliminarDatos").submit(function(event) {
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/eliminar_abono.php", //ver si esta el archivo
        data: parametros,
        beforeSend: function(objeto) {
            $("#se_elimino").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#se_elimino").html(datos);
            $('#dataDelete_abono').modal('hide');
            window.location.reload();
            //load("../ajax/ver_cxc.php");
            //desaparecer la alerta
            /*$(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert*/
           /* window.setTimeout(function() {
                $(".alert").fadeTo(200, 0).slideUp(200, function() {
                    $(this).remove();
                });
            }, 2000);*/
            
        }
    });
    event.preventDefault();
});

$("#add_abono").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var abono = $("#abono").val();
    //Inicia validacion
    if (isNaN(abono)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'El ABONO NO ES UN DATO VALIDO, INTENTAR DE NUEVO')
        $("#abono").focus();
        $('#guardar_datos').attr("disabled", false);
        return false;
    }
    //Fin validacion
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_abono.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
            //resetea el formulario
            $("#add_abono")[0].reset();
            //cierra la Modal
            $("#outer_div").load("../ajax/ver_cxc.php");
             $("#widgets").load("../ajax/carga_widgets.php");
            $('#add-stock').modal('hide');
            //desaparecer la alerta
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
    event.preventDefault();
})
$("#remove_stock").submit(function(event) {
    $('#eliminar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/eliminar_stock.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax2").html(datos);
            $('#eliminar_datos').attr("disabled", false);
            $("#outer_div").load("../ajax/ver_historial.php");
            load(1);
            //resetea el formulario
            $("#remove_stock")[0].reset();
            //desaparecer la alerta
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
    event.preventDefault();
})