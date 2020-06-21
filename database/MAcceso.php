<?php
require "../config/Conexion.php";

class MAcceso{

   //Funcion constructor
   public function __construct(){   
   }

   //Funcion Insertar Registros
   public function Insertar($cod_macceso,$desc_macceso,$accesos){
      $sql="INSERT INTO tbmacceso(cod_macceso,desc_macceso,estatus)
      VALUES('$cod_macceso','$desc_macceso','1')";
      $idmacceso=ejecutarConsulta_retornarID($sql);

      $num_elementos=0;
		$contador=1;
		$sw=true;

		while ($num_elementos < count($accesos))
		{
			$sql_detalle = "INSERT INTO tbusuarioac(idusuarioac,idmacceso,idacceso) 
			VALUES((CONCAT('$cod_macceso,'','$idmacceso')+'$contador'),'$idmacceso','$accesos[$num_elementos]');";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
			$contador=$contador+1;
		}
		return $sw;
   }

   //Funcion Editar Registros
   public function Editar($idmacceso,$cod_macceso,$desc_macceso,$accesos){
      $sql="UPDATE tbmacceso
      SET
      cod_macceso='$cod_macceso',
      desc_macceso='$desc_macceso'
      WHERE idmacceso='$idmacceso'";
      ejecutarConsulta($sql);

    //Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM tbusuarioac WHERE idmacceso='$idmacceso'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$contador=1;
		$sw=true;

		while ($num_elementos < count($accesos))
		{
			$sql_detalle = "INSERT INTO tbusuarioac(idusuarioac,idmacceso,idacceso) 
			VALUES((CONCAT('$cod_macceso','','$idmacceso')+'$contador'),'$idmacceso','$accesos[$num_elementos]');";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
			$contador=$contador+1;
		}
		return $sw;
   }

   //Funcion Eliminar Registros
   public function Eliminar($idmacceso){
      $sql="DELETE FROM tbmacceso 
      WHERE idmacceso='$idmacceso'";
      return ejecutarConsulta($sql);
   }

   //Funcion Cambiar Estatus de Registro Inactivo
   public function Activar($idmacceso){
      $sql="UPDATE tbmacceso 
      SET estatus='1' 
      WHERE idmacceso='$idmacceso'";
      return ejecutarConsulta($sql);
   }

    //Funcion Cambiar Estatus de Registro Activo
   public function Desactivar($idmacceso){
      $sql="UPDATE tbmacceso 
      SET estatus='0' 
      WHERE idmacceso='$idmacceso'";
      return ejecutarConsulta($sql);
   } 

    //Funcion Listar Registros Existentes
   public function Listar(){
      $sql="SELECT 
      idmacceso, 
      cod_macceso, 
      desc_macceso,
      estatus
      FROM tbmacceso";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Seleccionado
   public function Mostrar($idmacceso){
      $sql="SELECT 
      idmacceso, 
      cod_macceso, 
      desc_macceso,
      estatus
      FROM tbmacceso 
      WHERE idmacceso='$idmacceso'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Funcion Listar Registros Existentes para Selleccion
   public function Select(){
      $sql="SELECT 
      idmacceso, 
      cod_macceso, 
      desc_macceso,
      estatus
      FROM tbmacceso 
      WHERE estatus='1'
      ORDER BY cod_macceso ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Registros
   public function RptListar(){
      $sql="SELECT 
      idmacceso, 
      cod_macceso, 
      desc_macceso,
      estatus
      FROM tbmacceso
      ORDER BY cod_macceso ASC";
      return ejecutarConsulta($sql);
   }

   public function ListarModulo($modulo){
		$sql="SELECT * FROM tbacceso 
		WHERE modulo='$modulo'
		ORDER BY idacceso ASC"; 
		return ejecutarConsulta($sql);		
   }
   
   //Implementar un método para listar los permisos marcados
	public function Listarmarcados($idmacceso){
		$sql="SELECT * FROM tbusuarioac 
		WHERE idmacceso='$idmacceso'";
		return ejecutarConsulta($sql);
	}

}

?>