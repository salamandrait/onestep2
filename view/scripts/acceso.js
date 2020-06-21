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
	$("#idacceso").val("");
	$("#cod_acceso").val("");
	$("#desc_acceso").val("");
	Accesos('');
}

function Accesos(idacceso) {
	$.post("../ajax/acceso.php", { 'opcion': 'accesoscf', idacceso: idacceso}, function (r) {
		$("#tbconfig").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosi', idacceso: idacceso }, function (r) {
		$("#tbinven").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosopi', idacceso: idacceso }, function (r) {
		$("#tbinvenop").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosc', idacceso: idacceso }, function (r) {
		$("#tbcxp").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosopc', idacceso: idacceso }, function (r) {
		$("#tbcxpop").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosv', idacceso: idacceso }, function (r) {
		$("#tbcxc").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosopv', idacceso: idacceso }, function (r) {
		$("#tbcxcop").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosb', idacceso: idacceso }, function (r) {
		$("#tbban").html(r);
	});
	$.post("../ajax/acceso.php", { 'opcion': 'accesosopb', idacceso: idacceso }, function (r) {
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
					url: '../ajax/acceso.php',
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
			scrollY:"290px",
			scrollX:true,
			scrollCollapse:true,
			paging:false,
			bSort:true,
			bFilter:true,
			bInfo:true,
			deferRender:true,
			scroller:false,
			select:true,
   });        
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
   formData.append('opcion','guardaryeditar');

	$.ajax({
		url: "../ajax/acceso.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_acceso").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);
				listar();
			}
		}
	});	
}

function mostrar(idacceso)
{
	$.post("../ajax/acceso.php",{'opcion':'mostrar',idacceso:idacceso}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idacceso").val(data.idacceso);
		$("#cod_acceso").val(data.cod_acceso);
		$("#desc_acceso").val(data.desc_acceso);
		Accesos(idacceso);
		$('[data-toggle="tooltip"]').tooltip();
 	})
}

//Función para desactivar registros
function desactivar(idacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/acceso.php", {'opcion':'desactivar',idacceso :idacceso}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/acceso.php", {'opcion':'activar',idacceso:idacceso}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idacceso)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/acceso.php", {'opcion':'eliminar',idacceso : idacceso}, function(e){

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
		$('#rep').prop({
			'href':encodeURI('../reportes/rptUnidad.php'),
			'target':'_blank',
		});		
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

	$("#btnMTodoscf").click(function() {
		$('.chkconfig').prop('checked',true);	 	
		$(this).addClass('hidden');
		$('#btnDTodoscf').removeClass('hidden');
	});

	$("#btnDTodoscf").click(function() {
		$('.chkconfig').prop('checked',false);	 	
		$(this).addClass('hidden');
		$('#btnMTodoscf').removeClass('hidden');
	});

	$("#btnMTodosi").click(function() {
		$('.chkinv').prop('checked',true);	 	
		$(this).addClass('hidden');
		$('#btnDTodosi').removeClass('hidden');
	});

	$("#btnDTodosi").click(function() {
		$('.chkinv').prop('checked',false);	 	
		$(this).addClass('hidden');
		$('#btnMTodosi').removeClass('hidden');
	});

	$("#btnMTodosc").click(function() {
		$('.chkcompra').prop('checked',true);	 	
		$(this).addClass('hidden');
		$('#btnDTodosc').removeClass('hidden');
	});

	$("#btnDTodosc").click(function() {
		$('.chkcompra').prop('checked',false);	 	
		$(this).addClass('hidden');
		$('#btnMTodosc').removeClass('hidden');
	});

	$('#btnMTodosv').click(function() {
		$('.chkventa').prop('checked',true);	 	
		$(this).addClass('hidden');
		$('#btnDTodosv').removeClass('hidden');
	});

	$("#btnDTodosv").click(function() {
		$('.chkventa').prop('checked',false);	 	
		$(this).addClass('hidden');
		$('#btnMTodosv').removeClass('hidden');
	});

	$("#btnMTodosb").click(function() {
		$('.chkbanco').prop('checked',true);	 	
		$(this).addClass('hidden');
		$('#btnDTodosb').removeClass('hidden');
	});

	$("#btnDTodosb").click(function() {
		$('.chkbanco').prop('checked',false);	 	
		$(this).addClass('hidden');
		$('#btnMTodosb').removeClass('hidden');
	});

	$("#peraccesos").change(function() {

		if ($(this).val()==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	});

});

init();