var tabla,esfiscal,montofiscal,retenciona;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	MostrarModal();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	$.post('../ajax/pago.php',{'opcion':'Caja','op':'select'},function (r) {
		if (r=='') {
			$('#selectcaja').append('<option>No Existen Registros</option>');
			$('#selectcaja').niceSelect("update");
		} else {
			$("#selectcaja").html(r);
			$('#selectcaja').niceSelect("update");
		}

		$('#selectcaja').change(function () { 
			var id=$(this).val();

			$.post('../ajax/pago.php',{'opcion':'Caja','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#idcaja").val(data.idcaja);
				$("#cod_caja").val(data.cod_caja);
				$("#saldodisponible").val(data.saldoefectivo);	

				ValidarSaldo($("#saldodisponible").val());
			});
		});
	});

	$.post('../ajax/pago.php',{'opcion':'Cuenta','op':'select'},function (r) {
		if (r=='') {
			$('#selectcuenta').append('<option>No Existen Registros</option>');
			$('#selectcuenta').niceSelect("update");
		} else {
			$("#selectcuenta").html(r);
			$('#selectcuenta').niceSelect("update");

			$('#selectcuenta').change(function(){
				var id=$(this).val();

				$.post('../ajax/pago.php',{'opcion':'Cuenta','op':'data','id':id},function (data) {
					data=JSON.parse(data);
					$("#idcuenta").val(data.idcuenta);
					$("#cod_cuenta").val(data.cod_cuenta);
					$("#cod_banco").val(data.cod_banco);	
					$("#numcuenta").val(data.numcuenta);
					$("#saldodisponible").val(data.saldot);	
					ValidarSaldo($("#saldodisponible").val());
				});
			});
		}
	});
}

function ValidarSaldo(saldodisponible){
	var montoop=$("#montov").val();	
	var validar=parseFloat(saldodisponible)-parseFloat(montoop);

		if (montoop!=0) {
			if(validar<0){
				if ($("#tipopago").val()=='Caja') {
					bootbox.confirm({message:"¿El Monto de la Operacion es Mayor al saldo Disponible! Segenerara un Saldo Negativo de  <b>"
					+($.number(validar,2,",","."))+"</b> en la Caja  "+$("#idcaja option:selected").text()+"! Desea Continuar?", 
					buttons:{confirm:{label: 'OK',className:'btn-primary'},
					cancel:{label: 'Cancelar',className:'btn-danger'}},
						callback:function(result){
							if(!result){
								$("#idcaja").val("");
								$("#selectcaja").val("");
								$("#idcaja").val("");
								$("#cod_caja").val("");
								$("#saldodisponible").val("0.00")
							}
						}
					});																							
				} else if ($("#tipopago").val()=='Banco'){
					bootbox.confirm({message:"¿El Monto de la Operacion es Mayor al saldo Disponible! Segenerara un Saldo Negativo de  <b>"
						+($.number(validar,2,",","."))+"</b> en la Cuenta  "+$("#idcuenta option:selected").text()+"! Desea Continuar?", 
						buttons:{confirm:{label: 'OK',className:'btn-primary'},
						cancel:{label: 'Cancelar',className:'btn-danger'}},
							callback:function(result){
								if(!result){
									$("#idcuenta").val("");
									$("#selectcuenta").val("");
									$("#cod_cuenta").val("");
									$("#numcuenta").val("");
									$("#cod_banco").val("");
									$("#saldodisponible").val("0.00")
								}
						}});			
				}
			}
		}

	$("#btnGuardar").prop("disabled",false);
}

//Generar Correlativo
function generarCod(){	

	$.post('../ajax/correlativo.php',{'opcion':'generarCod','tabla':'tbpago'},function(data){
		data = JSON.parse(data);

		if (data.estatus==1)
		{
		$("#cod_pago")
		.val(data.codnum)
		.prop('readonly',true);

		} else{
			$("#cod_pago")
			.prop('readonly',false)
		}
		$("#numerodb,#numerodc").val(data.codnum)
	});

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

	$("input[type=text],input[type=textc],input[type=control],.ffechareg,#selectcuenta,#selectcaja").val("");
	$("input[type=controln]").val("0.00");
	$("input[type=controln]").prop('readonly',true);
	$("h5.control").html("");
	$("#idpago").val("");
	$('#tipo').val("Pago");	
  $("#origend").val("Pago");
	$("#estatus").val('Sin Procesar');
	$("input[type=checkbox]").val("0");
	$(".tot").prop('disabled',true);

	$("#tipopago option:selected").val('Banco');
	$("#tipopago").prop('disabled',true);
	$("#desc_proveedor,#desc_pago").prop({'disabled':false,'readonly':false});

	$(".ffechareg").datepicker({
    changeMonth: true,
    changeYear: true,
    autoclose:"true",
    format:'dd/mm/yyyy'
	}).datepicker("setDate", new Date());
	EventoChk();
}

