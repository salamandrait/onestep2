var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	editar();
	cancelarform();
	GenerarReporte();
	EventoChk();
	TipoOp();
	SaldoCuenta();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	$.post('../ajax/movbanco.php',{'opcion':'selectOperacion','origen':$("#origen").val()},function (r) {

		$("#idoperacion").html(r);
		$('#idoperacion').niceSelect("update");
		
	});

	$.post('../ajax/movbanco.php',{'opcion':'cuenta','op':'select'},function (r) {
		if (r=='') {
			$('#idcuenta').append('<option>No Existen Registros</option>');
			$('#idoperacion').niceSelect("update");
		} else {
			$("#idcuenta").html(r);
			$('#idoperacion').niceSelect("update");

			var id=$('#idcuenta').val();

			$.post('../ajax/movbanco.php',{'opcion':'cuenta','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#cod_cuenta").val(data.cod_cuenta);
				$("#numcuenta").val(data.numcuenta);
				$("#cod_banco").val(data.cod_banco);
				$("#desc_banco").val(data.desc_banco);
				$("#cod_moneda").val(data.cod_moneda);		
			});
		}
	});

	$("#idcuenta").change(function(){
		var id=$(this).val();
		$.post('../ajax/movbanco.php',{'opcion':'cuenta','op':'data','id':id},function (data) {
			data=JSON.parse(data);
			$("#cod_cuenta").val(data.cod_cuenta);
			$("#numcuenta").val(data.numcuenta);
			$("#cod_banco").val(data.cod_banco);
			$("#desc_banco").val(data.desc_banco);
			$("#cod_moneda").val(data.cod_moneda);
		});
	});
}

//Generar Correlativo
function generarCod(){	

	$.post('../ajax/correlativo.php',{'opcion':'generarCod','tabla':'tbmovbanco'},function(data){
		data = JSON.parse(data);
		$("#cod_movbanco").val(data.codnum)

		if (data.estatus==1)
		{
			$("#cod_movbanco")
			.val(data.codnum)
			.prop('readonly',true);
		} else{
			$("#cod_movbanco")
			.prop('readonly',false)
		}
	});
}

//Función limpiar
function limpiar(){

	$("#idmovbanco").val("");
	$("#cod_movbanco").val("");
	$("#desc_movbanco").val("");
	$("#estatus").val("Sin Procesar");
	$("#origen").val("Banco");
	$("#tipo").val("NC");
	$('#tipo').niceSelect("update");
   $("#numerod").val("");
   $("#numeroc").val("");
	$("#monto").val("0");
	$("#montod").val("0");
	$("#montoh").val("0");
	$("#saldot").val("0");
	$("#saldoinicial").val("0")

	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());
	EventoChk();
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
		if (value==1) {
			$(this).prop('checked', true);
		} else {
			$(this).prop('checked', false);
		}
	});
}

function TipoOp(){

	$("#tipo").change(function() {
		var valuea =$(this).val();
		var valueb =$("#monto").val();
		
		switch (valuea) {
			case 'NC':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'INT':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'TPOS':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'DEP':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'ND':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
			case 'TNEG':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
			case 'CHEQ':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
			case 'ITF':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
		}
    });
    
    $("#monto").change(function() {

		var valuea =$("#tipo").val();
		var valueb =$("#monto").val();

		switch (valuea) {
			case 'NC':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'INT':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'TPOS':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'DEP':
				$('#montod').val(valueb);
				$('#montoh').val(0);
			break;
			case 'ND':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
			case 'TNEG':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
			case 'CHEQ':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
			case 'ITF':
				$('#montoh').val(valueb);
				$('#montod').val(0);
			break;
		}
	});
}

