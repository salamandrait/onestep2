var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	EventoChk();

	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});;

	$.post('../ajax/usuario.php',{'opcion':'selectMAcceso'},function (r) {
		if (r=='') {
			$('#idmacceso').append('<option>No Existen Registros</option>');
			$('#idmacceso').trigger("chosen:updated");
		} else {
			$("#idmacceso").html(r);
			$('#idmacceso').trigger("chosen:updated");
		}
	});
}

//Función limpiar
function limpiar(){

  $("#mcod_usuario").val("");
  $("#mdesc_usuario").val("");	
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#mclave").val("");
	$("#mclavec").val("");
	$("#midusuario").val("");
	$('label[for="imagen"]').html('Cargar Imagen');
	$("#imagenmuestra").prop("src","");
	$("#imagenactual").val("");

}

//Función mostrar formulario
function mostrarform(flag){

	if (flag)
	{
		$("#listadoregistros").addClass('hidden');
		$("#formularioregistros").removeClass('hidden');
		$(".ocultar").addClass('hidden');
	}
	else
	{
		$("#listadoregistros").removeClass('hidden');
		$("#formularioregistros").addClass('hidden');
		$(".ocultar").removeClass('hidden'); 
	}
}

function EventoChk(){

	$("input[type=checkbox]").change(function() {

		if($(this).is(':checked')) {  
			$(this).val("1"); 
		} else {  
			$(this).val("0");
		} 
	});

	$("input[type=checkbox]").show(function() {
		var value=$(this).val();
		if (value==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	});

	$("input[type=checkbox]").change(function() {
		var value=$(this).val();
		if (value==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	})
}


//Función cancelarform
function cancelarform()
{
    $("#btnCancelar").click(function () { 
      mostrarform(false);
    });
}

//Función Agregar
function agregar(){

    $("#btnAgregar").click(function () { 
		limpiar();
		mostrarform(true);	  
    });
}

//Función Listar
function listar(){

	tabla=$('#tblistado').dataTable(
	{
		aProcessing: true,//Activamos el procesamiento del datatables
	    aServerSide: true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],

	    buttons : [
            {extend:'copyHtml5',
			text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar al Portapapeles',
			exportOptions:{
				columns:[1,2,3]
				}},
            {
            extend:'excelHtml5',
            text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3]}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3]}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3]}}],
             ajax:
				{
					url: '../ajax/usuario.php',
					type : "POST",
					data:{'opcion':'listar'},
					dataType : "json",						
					error: function(e){
					console.log(e.responseText);	
					}
				},
				bDestroy: true,
				iDisplayLength: 10,//Paginación
				order: [[1, "asc" ]],//Ordenar (columna,orden)
				// scrollY:"290px",
				// scrollX:true,
				// scrollCollapse:true,
				paging:true,
				select:true,
				bSort:true,
				bFilter:true,
				bInfo:true,
    });        
}

function ConfirmarClave(){
	$("#mclavec").change(function(){
		if ($(this).val()!=$("#mclave").val()) {
			bootbox.alert('La Nueva Clave Ingresada no Concide con la Clave de Confirmacion!')
			$("#mclave").focus(function () { 
			});
			$("#btnGuardar").prop("disabled",true);
		} else {
			$("#btnGuardar").prop("disabled",false);
		}
	})
	.show(function(){
		if ($(this).val()!=$("#mclave").val()) {
			bootbox.alert('La Nueva Clave Ingresada no Concide con la Clave de Confirmacion!')
			$("#mclave").focus(function () { 
			});
			$("#btnGuardar").prop("disabled",true);
		} else {
			$("#btnGuardar").prop("disabled",false);
		}
	});
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
   formData.append('opcion','guardaryeditar');

   	bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?, Recuerde que debe Salir e Ingresar Nuevamente para hacer Efectivo los cambios de Acceso!",
		buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
		callback:function(result){
			if(result){

				$.ajax({
					url: "../ajax/usuario.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success:function(datos){  

						if(datos==1062){
							bootbox.alert('El codigo <b>'+$("#cod_unidad").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
						}else{
							bootbox.alert(datos);
							mostrarform(false);		
							listar();
						}
				}
			});
		}
	}});
}

function mostrar(idusuario)
{
	$.post("../ajax/usuario.php",{'opcion':'mostrar',idusuario : idusuario}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#mcod_usuario").val(data.cod_usuario);
		$("#mdesc_usuario").val(data.desc_usuario);
		$("#mclave").val(data.clave);
		$("#mclavec").val(data.clave);
		$("#idmacceso").val(data.idmacceso);
		$("#idmacceso").niceSelect('update');
		$("#fechareg").val(data.fechareg);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);;
		

		$("#midusuario").val(data.idusuario);

		if(data.imagen==''||data.imagen==null){
			$("#imagenmuestra").prop("src","../files/usuarios/noimage.png");
			$("#imagenactual").val("");

		}else {
			$("#imagenmuestra").prop("src","../files/usuarios/"+data.imagen);
			$("#imagenactual").val(data.imagen);
		}

		$('[data-toggle="tooltip"]').tooltip();
			 
 	});
}

//Función para desactivar registros
function desactivar(idusuario)
{
    bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?, Recuerde que debe Salir e Ingresar Nuevamente para hacer Efectivo los cambios de Acceso!",
	buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		if(result)
        {
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){});

        	$.post("../ajax/usuario.php", {'opcion':'desactivar',idusuario : idusuario}, function(e){
				listar();
				dialog.modal('hide'); 
				bootbox.alert(e);
        	});	
        }
	}});
}

//Función para activar registros
function activar(idusuario)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){});

        	$.post("../ajax/usuario.php", {'opcion':'activar',idusuario : idusuario}, function(e){
				listar();
				dialog.modal('hide'); 
				bootbox.alert(e);
        	});	
        }
	}});
}

//Función para activar registros
function eliminar(idusuario,idmacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){});

        	$.post("../ajax/usuario.php", {'opcion':'eliminar',idusuario:idusuario,idmacceso:idmacceso}, function(e){

				if(e=='1451'){
					dialog.modal('hide'); 
					bootbox.alert('El Registro se encuentra relacionado con otros registros, No es posible <b>Eliminar!</b>');
				}else{
					listar();
					dialog.modal('hide');
					bootbox.alert(e);
				}

        	});	
        }
	}});
}

function GenerarReporte(){		
	
	$("#btnReporte").click(function(){
		$('#rep').prop({
			'href':'../reportes/rptUsuario.php',
			'target':'_blank',
		});
	});
};

function filePreview(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.readAsDataURL(input.files[0]);
		reader.onload = function (e) {
			$('#imagenmuestra').remove();
			$('#imagenh').after('<img id="imagenmuestra" class="img-responsive pad" style="max-width: 50%" src="'+e.target.result+'">');
		}
	}
}


$(function(){  
	
	$('[data-toggle="tooltip"]').tooltip();

	$("input[type=textc]").keyup(function(){ 
		$(this).val( $(this).val().toUpperCase());
	});
	
	//desabilitar Tecla Intro al enviar formularios
	$("#formulario").keypress(function(e) {
		if (e.which == 13) {
			return false;
		}
	});

	//Obtenemos la fecha actual
	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		showWeek:true,
		autoclose:"true",
		format:"dd/mm/yyyy"
 	}).datepicker("setDate", new Date());


	$("#imagen").change(function () {
		filePreview(this);
		$('label[for="imagen"]').html('Imagen Cargada');
	});

	ConfirmarClave();
   
});

init();