function EventoChk(){

	$("#retenciona").change(function() {

		if($(this).is(':checked')) {  
			$(this).val("1"); 
		} else {  
			$(this).val("0");
		} 
	});

	$("#retencionb").change(function() {

		if($(this).is(':checked')) {  
			$(this).val("1"); 
		} else {  
			$(this).val("0");
		} 
	});

	$("#retenciona").show(function() {
		var value=$(this).val();
		if (value==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	});

	$("#retencionb").show(function() {
		var value=$(this).val();
		if (value==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	});

	$("#retenciona").change(function() {
		var value=$(this).val();
		if (value==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	})

	$("#retencionb").change(function() {
		var value=$(this).val();
		if (value==0) {
			$(this).prop('checked', false);
		} else {
			$(this).prop('checked', true);
	  }
	})
}

//Función mostrar formulario
function mostrarform(flag){

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
function cancelarform(){

    $("#btnCancelar").click(function () { 
		  mostrarform(false);	  
    });
}

//Función Agregar
function agregar(){

  $("#btnAgregar").click(function () { 
		limpiar();
    mostrarform(true);
		$("#btnGuardar,#btnRetencionA,#btnRetencionB").prop("disabled",true);
		$(".ctrl").prop('disabled',false);
		generarCod();
		$('#movbanco').removeClass('hidden');
		$('#movcaja').addClass('hidden');
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
					url: '../ajax/pago.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listar'},				
					error: function(e){
					console.log(e);	
				}
			},
			bDestroy: true,
			iDisplayLength: 8,//Paginación
			order: [[1, "asc" ]],//Ordenar (columna,orden)
			// scrollY:"290px",
			// scrollX:true,
			// scrollCollapse:true,
			// paging:false,
			bSort:true,
			bFilter:true,
			bInfo:true,
			deferRender:true,
			scroller:true,
			select:true,
    });        
}

//Función para guardar o editar
function guardaryeditar(e){

	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	formData.append('opcion','guardaryeditar');

	bootbox.confirm({message:"¿Está Seguro de Guardar el Registro?",
		buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
			callback:function(result){
				if (result) {
					if (esfiscal==1) {
						if ($("#optipo").html()=='Factura') {
							if ($("#retenciona").val()==0) {
								bootbox.confirm({message:'No ha Realizado La Retencion de <b>Impuesto al Valor Agregado</b> '+
								'al Documento en Proceso.¿Desea Continuar?',
								buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
									callback:function(result){
										if (result) {
											Registrar(formData);
											$("#tipopago").remove($('<option value="IVA">Ret. I.V.A.</option>'));
										} else {
											$("#btnGuardar").prop("disabled",true);
										}
									}
								});				
							} else {
								Registrar(formData);
								$("#tipopago").remove($('<option value="IVA">Ret. I.V.A.</option>'));
							}		
						} else {
							Registrar(formData);
							$("#tipopago").remove($('<option value="IVA">Ret. I.V.A.</option>'));
						}		
					} else {
						Registrar(formData);
						$("#tipopago").remove($('<option value="IVA">Ret. I.V.A.</option>'));
					}				
				}
			}
	});
}

function Registrar(formData) {
	var dialog = bootbox.dialog({
		message: '<h4><i class="fa fa-spin fa-refresh text-success"></i></h4> Procesando...', size: 'small'
	});
	dialog.init();
	$.ajax({
		url: "../ajax/pago.php",
		type: "POST",
		datatype: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			dialog.modal('hide');
			bootbox.alert(datos);
			mostrarform(false);
			listar();
		}
	});
}

function mostrar(idpago){

	$.post("../ajax/pago.php",{'opcion':'mostrar',idpago:idpago}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		//array que crea los avlores de textbox segun el valor recibido
		$.each(data, function (label, valor) { 		
			$('#'+label).val(valor);	
		});

	//	$('#retenciona').val(data.retenciona);

		$.each(data, function (label, valor) { 		
			$('#'+label).html(valor);
		});

		$('#selectcuenta').val(data.idcuenta);
		$('#selectcuenta').niceSelect('update');

		$('#selectcaja').val(data.idcaja);
		$('#selectcaja').niceSelect('update');

		if (data.idcuenta!=0) 
		{
			$('#movbanco').removeClass('hidden');
			$('#movcaja').addClass('hidden');
			$("#tipopago").val('Banco');
		} 
		else if (data.idcaja!=0)
		{
			$('#movbanco').addClass('hidden');
			$('#movcaja').removeClass('hidden');
			$("#tipopago").val('Caja');
		}
		$("input[type=controln],input[type=control]").prop('readonly',true);
		$("#btnGuardar,#btnRetencionA,#btnRetencionB,#selectcuenta,#selectcaja,.ctrl,#retenciona,#retencionb").prop("disabled",true);
		$('[data-toggle="tooltip"]').tooltip();
		$('div').removeClass('collapsed-box');
		EventoChk();
 	})
}

