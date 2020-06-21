var tabla;
var detalles=0;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	TipoAjuste();
	ImportarDetalle();
	Procesar();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});
}

//Generar Correlativo
function generarCod(){	

	$.post('../ajax/correlativo.php',{'opcion':'generarCod','tabla':'tbajustep'},function(data){
		data = JSON.parse(data);
		$("#cod_ajuste").val(data.codnum)

		if (data.estatus==1)
		{
			$("#cod_ajustep")
			.val(data.codnum)
			.prop('readonly',true);
		} else{
			$("#cod_ajustep")
			.prop('readonly',false)
		}
	});
}

//Función limpiar
function limpiar(){
	$("#idajustep").val("");
	$("#estatus").val("Sin Procesar");
	$("#tipo").val("");
	$("#tipopreciom").val("");
	$("#fechareg").val("");
	$("#cod_ajustep").val("");
	$("#desc_ajustep").val("");
	$("#costoaprecio").val("0");

	$("#fechareg").datepicker({
    changeMonth: true,
    changeYear: true,
    autoclose:"true",
    format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());
	EventoChk()
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

function TipoAjuste(){ 

	$("#tipo").change(function () { 
		if ($(this).val()=='Costo') {
				$("#tipopreciom").val("");
				$("#tipopreciom").prop('disabled',true);
				$("#btnAgregarArt").prop('disabled',false);
		} else {
			$("#tipopreciom").prop('disabled',false);
			$("#btnAgregarArt").prop('disabled',false);		
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
		listar();	  
   });
}

//Función Agregar
function agregar(){
   $("#btnAgregar").click(function () {
		
		generarCod()
		limpiar();
    mostrarform(true);
		detalles=0;
		Evaluar();
		$(".filas").remove();
		$('.paneltb').css('height','200px');
		$("#totalreg").html(' :0');
		EvaluarProcesar();
   });
}

function EvaluarProcesar() {
	if ($("#estatus").val() == 'Registrado') {
		$("#btnGuardar,#btnAgregarArt,#tipo,#tipopreciom,#costoaprecio").prop('disabled', true);
		$("#btnProcesar").prop('disabled', false);
	}
	else if ($("#estatus").val() == 'Procesado') {
		$("#btnGuardar,#btnAgregarArt,#tipo,#tipopreciom,#costoaprecio").prop('disabled', true);
		$("#btnProcesar").prop('disabled', true);
	}
	else if ($("#estatus").val() == 'Sin Procesar') {
		$("#btnProcesar").prop('disabled', true);
		$("#tipo,#costoaprecio").prop('disabled', false);
	}
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
					url: '../ajax/ajustep.php',
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

//Función Listar
function listarId(idajustep){

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
					url: '../ajax/ajustep.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listarId',idajustep:idajustep},				
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

	bootbox.confirm({message:'¿Está Seguro de Guardar el Registro?',
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if (result) {

				var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-refresh label-success"></i></h4> Procesando...',size: 'small'});
						
				dialog.init(function(){});

				$.ajax({
				url: "../ajax/ajustep.php",
				type: "POST",
				datatype:"json", 
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos) {
					dialog.modal('hide');              
					bootbox.alert(datos); 
						$.post("../ajax/ajustep.php",{'opcion':'mostrarCod','cod':$("#cod_ajustep").val()}, function(data) {
							data = JSON.parse(data);
							mostrar(data.idajustep);
							EvaluarProcesar();
						});    
				},
				error: function(datos){
					dialog.modal('hide');              
					bootbox.alert(datos);
				}});			
			}
		}
	});
}

function Procesar() {
	$("#btnProcesar").click(function(){
		switch ($("#tipo").val()) {
			case 'Costo':

			var formData = new FormData($("#formulario")[0]);
			formData.append('opcion','procesarc');

				bootbox.confirm({message:'Se Ajustaran Sus '+$("#tipo").val()+'s segun los Parámetros Establecidos! '+
				'Este Proceso es Irreversible ¿Desea Continuar?',
					buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
					callback:function(result){
						if (result){

							var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-refresh label-success"></i></h4> Procesando...',size: 'small'});
						
							dialog.init(function(){});

							$.ajax({
							url: "../ajax/ajustep.php",
							type: "POST",
							datatype:"json", 
							data: formData,
							contentType: false,
							processData: false,
							success: function(datos) {
								dialog.modal('hide');              
								bootbox.alert(datos);
								$.post("../ajax/ajustep.php",{'opcion':'mostrarCod','cod':$("#cod_ajustep").val()}, function(data) {
									data = JSON.parse(data);
									mostrar(data.idajustep);
									EvaluarProcesar();
								});  
							},
							error: function(datos){
								dialog.modal('hide');              
								bootbox.alert(datos);
							}});
						}
					}
				});
				
			break;

			case 'Precio':

			var formData = new FormData($("#formulario")[0]);
			formData.append('opcion','procesarp');

				bootbox.confirm({message:'Se Ajustaran Sus '+$("#tipo").val()+'s segun los Parámetros Establecidos! '+
				'Este Proceso es Irreversible ¿Desea Continuar?',
					buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
					callback:function(result){
						if (result){

							var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-refresh label-success"></i></h4> Procesando...',size: 'small'});
						
							dialog.init(function(){});

							$.ajax({
							url: "../ajax/ajustep.php",
							type: "POST",
							datatype:"json", 
							data: formData,
							contentType: false,
							processData: false,
							success: function(datos) {
								dialog.modal('hide');              
								bootbox.alert(datos);
								$.post("../ajax/ajustep.php",{'opcion':'mostrarCod','cod':$("#cod_ajustep").val()}, function(data) {
									data = JSON.parse(data);
									mostrar(data.idajustep);
									EvaluarProcesar();
								});          
							},
							error: function(datos){
								dialog.modal('hide');              
								bootbox.alert(datos);
							}});
						}
					}
				});
				
			break;
		}

	})
	
}

function mostrar(idajustep)
{
	$.post("../ajax/ajustep.php",{'opcion':'mostrar',idajustep:idajustep}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idajustep").val(data.idajustep);
		$("#cod_ajustep").val(data.cod_ajustep);
		$("#desc_ajustep").val(data.desc_ajustep);
		$("#estatus").val(data.estatus);
		$("#tipo").val(data.tipo);
		$("#tipopreciom").val(data.tipoprecio);
		$("#fechareg").val(data.fechareg);
		$('[data-toggle="tooltip"]').tooltip();

		EvaluarProcesar();

		$.post('../ajax/ajustep.php',{'opcion':'mostrarDetalle',tipo:data.tipo,idajustep:idajustep},function(rdata){
				$('#tbdetalles').html(rdata)
				$('.paneltb').css('height','190px');
				$("span.numberf").number(true,2);
				$("input.numberf").number(true,2);	
				modificarSubtotales();
				detalles=$("#detalles").val();
				$("#totalreg").html(' '+detalles);
		});
 	})
}

