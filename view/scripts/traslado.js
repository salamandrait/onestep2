var tabla,tabladetalle;
var iddep;
var iddepi;
var tablal;
var cantidadr=0
var stockval=0;
var valorund=0;
var validar=0;
var permitir=0;
var permitir;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
  listar();
	agregar();
	cancelarform();
	SelccionDeposito();
	MostrarModal();
	// GenerarReporte();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	//Cargamos los items al select deposito
	$.post('../ajax/traslado.php',{'opcion':'selectDeposito'}, function (r) {
		$("#iddeposito,#iddepositoi").html(r);
		$("#iddeposito,#iddepositoi").val(r);
		$('#iddeposito,#iddepositoi').niceSelect('update');
	});
	
	$.post('../ajax/traslado.php',{'opcion':'Moneda'},function(cod_mo){	
		$('#lbcod_moneda').html(cod_mo);
	});

	$("#idarticulom").change(function () { 

		var idart=$(this).val();
		$.post('../ajax/traslado.php',{'opcion':'selectUnidad','idarticulo':idart},function (r) {
				$("#idartunidad").html(r);
				$('#idartunidad').trigger("chosen:updated");
	
			var id=$("#idartunidad").val();
	
				$.post('../ajax/traslado.php',{'opcion':'Unidad','id':id},function (data) {
					data =JSON.parse(data);
					$('#valorund').val(data.valor);
					$('#desc_unidad').val(data.desc_unidad);		
					valorund=data.valor;
			});			
		});	 
	});	
	 
	$("#idartunidad").change(function () { 
		var id=$(this).val();
		$.post('../ajax/traslado.php',{'opcion':'Unidad','id':id},function (data) {
			data =JSON.parse(data);
			$('#valorund').val(data.valor);
			$('#desc_unidad').val(data.desc_unidad);	
			valorund=data.valor;	
		});		 
	});
}

//Generar Correlativo
function generarCod(){	

	$.post('../ajax/correlativo.php',{'opcion':'generarCod','tabla':'tbtraslado'},function(data){
		data = JSON.parse(data);
		$("#cod_traslado").val(data.codnum)

		if (data.estatus==1)
		{
			$("#cod_traslado")
			.val(data.codnum)
			.prop('readonly',true);
		} else{
			$("#cod_traslado")
			.prop('readonly',false)
		}
	});
}

//Función limpiar
function limpiar(){

	$("#iddeposito").val("");
	$('#iddeposito').niceSelect('update');
	$("#iddepositoi").val("");
	$('#iddepositoi').niceSelect('update');
	$("#idtraslado").val("");
   $("#desc_traslado").val("");
	$("#estatus").val("Sin Procesar");
	$("#totalstock").html("0.00");
	$("#totalv").val("0.00");
	$("#totalv").html("0.00");
	$("#fechareg").val("");
	$(".filas").remove();

	//Obtenemos la fecha actual
	$("#fechareg").datepicker({
        changeMonth: true,
        changeYear: true,
        autoclose:"true",
        format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());

	$(".ctrl").prop("disabled", false);	
	$(".inp").prop("readonly", false);	
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag){

		$("#listadoregistros").addClass('hidden');
		$("#formularioregistros").removeClass('hidden');
		$("#btnAgregar").hide();
		$("#btnReporte").hide();

		$("#btnGuardar").prop("disabled",true);
		$("#btnCancelar").show();
        detalles=0;
	}
	else {
		$("#listadoregistros").removeClass('hidden');
		$("#formularioregistros").addClass('hidden');
		$("#btnAgregar").show();
		$("#btnReporte").show();
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
					url: '../ajax/traslado.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listar'},				
					error: function(e){
					console.log(e);	
				}
			},
			bDestroy: true,
			//iDisplayLength: 8,//Paginación
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

//Función Agregar
function agregar(){

   $("#btnAgregar").click(function () { 
      limpiar();
		mostrarform(true);
		generarCod();
		$("#iddepositoi,#iddeposito").addClass('validar');	  
   });
}

