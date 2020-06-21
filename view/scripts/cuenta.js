var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	MostrarImportar();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	$.post('../ajax/cuenta.php',{'opcion':'selectBanco'},function (r) {
		if (r=='') {
			$('#idbanco').append('<option>No Existen Registros</option>');
			$('#idbanco').trigger("chosen:updated");
		} else {
			$("#idbanco").html(r);
			$('#idbanco').trigger("chosen:updated");

			id=$("#idbanco").val();

			$.post('../ajax/cuenta.php',{'opcion':'Banco',id:id},function (data) {
				data =JSON.parse(data);
				$('#cod_banco').val(data.cod_banco);	
				$('#cod_moneda').val(data.cod_moneda);	
			});
		}
	});

	$("#idbanco").change(function (e) { 
		e.preventDefault();

		id=$(this).val();

		$.post('../ajax/cuenta.php',{'opcion':'Banco',id:id},function (data) {
			data =JSON.parse(data);
			$('#cod_banco').val(data.cod_banco);	
			$('#cod_moneda').val(data.cod_moneda);	
		});	
	});
}

function MostrarImportar()
{
	$("#btnImportar").click(function(){
		$("#ModalImportar").modal('show');
	});
}

//Función limpiar
function limpiar(){

	$("#cod_banco").trigger("reset");
	$('#idbanco').trigger("chosen:updated");
	$('#tipo').val("Corriente");
	$("#idcuenta").val("");
	$("#cod_cuenta").val("");
	$("#desc_cuenta").val("");
	$("#numcuenta").val("");
	$("#agencia").val("");
	$("#ejecutivo").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#fechareg").val("");
	$("#saldod").val("0.00");
	$("#saldoh").val("0.00");
	$("#saldot").val("0.00");

	//Obtenemos la fecha actual
	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		autoclose:"true",
		format:"dd/mm/yyyy"
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
    $("#btnCancelar").click(function () { 
		  limpiar();	  
		  mostrarform(false);	  
    });
}

//Función Agregar
function agregar(){

    $("#btnAgregar").click(function () { 	  
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
					url: '../ajax/cuenta.php',
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
		url: "../ajax/cuenta.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_cuenta").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);			
				listar();
			}
		}
	});	
}

function mostrar(idcuenta)
{
	$.post("../ajax/cuenta.php",{'opcion':'mostrar',idcuenta:idcuenta}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idcuenta").val(data.idcuenta);
		$("#cod_cuenta").val(data.cod_cuenta);
		$("#desc_cuenta").val(data.desc_cuenta);
		$("#idcuenta").val(data.idcuenta);
		$("#idbanco").val(data.idbanco);
		$('#idbanco').trigger("chosen:updated");
		$("#cod_banco").val(data.cod_banco);
		$("#cod_moneda").val(data.cod_moneda);
		$("#tipo").val(data.tipo);
		$("#tipo").trigger("chosen:updated");
		$("#cod_cuenta").val(data.cod_cuenta);
		$("#desc_cuenta").val(data.desc_cuenta);
		$("#numcuenta").val(data.numcuenta);
		$("#agencia").val(data.agencia);
		$("#ejecutivo").val(data.ejecutivo);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#saldod").val(data.saldod);
		$("#saldoh").val(data.saldoh);
		$("#saldot").val(data.saldot);
		$("#fechareg").val(data.fechareg);
		$("#tabagencia")
		$("#tabsaldo")

		$('[data-toggle="tooltip"]').tooltip();		
 	})
}

//Función para desactivar registros
function desactivar(idcuenta)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/cuenta.php", {'opcion':'desactivar',idcuenta : idcuenta}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idcuenta)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/cuenta.php", {'opcion':'activar',idcuenta : idcuenta}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idcuenta)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/cuenta.php", {'opcion':'eliminar',idcuenta : idcuenta}, function(e){

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
			'href':'../reportes/rptCuenta.php',
			'target':'_blank',
		});
	});
};

$('#formato').change(function(){
	var filename = $(this).val().split('\\').pop();
	var idname = $(this).prop('id');
	console.log($(this));
	console.log(filename);
	console.log(idname);
	$('span.'+idname).next().find('span').html(filename);
	$("#btnProcesar").prop('disabled',false);
});

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

	$("#btnProcesar").click(function () {
		bootbox.alert({message: '<h4><i class="fa fa-spin fa-spinner text-danger"></i></h4> Procesando...',size: 'small'});					
	});

		//Obtenemos la fecha actual
		$("#fechareg").datepicker({
			changeMonth: true,
			changeYear: true,
			autoclose:"true",
			format:"dd/mm/yyyy"
	 }).datepicker("setDate", new Date());
 
	 $('select').css('padding-left','3px');
	
	 $('.numberf').number(true,2);

});

init();