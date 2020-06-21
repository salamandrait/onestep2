var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});
}

//Función limpiar
function limpiar(){
	$("#idmacceso").val("");
	$("#cod_macceso").val("");
	$("#desc_macceso").val("");
	Accesos('');
}

function Accesos(idmacceso) {

	$.post("../ajax/macceso.php", { 'opcion': 'accesoscf', idmacceso: idmacceso }, function (r) {
		$("#tbconfig").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosg', idmacceso: idmacceso }, function (r) {
		$("#accesosg").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosi', idmacceso: idmacceso }, function (r) {
		$("#tbinven").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosopi', idmacceso: idmacceso }, function (r) {
		$("#tbinvenop").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosc', idmacceso: idmacceso }, function (r) {
		$("#tbcxp").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosopc', idmacceso: idmacceso }, function (r) {
		$("#tbcxpop").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosv', idmacceso: idmacceso }, function (r) {
		$("#tbcxc").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosopv', idmacceso: idmacceso }, function (r) {
		$("#tbcxcop").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosb', idmacceso: idmacceso }, function (r) {
		$("#tbban").html(r);
	});
	$.post("../ajax/macceso.php", { 'opcion': 'accesosopb', idmacceso: idmacceso }, function (r) {
		$("#tbbanop").html(r);
	});
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag)
	{
		$("#listadoregistros").addClass('hidden');
		$(".ocultar").addClass('hidden');
		$("#formularioregistros").removeClass('hidden');
	}
	else
	{
		$("#listadoregistros").removeClass('hidden');
		$(".ocultar").removeClass('hidden');
		$("#formularioregistros").addClass('hidden');
	}
}

//Función cancelarform
function cancelarform()
{
   $("#btnCancelar").click(function () { 
		limpiar();
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
      dom:'Bfrtip',//Definimos los elementos del control de tabla
      columnDefs:[{
		targets:'nd',//clase para definir las columnas a tratar
		orderable:false,//Definimos no ordenar por esta columna
		searchable:false,//Definimos no buscar por esta columna
		}],
	    buttons:[
			{extend:'copyHtml5',
			text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar al Portapapeles',
			exportOptions:{columns:[1,2,3]}},
			{
			extend:'excelHtml5',
			text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{columns:[1,2,3]}},
			{
			extend:'csvHtml5',
			text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{columns:[1,2,3]}},
			{
			extend:'pdf',
			text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{columns:[1,2,3]}}],
      ajax:{
					url: '../ajax/macceso.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listar'},				
					error: function(e){
					console.log(e);	
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

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	formData.append('opcion','guardaryeditar');
	 
	 bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?, Recuerde que debe Salir e Ingresar Nuevamente "+
	 "para hacer Efectivo los cambios en el Perfil de Acceso!",
	 buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	 callback:function(result){
		 if(result){
 
			var dialog = bootbox.dialog({
				message: '<h4><i class="fa fa-spin fa-refresh text-success"></i></h4> Procesando...',size: 'small'
			});
					
			dialog.init(function(){});

			$.ajax({
				url: "../ajax/macceso.php",
				type: "POST",
				datatype:"json", 
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos) {

					if(datos==1062){
						dialog.modal('hide');
						bootbox.alert('El codigo <b>'+$("#cod_macceso").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
					}else{
						dialog.modal('hide');
						bootbox.alert(datos);
						mostrarform(false);
						listar();
					}
				}
			});	
		}
	}});
}

function mostrar(idmacceso)
{
	$.post("../ajax/macceso.php",{'opcion':'mostrar',idmacceso:idmacceso}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idmacceso").val(data.idmacceso);
		$("#cod_macceso").val(data.cod_macceso);
		$("#desc_macceso").val(data.desc_macceso);
		$('[data-toggle="tooltip"]').tooltip();
		Accesos(idmacceso);
 	})
}