//Función cancelarform
function cancelarform(){

  $("#btnCancelar").click(function (){
     limpiar();
	  mostrarform(false);
	  $("#iddepositoi,#iddeposito").removeClass('validar');	 
  });
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
   var formData = new FormData($("#formulario")[0]);
   formData.append('opcion','guardaryeditar');

	bootbox.confirm({message:'¿Está Seguro de Guardar el Registro?',
	buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
	callback:function(result){
		
		if(result)
      {	
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){	
			});
			
			$.ajax({
				url: "../ajax/traslado.php",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,		
				success: function(datos)
				{      
					dialog.modal('hide');              
					bootbox.alert(datos);	          
					mostrarform(false);
					listar();
					$("#iddepositoi,#iddeposito").removeClass('validar');
					$("#iddepositoi,#iddeposito").prop('disabled',false);	 	 
				}
			});
		limpiar();
		}
	}});
}

function mostrar(idtraslado)
{
	$.post("../ajax/traslado.php",{'opcion':'mostrar',idtraslado : idtraslado}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$(".ctrl").prop("disabled", true);	
		$(".inp").prop("readonly",true);
		$("#iddeposito").val(data.iddeposito);
		$("#iddeposito").niceSelect('update');
		$("#iddepositoi").val(data.iddepositoi);
		$("#iddepositoi").niceSelect('update');
		$("#idtraslado").val(idtraslado);
		$("#idusuario").val(data.idusuario);
		$("#cod_traslado").val(data.cod_traslado);
		$("#desc_traslado").val(data.desc_traslado);
		$("#estatus").val(data.estatus);
		$("#totalh").val(data.totalh);
		$("#fechareg").val(data.fechareg);
 
      $.post("../ajax/traslado.php",{'opcion':'listarDetalle','id':data.idtraslado},function(r){
         $("#tbdetalles").html(r);
			calcularTotales();
			$("#totalv").html(data.totalh);
			$('.numberf').number(true,2,'.',',');	
		});

		$(".ctrl").prop("disabled", true);	
		$(".inp").prop("readonly", true);	

		$('[data-toggle="tooltip"]').tooltip();
 	});
}

//Función Listar Articulos
function listarArticulos()
{
	tabla=$('#tbarticulos').dataTable(
	{
		aProcessing: true,//Activamos el procesamiento del datatables
		aServerSide: true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [],
			columnDefs:[{
				"targets":'nd',
				"orderable":false,
				"searchable":false,		
         }],	
		ajax:
			{
				url: '../ajax/traslado.php',
               type : "POST",
               data:{'opcion':'listarArticulos','deporigen':iddepi,'depdestino':iddep},
					dataType : "json",						
					error: function(e){console.log(e.responseText);}
            },
		bDestroy: true,
		iDisplayLength:8,//Paginación
		order: [[ 1, "asc" ]],//Ordenar (columna,orden)
		bSort: true,
		bFilter:true,
		bInfo:true,
	});
}

function MostrarModal(){

	$("#btnAgregarArt").click(function () { 
		$("#ModalCrearArticulo").modal('show');
		listarArticulos();
		
	});

	$("#cod_articulom,#desc_articulom").click(function () { 
		$("#ModalArticulo").modal('show');
	});
}

function SelccionDeposito(){

	$("#iddeposito").change(function () { 
		if($("#iddepositoi option:selected").val()==$(this).val()){
			$("#iddeposito").val("")
			$("#iddepositoi").val("")
			bootbox.alert("El Deposito de Origen No puede ser Igual al Deposito de destino!");
		} else{

			iddepi=$("#iddepositoi").val();
			iddep=$("#iddeposito").val();
			$("#btnAgregarArt").prop('disabled',false);	
		}
	});

		$("#iddepositoi").change(function () { 
		if($("#iddeposito option:selected").val()==$(this).val()){
			$("#iddepositoi").val("")
			$("#iddeposito").val("")
			bootbox.alert("El Deposito de Origen No puede ser Igual al Deposito de destino!");
		} else{

			iddepi=$("#iddepositoi").val();
			iddep=$("#iddeposito").val();
			$("#btnAgregarArt").prop('disabled',false);	
		}
	});
}

//Declaración de variables necesarias para trabajar con las compras y sus detalles
var cont=0;
var detalles=0;

