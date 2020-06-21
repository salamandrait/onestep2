var tabla;
var cantidadr,stockval,valorund, validar;
var permitir=0;
var cont=0;
var detalles=0;
var tablapv,tabladoc,tablaart;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	MostrarModal();
	guardarnuevoProveedor();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});


	$.post('../ajax/compra.php',{'opcion':'selectDeposito'},function (r) {
		if (r=='') {
			$('#iddeposito').append('<option>No Existen Registros</option>');
			$('#iddeposito').niceSelect("update");
		} else {
			$("#iddeposito").html(r);
			$('#iddeposito').niceSelect("update");
		}
	});

	$.post('../ajax/compra.php',{'opcion':'condpago','op':'select'},function (r) {
		if (r=='') {
			$('#selectcondpago').append('<option>No Existen Registros</option>');
			$('#selectcondpago').niceSelect("update");
		} else {
			$("#selectcondpago").html(r);
			$('#selectcondpago').niceSelect("update");

			var id=$('#selectcondpago').val();

			$.post('../ajax/compra.php',{'opcion':'condpago','op':'data','id':id},function (data) {
				data=JSON.parse(data);
				$("#idcondpago").val(id);
				$("#dias").val(data.dias);
			});
		}
	});

	$("#selectcondpago").change(function(){
		var id=$(this).val();

		$.post('../ajax/compra.php',{'opcion':'condpago','op':'data','id':id},function (data) {
			data=JSON.parse(data);
			$("#idcondpago").val(id);
			$("#dias").val(data.dias);
			AddDias(data.dias);
		});
	});

	$("#idarticulom").change(function () { 
		var idart=$(this).val();
		$.post('../ajax/compra.php',{'opcion':'Unidad','op':'select','id':idart},function (r) {
				$("#idartunidad").html(r);
				$('#idartunidad').trigger("chosen:updated");
	
			var id=$("#idartunidad").val();
	
				$.post('../ajax/compra.php',{'opcion':'Unidad','op':'data','id':id},function (data) {
					data =JSON.parse(data);
					$('#valorund').val(data.valor);
					$('#desc_unidad').val(data.desc_unidad);		
					//valorund=data.valor;
			});			
		});	 
	});	
	 
	$("#idartunidad").change(function () { 
		var id=$(this).val();
		$.post('../ajax/compra.php',{'opcion':'Unidad','op':'data','id':id},function (data) {
			data =JSON.parse(data);
			$('#valorund').val(data.valor);
			$('#desc_unidad').val(data.desc_unidad);	
			//valorund=data.valor;	
		});		 
	});
}

