var tabla,tablao,filaop;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	EventoChk();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});
}

function CrearTabla(valor){
	filaop='<tr class="filaop form-control-sm">'+
	'<td class="text-center nd"><input type="checkbox" name="esvendedor" id="esvendedor" value="'+valor+'"></td>'+
	'<td class="text-right nd"><input type="text" name="comisionv" id="comisionv" value="'+valor+'" class="text-right"></td>'+
	'<td class="text-center nd"><input type="checkbox" name="escobrador" id="escobrador" value="'+valor+'"></td>'+
	'<td class="text-right nd"><input type="text" name="comisionc" id="comisionc" value="'+valor+'" class="text-right"></td>'+
	'</tr>';
	$('#tbopciones').append(filaop);
}

//Función limpiar
function limpiar(){

	$("#idvendedor").val("");
	$("#cod_vendedor").val("");
	$("#desc_vendedor").val("");
	$("#rif").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#fechareg").val(""); 

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
			exportOptions:{columns:[1,2,3,4,5,6,7]}},
			{
			extend:'excelHtml5',
			text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{columns:[1,2,3,4,5,6,7]}},
			{
			extend:'csvHtml5',
			text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{columns:[1,2,3,4,5,6,7]}},
			{
			extend:'pdf',
			text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{columns:[1,2,3,4,5,6,7]}}],
            ajax:{
					url: '../ajax/vendedor.php',
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
		url: "../ajax/vendedor.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_vendedor").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);
				$("#opcion,.filaop").remove();
				listar();
			}
		}
	});
	
}

function mostrar(idvendedor)
{
	$.post("../ajax/vendedor.php",{'opcion':'mostrar',idvendedor:idvendedor}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idvendedor").val(data.idvendedor);
		$("#cod_vendedor").val(data.cod_vendedor);
		$("#desc_vendedor").val(data.desc_vendedor);
		$("#rif").val(data.rif);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#fechareg").val(data.fechareg); 
		EventoChk();
		$('[data-toggle="tooltip"]').tooltip();

	
			filaop='<tr class="filaop">'+
			'<td class="text-center nd"><input type="checkbox" name="esvendedor" id="esvendedor" value="'+data.esvendedor+'"></td>'+
			'<td class="text-center nd"><input type="text" name="comisionv" id="comisionv" value="'+data.comisionv+'" class="text-right"></td>'+
			'<td class="text-center nd"><input type="checkbox" name="escobrador" id="escobrador" value="'+data.escobrador+'"></td>'+
			'<td class="text-center nd"><input type="text" name="comisionc" id="comisionc" value="'+data.comisionc+'" class="text-right"></td>'+
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
function desactivar(idvendedor)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/vendedor.php", {'opcion':'desactivar',idvendedor : idvendedor}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idvendedor)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/vendedor.php", {'opcion':'activar',idvendedor : idvendedor}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idvendedor)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/vendedor.php", {'opcion':'eliminar',idvendedor : idvendedor}, function(e){

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
			'href':'../reportes/rptVendedor.php',
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

	$("#fechareg").datepicker({
    changeMonth: true,
    changeYear: true,
    autoclose:"true",
    format:"dd/mm/yyyy"
  }).datepicker("setDate", new Date());

	
});

init();