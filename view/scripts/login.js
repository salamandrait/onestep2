

//Evento Clic para Mostrar Modal
$("#btnModalLogin").click(function() {
   $("#loginbox").addClass('hidden');
   $("#ModalLogin").modal('show');  
});


//Evento Clic para Mostrar Modal
$("#btnCancelar").click(function() {

   $("#loginbox").removeClass('hidden'); 
});

$("#frmAcceso").submit(function(e)
{
   e.preventDefault();
   cod_usuario=$("#cod_usuario").val();
   clave=$("#clave").val();

   function nota() {

      $("#btnLogin").click(function (e) { 
        e.preventDefault();
        $.gritter.add({
          title: 'Bienvenido al Sistema!',
          text: 'Ha iniciado sesion Correctamente!',
          image: '',
          sticky: false,
          time: '3000',
          class_name: 'bg-aqua'
       }); 
      });    
   }

   $.post("../ajax/usuario.php",{'opcion':'verificar',"cod_usuario":cod_usuario,"clave":clave}, function(dataset){
      if (dataset!='null') {
         data = JSON.parse(dataset);
         console.log(data);
         if ($("#cod_usuario").val()==data.cod_usuario && $("#clave").val()==data.clave && data.estatus=='1') {    
            $(location).prop("href","escritorio.php");    
         } else if (data.estatus=='0') {
            bootbox
            .alert('<h5><b>El Usuario se Encuentra Inactivo. Contacte al <a href="mailto:soporte.onestep@salamandradev.com">Administrador</a>!</b>'+
            ' <i class="glyphicon glyphicon-exclamation-sign text-success"></i></h5>');
         } else {
         bootbox.alert('<h5><b>Clave Incorrecta. <br>Verifique suevamente su Acceso o contacte al <a href="mailto:soporte.onestep@salamandradev.com">Administrador del Sistema</a>!</b>'+
         ' <i class="glyphicon glyphicon-exclamation-sign text-danger"></i></h5>');
         } 
      }  
   });
});