//Generar Correlativo
function generarCod(tipo){	

	$.post('../ajax/compra.php',{'opcion':'generarCod','tipo':tipo},function(data){
		data = JSON.parse(data);
		$("#cod_compra").val(data.codnum)

		if (data.estatus==1)
		{
			$("#cod_compra")
			.val(data.codnum)
			.prop('readonly',true);
		} else{
			$("#cod_compra")
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
							guardaryeditar(e)
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
		// $("#btnImportar").prop('disabled',false);
	
	});

}

//Mostrar Formulario Procesado
function mostrar(idcompra)
{
	$.post("../ajax/compra.php",{'opcion':'mostrarcompra',idcompra:idcompra}, function(data)
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

		$.post("../ajax/compra.php",{'opcion':'mostrarDetalle',idcompra:data.idcompra}, function(data)
		{
			$("#tbdetalles").html(data);
			$("#iddeposito").val($("#iddepositoimp").val());
			modificarSubtotales();
			calcularTotales();
			$('.numberf').number(true,2);	
			$("#desc_proveedor,#iddeposito,#btnImportar").prop('disabled',true);
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
					url: '../ajax/compra.php',
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
					url: "../ajax/compra.php",
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
							bootbox.alert('El codigo <b>'+$("#cod_compra").val()+
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


function metodo(){

    $.ajax({
        url : "../reportes/rptZona.php",
        success : function(archivo) {

            var nombreLogico = campo;
            var parametros = "dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=50,screenY=50,width=850,height=1050";
            var htmlText = "<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(archivo)+"'></embed>"; 
            var detailWindow = window.open ("../...label", nombreLogico, parametros);
            detailWindow.document.write(htmlText);
            detailWindow.document.close();
        },
        error : function(jqXHR, status, error) {
            alert("error\njqXHR="+jqXHR+"\nstatus="+status+"\nerror="+error);
        }
    });
}

//Función para desactivar registros
function anular(idcompra,tipo,origenc,origend,totalh)
{
	bootbox.confirm({message:"¿Está Seguro de Anular el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label:'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/compra.php", {
					'opcion':'anular',
					idcompra :idcompra,
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
function eliminar(idcompra,tipo,origenc,origend,totalh)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
			  $.post("../ajax/compra.php", 
			  {
				  'opcion':'eliminar',
				  idcompra : idcompra,
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

//Agregar Proveedor a Proceso
function agregarProveedor(idproveedor,cod_proveedor,desc_proveedor,rif,idcondpago,dias,limite)
{
	$("#idproveedor").val(idproveedor);
	$("#cod_proveedor").val(cod_proveedor);
	$("#desc_proveedor").val(desc_proveedor);
	$("#rif").val(rif);
	$('#selectcondpago').val(idcondpago); 
	$('#idcondpago').val(idcondpago); 
	$("#dias").val(dias);	
	$("#limite").val(limite);
	
    $("#ModalProveedor").modal('toggle');	
    
	//$('#iddeposito').prop('disabled', false);
	$('#selectcondpago').prop('disabled', false);
	Evaluar(true);
	SelccionDeposito();
	AddDias(dias);
}

//Agrgar Documento a Importar
function agregarImportarDoc(idcompraop,idproveedor,idcondpago,cod_proveedor,desc_proveedor,rif,dias,
	limite,tipo,origenc){

		$("#idcompraop").val(idcompraop);
		$("#idproveedor").val(idproveedor);
		$("#cod_proveedor").val(cod_proveedor);
		$("#desc_proveedor").val(desc_proveedor);
		$("#rif").val(rif);
		$('#selectcondpago').val(idcondpago);
		$('#idcondpago').val(idcondpago);  
		$("#dias").val(dias);	
		$("#limite").val(limite);
		$("#origend").val(tipo);
		$("#origenc").val(origenc);
		
		$('#selectcondpago').prop('disabled', false);
		AddDias(dias);

	$("#ModalImportar").modal('toggle');	
	ImportarDetalle();	
}

//Agregar Detalle de Documento Importado
function ImportarDetalle(){
	$.post('../ajax/compra.php',{'opcion':'listarImportar','id':$("#idcompraop").val()},function(r){
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

	$("#desc_proveedor").click(function () { 
		 
		$("#ModalProveedor").modal('show');
		listarProveedor(); 	
		$('#iddeposito').val("");
		$('#iddeposito').niceSelect('update');
		$('#iddeposito').prop('disabled', true);
		$('#selectcondpago').prop('disabled', true);
		$("#btnAgregar_item").prop("disabled", true);	
		$('#selectcondpago').val(""); 
		$("#idcondpago").val("");
		$("#dias").val("");

		$("#idproveedor").val("");
		$("#cod_proveedor").val("");
		$("#desc_proveedor").val("");
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

	$("#btnNuevoProveedor").click(function(){
		$("#ModalProveedor").modal('toggle');
		$("#ModalNuevoProveedor").modal('show');
	});

}

function guardarnuevoProveedor(){

	$("#btnGuardarP").click(function (evento) { 
		evento.preventDefault();
		var formData = new FormData($("#formproveedor")[0]);
		formData.append('opcion','guardarproveedor');

			$.ajax({
				url: "../ajax/compra.php",
				type: "POST",
				datatype:"json", 
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos) {

					$("#ModalNuevoProveedor").modal('toggle');
					$("#cod_proveedora, #rifa, #desc_proveedora").val("");
					listarProveedor(); 	
					$("#ModalProveedor").modal('show');	
					bootbox.alert(datos);
				}
			});

	});

	$("#btnCerrarP").click(function () { 
		$("#ModalNuevoProveedor").modal('toggle');
		$("#cod_proveedora, #rifa, #desc_proveedora").val("");
		$("#ModalProveedor").modal('show');
	});
	
}

//Listar Proveedor a Procesar
function listarProveedor()
{
	tablapv=$('#tbproveedor').dataTable(
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
				url: '../ajax/compra.php',
				type : "POST",
				dataType : "json",
				data:{'opcion':'listarProveedor'},					
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
					url: '../ajax/compra.php',
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
			url: '../ajax/compra.php',
			type : "POST",
			dataType : "json",
			data:{'opcion':'importarDoc','id':$("#idproveedor").val(),'estatus':$("#estatusdoc").val(),'tipo':$("#tipodoc").val()},			
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
function agregarDetalle(idarticulo,iddeposito,cod_articulo,desc_articulo,tipoa,costo,tasa,disp){
	$("#idarticulom").val(idarticulo);
	$("#iddepositom").val(iddeposito);
	$("#cod_articulom").val(cod_articulo);
	$("#desc_articulom").val(desc_articulo);
	$("#tasam").val(tasa);
	$("#tipom").val(tipoa);
	$("#costom").val(costo);
	$("#stockm").val(disp);

	$("#ModalArticulo").modal('hide');

		$.post('../ajax/compra.php',{'opcion':'Unidad','op':'select','id':idarticulo},function (r) {
				$("#idartunidad").html(r);
				$('#idartunidad').trigger("chosen:updated");
	
			var id=$("#idartunidad").val();
	
				$.post('../ajax/compra.php',{'opcion':'Unidad','op':'data','id':id},function (data) {
					data =JSON.parse(data);
					$('#valorund').val(data.valor);
					$('#desc_unidad').val(data.desc_unidad);	
					//valorund=data.valor;
			});			
		});

	// $("#cantidadm,#idarticulom,#idartunidad").change(function(){
	// 	cantidadr=$("#cantidadm").val();
	// 	stockval=$("#stockm").val();
	// 	valorund=$('#valorund').val();
	// 	validar=stockval-(cantidadr*valorund);	
	// });	

}

//Agregar Renglones a Procesar
function agregarRengon()
{  
	$("#btnAceptarM").click(function(){

		if($("#idarticulom").val()==$("#idarticulo").val()){		
			bootbox.alert('El Artículo <b>'+$("#desc_articulom").val()+
			'</b> ya se Encuentra en el Listado!. Modifique el Renglon o Seleccione otro Artículo');
		}else if($("#cantidadm").val()==0){
			bootbox.alert('Debe ingresar una Cantidad para poder agregar el Artículo!');
		} else {
			DataSetAgregarRenglon();
		}	
	});
}

function DataSetAgregarRenglon() {
	var idarticulov, idartunidadv, iddepositov, cantidadv, tipov, valorv, dispv, costov, tasav;
	var cod_articulov, desc_articulov, desc_unidadv;
	var totalt = 0;

	idarticulov = $.trim($("#idarticulom").val());
	iddepositov = $.trim($("#iddeposito").val());
	idartunidadv = $.trim($("#idartunidad").val());
	cod_articulov = $.trim($("#cod_articulom").val());
	desc_articulov = $.trim($("#desc_articulom").val());
	desc_unidadv = $.trim($('#desc_unidad').val());
	cantidadv = $.trim($("#cantidadm").val());
	dispv = $.trim($("#stockm").val());
	costov = $.trim($("#costom").val());
	tipov = $.trim($("#tipom").val());
	tasav = $.trim($("#tasam").val());
	valorv = $.trim($('#valorund').val());

	var subtotal = cantidadv * (costov * valorv);
	var subimp = (((costov * valorv) * tasav) / 100) * cantidadv;
	totalt = subtotal + subimp;

	var w = 'style="width:';
	var a = '; text-align:';
	var fila = '<tr class="filas" id="fila' + cont + '" style="border:1px solid #ddd">' +
		'<td><h5 ' + w + '30px' + a + 'center;"><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle(' + cont + ')">' +
		'<span class="fa fa-times-circle"></span></button></h5></td>' +
		'<td class="hidden">' +
		'<input name="idarticulo[]" id="idarticulo" value="' + idarticulov + '" type="text">' +
		'<input name="iddeposito[]" id="iddeposito[]" value="' + iddepositov + '" type="text">' +
		'<input name="idartunidad[]" id="idartunidad[]" value="' + idartunidadv + '" type="text">' +
		'<input name="tipoa[]" id="tipoa[]" value="' + tipov + '" type="text">' +
		'<input name="disp[]" id="disp[]" value="' + dispv + '" type="text">' +
		'<input name="tasa[]" id="tasa[]" value="' + tasav + '" type="text">' +
		'<input name="valor[]" id="valor[]" value="' + valorv + '" type="text">' +
		'<input type="text" onchange="modificarSubtotales()" name="cantidad[]" id="cantidad" value="' + cantidadv + '"></td>' +
		'<td><h5 ' + w + '120px;">' + cod_articulov + '</h5></td>' +
		'<td><h5 ' + w + '400px; font-size:13px;">' + desc_articulov + '</h5></td>' +
		'<td><h5 ' + w + '90px;">' + desc_unidadv + '</h5></td>' +
		'<td><h5 ' + w + '80px' + a + 'right;">' + cantidadv + '</h5></td>' +
		'<td><h5 ' + w + '120px' + a + 'right;"><input ' + w + '120px' + a + 'right;" name="costo[]" id="costo[]" ' +
		'onchange="modificarSubtotales()" class="form-control input_tab" value="' + ($.number(costov * valorv, 2, '.', '')) + '" type="text" ></h5></td>' +
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
		var prec = document.getElementsByName("costo[]");
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

	if($("#idcompraop").val()!=''){
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
			$("#desc_proveedor,#iddeposito").prop('disabled',true);
		}
		else
		{
			$("#btnGuardar").prop('disabled',true);
			$("#desc_proveedor,#iddeposito").prop('disabled',false);
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
		metodo();
		// $('#rep').prop({
		// 	'href':'../reportes/rptCompra.php',
		// 	'target':'_blank',
		// });
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

	document.title = "..: "+$("#tipo").val()+" de Compras :..";

});

init();