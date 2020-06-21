<?php
require "../config/Conexion.php";

class Operacion{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   
   //Implementamos Insertar
   public function Insertar($cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco)
   {
      $sql="INSERT INTO tboperacion(cod_operacion,desc_operacion,escompra,esventa,esinventario,esconfig,esbanco,estatus)
      VALUES('$cod_operacion','$desc_operacion','$escompra','$esventa','$esinventario','$esconfig','$esbanco','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idoperacion,$cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco)
   {
      $sql="UPDATE tboperacion
      SET
      cod_operacion='$cod_operacion',
      desc_operacion='$desc_operacion',
      escompra = '$escompra',
      esventa = '$esventa',
      esinventario = '$esinventario',
      esconfig = '$esconfig',
      esbanco = '$esbanco'
      WHERE idoperacion='$idoperacion'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idoperacion)
   {
      $sql="DELETE FROM tboperacion 
      WHERE idoperacion='$idoperacion'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idoperacion)
   {
      $sql="UPDATE tboperacion 
      SET estatus='1' 
      WHERE idoperacion='$idoperacion'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idoperacion)
   {
      $sql="UPDATE tboperacion 
      SET estatus='0' 
      WHERE idoperacion='$idoperacion'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idoperacion, 
      cod_operacion, 
      desc_operacion,
      escompra,
      esventa,
      esinventario,
      esconfig,
      esbanco,
      estatus
      FROM tboperacion";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idoperacion)
  {
      $sql="SELECT 
      idoperacion, 
      cod_operacion, 
      desc_operacion,
      escompra,
      esventa,
      esinventario,
      esconfig,
      esbanco,
      estatus
      FROM tboperacion 
      WHERE idoperacion='$idoperacion'";
      return ejecutarConsultaSimpleFila($sql);
  }

   //Implementamos Select
   public function Select()
   {
      $sql="SELECT 
      idoperacion, 
      cod_operacion, 
      desc_operacion,
      escompra,
      esventa,
      esinventario,
      esconfig,
      esbanco,
      estatus
      FROM tboperacion WHERE estatus='1'
      ORDER BY cod_operacion ASC";
      return ejecutarConsulta($sql);
  }

   //Implementamos Select
	public function SelectOp($optipo)
	{	
		if ($optipo=='Compra') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND escompra='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='Venta') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esventa='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='Inventario') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esinventario='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='Banco') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esbanco='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='Config') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esconfig='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);
		}else if($optipo=='') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1'
         ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		}		
	}

  //Implementamos Listar
  public function RptListar()
  {
      $sql="SELECT 
      idoperacion, 
      cod_operacion, 
      desc_operacion,
      escompra,
      esventa,
      esinventario,
      esconfig,
      esbanco,
      estatus
      FROM tboperacion
      ORDER BY cod_operacion ASC";
      return ejecutarConsulta($sql);
  }

}
?>