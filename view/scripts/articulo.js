var tabla;
var percen=100;
var idimp;
var principal,valoru,idarticulou,idartunidad,idunidad,cod_articulo;
var nuevo_registro=false;
var pnumdecimal=2;
var inumdecimal=0;


//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	agregar();
	cancelarform();
	GenerarReporte();
	MostrarImportar();
	InputSelectChange();
	EventoChk();
	Montos();
	Unidad();
	
	$("#formulario").submit(function(e){
		guardaryeditar(e);	
	});

		//Cargamos los items al select unidad
	$.post("../ajax/articulo.php?",{'opcion':'selectUnidad'}, function (r) {
		if (r=='') {
			$('#idunidad').append('<option>No Existen Registros</option>');
			$('#idunidad').prop('disabled', true);
		} else {
			$("#idunidad").html(r);
			$('#idunidad').trigger("chosen:updated");
		}	
	});

	$.post("../ajax/articulo.php",{'opcion':'selectImpuesto'}, function (r) {
		if (r=='') {
			$('#idimpuesto').append('<option>No Existen Registros</option>');
			$('#idimpuesto').trigger("chosen:updated");
		} else {
			$("#idimpuesto").html(r);
			$('#idimpuesto').trigger("chosen:updated");

			var id=$("#idimpuesto").val();

			$.post("../ajax/articulo.php",{'opcion':'Impuesto',id:id}, function (data) {
				data=JSON.parse(data);
				$("#tasa").val(data.tasa);

				var costo=$("#costo").val()
	
				$("#costoimp").val((costo*data.tasa)/percen);
				$("#tcosto").val(parseFloat((costo*data.tasa)/percen)+parseFloat(costo));
			});
		}
	});	
	
	$.post("../ajax/articulo.php",{'opcion':'selectCategoria'}, function (r) {
		if (r=='') {
			$('#idcategoria').append('<option>No Existen Registros</option>');
			$('#idcategoria').trigger("chosen:updated");
		} else {
			$("#idcategoria").html(r);
			$('#idcategoria').trigger("chosen:updated");

			var id=$('#idcategoria').val();

			$.post("../ajax/articulo.php",{'opcion':'selectLinea',idcategoria:id}, function (r) {

				if (r=='') {
					$("#idlinea").html('');
					$("#idlinea").append('<option>No Existen Registros</option>');
					$('#idlinea').trigger("chosen:updated");
				} else {
					$("#idlinea").html(r);
					$('#idlinea').trigger("chosen:updated");
				}	
			});
		}	
	});

	$("#idcategoria").change(function(){	
		
		var id=$(this).val();

		$.post("../ajax/articulo.php",{'opcion':'selectLinea',idcategoria:id}, function (r) {

			if (r=='') {
				$("#idlinea").html('');
				$("#idlinea").append('<option>No Existen Registros</option>');
				$('#idlinea').trigger("chosen:updated");
			} else {
				$("#idlinea").html(r);
				$('#idlinea').trigger("chosen:updated");
			}	
		});
	});

	$("#idimpuesto").change(function(){	
		
		var id=$(this).val();

		$.post("../ajax/articulo.php",{'opcion':'Impuesto',id:id}, function (data) {
			data=JSON.parse(data);
			$("#tasa").val(data.tasa);

			var costo=$("#costo").val()

			$("#costoimp").val((costo*data.tasa)/percen);
			$("#tcosto").val(parseFloat((costo*data.tasa)/percen)+parseFloat(costo));
		});
	});
}

