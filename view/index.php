<?php 
//redireccionar a la vista de login
header ('Location: ../view/noacceso401.php'); 
		//Limpiamos las variables de sesión   
      session_unset();
      //Destruìmos la sesión
      session_destroy();

?>