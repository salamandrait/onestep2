var tabla;
var detalles=0;
var tablacl,tabladoc,tablaart;
var permitir;
var validar,cantidadr,stockval,valorund=0;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	MostrarModal();
	guardarnuevoCliente()
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	$.post('../ajax/venta.php',{'opcion':'selectDeposito'},function (r) {
		if (r=='') {
			$('#iddeposito').append('<option>No Existen Registros</option>');
			$('#iddeposito').niceSelect("update");
		} else {
			$("#iddeposito").html(r);
			$('#iddeposito').niceSelect("update");
		}
	});

	$.post('../ajax/venta.php',{'opcion':'condpago','op':'select'},function (r) {
		if (r=='') {
			$('#selectcondpago').append('<option>No Existen Registros</option>');
			$('#selectcondpago').niceSelect("update");
		} else {
			$("#selectcondpago").html(r);
			$('#selectcondpago').niceSelect("update");

			var id=$('#selectcondpago').val();

			$.post('../ajax/venta.php',{'opcion':'condpago','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#idcondpago").val(id);
				$("#dias").val(data.dias);
			});
		}
	});

	$.post('../ajax/venta.php',{'opcion':'vendedor','op':'select'},function (r) {
		if (r=='') {
			$('#selectvendedor').append('<option>No Existen Registros</option>');
			$('#selectvendedor').niceSelect("update");
		} else {
			$("#selectvendedor").html(r);
			$('#selectvendedor').niceSelect("update");

			var id=$('#selectvendedor').val();

			$.post('../ajax/venta.php',{'opcion':'vendedor','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#idvendedor").val(id);
			});
		}
	});

	$("#selectcondpago").change(function(){
		var id=$(this).val();

		$.post('../ajax/venta.php',{'opcion':'condpago','op':'data','id':id},function (data) {
			data=JSON.parse(data);
			$("#idcondpago").val(id);
			$("#dias").val(data.dias);
			AddDias(data.dias);
		});
	});

	$("#selectvendedor").change(function(){
		var id=$(this).val();

		$.post('../ajax/venta.php',{'opcion':'vendedor','op':'data','id':id},function (data) {
			data=JSON.parse(data);
			$("#idvendedor").val(id);
		});
	});

	$("#idarticulom").change(function () { 
		var idart=$(this).val();
		$.post('../ajax/venta.php',{'opcion':'Unidad','op':'select','id':idart},function (r) {
				$("#idartunidad").html(r);
				$('#idartunidad').trigger("chosen:updated");
	
			var id=$("#idartunidad").val();
	
			$.post('../ajax/venta.php',{'opcion':'Unidad','op':'data','id':id},function (data) {
					data =JSON.parse(data);
					$('#valorund').val(data.valor);
					$('#desc_unidad').val(data.desc_unidad);		
					valorund=data.valor;
			});			
		});	


		$.post('../ajax/venta.php',{'opcion':'Precio','id':idart,'tasa':$("#tasam").val(),'tipop':$("#tipoprecio").val()},function (data) {
			data =JSON.parse(data);
			$("#preciom").val($.number(data.precio,2,'.',''));
		}); 
	});	

	$("#tipoprecio").change(function (){
		var tipop=$(this).val()
		$.post('../ajax/venta.php',{'opcion':'Precio','id':$("#idarticulom").val(),'tasa':$("#tasam").val(),'tipop':tipop},function (data) {
			data =JSON.parse(data);
			$("#preciom").val($.number(data.precio,2,'.',''));
		}); 
	});

	$("#idartunidad").change(function () { 
		var id=$(this).val();
		$.post('../ajax/venta.php',{'opcion':'Unidad','op':'data','id':id},function (data) {
			data =JSON.parse(data);
			$('#valorund').val(data.valor);
			$('#desc_unidad').val(data.desc_unidad);	
			valorund=data.valor;	
		});		 
	});
}

