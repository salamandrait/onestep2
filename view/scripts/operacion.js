var tabla,tablao,filaop;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	MostrarImportar();
	EventoChk();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});
}

function CrearTabla(valor){
	filaop='<tr class="filaop">'+
	'<td class="text-center"><input type="checkbox" name="esinventario" id="esinventario" value="'+valor+'"></td>'+
	'<td class="text-center"><input type="checkbox" name="escompra" id="escompra" value="'+valor+'"></td>'+
	'<td class="text-center"><input type="checkbox" name="esventa" id="esventa" value="'+valor+'"></td>'+
	'<td class="text-center"><input type="checkbox" name="esbanco" id="esbanco" value="'+valor+'"></td>'+
	'<td class="text-center"><input type="checkbox" name="esconfig" id="esconfig" value="'+valor+'"></td>'+
	'</tr>';
	$('#tbopciones').append(filaop);
}

function MostrarImportar()
{
	$("#btnImportar").click(function(){
		$("#ModalImportar").modal('show');
	});
}

//Función limpiar
function limpiar(){

	$("#idoperacion").val("");
	$("#cod_operacion").val("");
	$("#desc_operacion").val("");
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
		  $("#opcion,.filaop").remove();
		  mostrarform(false);	  
    });
}

//Función Agregar
function agregar(){

    $("#btnAgregar").click(function () { 
		  limpiar();
		  
		  CrearTabla(0);
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
					url: '../ajax/operacion.php',
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
		url: "../ajax/operacion.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_operacion").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);
				$("#opcion,.filaop").remove();
				listar();
			}
		}
	});
	
}

function mostrar(idoperacion)
{
	$.post("../ajax/operacion.php",{'opcion':'mostrar',idoperacion:idoperacion}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idoperacion").val(data.idoperacion);
		$("#cod_operacion").val(data.cod_operacion);
		$("#desc_operacion").val(data.desc_operacion);
		$('[data-toggle="tooltip"]').tooltip();
		

			filaop='<tr class="filaop">'+
			'<td class="text-center nd"><input type="checkbox" name="esinventario" id="esinventario" value="'+data.esinventario+'"></td>'+
			'<td class="text-center nd"><input type="checkbox" name="escompra" id="escompra" value="'+data.escompra+'"></td>'+
			'<td class="text-center nd"><input type="checkbox" name="esventa" id="esventa" value="'+data.esventa+'"></td>'+
			'<td class="text-center nd"><input type="checkbox" name="esbanco" id="esbanco" value="'+data.esbanco+'"></td>'+
			'<td class="text-center nd"><input type="checkbox" name="esconfig" id="esconfig" value="'+data.esconfig+'"></td>'+
			'</tr>';
			
			tablao =$('#tbopciones').dataTable({
				columnDefs:[{
					targets:'nd',//clase para definir las columnas a tratar
					orderable:false,//Definimos no ordenar por esta columna
					searchable:false,//Definimos no buscar por esta columna
				}],
				bDestroy: true,
				paging:false,
				select:false,
				bFilter:false,
				bInfo:false,
			}).append(filaop);
			$('#tbopciones').addClass('compact');
			$('#tbopciones tr.odd').addClass('hidden');

		EventoChk();
 	})
}

//Función para desactivar registros
function desactivar(idoperacion)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/operacion.php", {'opcion':'desactivar',idoperacion : idoperacion}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idoperacion)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/operacion.php", {'opcion':'activar',idoperacion : idoperacion}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idoperacion)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/operacion.php", {'opcion':'eliminar',idoperacion : idoperacion}, function(e){

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
			'href':'../reportes/rptOperacion.php',
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
	
});

init();