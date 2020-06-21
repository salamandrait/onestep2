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
}

function MostrarImportar()
{
	$("#btnImportar").click(function(){
		$("#ModalImportar").modal('show');
	});
}

//Función limpiar
function limpiar(){

	$("#idimpuesto").val("");
	$("#cod_impuesto").val("");
	$("#desc_impuesto").val("");
	$("#simbolo").val("");
	$("#tasa").val(0);
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
					url: '../ajax/impuesto.php',
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
			// scrollY:"290px",
			// scrollX:true,
			// scrollCollapse:true,
			paging:true,
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

	$.ajax({
		url: "../ajax/impuesto.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_impuesto").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);
				
				listar();
			}
		}
	});
	
}

function mostrar(idimpuesto)
{
	$.post("../ajax/impuesto.php",{'opcion':'mostrar',idimpuesto:idimpuesto}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idimpuesto").val(data.idimpuesto);
		$("#cod_impuesto").val(data.cod_impuesto);
		$("#desc_impuesto").val(data.desc_impuesto);
		$("#tasa").val(data.tasa);
		$("#simbolo").val(data.simbolo);
		$('[data-toggle="tooltip"]').tooltip();
		
 	})
}

//Función para desactivar registros
function desactivar(idimpuesto)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/impuesto.php", {'opcion':'desactivar',idimpuesto : idimpuesto}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idimpuesto)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/impuesto.php", {'opcion':'activar',idimpuesto : idimpuesto}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idimpuesto)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/impuesto.php", {'opcion':'eliminar',idimpuesto : idimpuesto}, function(e){

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
			'href':'../reportes/rptImpuesto.php',
			'target':'_blank',
		});
	});

url
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
	


});

init();