function InputSelectChange() {  

	$.post("../ajax/articulo.php",{'opcion':'selectCategoria'}, function (r) {
		if (r=='') {
			$('#idcategoria').append('<option>No Existen Registros</option>');
			$('#idcategoria').trigger("chosen:updated");
		} else {
			$("#idcategoria").html(r);
			$('#idcategoria').trigger("chosen:updated");

			var id=$('#idcategoria').val();

			$.post("../ajax/articulo.php",{'opcion':'selectLinea',idcategoria:id}, function (r) {

				if (r=='') {
					$("#idlinea").html('');
					$("#idlinea").append('<option>No Existen Registros</option>');
					$('#idlinea').trigger("chosen:updated");
					$('#idlinea').chosen({no_results_text: "Oops, nothing found!"}); 
				} else {
					$("#idlinea").html(r);
					$('#idlinea').trigger("chosen:updated");
				}	
			});
		}	
	});

	$("#idcategoria").change(function(){	
		
		var id=$(this).val();

		$.post("../ajax/articulo.php",{'opcion':'selectLinea',idcategoria:id}, function (r) {

			if (r=='') {	
				$("#idlinea").html('');
				$("#idlinea").append('<option>No Existen Registros</option>');
				$('#idlinea').trigger("chosen:updated");
			} else {
				$("#idlinea").html(r);
				$('#idlinea').trigger("chosen:updated");
			}	
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
	
	$("#btnMostrarUnidad").css('display','none');
	$("#tipo").val("General");
	$("#origen").val("Nacional");
	$("#tipo").trigger("chosen:updated");
	$("#origen").trigger("chosen:updated");
	$("#lbtotalstock").html("0");
	$("#idarticulo").val("");
	$("#idcategoria").val("");
	$("#idlinea").val("");
	$("input[type=text],input[type=textc]").val("");
	$("input[type=checkbox]").val("0");
	$("input.numberf").val("0.00");
	$("#print").hide();	
	$(".filas").remove();
	$('label[for="imagena"]').html('Cargar Imagen');
	$("#imagenmuestra").prop("src","");
	$("#imagenactual").val("");
	$("#imagena").val("");

		//Obtenemos la fecha actual
		$("#fechareg").datepicker({
			changeMonth: true,
			changeYear: true,
			showWeek:true,
			autoclose:"true",
			format:"dd/mm/yyyy"
		}).datepicker("setDate", new Date());
	EventoChk();
}

function EventoChk()
{	
	$("#costoprecio").click(function() {

		if($(this).is(':checked')) 
		{
			$(this).val(1); 

			var costo=$("#costo").val()
			var tasa=$("#tasa").val();

			$("#precio1,#precio2,#precio3").val(parseFloat((costo*tasa)/percen)+parseFloat(costo));
			$("#mgp1,#mgp2,#mgp3").val("0");
		} else {
			$(this).val(0);
			$("#precio1,#precio2,#precio3").val("0.00");
			$("#mgp1,#mgp2,#mgp3").val("0");
		}				
	});

	$("#costoprecio").show(function() {
		var value=$(this).val();
		 if (value==0) {
			$(this).prop('checked',false);
		 } else {
			$(this).prop('checked',true);
		 }
	 }); 	

	 $("#principal").click(function() {

		if($(this).is(':checked')) 
		{
			$(this).val(1); 

		} else {
			$(this).val(0);;
		}				
	 });

	 $("#principal").show(function() {
		var value=$(this).val();
		 if (value==0) {
			$(this).prop('checked',false);
		 } else {
			$(this).prop('checked',true);
		 }
	 });
}

function Montos()
{	
	$('input.numberf2').number(true,0);

	$("#costo").keyup(function (){ 
		var costo=$(this).val()
		var tasa=$("#tasa").val();

		$("#costoimp").val((costo*tasa)/percen);
		$("#tcosto").val(parseFloat((costo*tasa)/percen)+parseFloat(costo));
	});


	$("#precio1,#mgp1").keyup(function ()
	{ 
		var mgp1=parseFloat($("#mgp1").val());
		var tasa=parseFloat($("#tasa").val());
		var precio1=parseFloat($("#precio1").val());
		var precioimp1=parseFloat($("#precioimp1").val());
		
		$("#hprecio1").val(precio1+((precio1*mgp1)/percen));
		var hprecio1=parseFloat($("#hprecio1").val());
		$("#precioimp1").val((hprecio1*tasa)/percen);
		var precioimp1=parseFloat($("#precioimp1").val());
		$("#tprecio1").val(precioimp1+hprecio1);
	});

	$("#precio2,#mgp2").keyup(function ()
	{ 
		var mgp2=parseFloat($("#mgp2").val());
		var tasa=parseFloat($("#tasa").val());
		var precio2=parseFloat($("#precio2").val());
		var precioimp2=parseFloat($("#precioimp2").val());
		
		$("#hprecio2").val(precio2+((precio2*mgp2)/percen));
		var hprecio2=parseFloat($("#hprecio2").val());
		$("#precioimp2").val((hprecio2*tasa)/percen);
		var precioimp2=parseFloat($("#precioimp2").val());
		$("#tprecio2").val(precioimp2+hprecio2);
	});

	$("#precio3,#mgp3").keyup(function ()
	{ 
		var mgp3=parseFloat($("#mgp3").val());
		var tasa=parseFloat($("#tasa").val());
		var precio3=parseFloat($("#precio3").val());
		var precioimp3=parseFloat($("#precioimp3").val());
		
		$("#hprecio3").val(precio3+((precio3*mgp3)/percen));
		var hprecio3=parseFloat($("#hprecio3").val());
		$("#precioimp3").val((hprecio3*tasa)/percen);
		var precioimp3=parseFloat($("#precioimp3").val());
		$("#tprecio3").val(precioimp3+hprecio3);
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
		nuevo_registro=false;
    });
}

//Función Agregar
function agregar(){

    $("#btnAgregar").click(function () {
		  mostrarform(true);
		  nuevo_registro=true;
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
					url: '../ajax/articulo.php',
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
			scrollX:true,
			scrollCollapse:true,
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
		url: "../ajax/articulo.php",
		 type: "POST",
		 datatype:"json", 
	    data: formData,
	    contentType: false,
		 processData: false,
		 success: function(datos) {

		if (nuevo_registro==true) {

			if (datos==1062) {
				bootbox.alert('El codigo <b>'+$("#cod_articulo").val()+
				'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
			} else {
				mostrarform(false);		
				listar();
				nuevo_registro=false;
				bootbox.confirm({message:datos +" Desea Ingrear ahora las Unidades?",buttons:{
					confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},			
					callback:function(result){
						if(result)
						  {
								$.post("../ajax/articulo.php",{'opcion':'mostrarCod','cod':cod_articulo}, function(data) {
										data = JSON.parse(data);
										mostrarUnidad(data.idarticulo);	
								});			
						  } 
					}});
				}			
		} else if (nuevo_registro!=true) {
				if (datos==1062) {
					bootbox.alert('El codigo <b>'+$("#cod_articulo").val()+'</b> ya se encuenta Registrado!. No es Posible Ingresar Registros Duplicados');
				} else {
					mostrarform(false);			
					listar();
					bootbox.alert(datos);
					nuevo_registro=false;
				}		
			}	
		}
	});	
}

function mostrar(idarticulo)
{
	$.post("../ajax/articulo.php",{'opcion':'mostrar',idarticulo:idarticulo}, function(data)
	{	
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idarticulo").val(data.idarticulo);
		$("#cod_articulo").val(data.cod_articulo);
		$("#desc_articulo").val(data.desc_articulo);
		$("#idimpuesto").val(data.idimpuesto);
		$('#idimpuesto').trigger("chosen:updated");
		$("#tasa").val(data.tasa);
		$("#idcategoria").val(data.idcategoria);
		$('#idcategoria').trigger("chosen:updated");
		$("#idlinea").val(data.idlinea);
		$('#idlinea').trigger("chosen:updated");
		$("#origen").val(data.origen);
    $('#origen').trigger("chosen:updated");
    $("#tipo").val(data.tipo);
    $('#tipo').trigger("chosen:updated");
		$("#stock").val(data.stock);
		$("#artref").val(data.artref);

		$("#stockmin").val(data.stockmin);
		$("#stockmax").val(data.stockmax);
		$("#stockped").val(data.stockped);
		$("#alto").val(data.alto);
		$("#ancho").val(data.ancho);
		$("#peso").val(data.peso);
		$("#fechareg").val(data.fechareg);
		$("#comision").val(data.comision);

		$("#btnMostrarUnidad").css('display','');

		$("#costoprecio").val(data.costoprecio);
			
		$("#costo").val(data.costo);
		var costoimp=parseFloat(data.costo)*parseFloat(data.tasa/percen);
		$("#costoimp").val(parseFloat(data.costo)*parseFloat(data.tasa/percen));
		$("#tcosto").val(parseFloat(costoimp)+parseFloat(data.costo));

		$("#mgp1").val(data.mgp1);
		$("#mgp2").val(data.mgp2);
		$("#mgp3").val(data.mgp3);

		$("#precio1").val(data.precio1);
		$("#precio2").val(data.precio2);
		$("#precio3").val(data.precio3);

		$("#hprecio1").val(parseFloat((data.precio1*data.mgp1)/percen)+parseFloat(data.precio1));
		$("#hprecio2").val(parseFloat((data.precio2*data.mgp2)/percen)+parseFloat(data.precio2));
		$("#hprecio3").val(parseFloat((data.precio3*data.mgp3)/percen)+parseFloat(data.precio3));

		$("#precioimp1").val($("#hprecio1").val()*data.tasa/percen);
		$("#precioimp2").val($("#hprecio2").val()*data.tasa/percen);
		$("#precioimp3").val($("#hprecio3").val()*data.tasa/percen);

		$("#tprecio1").val(parseFloat($("#precioimp1").val())+parseFloat($("#hprecio1").val()));
		$("#tprecio2").val(parseFloat($("#precioimp2").val())+parseFloat($("#hprecio2").val()));
		$("#tprecio3").val(parseFloat($("#precioimp3").val())+parseFloat($("#hprecio3").val()));

			$.post("../ajax/articulo.php",{'opcion':'Linea','id':data.idlinea}, function (r) {
				$("#idlinea").html(r);
				$('#idlinea').trigger("chosen:updated");
			});

		if(data.imagen==''||data.imagen==null)
		{
			$("#imagenmuestra").prop("src","");
			$("#imagenactual").val("");
	
		}else {
			//$('#imagenmuestra').remove();
			$('#imagenah').after('<img id="imagenmuestra" class="img-responsive pad" style="max-width: 50%" src="../files/articulos/'+data.imagen+'">');
			$("#imagenactual").val(data.imagen);	
		}

		$.post("../ajax/articulo.php",{'opcion':'ListarStock','id':data.idarticulo},function(data){
			$("#tblListadoDep").html(data)
		});

		$('[data-toggle="tooltip"]').tooltip();
		generarbarcode();
		EventoChk();

		$("#btnMostrarUnidad").click(function(){
			$("#tblListadoDep2").addClass('hidden');
			mostrarUnidad(data.idarticulo);
		});
	});
	

}

function mostrarImagen(idarticulo){

	$.post("../ajax/articulo.php",{'opcion':'mostrar',idarticulo : idarticulo}, function(data)
	{
		data = JSON.parse(data);
		var dialog = bootbox.dialog({
			title: '<span id="articulom"></span>',
			message: '<img class="img-responsive pad" src="" id="imgmuestra" style="max-width: 50%">',
			buttons: {
				 Ok: {
					  label: "Ok",
					  className: 'btn-primary',}
				 }
			});

			dialog.init(function(){
				$('.modal-content').css('width','60%');
				$('.bootbox-close-button').css('display','none');
				$("#articulom").html('<label>'+data.desc_articulo+'</label>');
				$("#imgmuestra").prop("src","../files/articulos/"+data.imagen);
			});
	});
}

function mostrarCostoPrecio(idarticulo){

	$.post("../ajax/articulo.php",{'opcion':'mostrar',idarticulo : idarticulo}, function(data)
	{
		data = JSON.parse(data);	
		$("#particulo").html('<label>'+data.desc_articulo+'</label>');

		var preciosubt1=parseFloat((data.precio1*data.mgp1)/percen)+parseFloat(data.precio1);
		var preciosubt2=parseFloat((data.precio2*data.mgp2)/percen)+parseFloat(data.precio2);
		var preciosubt3=parseFloat((data.precio3*data.mgp3)/percen)+parseFloat(data.precio3);

		var imp1=preciosubt1*data.tasa/percen;
		var imp2=preciosubt2*data.tasa/percen;
		var imp3=preciosubt3*data.tasa/percen;

		var costoimp=parseFloat(data.costo)*parseFloat(data.tasa/percen);
		$("#tcostom").val(costoimp+parseFloat(data.costo));
		$("#tprecio1m").val(preciosubt1+imp1);
		$("#tprecio2m").val(preciosubt2+imp2);
		$("#tprecio3m").val(preciosubt3+imp3);

		$("#ModalPrecio").modal('show');

	});
}

function listarartunidad(idarticulo){

	tablau=$('#tbartlistado').dataTable(
		{
			aProcessing: true,//Activamos el procesamiento del datatables
			aServerSide: true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			columnDefs:[{
			targets:'nd',//clase para definir las columnas a tratar
			orderable:false,//Definimos no ordenar por esta columna
			searchable:false,//Definimos no buscar por esta columna
			}],
			 buttons : [],
				ajax:
				{
					url: '../ajax/articulo.php?',
					type : "POST",
					dataType : "json",
					data:{'opcion':'listarUnidad',idarticulo:idarticulo},							
					error: function(e){
					console.log(e.responseText);
					}
				},
			bDestroy: true,
			order: [[ 2, "asc" ]],//Ordenar (columna,orden)
			select:false,
			bSort: false,
			bFilter:false,
			bInfo:false,				
		}); 
}

function mostrarUnidad(idarticulo){

	listarartunidad(idarticulo);

	$.post("../ajax/articulo.php",{'opcion':'mostrar',idarticulo : idarticulo}, function(data)
	{
		data = JSON.parse(data);
		$("#uarticulo").html(data.desc_articulo);
		$("#idarticulou").val(data.idarticulo);
		idarticulou=data.idarticulo;
		$("#ModalUnidad").modal('show');

		$.post("../ajax/articulo.php",{'opcion':'ListarStock','id':idarticulo},function(data){
			$("#tblListadoDep2").html(data)
		});

	});
}

function editarUnidad(idarticulo,idartunidad) {

	$.post("../ajax/articulo.php",{'opcion':'mostrarUnd',idarticulo:idarticulo,'idartunidad':idartunidad}, function(data)
	{
		data = JSON.parse(data);

		$("#idarticulou").val(idarticulo);
		$("#idartunidad").val(idartunidad);
		$("#idunidad").val(data.idunidad);
		$('#idunidad').trigger("chosen:updated");
		$("#valor").val(data.valor);
		$("#principal").val(data.principal);
		$("#select").removeClass('hidden');
		$("#tblListadoDep2").addClass('hidden');
		$("#btnGuardarU").prop('disabled',false);
		$("#btnNuevo").prop('disabled',true);
		$("#btnCancelarU").prop('disabled',false);
		EventoChk();
	});	
}

//Función para activar registros
function eliminarUnidad(idartunidad,idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",
		buttons:{confirm:{label: 'OK',className:'btn-primary'},
		cancel:{label: 'Cancelar',className:'btn-danger'},},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php", {'opcion':'eliminarUnd',idartunidad:idartunidad}, function(e){
				bootbox.alert(e);
				listarartunidad(idarticulo);
        	});	
        }
	}});
}