//Función para desactivar registros
function desactivar(idmacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/macceso.php", {'opcion':'desactivar',idmacceso :idmacceso}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idmacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/macceso.php", {'opcion':'activar',idmacceso:idmacceso}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idmacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/macceso.php", {'opcion':'eliminar',idmacceso : idmacceso}, function(e){

				if(e=='1451'){
					bootbox.alert('El Registro se encuentra relacionado con otros registros, No es posible <b>Eliminar!</b>');
				}else{
					listar();
					bootbox.alert(e);		
				}
        	});	
        }
	}});
}

function GenerarReporte(){			
	$("#btnReporte").click(function(){

		     $.ajax({
        url : $('#rep').prop('href','../reportes/rptZona.php'),
        success : function(archivo) {

            var nombreLogico = campo;
            var parametros = "dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=50,screenY=50,width=850,height=1050";
            var htmlText = "<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(archivo)+"'></embed>"; 
            var detailWindow = window.open ("", nombreLogico, parametros);
            detailWindow.document.write(htmlText);
            detailWindow.document.close();
        },
        error : function(jqXHR, status, error) {
            alert("error\njqXHR="+jqXHR+"\nstatus="+status+"\nerror="+error);
        },
        complete : function(jqXHR, status) {

        }
    });
	});
}

function SeleccionarGrupo() {
	$("#btnMTodoscf").click(function () {
		$('.chkconfig')
			.prop('checked', true)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-green glyphicon glyphicon-ok-circle');
		$(this).addClass('hidden');
		$('#btnDTodoscf').removeClass('hidden');
	});
	$("#btnDTodoscf").click(function () {
		$('.chkconfig')
			.prop('checked', false)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-red glyphicon glyphicon-remove-circle');
		$(this).addClass('hidden');
		$('#btnMTodoscf').removeClass('hidden');
	});
	$("#btnMTodosi").click(function () {
		$('.chkinv')
			.prop('checked', true)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-green glyphicon glyphicon-ok-circle');
		$(this).addClass('hidden');
		$('#btnDTodosi').removeClass('hidden');
	});
	$("#btnDTodosi").click(function () {
		$('.chkinv')
			.prop('checked', false)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-red glyphicon glyphicon-remove-circle');
		$(this).addClass('hidden');
		$('#btnMTodosi').removeClass('hidden');
	});
	$("#btnMTodosc").click(function () {
		$('.chkcompra').prop('checked', true)
			.prop('checked', true)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-green glyphicon glyphicon-ok-circle');
		$(this).addClass('hidden');
		$('#btnDTodosc').removeClass('hidden');
	});
	$("#btnDTodosc").click(function () {
		$('.chkcompra')
			.prop('checked', false)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-red glyphicon glyphicon-remove-circle');
		$(this).addClass('hidden');
		$('#btnMTodosc').removeClass('hidden');
	});
	$('#btnMTodosv').click(function () {
		$('.chkventa')
			.prop('checked', true)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-green glyphicon glyphicon-ok-circle');
		$(this).addClass('hidden');
		$('#btnDTodosv').removeClass('hidden');
	});
	$("#btnDTodosv").click(function () {
		$('.chkventa')
			.prop('checked', false)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-red glyphicon glyphicon-remove-circle');
		$(this).addClass('hidden');
		$('#btnMTodosv').removeClass('hidden');
	});
	$("#btnMTodosb").click(function () {
		$('.chkbanco')
			.prop('checked', true)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-green glyphicon glyphicon-ok-circle');
		$(this).addClass('hidden');
		$('#btnDTodosb').removeClass('hidden');
	});
	$("#btnDTodosb").click(function () {
		$('.chkbanco')
			.prop('checked', false)
			.removeClass('text-green glyphicon glyphicon-ok-circle')
			.removeClass('text-red glyphicon glyphicon-remove-circle')
			.addClass('text-red glyphicon glyphicon-remove-circle');
		$(this).addClass('hidden');
		$('#btnMTodosb').removeClass('hidden');
	});
}

$(function(){  
	
	$('[data-toggle="tooltip"]').tooltip();

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

	SeleccionarGrupo();

});

init();