function MostrarModal() {

	$("#desc_proveedor").click(function () { 
		$("#ModalProveedor").modal('show');	
		listarProveedor();
		$("#btnDocumentos").prop('disabled',true);	
		$("#idcompra").val("");
		$("#idproveedor").val("");
		$("#cod_proveedor").val("");
		$("#desc_proveedor").val("");
		$("#rif").val("");
		$("h5.control").html("");
		$("input[type=controln]").val("0.00");
		$("#idoperacion").val("");
		$("#tipopago option:selected").val('Banco');
		$("#tipopago").prop('disabled',true);
			esfiscal=0;
			montofiscal=0;
			retenciona=0;
			$("#btnRetencionA,#btnRetencionB").prop("disabled",true);
	});

	$("#btnDocumentos").click(function () { 
		$("#ModalDocumento").modal('show');	
		listarDocumento();
		$("h5.control").html("");
		$("input[type=controln]").val("0.00");
    $('#idcompra').val("");
    $("#origend").val("Pago");
    $("#origenc").val("");
    $("#montov").prop('readonly',true);
		$("#mtotal").prop('disabled',true);
		
		$("#selectcuenta").val("");
		$("#selectcaja").val("");
		$("#cod_cuenta").val("");
		$("#cod_caja").val("");
		$("#numcuenta").val("");
		$("#cod_banco").val("");
		$("#saldodisponible").val("0.00")
		$("#saldodisponible").val("0.00")
		esfiscal=0;
		montofiscal=0;
		retenciona=0;
		$("#btnRetencionA,#btnRetencionB").prop("disabled",true);
  });

	$("#btnRetencionA").click(function(){
		datosRetncionA();
	});
}

function listarProveedor(){

	tabla=$('#tbproveedor').dataTable(
	{
		aProcessing: true,//Activamos el procesamiento del datatables
		aServerSide: true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],
	    buttons: [		          
		        ],
		ajax:
			{
				url: '../ajax/pago.php',
				type : "POST",
				dataType : "json",
				data:{'opcion':'listarProveedor'},		
				error: function(e){console.log(e.responseText);}
			},
		bDestroy: true,
		iDisplayLength: 8,//Paginación
		order: [[ 1, "asc" ]],//Ordenar (columna,orden)
	});
}

function listarDocumento()
{ 
  tabla=$('#tbdocumento').dataTable({
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    columnDefs:[{
      "targets":'nd',//clase para definir las columnas a tratar
      "orderable":false,//Definimos no ordenar por esta columna
      "searchable":false,//Definimos no buscar por esta columna
    }],
    buttons: [],
    ajax:{
      url: '../ajax/pago.php',
      type : "POST",
      dataType : "json",
			data:{'opcion':'listarDoc','id':$("#idproveedor").val()},
        error: function(e){console.log(e.responseText);}
      },
      bDestroy: true,
      iDisplayLength: 8,//Paginación
        order: [[ 1, "asc" ]],//Ordenar (columna,orden)
      })
}

function agregarProveedor(vidproveedor,vcod_proveedor,vdesc_proveedor,vrif,vsaldo,vidoperacion) {
	$("#idproveedor").val(vidproveedor);
	$("#cod_proveedor").val(vcod_proveedor);
	$("#desc_proveedor").val(vdesc_proveedor);
	$("#rif").val(vrif);
	$("#saldot").val(vsaldo);
	$("#idoperacion").val(vidoperacion);
	$("#ModalProveedor").modal('toggle');
	$("#btnDocumentos").prop('disabled',false);	
	$("#tipopago").prop('disabled',false);		   	
	idproveedor=vidproveedor;
}