//para limpiar los campos antes de ingresarUnidad
function Unidad() {

	$("#btnNuevo").click(function(){
		opcion = 'insertar'; //alta 
		$("#principal").val("0");          
		$("#valor").val("0");
		$('#idunidad').trigger("chosen:updated");
		$("#select").removeClass('hidden');
		$("#tblListadoDep2").addClass('hidden');
		$("#btnGuardarU").prop('disabled',false);
		$("#btnNuevo").prop('disabled',true);
		$("#btnCancelarU").prop('disabled',false);
		EventoChk();
	});

	$("#btnGuardarU").click(function(e){	
		guardarEditarUnidad(e);
		$("#select").addClass('hidden');
		$("#tblListadoDep2").removeClass('hidden');
		$("#btnGuardarU").prop('disabled',true);
		$("#btnNuevo").prop('disabled',false);
		$("#btnCancelarU").prop('disabled',true);
	});

	$("#btnCancelarU").click(function(){	
		$("#select").addClass('hidden');
		$("#tblListadoDep2").removeClass('hidden');
		$("#btnGuardarU").prop('disabled',true);
		$("#btnNuevo").prop('disabled',false);
		$("#btnCancelarU").prop('disabled',true);
	});
	
	$("#btnCerrarU").click(function(){        
		idarticulou=null;
		$("#formUnidad").trigger("reset");
		$("#select").addClass('hidden');
		$("#tblListadoDep2").removeClass('hidden');
		$("#btnGuardarU").prop('disabled',true);
		$("#btnNuevo").prop('disabled',false);
		$("#btnCancelarU").prop('disabled',true);
	});	
}