function agregarDetalle(idarticulo,iddeposito,cod_articulo,desc_articulo,tipor,costo,stock,disp){
	$("#idarticulom").val(idarticulo);
	$("#iddeporigen").val(iddeposito);
	$("#cod_articulom").val(cod_articulo);
	$("#desc_articulom").val(desc_articulo);
	$("#tipom").val(tipor);
	$("#costom").val(costo);
	$("#stockm").val(stock);
	$("#dispdestino").val(disp);

	$("#ModalArticulo").modal('hide');

	var idart=$("#idarticulom").val();

		$.post('../ajax/traslado.php',{'opcion':'selectUnidad','idarticulo':idart},function (r) {
				$("#idartunidad").html(r);
				$('#idartunidad').trigger("chosen:updated");
	
			var id=$("#idartunidad").val();
	
				$.post('../ajax/traslado.php',{'opcion':'Unidad','id':id},function (data) {
					data =JSON.parse(data);
					$('#valorund').val(data.valor);
					$('#desc_unidad').val(data.desc_unidad);	
					valorund=data.valor;
			});			
	});

	$("#cantidadm,#idarticulom,#idartunidad").change(function(){

		cantidadr=$("#cantidadm").val();
		stockval=$("#stockm").val();
		valorund=$('#valorund').val();
		validar=stockval-(cantidadr*valorund);	
	});		
}

function agregarRengon()
{  	
	$("#btnAceptarM").click(function(){

		permitir=true;

		validar=stockval-(cantidadr*valorund);

			if (validar<0) {
				if (permitir) {
					bootbox.confirm({
					message: 'La Cantidad a Procesar es Mayor al Stock Disponible! Se generará un Stock Negativo de  <b>'
						+($.number(validar,0))+'</b> en el <b>Deposito de Origen!</b> Desea Continuar?',
						buttons: {
							confirm: { label: 'OK', className: 'btn-primary' },
							cancel: { label: 'Cancelar', className: 'btn-danger' }
						},
						callback: function (result) {
							if (!result){
								$("#cantidadm").val("0");
								$("#btnAceptarM").prop('disabled',true);
							} else {
								DatasetAgregarRenglon();
							}
					}});
				}else {
					bootbox.alert('La Cantidad a Procesar  de <b>'+($.number(cantidadr*valorund))+
					' Unds. </b> es Mayor al Stock Disponible <b>'+($.number(stockval,0))+
					'</b> en el <b>Deposito de Origen!</b>  No es Posible realizar la Operación.'
					);
						$("#cantidadm").val("0");
						$("#btnAceptarM").prop('disabled',false);
				}
			} else{
				DatasetAgregarRenglon();
			}
	});
}

//Datos Correspondientes al Renglon a Ingresar
function DatasetAgregarRenglon() {

	var idarticulov,idartunidadv,cantidadv,tipov,valorv,dispv,costov,stockv;
	var cod_articulov, desc_articulov,desc_unidadv;
	var iddepositoi;
	var iddepositod;
	var totalt=0;

		idarticulov=$.trim($("#idarticulom").val());
		iddepositoi=$.trim($("#iddeporigen").val());
		iddepositod=$("#iddeposito").val();
		idartunidadv=$.trim($("#idartunidad").val());
		cod_articulov=$.trim($("#cod_articulom").val());
		desc_articulov=$.trim($("#desc_articulom").val());
		desc_unidadv=$.trim($('#desc_unidad').val());
		cantidadv=$.trim($("#cantidadm").val());
		dispv =$.trim($("#stockm").val());
		stockv=$.trim($("#stockm").val());
		dispv=$.trim($("#dispdestino").val());
		costov=$.trim($("#costom").val());
		tipov=$.trim($("#tipom").val());
		valorv=$.trim($('#valorund').val());

	var w = 'style="width:';
	var a = '; text-align:';

	if($("#idarticulom").val()==$("#idarticulo").val()){

		bootbox.alert('El Artículo <b>'+$("#desc_articulom").val()+
		'</b> ya se Encuentra en el Listado!. Modifique el Renglon o Seleccione otro Artículo');

	}else if($("#cantidadm").val()==0){
		bootbox.alert('Debe ingresar una Cantidad para poder agregar el Artículo!');
	} else {

		totalt = cantidadv * (costov * valorv);
			var fila='<tr class="filas" id="fila'+cont+'">'+
			'<td style="width:25px; text-align:center;">'+
			'<button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle('+cont+')">'+
			'<span class="fa fa-times-circle"></span></button></td>'+
			'<td class="hidden">'+
				'<input type="hidden" name="idarticulo[]" id="idarticulo" value="'+idarticulov+'">'+
				'<input type="hidden" name="iddepositoi[]" id="iddepositoi" value="'+iddepositoi+'">'+
				'<input type="hidden" name="iddepositod[]" id="iddepositod" value="'+iddepositod+'">'+
				'<input type="hidden" name="disp[]" id="disp[]" value="'+dispv+'">'+
				'<input type="hidden" name="stock[]" id="stock[]" value="'+stockv+'">'+
				'<input type="hidden" name="tipo[]" id="tipo[]" value="'+tipov+'">'+
				'<input type="hidden" name="valor[]" id="valor[]" value="'+valorv+'">'+
				'<input type="hidden" name="idartunidad[]" id="idartunidadr[]" value="'+idartunidadv+'">'+
				'<input type="text" onchange="modificarSubtotales();" name="cantidad[]" id="cantidad[]" value="'+cantidadv+'">'+
			'</td>'+
			'<td><h5 ' + w + '150px;">'+cod_articulov+'</h5></td>'+
			'<td><h5 ' + w + '350px;">'+desc_articulov+'</h5></td>'+
			'<td><h5 ' + w + '90px;">'+desc_unidadv+'</h5></td>'+
			'<td><h5 ' + w + '80px' + a + 'right;">' + cantidadv + '</h5></td>'+
			'<td><input type="text" onchange="modificarSubtotales();" '+w+'140px'+a+'right;" name="costo[]" id="costo[]" value="'+costov+'"></td>'+
			'<td><h5 id="total" name="total" onchange="modificarSubtotales();calcularTotales();" class="numberf" '+w+'150px'+a+'right;">'+totalt+'</h5></td>'+
			'</tr>';
			cont++;
      detalles=detalles+1;   
      $('#tbdetalles').append(fila);
      $('#tbdetalles').addClass('table-hover');
      modificarSubtotales();
			calcularTotales();
			validar=0;
			stockval=0;
			cantidadr=0;
			valorund=0;
		$("#ModalCrearArticulo").modal('toggle');
		$("input.control,select.control").val("");
	}
}

