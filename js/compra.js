$(document).ready(function() {
    $("#resultados").load("../ajax/agregar_tmp_compra.php");
    $("#resultados2").load("../ajax/carga_resibido2.php");
    $("#f_resultado").load("../ajax/incrementa_fact_compra.php");
    $("#datos_factura").load();
    $("#cod_resultado").load("../ajax/incrementa_cod_prod.php");
    load(1);
});


function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../ajax/productos_modal_compras2.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}

function agregar(id) {
    var costo_producto = document.getElementById('costo_producto_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    //Inicia validacion
    if (isNaN(cantidad)) {
        $.Notification.notify('error', 'bottom center', 'ERROR!', 'LA CANTIDAD DIGITADA NO ES UN FORMATO VALIDO')
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(costo_producto)) {
        $.Notification.notify('error', 'bottom center', 'ERROR!', 'EL COSTO DIGITADO NO ES UN FORMATO VALIDO')
        document.getElementById('costo_producto_' + id).focus();
        return false;
    }
    //Fin validacion
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_tmp_modalcompras.php",
        data: "id=" + id + "&costo_producto=" + costo_producto + "&cantidad=" + cantidad,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
            $.Notification.notify('success', 'bottom center', 'EXITO!', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')
        }
    });
}
//CONTROLA EL FORMULARIO DEL CODIGO DE BARRA
$("#barcode_form").submit(function(event) {
    var id = $("#barcode").val();
    var cantidad = $("#barcode_qty").val();
    var id_sucursal = 0;
    //Inicia validacion
    if (isNaN(cantidad)) {
        swal('Oops...', 'La Cantidad no es un numero. Inténtalo de nuevo!', 'error')
        $("#barcode_qty").focus();
        return false;
    }
    //Fin validacion
    parametros = {
        'id': id,
        'id_sucursal': id_sucursal,
        'cantidad': cantidad
    };
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_tmp_compra.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
            $("#id").val("");
            $("#id").focus();
            $("#barcode").val("");
        }
    });
    event.preventDefault();
})

function eliminar(id) {
    $.ajax({
        type: "GET",
        url: "../ajax/agregar_tmp_compra.php",
        data: "id=" + id,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}
//FUNCION QUE MANDA EL FORMULARIO AL ARCHIVO PARA GENERAR PDF
/*$("#datos_compra").submit(function() {
    var id_proveedor = $("#id_proveedor").val();
    var id_vendedor = $("#id_vendedor").val();
    var condiciones = $("#condiciones").val();
    var fecha = $("#fecha").val();
    var factura = $("#factura").val();
    if (id_proveedor == "") {
        alert("Debes seleccionar un Proveedor");
        $("#nombre_proveedor").focus();
        return false;
    }
    $("#datos_compra")[0].reset();
    VentanaCentrada('../pdf/documentos/compra_pdf.php?id_proveedor=' + id_proveedor + '&id_vendedor=' + id_vendedor + '&condiciones=' + condiciones + '&fecha=' + fecha + '&factura=' + factura, 'Factura', '', '800', '600', 'true');
});*/
$("#datos_factura").submit(function(event) {
    $('#guardar_factura').attr("disabled", true);
    var id_proveedor = $("#id_proveedor").val();
    if (id_proveedor == "") {
        $.Notification.notify('error', 'bottom center', 'NOTIFICACIÓN', 'DEBE SELECCIONAR UN PROVEEDOR VALIDO')
        $("#nombre_proveedor").focus();
        $('#guardar_factura').attr("disabled", false);
        return false;
    }
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/guardar_compra.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajaxf").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajaxf").html(datos);
            $('#guardar_factura').attr("disabled", false);
            //resetea el formulario
            $("#datos_factura")[0].reset(); //Recet al formilario de el cliente
            $("#barcode_form")[0].reset(); // Recet al formulario de la fatura
            $("#resultados").load("../ajax/agregar_tmp_compra.php"); // carga los datos nuevamente
            $("#f_resultado").load("../ajax/incrementa_fact_compra.php");
            $("#barcode").focus();
            load(1);
            //desaparecer la alerta
            $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert
        }
    });
    event.preventDefault();
})
$("#guardar_proveedor").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_proveedor.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            //resetea el formulario
            $("#guardar_proveedor")[0].reset();
            //desaparecer la alerta
            $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert
            load(1);
        }
    });
    event.preventDefault();
})
$("#guardar_producto_compra").submit(function(event) {
    $('#guardar_datos_prod_compra').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_producto.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos_prod_compra').attr("disabled", false);
            $("#cod_resultado").load("../ajax/incrementa_cod_prod.php");
            //resetea el formulario
            $("#guardar_producto_compra")[0].reset();
            //desaparecer la alerta
            /*$(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert
            load(1);*/
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
    event.preventDefault();
})

function imprimir_factura(id_factura) {
    VentanaCentrada('../pdf/documentos/ver_comprax.php?id_factura=' + id_factura, 'Factura', '', '724', '468', 'true');
}