function guardarEditarUnidad(e) {
                       
	e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

	principal = $.trim($('#principal').val()); 
	valoru = $.trim($('#valor').val());
	idarticulou = $.trim($("#idarticulou").val());
	idartunidad = $.trim($("#idartunidad").val());
	idunidad = $.trim($('#idunidad option:selected').val());

	$.post("../ajax/articulo.php", 
	{
		'opcion':'guardareditarUnidad',
		idarticulou:idarticulou,
		idartunidad:idartunidad,
		idunidad:idunidad, 
		principal:principal, 
		valor:valoru
	}, function(e){

		if(e==1062){
			bootbox.alert('La Unidad <b>'+($('#idunidad option:selected').text())+'</b> ya se encuenta Registrada!');
		}else{
			bootbox.alert(e);
			listarartunidad($("#idarticulou").val());
		}
	});																									 
}

//Función para desactivar registros
function desactivar(idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Desactivar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/articulo.php", {'opcion':'desactivar',idarticulo : idarticulo}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function activar(idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Activar el Registro?",
	buttons:{confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
	callback:function(result){
		if(result)
			{
				$.post("../ajax/articulo.php", {'opcion':'activar',idarticulo : idarticulo}, function(e){
					listar();
					bootbox.alert(e);
				});	
			}
		}
	});
}

