var tabla,id;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	listar();
	cancelarform();
	GenerarReporte();

	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

	$.post('../ajax/impuestoi.php',{'opcion':'ListarTipoImp'},function (r) {
		if (r=='') {
			$('#idimpuestoi').append('<option>No Existen Registros</option>');
			$('#idimpuestoi').trigger("chosen:updated");
		} else {
			$("#idimpuestoi").html(r);
			$('#idimpuestoi').trigger("chosen:updated");

			id=$("#idimpuestoi").val();

			$.post('../ajax/impuestoi.php',{'opcion':'Impuestoi',id:id},function (data) {
				data =JSON.parse(data);
				$('#cod_impuestoih').val(data.cod_impuestoi);	
			});

			listar();
		}
	});

	$('#idimpuestoi').change(function () { 

		id=$(this).val();

		$.post('../ajax/impuestoi.php',{'opcion':'Impuestoi',id:id},function (data) {
			data =JSON.parse(data);
			$('#cod_impuestoih').val(data.cod_impuestoi);	
		});
		
		listar();
	});

}

//Función limpiar
function limpiar(){

   //$("#idimpuestoid").val("");
   $("#cod_concepto").val("");
   $("#desc_concepto").val("");
   $("#cod_concepto,#desc_concepto").prop('readonly',false);
	$("#base").val("");
	$("#retencion").val("");
	$("#sustraendo").val("");
}

//Función mostrar formulario
function mostrarform(flag){

	limpiar();
	if (flag)
	{
		$("#listadoregistros").addClass('hidden');
		$("#formularioregistros").removeClass('hidden');
		$("#btnAgregar").addClass('hidden');
		$("#btnReporte").addClass('hidden');
	}
	else
	{
		$("#listadoregistros").removeClass('hidden');
		$("#formularioregistros").addClass('hidden');
		$("#btnAgregar").removeClass('hidden');
		$("#btnReporte").removeClass('hidden');
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
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        columnDefs:[{
			"targets":'nd',//clase para definir las columnas a tratar
			"orderable":false,//Definimos no ordenar por esta columna
			"searchable":false,//Definimos no buscar por esta columna
		}],
	    buttons : [
            {extend:'copyHtml5',
			text:'<i class="fa fa-file-archive-o text-blue"></i>',
			titleAttr:'Copiar al Portapapeles',
			exportOptions:{
				columns:[1,2,3,4,5,6]}},
            {
            extend:'excelHtml5',
            text:'<i class="fa fa-file-excel-o text-green"></i>',
			titleAttr:'Exportar a Excel',
			exportOptions:{
				columns:[1,2,3,4,5,6]}},
            {
            extend:'csvHtml5',
            text:'<i class="fa fa-file-text-o text-purple"></i>',
			titleAttr:'Exportar a Texto',
			exportOptions:{
				columns:[1,2,3,4,5,6]}},
            {
            extend:'pdf',
            text:'<i class="fa fa-file-pdf-o text-red"></i>',
			titleAttr:'Exportar a PDF',
			exportOptions:{
				columns:[1,2,3,4,5,6]}}
			],
             ajax:
				{
					url: '../ajax/impuestoi.php',
               type : "POST",
               data:{'opcion':'listar',idimpuestoi:id},
					dataType : "json",						
					error: function(e){
					console.log(e.responseText);	
					}
				},
				bDestroy:true,
				order: [[ 1, "asc" ]],//Ordenar (columna,orden)
				scrollY:"270px",
				scrollX:true,
				scrollCollapse:true,
				paging:false,
				select:true	
    });        
}

//Función para guardar o editar
function guardaryeditar(e)
{

	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
   formData.append('opcion','guardaryeditar');

	$.ajax({url: "../ajax/impuestoi.php",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
		 success: function(datos) {

			if(datos==1062){
				bootbox.alert('El codigo <b>'+$("#cod_concepto").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			}else{
				bootbox.alert(datos);
				mostrarform(false);
				
				listar();
			}
		}
	});
}

function mostrar(idimpuestoid)
{
	$.post("../ajax/impuestoi.php",{'opcion':'mostrar',idimpuestoid:idimpuestoid}, function(data)
	{
		data = JSON.parse(data);		
		mostrarform(true);
      $("#idimpuestoi").val(data.idimpuestoi);
      $("#idimpuestoif").val(data.idimpuestoi);
		$('#idimpuestoi').trigger("chosen:updated");;
		$("#cod_impuestoi").val(data.cod_impuestoi);
		$("#desc_impuestoi").val(data.desc_impuestoi);
		$("#cod_concepto").val(data.cod_concepto);
		$("#desc_concepto").val(data.desc_concepto);
		$("#base").val(data.base);
		$("#retencion").val(data.retencion);
		$("#sustraendo").val(data.sustraendo);
		$("#idimpuestoid").val(idimpuestoid);
      $('[data-toggle="tooltip"]').tooltip();
      $("#cod_concepto,#desc_concepto").prop('readonly',false);
      
 	})
}

//Función para activar registros
function eliminar(idimpuestoid)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/impuestoi.php", {'opcion':'eliminar',idimpuestoid:idimpuestoid}, function(e){

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
			'href':'../reportes/rptImpuestoi.php',
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
   
   $('.numberf').number(true,2);

	$('select,.px').css('padding-left','3px');

});

init();