//Función para activar registros
function anular(idajustep)
{
	bootbox.confirm({message:"¿Está Seguro de Anular el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/ajustep.php", {'opcion':'anular',idajustep:idajustep}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idajustep)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/ajustep.php", {'opcion':'eliminar',idajustep : idajustep}, function(e){

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

function PatametrosTabla() {
	$('#tbdetalles').dataTable({
		bFilter: false,
	//	bDestroy: true,
		scrollY: "200px",
		scrollX: true,
		scrollCollapse: true,
		paging: false,
		columnDefs: [{
		targets: 'nd',
		 	orderable: false,
		 	searchable: false,
		}],
	});
}

function ImportarDetalle(){
	$("#btnAgregarArt").click(function(){  
		$.post('../ajax/ajustep.php',
		{'opcion':'listarArticulo','tipo':$("#tipo").val(),'tipop':$("#tipopreciom").val(),'costoaprecio':$("#costoaprecio").val()},function(r){
			$('#tbdetalles').html(r)
			$('.paneltb').css('height','200px');
			$("span.numberf").number(true,2);
			$("input.numberf").number(true,2);	
			modificarSubtotales();
			detalles=$("#detalles").val();
			$("#totalreg").html(' '+detalles);
			Evaluar();
			//PatametrosTabla();
		});
	});
}

//Calculos
function modificarSubtotales()
{
	var tipo=$("#tipo").val();
	switch (tipo) {

		case 'Precio':
			var prec = document.getElementsByName("precio[]");
			var mgp = document.getElementsByName("mgp[]");
			var tax = document.getElementsByName("tasa[]");
			var sub = document.getElementsByName("subtotal");
			var totalp = document.getElementsByName("totalp");

			for (var i = 0; i <prec.length; i++) 
			{
				var inpP = prec[i];
				var inpMG = mgp[i];
				var inpS = sub[i]; 
				var taX = tax[i];
				var totalP = totalp[i];                          

				inpS.value = parseFloat(((inpP.value * inpMG.value)/100))+parseFloat(inpP.value);
				totalP.value=((parseFloat(inpS.value)*parseFloat(taX.value))/100)+parseFloat(inpS.value);

				document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
				document.getElementsByName("totalp")[i].innerHTML = totalP.value;
			}
			$('.numberf').number(true,2,'.',',');		
		break;

		case 'Costo':
			var costo = document.getElementsByName("costo[]");
			var tax = document.getElementsByName("tasa[]");
			var imp = document.getElementsByName("imp");
			var totalc = document.getElementsByName("totalc");

			for (var i = 0; i <costo.length; i++) 
			{
				var inpC = costo[i];
				var inpI = imp[i]; 
				var taX = tax[i];
				var totalC = totalc[i];                          

				inpI.value = parseFloat(inpC.value *taX.value)/100;
				totalC.value=parseFloat(inpI.value)+parseFloat(inpC.value);

				document.getElementsByName("imp")[i].innerHTML = inpI.value;
				document.getElementsByName("totalc")[i].innerHTML = totalC.value;
				$('.numberf').number(true,2,'.',',');	
			}	
		break;
	}
}

//Eliminar Renglon
function eliminarDetalle(indice){

	$("#fila" + indice).remove();
	detalles=--detalles;
	$("#totalreg").html(' :'+detalles);
	Evaluar();
}

//Evaluar Cantidad de Renglones
function Evaluar(){
	
	if (detalles>0)
	{
		$("#btnGuardar").prop('disabled',false);	
	}
	else
	{
		$("#btnGuardar").prop('disabled',true);
		cont=0;	
	}
}

function GenerarReporte(){			
	$("#btnReporte").click(function(){
		 $('#rep').prop({
		 'href':'../reportes/rptZona.php',
		 'target':'_blank',});
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
	
		$('select').css('padding','2px');

	$("#fechareg").datepicker({
		format:"dd/mm/yyyy",
		autoclose: true,
	});

	document.title = "..: Ajuste de Costos y Precios :..";



});

init();