<?php
require_once "Global.php";

$conexion = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');

//Si tenemos un posible error en la conexión lo mostramos
if (mysqli_connect_errno())
{
	printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
	exit();
}

if (!function_exists('ejecutarConsulta'))
{
   function ejecutarConsulta($sql)
	{

      global $conexion;
         $query = $conexion->query($sql);
      if ($query==true){
         return $query;
      } else {

         switch (mysqli_errno($conexion)) {
         case 1451:
            return '1451';
         break;
         case 1062:
            return '1062';
         break;
         case 1054:
            return 'Error al ejecutar el Proceso!. <b>Existe una Columna Desconocida!</b> '.mysqli_error($conexion);
         break;
         default:
            return mysqli_error($conexion);
         break;	
         }
      }    
   }
   
	function ejecutarConsultaSimpleFila($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);		
		$row = $query->fetch_assoc();
		return $row;
   }
   
   function ejecutarConsultaSimple($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);		
		$row = $query->fetch_row();
		return $row;
	}

	function ejecutarConsulta_retornarID($sql)
	{
		global $conexion;
		$conexion->query($sql);		
		return $conexion->insert_id;		
	}

	function limpiarCadena($str)
	{
		global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}   
}



?>