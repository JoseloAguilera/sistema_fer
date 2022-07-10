$(document).ready(function() {
    //$("#resultados").load("../ajax/ver_historial.php");
    load(1);
});

function load(page) {
    var range = $("#range").val();
    var tipo = $("#tipo").val();
    var parametros = {
        "action": "ajax",
        "page": page,
        'range': range,
        'tipo': tipo
    };
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../ajax/ver_historial.php',
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
$("#add_stock").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_stock.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            $('#add-stock').modal('hide');
            //$("#outer_div").load("../ajax/ver_historial.php");
            load(1);
            //resetea el formulario
            $("#add_stock")[0].reset();
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
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#eliminar_datos').attr("disabled", false);
            $('#remove-stock').modal('hide');
            //$("#outer_div").load("../ajax/ver_historial.php");
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