function agergarDocumento(vidcompra,vfechareg,vfechaven,vcod_compra,vtipo,vnumerod,vnumeroc,vsubtotal
,vimpuesto,vtotal,vsaldo,vesfiscal,vmontofiscal,vretenciona){	

	$('#idcompra').val(vidcompra);
	$('#fecharegp').html(vfechareg);
	$('#fechaven').html(vfechaven);
	$('#cod_compra').html(vcod_compra);
	$('#numerod').html(vnumerod);
	$('#numeroc').html(vnumeroc);
	$('#optipo').html(vtipo);	
	$('#subtotalop').val(vsubtotal);
	$('#impuestoh').val(vimpuesto);
	$('#totalop').val(vtotal);
	$('#saldoh').val(vsaldo);
	$('#saldov').val(vsaldo);
	$("#origend").val(vtipo);
	$("#origenc").val(vcod_compra);
	$(".tot").prop("disabled", false);
	$('#movbanco').removeClass('hidden');
	$('#movcaja').addClass('hidden');
	esfiscal=vesfiscal;
	montofiscal=vmontofiscal;
	retenciona=vretenciona;
	
	$("#retenciona").val(vretenciona);
	$("#montov").prop('readonly',false);
	$(".tot").prop('disabled',false);
	$("#tipopago").prop('disabled',false);
	$("#numerocb").prop("readonly",false);
  $("#ModalDocumento").modal('toggle');
	Montos();
 	ValidarCuenta();
	if (esfiscal) {
		if (vtipo=='Factura' && retenciona==1) {
			$("#btnRetencionA,#btnRetencionB").prop("disabled",true);
		} else if (vtipo=='Factura' && retenciona==0) {
			$("#btnRetencionA,#btnRetencionB").prop("disabled",false);		
		} else if (vtipo!='Factura'){
			$("#btnRetencionA,#btnRetencionB").prop("disabled",true);
		}	
	} else{
		$("#btnRetencionA,#btnRetencionB").prop("disabled",true);
	} 
	EventoChk();	
}

function datosRetncionA(){

	$('#subtotalm').val($('#subtotalop').val());
	$('#impuestom').val($('#impuestoh').val());
	$('#montofiscalm').val(montofiscal);
	var ivaretenido= parseFloat($('#impuestom').val())*parseFloat(montofiscal)/100;
	$("#montoretencion,#montov,#totalh,#montoh").val(ivaretenido);
	$("#ModalRetencionA").modal('show');	
	$('#montofiscalm').keyup(function(){ 
	$("#montoretencion,#montov,#totalh,#montoh").val(parseFloat($('#impuestom').val())*parseFloat($(this).val())/100);
	});

	$('#btnCancelarR').click(function(){ 
		$("#ModalRetencionA").modal('toggle');
	});

	$('#btnAceptarR').click(function(){ 
		$("input[type=checkbox]").val("1");
		$("#retenciona").val(1);
		$("#retenciona").prop('checked',true);
		$("#ModalRetencionA").modal('toggle');
		$("#btnRetencionA,#btnRetencionB").prop("disabled",true);
		$("#montov").prop('readonly',true);
		$("#tipo").val('Ret. de I.V.A.');
		$(".tot").prop("disabled", true);
		$('#movbanco').addClass('hidden');
		$('#movcaja').removeClass('hidden');
		$("#selectcaja").prop("disabled",false);
		$("#tipopago").append($('<option value="IVA">Ret. I.V.A.</option>'));
		$("#tipopago").val('IVA');
		$("#btnDocumentos").prop("disabled", true);
			Montos();
		$("#btnGuardar").prop("disabled",false);
	});
}