//Generar Correlativo
function generarCod(tipo){	

	$.post('../ajax/venta.php',{'opcion':'generarCod','tipo':tipo},function(data){
		data = JSON.parse(data);
		$("#cod_venta").val(data.codnum)

		if (data.estatus==1)
		{
			$("#cod_venta")
			.val(data.codnum)
			.prop('readonly',true);
		} else{
			$("#cod_venta")
			.prop('readonly',false)
		}
	});
}

//Función limpiar
function limpiar(){
	$("input[type=text],input[type=textc],input[type=email],input[type=tel],input[type=url],.ffecha").val("");
	$("input[type=checkbox]").val("0");
	$("input[type=controln]").val("0");
	$("input[type=control]").val("");
	$(".numberf").val("0");
	$("span.numberf").html("0.00");
	$("#origend").val($("#tipo").val());
	$("#estatus").val('Sin Procesar');
	$('select').val("");
	$('select').niceSelect('update');
	$("#estatusdoc").val('sinp');
	$("#fechareg,#fechaven").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy",

	}).datepicker("setDate", new Date());

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
    $("#btnCancelar").click(function (e) { 

			if(detalles>0 && $("#numerod").val!=''){
				bootbox.confirm({message:'Esta a punto de Salir sin completar el Proceso! ¿Desea Guardar antes de Salir?',
				buttons:{confirm:{label:'Aceptar',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
					callback:function (result) {
						if(result)
						{
							guardaryeditar(e);
							mostrarform(false);
						} else{
							mostrarform(false);
							Evaluar(false);
						}		
					}
				});
			}
			else{
				mostrarform(false);
				Evaluar(false);
			}		
    });
}

//Función Agregar
function agregar(){
   $("#btnAgregar").click(function () { 
		limpiar();
		mostrarform(true);
		generarCod($("#tipo").val())
		detalles=0;
		$(".filas").remove();
		//$("#btnGuardar").prop('disabled',true);
		Evaluar(false);
		$('.iop').prop('readonly',false);
		$('.ctrl').prop('disabled',false);
		//$("#iddeposito").prop('disabled',true);
		//$("#btnImportar").prop('disabled',false);
	});

}

//Mostrar Formulario Procesado
function mostrar(idventa)
{
	$.post("../ajax/venta.php",{'opcion':'mostrarventa',idventa:idventa}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		//array que crea los avlores de textbox segun el valor recibido
		$.each(data, function (label, valor) { 		
			$('#'+label).val(valor)	
		});
		$('#iddeposito').niceSelect('update');
		$('#selectcondpago').val(data.idcondpago);
		$('#selectcondpago').niceSelect('update');
		$('.iop').prop('readonly',true);
		$('.ctrl').prop('disabled',true);
	
		$('[data-toggle="tooltip"]').tooltip();
		detalles=0;

		$.post("../ajax/venta.php",{'opcion':'mostrarDetalle',idventa:data.idventa}, function(data)
		{
			$("#tbdetalles").html(data);
			$("#iddeposito").val($("#iddepositoimp").val());
			modificarSubtotales();
			calcularTotales();
			$('.numberf').number(true,2);	
			$("#desc_cliente,#iddeposito,#btnImportar").prop('disabled',true);
		});
		Evaluar(false);
 	})
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
			exportOptions:{columns:[1,2,3,4,5,6,7,8]}},
			{
			extend:'excelHtml5',
			text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{columns:[1,2,3,4,5,6,7,8]}},
			{
			extend:'csvHtml5',
			text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{columns:[1,2,3,4,5,6,7,8]}},
			{
			extend:'pdf',
			text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{columns:[1,2,3,4,5,6,7,8]}}],
            ajax:{
					url: '../ajax/venta.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listar','tipo':$("#tipo").val()},				
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
			if(result){	

				var dialog = bootbox.dialog({
					message: '<h4><i class="fa fa-spin fa-refresh text-success"></i></h4> Procesando...',size: 'small'
				});
						
				dialog.init(function(){});

				$.ajax({
					url: "../ajax/venta.php",
					type: "POST",
					datatype:"json", 
					data: formData,
					contentType: false,
					processData: false,
					progress:function(datos){
							alert(datos);
					},
					success: function(datos) {
				
						if(datos==1062){
							bootbox.alert('El codigo <b>'+$("#cod_venta").val()+
							'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
							dialog.modal('hide');  
						}else{
							dialog.modal('hide');  
							bootbox.alert(datos);
							mostrarform(false);
							listar();
							limpiar();							
						}
					}
				});	
			}
		}
	});
}

