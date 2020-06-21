var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	editar();
	cancelarform();
	GenerarReporte();
	Monto();
	EventoChk();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	$.post('../ajax/movcaja.php',{'opcion':'selectOperacion','origen':$("#origen").val()},function (r) {
		if (r=='') {
			$('#idoperacion').append('<option>No Existen Registros</option>');
			$('#idoperacion').trigger("chosen:updated");
		} else {
			$("#idoperacion").html(r);
			$('#idoperacion').trigger("chosen:updated");
		}
	});

	$.post('../ajax/movcaja.php',{'opcion':'caja','op':'select'},function (r) {
		if (r=='') {
			$('#idcaja').append('<option>No Existen Registros</option>');
			$('#idcaja').trigger("chosen:updated");
		} else {
			$("#idcaja").html(r);
			$('#idcaja').trigger("chosen:updated");

			var id=$('#idcaja').val();

			$.post('../ajax/movcaja.php',{'opcion':'caja','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#cod_caja").val(data.cod_caja);			
				$("#saldototal").val(data.saldototal);
			});
		}
	});

	$("#idcaja").change(function(){
		var id=$(this).val();
		$.post('../ajax/movcaja.php',{'opcion':'caja','op':'data','id':id},function (data) {
			data=JSON.parse(data);
			$("#cod_caja").val(data.cod_caja);
			$("#saldototal").val(data.saldototal);
		});
	});

	$.post('../ajax/movcaja.php',{'opcion':'banco','op':'select'},function (r) {
		if (r=='') {
			$('#idbanco').append('<option>No Existen Registros</option>');
			$('#idbanco').trigger("chosen:updated");
		} else {
			$("#idbanco").html(r);
			$('#idbanco').trigger("chosen:updated");
		}
	});
}

function SelectChangeBanco(){

	$.post('../ajax/movcaja.php',{'opcion':'banco','op':'select'},function (r) {
		if (r=='') {
			$('#idbanco').append('<option>No Existen Registros</option>');
			$('#idbanco').trigger("chosen:updated");
		} else {
			$("#idbanco").html(r);
			$('#idbanco').trigger("chosen:updated");

			var id=$("#idbanco").val();
			$.post('../ajax/movcaja.php',{'opcion':'banco','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#cod_banco").val(data.cod_banco);
			});
		}
	});

	$("#idbanco").change(function(){

		var id=$(this).val();
		$.post('../ajax/movcaja.php',{'opcion':'banco','op':'data','id':id},function (data) {
			data=JSON.parse(data);
			$("#cod_banco").val(data.cod_banco);
		});
	});

}

//Generar Correlativo
function generarCod(){	

	$.post('../ajax/correlativo.php',{'opcion':'generarCod','tabla':'tbmovcaja'},function(data){
		data = JSON.parse(data);
		$("#cod_movcaja").val(data.codnum)

		if (data.estatus==1)
		{
			$("#cod_movcaja")
			.val(data.codnum)
			.prop('readonly',true);
		} else{
			$("#cod_movcaja")
			.prop('readonly',false)
		}
	});
}

//Función limpiar
function limpiar(){

	$("#idmovcaja").val("");
	$("#idbanco").val("");
	$("#cod_banco").val("");
	$('#tipo').val("Ingreso");
	$('#tipo').trigger("chosen:updated");
	$('#forma').val("Efectivo");
	$('#forma').trigger("chosen:updated");
	$("#cod_movcaja").val("");
	$("#desc_movcaja").val("");
	$("#numerod").val("");
	$("#numeroc").val("");
	$("#monto").val("0.00");
	$("#montod").val(0.00);
	$("#montoh").val(0.00);
	$("#numerod").val("");
	$("#numeroc").val("");
	$("#origen").val("Banco");
	$("#estatus").val("Sin Procesar");
	$("#saldoinicial").val("0");

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
		if (value==1) {
			$(this).prop('checked', true);
		} else {
			$(this).prop('checked', false);
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
		mostrarform(false);
		$("#btnEditar").prop('disabled',true);
		$("#btnGuardar").prop('disabled',false);
		ShowForma(); 
    });
}

