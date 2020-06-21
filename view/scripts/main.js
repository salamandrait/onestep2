var actiontd=false;


function Salir(){

   bootbox.confirm({message:"Está a punto de Salir del Sistema ¿Desea Continuar?",buttons:{
      confirm:{label: 'OK',className:'btn-primary'},cancel:{label: 'Cancelar',className:'btn-danger'}},
      callback:function(result){
      if(result)
      {
         $.post("../ajax/usuario.php", {'opcion':'salir'}, function(){
         });
      
         $(location).delay(500).prop("href","../view/login.html")
       
      }
   }});
}

function ConfirmarClave(){
	$("#clavec").change(function(){
		if ($(this).val()!=$("#clave").val()) {
			bootbox.alert('La Nueva Clave Ingresada no Concide con la Clave de Confirmacion!')
			$("#clave").focus(function () { 
			});
			$("#btnGuardarCl").prop("disabled",true);
		} else {
			$("#btnGuardarCl").prop("disabled",false);
		}
	});
}

function CambiarClave(){

    $("#btnCambiarClave").click(function () { 

      $.post("../ajax/usuario.php",{'opcion':'mostrar',idusuario : $("#iduser").val()}, function(data)
      {
        data = JSON.parse(data);
        $("#idusuario").val(data.idusuario);
        $("#desc_usuariom").html(data.desc_usuario);
        $("#clave").val(data.clave);
        $("#clavec").val(data.clave);
      });
      $("#ModalCambiarClave").modal('show');
      
    });

    ConfirmarClave();

    $("#btnGuardarCl").click(function (e) {
      e.preventDefault(); //No se activará la acción predeterminada del evento
      var formData = new FormData($("#formclave")[0]);
      formData.append('opcion','actclave');

      
      bootbox.confirm({message:"¿Está Seguro de Cambiar Su Clave? Para Hacer Efectivo el Cambio Saldra Automaticamente del Sistema ",
      buttons:{confirm:{label: 'OK',className:'btn-primary btn-sm'},cancel:{label: 'Cancelar',className:'btn-danger btn-sm'}},
      callback:function(result){
        if(result){
    
          var dialog = bootbox.dialog({message: '<h4><i class="fa fa-spin fa-circle-o-notch text-success"></i></h4> Procesando...',size: 'small'});
                      
          dialog.init(function(){});
          }
            $.ajax({
              url: "../ajax/usuario.php",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success:function(datos){ 

                dialog.modal('hide');
                bootbox.alert(datos);
        
                $.post("../ajax/usuario.php", {'opcion':'salir'}, function(){
                  $(location).delay(5000).prop("href","../view/login.html");
                });       
              }
            });
        }
      });
    });
}

function nota() {
 
}

function muestraToolTip(){
  //Total Total Pedidos Compra
  $.post("../ajax/escritorio.php",{'opcion':'totalpedidoc'}, function(data){

    var data=JSON.parse(data);
    if (data.totalp!=0) {
      $("#pc").html(data.totalp);
    }
  });


   //Total Total Facturas Compra
  $.post("../ajax/escritorio.php",{'opcion':'totalfacturac'}, function(data){
    var data=JSON.parse(data);
     if (data.totalf!=0) {
      $("#fc").html(data.totalf);
     }
  });

    //Total Total Pedidos Venta
  $.post("../ajax/escritorio.php",{'opcion':'totalpedidov'}, function(data){

    var data=JSON.parse(data);
   if (data.totalp!=0) {
      $("#pv").html(data.totalp);
    }
  });

  //Total Total Facturas Venta
  $.post("../ajax/escritorio.php",{'opcion':'totalfacturav'}, function(data){

    var data=JSON.parse(data);
     if (data.totalf!=0) {
      $("#fv").html(data.totalf);
     }
  });
   
}

$(function(){
  CambiarClave();
  setTimeout(muestraToolTip(), 10000);
});
