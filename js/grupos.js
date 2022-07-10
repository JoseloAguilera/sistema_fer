	$(function() {
	    load(1);
	});
	// Carga los datos de la tabla de los group_users
	function load(page) {
	    var query = $("#q").val();
	    var per_page = $("#per_page").val();
	    var parametros = {
	        "action": "ajax",
	        "page": page,
	        'query': query,
	        'per_page': per_page
	    };
	    $("#loader").fadeIn('slow');
	    $.ajax({
	        url: '../ajax/buscar_permisos.php',
	        data: parametros,
	        beforeSend: function(objeto) {
	            $("#loader").html("<img src='../../img/ajax-loader.gif'> Cargando...");
	        },
	        success: function(data) {
	            $(".outer_div").html(data).fadeIn('slow');
	            $("#loader").html("");
	        }
	    })
	}
	//Guarda el Formulario de los Cargos y permisos
	$("#guardar_permisos").submit(function(event) {
	    $('#guardar_datos').attr("disabled", true);
	    var parametros = $(this).serialize();
	    $.ajax({
	        type: "POST",
	        url: '../ajax/nuevo_permiso.php',
	        data: parametros,
	        beforeSend: function(objeto) {
	            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Enviando...');
	        },
	        success: function(datos) {
	            $("#resultados_ajax").html(datos);
	            $('#guardar_datos').attr("disabled", false);
	            load(1);
	            $("#guardar_permisos")[0].reset();
	            window.setTimeout(function() {
	                $(".alert").fadeTo(500, 0).slideUp(500, function() {
	                    $(this).remove();
	                });
	            }, 5000);
	            //$('#permisos_modal').modal('hide');
	        }
	    });
	    event.preventDefault();
	})
	//Guarda la Edicion de de los Permisos
	$("#editar_permisos").submit(function(event) {
	    $('#actualizar_datos').attr("disabled", true);
	    var parametros = $(this).serialize();
	    $.ajax({
	        type: "POST",
	        url: '../ajax/editar_permiso.php',
	        data: parametros,
	        beforeSend: function(objeto) {
	            $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Enviando...');
	        },
	        success: function(datos) {
	            $("#resultados_ajax2").html(datos);
	            $('#actualizar_datos').attr("disabled", false);
	            load(1);
	            window.setTimeout(function() {
	                $(".alert").fadeTo(500, 0).slideUp(500, function() {
	                    $(this).remove();
	                });
	            }, 5000);
	        }
	    });
	    event.preventDefault();
	})
	//Selecciona todos los checkbox de la Modal
	$('#all_ver').change(function() {
	    var checkboxes = $(".ck");
	    if ($(this).is(':checked')) {
	        checkboxes.prop('checked', true);
	    } else {
	        checkboxes.prop('checked', false);
	    }
	});
	$('#all_mod').change(function() {
	    var checkboxes = $(".ck1");
	    if ($(this).is(':checked')) {
	        checkboxes.prop('checked', true);
	    } else {
	        checkboxes.prop('checked', false);
	    }
	});
	$('#all_del').change(function() {
	    var checkboxes = $(".ck2");
	    if ($(this).is(':checked')) {
	        checkboxes.prop('checked', true);
	    } else {
	        checkboxes.prop('checked', false);
	    }
	});

	function checked_all() {
	    $('#all_ver2').change(function() {
	        var checkboxes = $(".ck");
	        if ($(this).is(':checked')) {
	            checkboxes.prop('checked', true);
	        } else {
	            checkboxes.prop('checked', false);
	        }
	    });
	    $('#all_mod2').change(function() {
	        var checkboxes = $(".ck1");
	        if ($(this).is(':checked')) {
	            checkboxes.prop('checked', true);
	        } else {
	            checkboxes.prop('checked', false);
	        }
	    });
	    $('#all_del2').change(function() {
	        var checkboxes = $(".ck2");
	        if ($(this).is(':checked')) {
	            checkboxes.prop('checked', true);
	        } else {
	            checkboxes.prop('checked', false);
	        }
	    });
	}
	//Eliminar un dato
	$('#dataDelete').on('show.bs.modal', function(event) {
	    var button = $(event.relatedTarget) // Botón que activó el modal
	    var id = button.data('id') // Extraer la información de atributos de datos
	    var modal = $(this)
	    modal.find('#id_permiso').val(id)
	})
	$("#eliminarDatos").submit(function(event) {
	    var parametros = $(this).serialize();
	    $.ajax({
	        type: "POST",
	        url: "../ajax/eliminar_permiso.php",
	        data: parametros,
	        beforeSend: function(objeto) {
	            $(".datos_ajax_delete").html('<img src="../../img/ajax-loader.gif"> Cargando...');
	        },
	        success: function(datos) {
	            $(".datos_ajax_delete").html(datos);
	            $('#dataDelete').modal('hide');
	            load(1);
	            window.setTimeout(function() {
	                $(".alert").fadeTo(500, 0).slideUp(500, function() {
	                    $(this).remove();
	                });
	            }, 5000);
	        }
	    });
	    event.preventDefault();
	});