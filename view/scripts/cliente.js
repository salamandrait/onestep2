var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	EventoChk();
	importarExcel();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});


	//Cargamos los items al select 
	$.post("../ajax/cliente.php",{'opcion':'selectVendedor'}, function(r){
		if (r=='') {
			$('#idvendedor').append('<option>No Existen Registros</option>');
		} else {
			$("#idvendedor").html(r);
			$("#idvendedor").niceSelect('update');
		}	
	});

		//Cargamos los items al select 
	$.post("../ajax/cliente.php",{'opcion':'selectZona'}, function(r){
		if (r=='') {
			$('#idzona').append('<option>No Existen Registros</option>');
		} else {
			$("#idzona").html(r);
			$("#idzona").niceSelect('update');
		}	
	});

	$.post("../ajax/cliente.php",{'opcion':'selectCondPago'}, function(r){
		if (r=='') {
			$('#idcondpago').append('<option>No Existen Registros</option>');
		} else {
			$("#idcondpago").html(r);
			$("#idcondpago").niceSelect('update');
		}	
	});

	$.post("../ajax/cliente.php",{'opcion':'selectTipoCliente'}, function(r){
		if (r=='') {
			$('#idtipocliente').append('<option>No Existen Registros</option>');
		} else {
			$("#idtipocliente").html(r);
			$("#idtipocliente").niceSelect('update');
		}	
	});

	$.post("../ajax/cliente.php",{'opcion':'selectOperacion','op':'Venta'}, function(r){
		if (r=='') {
			$('#idoperacion').append('<option>No Existen Registros</option>');
		} else {
			$("#idoperacion").html(r);
			$('#idoperacion').niceSelect('update');
		}
	});
	
	$.post("../ajax/cliente.php",{'opcion':'selectImpuestoi'}, function(r){
		$("#idimpuestoi").html(r);
		$('#idimpuestoi').niceSelect('update');
	});
}

//Función limpiar
function limpiar(){
	$("input[type=text],input[type=textc],input[type=email],input[type=tel],input[type=url],#fechareg").val("");
	$("input[type=checkbox]").val("0");
	$(".numberf").val("0");

	$('select').niceSelect('update');

	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());
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
			},
			{
			targets:'nv',//clase para definir las columnas a tratar
			orderable:false,//Definimos no ordenar por esta columna
			searchable:false,//Definimos no buscar por esta columna
			visible:false,
			}],
	    buttons:[
			{extend:'copyHtml5',
			text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar al Portapapeles',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13]}},
			{
			extend:'excelHtml5',
			text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13]}},
			{
			extend:'csvHtml5',
			text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13]}},
			{
			extend:'pdf',
			text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9,10,11,12,13]}}],
            ajax:{
					url: '../ajax/cliente.php',
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
			scroller:true,
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
		url: "../ajax/cliente.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_cliente").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);
				listar();
			}
		}
	});	
}

function mostrar(idcliente)
{
	$.post("../ajax/cliente.php",{'opcion':'mostrar',idcliente:idcliente}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$('select').niceSelect('update');

		//array que crea los avlores de textbox segun el valor recibido
		$.each(data, function (label, valor) { 		
			$('#'+label).val(valor)	
		});

		$('[data-toggle="tooltip"]').tooltip();
		EventoChk();
 	})
}

//Función para desactivar registros
function desactivar(idcliente)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/cliente.php", {'opcion':'desactivar',idcliente :idcliente}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idcliente)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/cliente.php", {'opcion':'activar',idcliente:idcliente}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idcliente)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/cliente.php", {'opcion':'eliminar',idcliente : idcliente}, function(e){

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
			'href':'../reportes/rptCliente.php',
			'target':'_blank',
		});
	});
};

function importarExcel(){	

	$('#formato').change(function(){
		var filename = $(this).val().split('\\').pop();
		var idname = $(this).prop('id');
		$('span.'+idname).next().find('span').html(filename);
		$("#btnProcesar").prop('disabled',false);
	});

	$("#btnImportar").click(function(){
		$("#ModalImportar").modal('show');
	});
	
	$("#btnProcesar").click(function (e){
	 	e.preventDefault();

		 	var paqueteDeDatos = new FormData($("#formSubir")[0]);
			paqueteDeDatos.append('formato', $('#formato')[0].files[0]);

			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){});

			$.ajax({
				url: "../ajax/importarExcelCl.php",
				type: 'POST',
				contentType: false,
				data: paqueteDeDatos,
				processData: false,
				cache: false, 
				success: function(resultado){ 

			 		dialog.modal('hide');

					$("#ModalImportar").modal('toggle');

					bootbox.alert(resultado);
			 		listar();

					var idname = 'formato';
					$('span.'+idname).next().find('span').html('CARGAR');

					$("#btnProcesar").prop('disabled',true);	
					},
					error: function (){ 
						alert("Algo ha fallado.");
						var idname = 'formato';
						$('span.'+idname).next().find('span').html('CARGAR');
					}			
				});
	});

	$("#btnCancelar").click(function (e){
			e.preventDefault();
		$('#formato').val("");
		var idname = 'formato';
		$('span.'+idname).next().find('span').html('CARGAR');
		$("#btnProcesar").prop('disabled',true);	
	});
}

$(function(){  
	
	$('[data-toggle="tooltip"]').tooltip(); 

	$("input[type=textc]").keyup(function(){ 
		$(this).val( $(this).val().toUpperCase());
	});

	$("#cod_cliente").change(function(){
	 	$('#rif').val("J-"+$("#cod_cliente").val());
	})
	
	//desabilitar Tecla Intro al enviar formularios
	$("#formulario").keypress(function(e) {
		if (e.which == 13) {
			return false;
		}
	});

	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());

	$('.numberf').number( true, 2);

});

init();