//Función Agregar
function agregar(){
    $("#btnAgregar").click(function () { 
		mostrarform(true);
		generarCod();
		$(".ctrl").prop('disabled',false);
		$(".opi").prop('readonly',false);
		$("#btnEditar").prop('disabled',true);
		$("#btnGuardar").prop('disabled',true);
		ShowForma();
    });
}

//Función Agregar
function editar(){

	$("#btnEditar").click(function () { 
	
	  $(".ctrl").prop('disabled',false);
	  $(".opi").prop('readonly',false);
	  $("#btnEditar").prop('disabled',true);
	  $("#btnGuardar").prop('disabled',false);
	  $("#idcaja").prop('disabled',false);
	  ShowForma();
  
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
		}
		],
	    buttons:[
			{extend:'copyHtml5',
			text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar al Portapapeles',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9]}},
			{
			extend:'excelHtml5',
			text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9]}},
			{
			extend:'csvHtml5',
			text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9]}},
			{
			extend:'pdf',
			text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{columns:[1,2,3,4,5,6,7,8,9]}}],
            ajax:{
					url: '../ajax/movcaja.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listar'},				
					error: function(e){
					console.log(e);	
				}
			},
			bDestroy: true,
			iDisplayLength: 10,//Paginación
			order: [[2, "asc" ]],//Ordenar (columna,orden)
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

	bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?",
		buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
		callback:function(result){
		if(result)
		{	
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){});
			
			$.ajax({
				url: "../ajax/movcaja.php",
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
			limpiar();
		}
	}});
}

function mostrar(idmovcaja)
{
	$.post("../ajax/movcaja.php",{'opcion':'mostrar',idmovcaja:idmovcaja}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#origen").val(data.origen);
		$("#idmovcaja").val(data.idmovcaja);
		$("#idusuario").val(data.idusuario);
		$("#cod_movcaja").val(data.cod_movcaja);
		$("#desc_movcaja").val(data.desc_movcaja);
		$("#tipo").val(data.tipo);
		$('#tipo').trigger("chosen:updated");
		$("#forma").val(data.forma);
		$('#forma').trigger("chosen:updated");
		$("#idoperacion").val(data.idoperacion);
		$('#idoperacion').trigger("chosen:updated");
		$("#idcaja").val(data.idcaja);
		$('#idcaja').trigger("chosen:updated");
		$("#cod_caja").val(data.cod_caja);
		$("#idbanco").val(data.idbanco);
		$('#idbanco').trigger("chosen:updated");
		$("#cod_banco").val(data.cod_banco);
		$("#numerod").val(data.numerod);
		$("#numeroc").val(data.numeroc);
		$("#estatus").val(data.estatus);
		$("#montod").val(data.montod);
		$("#montoh").val(data.montoh);
		$("#saldototal").val(data.saldototal);
		$("#fechareg").val(data.fechareg);

		$("#tipo").show(function() {

			var valuea =$(this).val();
			var valueb =$("#montoh").val();
			var valuec =$("#montod").val();

			if (valuea==='Ingreso') {
				$('#monto').val(valuec);
			} else if (valuea==='Egreso') {
				$('#monto').val(valueb);
			}
		});

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
function anular(idmovcaja,idcaja)
{
	bootbox.confirm({message:"¿Está Seguro de Anular el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/movcaja.php", {
					'opcion':'anular',
					idmovcaja : idmovcaja,
					idcaja:idcaja
				}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idmovcaja,idcaja)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/movcaja.php", {
				  'opcion':'eliminar',
				  idmovcaja : idmovcaja,
				  idcaja:idcaja
				}, function(e){

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
			'href':'../reportes/rptMovCaja.php',
			'target':'_blank',
		});
	});
};