function SaldoCuenta(){

	$("#monto").change(function() {
		var saldocuenta=$("#saldot").val();
		var montoop=$("#monto").val();
		var tipo=$("#tipo").val();
		var validar=saldocuenta-montoop;
	
		if(tipo=='ND'|| tipo=='ITF' || tipo=='TNEG' || tipo=='CHEQ'){

			if(validar<0){

                bootbox.confirm({message:"¿El Monto de la Operacion es Mayor al saldo Disponible! Segenerará un Saldo Negativo de <b>"
                +($.number(validar,2,'.',','))+"</b>  en la Cuenta! Desea Continuar?", 
                buttons:{confirm:{label: 'OK',className:'btn-primary'},
                cancel:{label: 'Cancelar',className:'btn-danger'}},
                callback:function(result){
					if(!result){
						$("#monto").val("0.00");
						$("#montod").val(0);
						$("#montoh").val(0);
                    }
                }});
			}			
		}
	});
	//SaldoCuenta
	$("#tipo").change(function() {
		var saldocuenta=$("#saldot").val();
		var montoop=$("#monto").val();
		var tipo=$("#tipo").val();
		var validar=saldocuenta-montoop;
		
		if(tipo=='ND'|| tipo=='ITF' || tipo=='TNEG' || tipo=='CHEQ'){

			if(validar<0){

                bootbox.confirm({message:"¿El Monto de la Operacion es Mayor al saldo Disponible! Segenerara un Saldo Negativo de <b>"
                +($.number(validar,2,'.',','))+"</b> en la Cuenta! Desea Continuar?", 
                buttons:{confirm:{label: 'OK',className:'btn-primary'},
                cancel:{label: 'Cancelar',className:'btn-danger'}},
                callback:function(result){
					if(!result){
						$("#monto").val("0.00");
						$("#montod").val(0);
						$("#montoh").val(0);			
					}
                }});
			}	
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

		if($("#estatus").val()=="Sin Procesar"){
			bootbox.confirm({message:'Esta a punto de Salir sin completar el Proceso! ¿Desea Continuar?',
			buttons:{confirm:{label:'Aceptar',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
				callback:function (result) {
					if(result)
					{
						mostrarform(false);
						$(".opi").prop('readonly',true);
						$(".ctrl").prop('disabled',true);
					}		
				}
			});
		}
		else{

			mostrarform(false);
			$(".opi").prop('readonly',true);
			$(".ctrl").prop('disabled',true);
		}		
    });
}

//Función Agregar
function agregar(){

    $("#btnAgregar").click(function () { 
		  generarCod();
		  $(".ctrl").prop('disabled',false);
		  $(".opi").prop('readonly',false);
		  $("#btnEditar").prop('disabled',true);
		  $("#btnGuardar").prop('disabled',true);
		  mostrarform(true);
		  limpiar();
		  EventoChk();
    });
}

function editar() {
	$("#btnEditar").click(function () { 

		$(".ctrl").prop('disabled',false);
		$(".opi").prop('readonly',false);
		$("#btnEditar").prop('disabled',true);
		$("#btnGuardar").prop('disabled',false);

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
					url: '../ajax/movbanco.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listar'},				
					error: function(e){
					console.log(e);	
				}
			},
			bDestroy: true,
			//iDisplayLength: 10,//Paginación
			order: [[1, "asc" ]],//Ordenar (columna,orden)
			scrollY:"290px",
			scrollX:true,
			scrollCollapse:true,
			paging:false,
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

	bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?",
		buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
		callback:function(result){
		if(result)
		{	
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-refresh text-success"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){});
			
			$.ajax({
				url: "../ajax/movbanco.php",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos){   
				dialog.modal('hide');                    
				bootbox.alert(datos);          
				mostrarform(false);
				listar();
			}});
		}
	}});
}

function mostrar(idmovbanco)
{
	$.post("../ajax/movbanco.php",{'opcion':'mostrar',idmovbanco:idmovbanco}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		//array que crea los avlores de textbox segun el valor recibido
		$.each(data, function (label, valor) { 		
			$('#'+label).val(valor)	
		});
		$("#idcuenta").niceSelect("update");
		$('#idoperacion').niceSelect("update");
		$('#tipo').niceSelect("update");
		EventoChk();

		var op=data.tipo;

		if (op=='NC'||op=='TPOS'||op=='DEP'||op=='INT') {

			$('#monto').val(data.montod);

		} else if (op=='ND'||op=='CHEQ'||op=='TNEG'||op=='ITF') {

			$('#monto').val(data.montoh);
		}

		$("#btnGuardar").prop('disabled',true);

		if(data.origen=='Banco' && data.estatus!='Anulado')
		{
			$("#btnEditar").prop('disabled',false);
		}
		else {
			$("#btnEditar").prop('disabled',true);
		}

		$(".opi").prop('readonly',true);
		$(".ctrl").prop('disabled',true);

		$('[data-toggle="tooltip"]').tooltip();
		
 	})
}

//Función para desactivar registros
function anular(idmovbanco)
{
	bootbox.confirm({message:"¿Está Seguro de Anular el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/movbanco.php", {'opcion':'anular',idmovbanco : idmovbanco}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idmovbanco)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/movbanco.php", {'opcion':'eliminar',idmovbanco : idmovbanco}, function(e){

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
			'href':'../reportes/rptMovBanco.php',
			'target':'_blank',
		});
	});
};


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

	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());

	$('select').css('padding-left','0px');


	$('.numberf').number(true,2);

	$("#monto").change(function () { 

		if ($(this).val()>0)
		{
			$("#btnGuardar").prop('disabled',false);
		} else
		{
			$("#btnGuardar").prop('disabled',true);
		}
	});

	document.title = "..:Movimiento de Banco:..";
	

});

init();