//Función para activar registros
function eliminar(idarticulo)
{
	bootbox.confirm({message:"¿Está Seguro de Eliminar el Registro?",buttons:{
		confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
		callback:function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php", {'opcion':'eliminar',idarticulo : idarticulo}, function(e){

				if(e=='1451'){
					bootbox.alert('El Registro se encuentra relacionado con otros registros, No es posible <b>Eliminar!</b>');
				}else{	
					
					bootbox.alert(e);	
					listar();
				}
        	});	
        }
	}});
}

//función para generar el código de barras
function generarbarcode() {

	if($("#artref").val()!=''){
		artref = $("#artref").val();
		JsBarcode("#barcode", artref);
		$("#print").show();
		$(".print").prop('disabled',false);
	} else {
		$(".print").prop('disabled',true);
	}
}

//Función para imprimir el Código de barras
function imprimir() {
  $("#print").printArea();
}

function filePreview(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.readAsDataURL(input.files[0]);
		reader.onload = function (e) {
			$('#imagenmuestra').addClass('hidden');
			$('#imagenah').after('<img id="imagenmuestra" class="img-responsive pad" style="max-width: 50%" src="'+e.target.result+'">');
		}
	}
}

function GenerarReporte(){		
	
	$("#btnReporte").click(function(){
		$('#rep').prop({
			'href':'../reportes/rptArticulo.php',
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

	$('select').css('padding-left','3px');

	$("#imagena").change(function () {
		filePreview(this);
		$('label[for="imagena"]').html('Imagen Cargada');
	});

	//Obtenemos la fecha actual
	$("#fechareg").datepicker({
		changeMonth: true,
		changeYear: true,
		showWeek:true,
		autoclose:"true",
		format:"dd/mm/yyyy"
	}).datepicker("setDate", new Date());

	$('.numberf').number(true,pnumdecimal);

	$("#cod_articulo").change(function () { 
		cod_articulo=$(this).val();
	});
	

});

init();