function ShowForma(){
	var valor=$("#forma").val();

	if (valor=='Cheque'||valor=='Tarjeta') {

		$("#idbanco,#numeroc").prop("required",true);
		$("#idbanco,#numeroc").prop('disabled',false);	
		$("#numeroc").prop("required",true);	 
	} else {
		$("#idbanco,#numeroc").prop("required",false);
		$("#idbanco,#numeroc").prop('disabled',true);
		$("#idbanco,#numeroc,#cod_banco").val("");	
	}
}

function Monto(){

	var monto;
	var tipo;

	$("#tipo").change(function(){
		tipo=$(this).val();
		monto=$("#monto").val();

		if (tipo=='Ingreso') {
			$("#montod").val(monto);
			$("#montoh").val(0);
		} else {
			$("#montoh").val(monto);
			$("#montod").val(0);
	  	}
	});

	$("#monto").keyup(function(){
		monto=$(this).val();
		tipo=$("#tipo").val();

		if (tipo=='Ingreso') {
			$("#montod").val(monto);
			$("#montoh").val(0);
		} else {
			$("#montoh").val(monto);
			$("#montod").val(0);
		}
	});

	$("#forma").change(function(){

		if ($(this).val()=='Cheque'||$(this).val()=='Tarjeta') {

			$("#idbanco,#numeroc").prop("required",true);
			$("#idbanco,#numeroc").prop('disabled',false);	
			$("#numeroc").prop("required",true);
			SelectChangeBanco();		 
		} else {
			$("#idbanco,#numeroc").prop("required",false);
			$("#idbanco,#numeroc").prop('disabled',true);
			$("#idbanco,#numeroc,#cod_banco").val("");	
		}
	});

	$("#forma").show(function(){

		if ($(this).val()=='Cheque'||$(this).val()=='Tarjeta') {

			$("#idbanco,#numeroc").prop("required",true);
			$("#idbanco,#numeroc").prop('disabled',false);	
			$("#numeroc").prop("required",true);
			SelectChangeBanco();		 
		} else {
			$("#idbanco,#numeroc").prop("required",false);
			$("#idbanco,#numeroc").prop('disabled',true);
			$("#idbanco,#numeroc,#cod_banco").val("");	
		}
	});

	$("#monto").change(function() {
		var saldo=$("#saldototal").val();
		var monto=$("#monto").val();
		var op=$("#tipo").val();
		var validar=saldo-monto;
	
		if(op=='Egreso'){

			if(validar<0){

            bootbox.confirm({message:"¿El Monto de la Operacion es Mayor al saldo Disponible! Segenerara un Saldo Negativo de  <b>"
            +($.number(validar,2,'.',','))+"</b>  en Caja! Desea Continuar?", 
            buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
            callback:function(result){
					if(!result){
						$("#monto").val("0.00");
						$("#montod").val(0.00);
						$("#montoh").val(0.00);
               }
            }});
			}			
		}
	});

	$("#tipo").change(function() {
		var saldo=$("#saldototal").val();
		var monto=$("#monto").val();
		var op=$("#tipo").val();
		var validar=saldo-monto;
		
		if(op=='Egreso'){

			if(validar<0){

            bootbox.confirm({message:"¿El Monto de la Operacion es Mayor al saldo Disponible! Segenerara un Saldo Negativo de <b>"
            +($.number(validar,2,'.',','))+"</b> en Caja! Desea Continuar?", buttons:{confirm:{label: 'OK',className:'btn-primary'},
            cancel:{label: 'Cancelar',className:'btn-danger'}},
            callback:function(result){
					if(!result){
						$("#monto").val("0.00");
						$("#montod").val(0.00);
						$("#montoh").val(0.00);			
					}
            }});
			}		
		}
	});
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

	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());

 $('select').css('padding-left','0px');
 
 $('.padding-div').css('padding-right','3px');

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

 document.title = "..:Movimiento de Caja:..";

});

init();