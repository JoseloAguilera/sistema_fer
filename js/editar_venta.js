$(document).ready(function() {
    load(1);
    $("#resultados").load("../ajax/editar_tmp.php");
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../ajax/productos_modal_ventas.php?action=ajax&page=' + page + '&q=' + q,
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
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var costo = document.getElementById('precio_costo_' + id).value;
    precio_costo = parseInt(costo, 10);
    //console.log(precio_costo);
    //Inicia validacion
    if (isNaN(cantidad)) {
        $.Notification.notify('error', 'bottom center', 'NOTIFICACIÓN', 'LA CANTIDAD NO ES UN NUMERO. INTENTELO DE NUEVO')
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(precio_venta)) {
        $.Notification.notify('error', 'bottom center', 'NOTIFICACIÓN', 'ESTO NO ES UN NUMERO. INTENTELO DE NUEVO')
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    parseInt(precio_costo, 10);
    if (precio_venta < (precio_costo+(precio_costo*0.1))) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'EL PRECIO ES MUY BAJO, INTENTAR DE NUEVO')
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    //Fin validacion
    $.ajax({
        type: "POST",
        url: "../ajax/editar_tmp_modalventas.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $.Notification.notify('success', 'bottom center', 'NOTIFICACIÓN', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')
            $("#resultados").html(datos);
        }
    });
}

function eliminar(id) {
    $.ajax({
        type: "GET",
        url: "../ajax/editar_tmp.php",
        data: "id=" + id,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $.Notification.notify('warning', 'bottom center', 'NOTIFICACIÓN', 'LA CANTIDAD FUE AGREGADA AL INVENTARIO')
            $("#resultados").html(datos);
        }
    });
}
$("#datos_factura").submit(function(event) { //El formulario envia los datos aqui
    var id_cliente = $("#id_cliente").val();
    if (id_cliente == "") {
        swal('Oops...', 'Seleccionar Cliente. Inténtalo de nuevo!', 'info')
        $("#nombre_cliente").focus();
        return false;
    }
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/editar_fact_venta.php",
        data: parametros,
        beforeSend: function(objeto) {
            $(".editar_factura").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $(".editar_factura").html(datos);
            //desaparecer la alerta
            $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert
        }
    });
    event.preventDefault();
});
//CONTROLA EL FORMULARIO DEL CODIGO DE BARRA
$("#barcode_form").submit(function(event) {
    var id = $("#barcode").val();
    var cantidad = $("#barcode_qty").val();
    var id_factura = $("#factura").val();
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
        url: "../ajax/editar_tmp.php",
        data: parametros,
        beforeSend: function(objeto) {
            $.Notification.notify('warning', 'bottom center', 'NOTIFICACIÓN', 'LA CANTIDAD FUE DESCONTADA DEL INVENTARIO')
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
$("#guardar_cliente").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_cliente.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
            //resetea el formulario
            $("#guardar_cliente")[0].reset();
            $("#nombre").focus();
            //desaparecer la alerta
            window.setTimeout(function() {
                $(".alert").fadeTo(200, 0).slideUp(200, function() {
                    $(this).remove();
                });
            }, 2000);
        }
    });
    event.preventDefault();
})
$("#guardar_producto").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_producto.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax_productos").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax_productos").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})

function imprimir_factura(id_factura) {
    VentanaCentrada('../pdf/documentos/ver_factura.php?id_factura=' + id_factura, 'Factura', '', '724', '568', 'true');
}