//Mostrar Formulario Procesado
function reporte(idventa)
{
	$.post("../ajax/venta.php", {'opcion':'reporteCp',idventa:idventa}, function(e){
		$("#formulario").append('<iframe src="../reportes/rptZona.php"></iframe>')
	});
}

//Función para desactivar registros
function anular(idventa,tipo,origenc,origend,totalh)
{
	bootbox.confirm({message:"¿Está Seguro de Anular el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/venta.php", {
					'opcion':'anular',
					idventa :idventa,
					tipo:tipo,
					origenc:origenc,
					origend:origend,
					totalh:totalh
				}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idventa,tipo,origenc,origend,totalh)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
			  $.post("../ajax/venta.php", 
			  {
				  'opcion':'eliminar',
				  idventa : idventa,
				  tipo:tipo,
					origenc:origenc,
					origend:origend,
					totalh:totalh
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

//Agregar Cliente a Proceso
function agregarCliente(idcliente,idvendedor,cod_cliente,desc_cliente,rif,idcondpago,dias,limite)
{
	$("#idcliente").val(idcliente);
	$("#cod_cliente").val(cod_cliente);
	$("#desc_cliente").val(desc_cliente);
	$("#rif").val(rif);
	$('#selectcondpago').val(idcondpago); 
	$('#idcondpago').val(idcondpago);
	$('#selectvendedor').val(idvendedor); 
	$('#idvendedor').val(idvendedor);  
	$("#dias").val(dias);	
	$("#limite").val(limite);

  $("#ModalCliente").modal('toggle');	
    
	//$('#iddeposito').prop('disabled', false);
	$('#selectcondpago').prop('disabled', false);
	$('#selectvendedor').prop('disabled', false);
	Evaluar(true);
	SelccionDeposito();
	AddDias(dias);
}

//Agrgar Documento a Importar
function agregarImportarDoc(idventaop,idcliente,idvendedor,idcondpago,cod_cliente,desc_cliente,rif,dias,
	limite,tipo,origenc){

		$("#idventaop").val(idventaop);
		$("#idcliente").val(idcliente);
		$("#cod_cliente").val(cod_cliente);
		$("#desc_cliente").val(desc_cliente);
		$("#rif").val(rif);
		$('#selectcondpago').val(idcondpago);
		$('#selectvendedor').val(idvendedor);
		$('#idcondpago').val(idcondpago);  
		$('#idvendedor').val(idvendedor);  
		$("#dias").val(dias);	
		$("#limite").val(limite);
		$("#origend").val(tipo);
		$("#origenc").val(origenc);
		
		$('#selectcondpago').prop('disabled', false);
		$('#selectvendedor').prop('disabled', false);
		AddDias(dias);

	$("#ModalImportar").modal('toggle');	
	ImportarDetalle();	
}

//Agregar Detalle de Documento Importado
function ImportarDetalle(){
	$.post('../ajax/venta.php',{'opcion':'listarImportar','id':$("#idventaop").val()},function(r){
		$('#tbdetalles').html(r)
		$("span.numberf").number(true,2);
		$("input.numberf").number(true,2);
		$('#iddeposito,#btnAgregar_item').prop('disabled', true);
		$("#iddeposito").val($("#iddepositoimp").val());	
		modificarSubtotales();
		calcularTotales();
		detalles=$("#detalles").val();
		Evaluar(true);
	});
}

//Mostrar Ventanas Modal
function MostrarModal(){

	$("#desc_cliente").click(function () {	
		$("#ModalCliente").modal('show');
		listarCliente();
		$('#iddeposito').val("");
		$('#iddeposito').niceSelect('update');
		$('#iddeposito').prop('disabled', true);
		$('#selectcondpago').prop('disabled', true);
		$('#selectvendedor').prop('disabled', true);
		$("#btnAgregar_item").prop("disabled", true);	
		$('#selectcondpago').val(""); 
		$('#selectvendedor').val("");
		$("#idcondpago").val("");
		$("#dias").val("");

		$("#idcliente").val("");
		$("#cod_cliente").val("");
		$("#desc_cliente").val("");
		$("#rif").val("");
		$("#limite").val("");
		
	});

	//Se llama el Modal de crear el Artucylo segun las caracteristicas deseadas
	$("#btnAgregar_item").click(function () { 
		$("#ModalCrearArticulo").modal('show');	
	});

	$("#cod_articulom,#desc_articulom").click(function (){
		listarArticulos(); 
		
		$("#ModalArticulo").modal('show');
		$("#btnAceptarM").prop('disabled',false);
		$("#cantidadm").val("");
			validar=0;
	});

	$("#btnImportar").click(function(){ 
			$("#ModalImportar").modal('show');
			$('#iddeposito').val("");
			$("#tipodoc").val("");
				if ($("#tipo").val()=='Cotizacion') {
						$('option[value=Cotizacion]').removeClass('hidden')
						$('option[value=Pedido]').addClass('hidden')
						$('option[value=Factura]').addClass('hidden')
				} else 	if ($("#tipo").val()=='Pedido') {
						$('option[value=Cotizacion]').removeClass('hidden')
						$('option[value=Pedido]').addClass('hidden')
						$('option[value=Factura]').addClass('hidden')
				}else 	if ($("#tipo").val()=='Factura') {
						$('option[value=Cotizacion]').removeClass('hidden')
						$('option[value=Pedido]').removeClass('hidden')
						$('option[value=Factura]').addClass('hidden')
				}
			eliminarImp();

			//Tipo de Documento(FACTURA/PEDIDO/COTIZACION)
			$("#tipodoc").change(function(){
				$("#estatusdoc").val("sinp");
				listarTipoDoc();
			});

			//Estado del Documento(PROCESADO/SIN PROCESAR)
			$("#estatusdoc").change(function(){
				listarTipoDoc();
			});		
	});

	$("#btnCerrarImpDoc").click(function(){ 
		$("#ModalImportar").modal('toggle')	
		$("#tipodoc").val("");
		listarTipoDoc();
	});

	$("#btnNuevoCliente").click(function(){
		$("#ModalCliente").modal('toggle');
		$("#ModalNuevoCliente").modal('show');
	});
}

function guardarnuevoCliente(){

	$("#btnGuardarP").click(function (evento) { 
		evento.preventDefault();
		var formData = new FormData($("#formcliente")[0]);
		formData.append('opcion','guardarcliente');

			$.ajax({
				url: "../ajax/venta.php",
				type: "POST",
				datatype:"json", 
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos) {
					$("#ModalNuevoCliente").modal('toggle');
					$("#cod_clientea, #rifa, #desc_clientea").val("");
					listarCliente();
					bootbox.alert(datos);	
					$("#ModalCliente").modal('show');
			}
		});
	});

	$("#btnCerrarP").click(function () { 
		$("#ModalNuevoCliente").modal('toggle');
		$("#cod_clientea, #rifa, #desc_clientea").val("");
		$("#ModalCliente").modal('show');
	});
	
}

//Listar Cliente a Procesar
function listarCliente()
{
	tabla=$('#tbcliente').dataTable(
	{
		aProcessing: true,//Activamos el procesamiento del datatables
		aServerSide: true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		columnDefs:[{
		targets:'nd',//clase para definir las columnas a tratar
		orderable:false,//Definimos no ordenar por esta columna
		searchable:false,//Definimos no buscar por esta columna
		}],
	    buttons: [],
		ajax:
			{
				url: '../ajax/venta.php',
				type : "POST",
				dataType : "json",
				data:{'opcion':'listarCliente'},					
				error: function(e){console.log(e.responseText);}
			},
		bDestroy: true,
		iDisplayLength: 8,//Paginación
		order: [[ 1, "asc" ]],//Ordenar (columna,orden)
		bFilter:true,
		bInfo:true,
	});
}

//Listar Articulos a Procesar
function listarArticulos(){

	tablaart=$('#tbarticulos').dataTable(
		{
			aProcessing: true,//Activamos el procesamiento del datatables
			aServerSide: true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			columnDefs:[{
			targets:'nd',//clase para definir las columnas a tratar
			orderable:false,//Definimos no ordenar por esta columna
			searchable:false,//Definimos no buscar por esta columna
			}],
			 buttons: [],
			ajax:
				{
					url: '../ajax/venta.php',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listarArticulo','id':$("#iddeposito").val()},					
					error: function(e){
						console.log(e.responseText);
					}
				},
			bDestroy: true,
			iDisplayLength: 8,//Paginación
			order: [[ 1, "asc" ]],//Ordenar (columna,orden)
			bFilter:true,
			bInfo:true,
	});
}

//Listar Documentos Pendientes
function listarTipoDoc()
{
	tabladoc=$('#tbdocumento').dataTable({
		aProcessing: true,//Activamos el procesamiento del datatables
		aServerSide: true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		columnDefs:[{
		targets:'nd',//clase para definir las columnas a tratar
		orderable:false,//Definimos no ordenar por esta columna
		searchable:false,//Definimos no buscar por esta columna
		}],
	    buttons: [],
		ajax:
		{
			url: '../ajax/venta.php',
			type : "POST",
			dataType : "json",
			data:{'opcion':'importarDoc','id':$("#idcliente").val(),'estatus':$("#estatusdoc").val(),'tipo':$("#tipodoc").val()},			
			error: function(e){
				console.log(e.responseText);
			}
		},
		bDestroy: true,
		order: [[ 1, "asc" ]],//Ordenar (columna,orden)
		bFilter:false,
		bInfo:true,
		scrollY:"290px",
		scrollX:true,
		scrollCollapse:true,
		paging:false,
	});

}

//Seleccionar Deposito para Proceso
function SelccionDeposito(){

	$("#iddeposito").change(function () { 	
		$("#btnAgregar_item").prop("disabled", false);	
	});
}

//Validar Articulo/Existencia y Unidad
function agregarDetalle(idarticulo,iddeposito,cod_articulo,desc_articulo,tipoa,tasa,disp,stock){
	$("#idarticulom").val(idarticulo);
	$("#iddepositom").val(iddeposito);
	$("#cod_articulom").val(cod_articulo);
	$("#desc_articulom").val(desc_articulo);
	$("#tipom").val(tipoa);
	$("#tasam").val(tasa);
	$("#dispm").val(disp);
	$("#stockval").val(stock);
	$("#tipoprecio").val('p1');
	$("#ModalArticulo").modal('hide');
	

	$.post('../ajax/venta.php',{'opcion':'Precio','id':idarticulo,'tasa':tasa,'tipop':'p1'},function (data) {
		data =JSON.parse(data);
		$("#preciom").val($.number(data.precio,2,'.',''));
	});

		$.post('../ajax/venta.php',{'opcion':'Unidad','op':'select','id':idarticulo},function (r) {
				$("#idartunidad").html(r);
				$('#idartunidad').trigger("chosen:updated");
	
			var id=$("#idartunidad").val();
	
				$.post('../ajax/venta.php',{'opcion':'Unidad','op':'data','id':id},function (data) {
					data =JSON.parse(data);
					$('#valorund').val(data.valor);
					$('#desc_unidad').val(data.desc_unidad);	
					valorund=data.valor;
			});			
		});

	$("#cantidadm,#idarticulom,#idartunidad").change(function(){
	 	cantidadr=$("#cantidadm").val();
	 	stockval=$("#stockval").val();
	 	valorund=$('#valorund').val();

	$("#btnAceptarM").prop('disabled',false);	

		$.post('../ajax/venta.php',{'opcion':'Precio','id':idarticulo,'tasa':tasa,'tipop':'p1'},function (data) {
			data =JSON.parse(data);
			$("#preciom").val($.number(data.precio,2,'.',''));
		});
	});	

}

//Agregar Renglones a Procesar
function agregarRengon()
{  
	$("#btnAceptarM").click(function(){
		if ($("#tipo").val()!='Cotizacion') {
			//variable que define si se permite stock negativo en Inventario
			permitir=true;
			//Calculamos el estock actual menos la cantidad a Procesar
			validar=stockval-(cantidadr*valorund)		
			//Si el Calculo es menor que cero mostramos los mensajes segun la variable permir definida antes
			if (validar<0) {	
				if (permitir) {
					//si la variable es positiva mostramos advertencia				
					bootbox.confirm({
					message: "La Cantidad a Procesar es Mayor al Stock Disponible! Se generará un Stock Negativo de  <b>"
					+ ($.number(validar, 0)) + " Unds. <b> en el Deposito  <b>" + $("#iddeposito option:selected").text() + "</b>! Desea Continuar?",
					buttons: {confirm: { label: 'OK', className: 'btn-primary' },cancel: { label: 'Cancelar', className: 'btn-danger' }},
							callback: function (result) {
							if (!result) {
								$("#cantidadm").val("0");
								$("#btnAceptarM").prop('disabled',true);
							} else {
								DataSetAgregarRenglon();
					}}});		
				} else {
						//si la variable es Negativa Inpedimos continuar y mostramos advertencia				
						bootbox.alert("La Cantidad a Procesar  de  <b>"+($.number(cantidadr,0))+
						" Und(s). </b> es Mayor al Stock Disponible  <b>"+($.number(stockval,0))+
						"</b>  en el Deposito  <b>"+$("#iddeposito option:selected").text()+"</b>!  No es Posible realizar la Operacion");
						$("#cantidadm").val("0");
						$("#btnAceptarM").prop('disabled',false);
				}
			} else {
				//en caso de tener estock continuamos
				DataSetAgregarRenglon();
			}				
		} else {
			DataSetAgregarRenglon();
		}		
	});
}

var cont=0;
function DataSetAgregarRenglon() {

		var idarticulov, idartunidadv, iddepositov,tipopreciov, cantidadv, tipov, valorv, dispv, preciov, tasav;
		var cod_articulov, desc_articulov, desc_unidadv;
		var totalt = 0;

		idarticulov = $.trim($("#idarticulom").val());
		idartunidadv = $.trim($("#idartunidad").val());
		iddepositov = $.trim($("#iddeposito").val());
		tipopreciov = $.trim($("#tipoprecio").val());
		cod_articulov = $.trim($("#cod_articulom").val());
		desc_articulov = $.trim($("#desc_articulom").val());
		desc_unidadv = $.trim($('#desc_unidad').val());
		cantidadv = $.trim($("#cantidadm").val());
		dispv = $.trim($("#dispm").val());
		preciov = $.trim($("#preciom").val());
		tipov = $.trim($("#tipom").val());
		tasav = $.trim($("#tasam").val());
		valorv = $.trim($('#valorund').val());

	if($("#idarticulom").val()==$("#idarticulo").val()){		
			bootbox.alert('El Artículo <b>'+$("#desc_articulom").val()+
			'</b> ya se Encuentra en el Listado!. Modifique el Renglon o Seleccione otro Artículo');
	}else if($("#cantidadm").val()==0){
			bootbox.alert('Debe ingresar una Cantidad para poder agregar el Artículo!');
	} else {

		var subtotal = cantidadv * (preciov * valorv);
		var subimp = (((preciov * valorv) * tasav) / 100) * cantidadv;
		totalt = subtotal + subimp;

		var w = 'style="width:';
		var a = '; text-align:';
		var fila = '<tr class="filas" id="fila'+cont+'" style="border:1px solid #ddd">' +
			'<td><h5 ' + w + '30px' + a + 'center;"><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle(' + cont + ')">' +
			'<span class="fa fa-times-circle"></span></button></h5></td>' +
			'<td class="hidden">' + 
			'<input name="idarticulo[]" id="idarticulo" value="' + idarticulov + '" type="text">' +
			'<input name="iddeposito[]" id="iddeposito[]" value="' + iddepositov + '" type="text">' +
			'<input name="idartunidad[]" id="idartunidad[]" value="' + idartunidadv + '" type="text">' +
			'<input name="tipoprecio[]" id="tipoprecio[]" value="' + tipopreciov + '" type="text">' +
			'<input name="tipoa[]" id="tipoa[]" value="' + tipov + '" type="text">' +
			'<input name="disp[]" id="disp[]" value="' + dispv + '" type="text">' +
			'<input name="tasa[]" id="tasa[]" value="' + tasav + '" type="text">' +
			'<input name="valor[]" id="valor[]" value="' + valorv + '" type="text">' +
			'<input type="text" onchange="modificarSubtotales()" name="cantidad[]" id="cantidad" value="' + cantidadv + '"></td>' +
			'<td><h5 ' + w + '140px;">' + cod_articulov + '</h5></td>' +
			'<td><h5 ' + w + '400px; font-size:13px;">' + desc_articulov + '</h5></td>' +
			'<td><h5 ' + w + '90px;">' + desc_unidadv + '</h5></td>' +
			'<td><h5 ' + w + '80px' + a + 'right;">' + cantidadv + '</h5></td>' +
			'<td><h5 ' + w + '120px' + a + 'right;"><input ' + w + '120px' + a + 'right;" name="precio[]" id="precio[]" ' +
			'onchange="modificarSubtotales()" class="form-control input_tab" value="' + ($.number(preciov * valorv, 2, '.', '')) + '" type="text" ></h5></td>' +
			'<td><h5 ' + w + '130px' + a + 'right;" class="numberf" id="subtotal" name="subtotal" >' + subtotal + '</h5></td>' +
			'<td><h5 ' + w + '130px' + a + 'right;" class="numberf" "id="subimp" name="subimp">' + subimp + '</h5></td>' +
			'<td class="hidden"><h5>' + tasav + '</h5></td>' +
			'<td><h5 ' + w + '140px' + a + 'right;" id="total' + cont + '" name="total" class="numberf">' + totalt + '</h5></td>';
		'</tr>';
		cont++;
		detalles = detalles+1;
		$('#tbdetalles').append(fila);
		modificarSubtotales();
		calcularTotales();
		$("#ModalCrearArticulo").modal('toggle');
		//Limpiar Campos de Tabla Modal
		$("input.control,select.control").val("");
	}		
}

//Limpiar Tabla despues de Ingresar Renglon
function LimpiarDetalle() { 
	$("#btnCancelarM").click(function (e) { 
		e.preventDefault();
		$("input.control,select.control").val("");
	});
}

//Calculos
function modificarSubtotales()
{
		var cant = document.getElementsByName("cantidad[]");
		var prec = document.getElementsByName("precio[]");
		var sub = document.getElementsByName("subtotal");
		var subi = document.getElementsByName("subimp");
		var tasa = document.getElementsByName("tasa[]");

		for (var i = 0; i <cant.length; i++) 
		{
			var inpC = cant[i];
			var inpP = prec[i];
			var inpS = sub[i];                           
			var Tax = tasa[i];
			var inpI = subi[i];

			inpS.value = inpC.value * inpP.value;
			inpI.value = ((inpP.value * Tax.value)/100) * inpC.value;

			document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
			document.getElementsByName("subimp")[i].innerHTML = inpI.value;
			document.getElementsByName("total")[i].innerHTML =inpI.value + inpS.value;
		}

	calcularSubTotales();
	calcularTotalesIVA();
	calcularTotales();
	$('.numberf').number(true,2);	

}

function calcularSubTotales()
{
	var subt = document.getElementsByName("subtotal");
	var stotal = 0.0;

		for (var i = 0; i <subt.length; i++) 
		{
			stotal += document.getElementsByName("subtotal")[i].value;
		}

	$("#subtotalt").html(stotal);
	$("#subtotalh").val(stotal);
	Evaluar(true);
	$('.numberf').number(true,2);	
}

function calcularTotales()
{
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

		for (var i = 0; i <sub.length; i++) 
		{
			total += document.getElementsByName("subtotal")[i].value + document.getElementsByName("subimp")[i].value;
		}

	$("#totalt").html(total);
	$("#totalh").val(total);

	if ($("#tipo").val!='Cotizacion') {
		$("#saldoh").val(total);
	}
	Evaluar(true);

	$('.numberf').number(true,2);	
	
}

function calcularTotalesIVA()
{
	var subi = document.getElementsByName("subtotal");
	var totali = 0.0;

		for (var i = 0; i <subi.length; i++) 
		{
			totali += document.getElementsByName("subimp")[i].value;
		}

	$("#impuestot").html(totali);
	$("#impuestoh").val(totali);
	$('.numberf').number(true,2);	
	Evaluar(true);
}

//Eliminar Renglon
function eliminarDetalle(indice){

	$("#fila" + indice).remove();
	detalles=--detalles;
   calcularTotales();
   calcularTotalesIVA();
	calcularSubTotales();
	Evaluar(true);

	if($("#idventaop").val()!=''){
		$("#iddeposito").prop('disabled',true);
	}
}

//Eliminar Detalle Documento Importado
function eliminarImp(){

	$(".filas").remove();
	detalles=--detalles;
  calcularTotales();
  calcularTotalesIVA();
	calcularSubTotales();
	Evaluar(true);
}

//Evaluar Cantidad de Renglones
function Evaluar(validar){
	
	if (validar) {

		if (detalles>0)
		{
			$("#btnGuardar").prop('disabled',false);	
			$("#desc_cliente,#iddeposito").prop('disabled',true);
		}
		else
		{
			$("#btnGuardar").prop('disabled',true);
			$("#desc_cliente,#iddeposito").prop('disabled',false);
			cont=0;	
		}

	} else{
		$("#btnImportar").prop('disabled',false);
		$("#iddeposito").prop('disabled',true);
	}	
}

//Agregar Dias de Vencimiento
function AddDias(toAdd) {

	if (!toAdd || toAdd == '' || isNaN(toAdd)) return;

	var d = new Date();	
	d.setDate(d.getDate() + parseInt(toAdd));

	var yesterDAY = (d.getDate()<10?"0"+d.getDate():d.getDate()) + "/" + 
	((d.getMonth()+1)<10?"0"+(d.getMonth()+1):(d.getMonth()+1)) +"/"+ d.getFullYear();

	$("#fechaven").val(yesterDAY);

}

function GenerarReporte(){			
	$("#btnReporte").click(function(){
		$('#rep').prop({
			'href':'../reportes/rptVenta.php',
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
	
	//desabilitar Tecla Intro al enviar formularios
	$("#formulario").keypress(function(e) {
		if (e.which == 13) {
			return false;
		}
	});

	$('.numberf').number(true,2)

	agregarRengon();
	LimpiarDetalle();
	modificarSubtotales();
	calcularTotales();

	// $('select').picker();

	document.title = "..: "+$("#tipo").val()+" de Ventas :..";

});

init();