function Montos()
{	
	$("#montov")
	.keyup(function (){ 
		$("#saldodisponible").val("0.00")
		$("#cod_caja").val("");
		$("#cod_cuenta,#cod_banco,#numcuenta").val("");
			ValidarCuenta();

			$('div').removeClass('collapsed-box');

			$("#montoh").val($(this).val());

		var valor=$(this).val();
		var saldov=$("#saldov").val();
		
		$("#saldoh").val(parseFloat(saldov)-parseFloat(valor));

		$("#totalh").val(parseFloat(valor));
		
		var validar=saldov-valor;

		if (validar<0) {

			bootbox.alert('No puede Ingresar un Monto Mayor al <b>Saldo Pendiente</b>!. Se asignara el Monto Total de la Operación');
      $("#montov").val(saldov);
      $("#montoh").val(saldov);
			$("#totalh").val(saldov);
			$("#saldoh").val(0.00)
		}		
	})

	.change(function (){ 

		$("#montoh").val($(this).val());
		$('div').removeClass('collapsed-box');


		var valor=$(this).val();
		var saldov=$("#saldov").val();
		
		$("#saldoh").val(parseFloat(saldov)-parseFloat(valor));

		$("#totalh").val(parseFloat(valor));
		
		var validar=saldov-valor;

		if (validar<0) {

			bootbox.alert('No puede Ingresar un Monto Mayor al Saldo Pendiente!, Se asignara el Monto Total de la Operación');
      $("#montov").val(saldov);
      $("#montoh").val(saldov);
			$("#totalh").val(saldov);
			$("#saldoh").val(0.00)
		}		
	});

	$("#montov").show(function (){ 

		var valor=$(this).val();
		var saldov=$("#saldov").val();
		$('div').removeClass('collapsed-box');
		
		$("#saldoh").val(parseFloat(saldov)-parseFloat(valor));

		$("#totalh").val(parseFloat(valor));
		
		var validar=saldov-valor;

		if (validar<0) {

			bootbox.alert('No puede Ingresar un Monto Mayor al Saldo Pendiente!, Se asignara el Monto Total de la Operación');
			$("#montov").val(saldov);
			$("#totalh").val(saldov);
			$("#saldoh").val(0.00)
		}		
	});

	$("#montoh").change(function() {
		ValidarCuenta();

		$("#montoh").val($(this).val());
		$('div').removeClass('collapsed-box');

		$("#fecharegb","#fecharegc").prop('disabled',false);

		ValidarSaldo($("#saldodisponible").val())
			
	});
	ValidarCuenta();
}

function ValidarCuenta()
{
    $("#montov")
		.show(function(){
        var validar=$(this).val()
				$("#cod_cuenta,#cod_banco,#numcuenta,#cod_caja,#selectcaja,#selectcuenta").val("");
        if(validar==0){
            $('#selectcuenta,#selectcaja').prop('disabled',true);
        } else if(validar!=0){
            $('#selectcuenta,#selectcaja').prop('disabled',false);
        }
    }
		).keyup(function(){
      var validar=$(this).val()
			$("#cod_cuenta,#cod_banco,#numcuenta,#cod_caja,#selectcaja,#selectcuenta").val("");
      if(validar==0){
				$('#selectcuenta,#selectcaja').prop('disabled',true);
			
      } else if(validar!=0){
        $('#selectcuenta,#selectcaja').prop('disabled',false);
			}
		
		$('#numerocb').prop('readonly',false);

    });
}

function GenerarReporte(){		
	
	$("#btnReporte").click(function(){
		$('#rep').prop({
			'href':'../reportes/rptPago.php',
			'target':'_blank',
		});
	});
};

$(function(){  
	
	$('[data-toggle="tooltip"]').tooltip();

	$('[data-toggle="tooltip"]').tooltip(); 

	$("input[type=textc]").keyup(function(){ 
		$(this).val( $(this).val().toUpperCase());
	});

	$(".ffechareg").datepicker({
    changeMonth: true,
    changeYear: true,
    autoclose:"true",
    format:'dd/mm/yyyy'
	}).datepicker("setDate", new Date());
	
	//desabilitar Tecla Intro al enviar formularios
	$("#formulario").keypress(function(e) {
		if (e.which == 13) {
			return false;
		}
	});

	$('#tipopago')
	.change(function(){
		var tipo=$(this).val();
		$("#saldodisponible,#saldodisponible").val("0.00")
		$("#cod_cuenta,#cod_banco,#numcuenta,#cod_caja,#selectcaja,#selectcuenta").val("");
		$("#numerocb").prop("readonly",false);

		if (tipo=='Banco') 
		{
			$('#movbanco').removeClass('hidden');
			$('#movcaja').addClass('hidden');
			$("#selectcuenta").prop("disabled",false);
		} 
		else if (tipo=='Caja')
		{
			$('#movbanco').addClass('hidden');
			$('#movcaja').removeClass('hidden');
			$("#selectcaja").prop("disabled",false);
		} 
	})

	$(".tot").click(function(){
		$("#montov")
		.val(0.00)
        .val(parseFloat($("#saldov").val()));
        $("#montoh")
		.val(0.00)
        .val(parseFloat($("#saldov").val()));   
		Montos();
  });

	$(".numberf").number(true,2,'.',',');

});

init();