//Calculo de SubTotales
function modificarSubtotales()
{
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("costo[]");
	var sub = document.getElementsByName("total");
		for (var i = 0; i <cant.length; i++) 
		{
			var inpC = cant[i];
			var inpP = prec[i];
			var inpS = sub[i];                           

			inpS.value = inpC.value * inpP.value;

			document.getElementsByName("total")[i].innerHTML = inpS.value;
		}

		$('.numberf').number(true,2);	

	calcularTotales();
	evaluar();
}

function calcularTotales()
{
	var sub = document.getElementsByName("total");
	var total = 0.0;

		for (var i = 0; i <sub.length; i++) 
		{
			total += document.getElementsByName("total")[i].value;
		}

	$("#totalv").html(total);
	$("#totalh").val(total);
	$('.numberf').number(true,2);	
	evaluar();
}	

function eliminarDetalle(indice){
	$("#fila" + indice).remove();
	detalles=detalles-1;
	calcularTotales();
	evaluar();
}

function evaluar()
{
	if (detalles>0)
	{
		$("#btnGuardar").prop('disabled',false);
		$(".validar").prop('disabled',true);
	}
	else
	{
		$("#btnGuardar").prop('disabled',true);
		$(".validar").prop('disabled',false);		
		cont=0;	
	}
}

//Función para anular registros
function anular(idtraslado,tipo)
{
	bootbox.confirm({message:'¿Está Seguro de Anular el Registro?',
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
        {
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){	
			});

			$.post('../ajax/traslado.php', {'opcion':'anular',idtraslado:idtraslado,tipo:tipo}, function(e){
				dialog.modal('hide');
            bootbox.alert(e);									
				mostrarform(false);
				listar();
			});			
        }
	}});
}

//Función para eliminar registros
function eliminar(idtraslado,tipo)
{

	bootbox.confirm({message:'¿Está Seguro de Eliminar el Registro?',
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
        {
			var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});
						
			dialog.init(function(){	
			});

			$.post('../ajax/traslado.php', {'opcion':'eliminar',idtraslado:idtraslado,tipo:tipo}, function(e){
				dialog.modal('hide');
				bootbox.alert(e);									
				mostrarform(false);
				listar();				
        	});	
        }
	}});
}
//

function GenerarReporte(){		
	
	$("#btnReporte").click(function(){
		$('#rep').prop('href','../reportes/rptAjuste.php')	
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
	
    $(".ffechareg").datepicker({
		format:"dd/mm/yyyy",
		autoclose: true,
	});

   $('.numberf').number(true,2);	
   
	document.title = "..:One Step||Traslado Entre Depositos:..";
	
	agregarRengon();

});

init();