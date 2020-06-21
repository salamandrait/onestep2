<?php
require "../config/Conexion.php";

class CondPago{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_condpago,$desc_condpago,$dias)
   {
      $sql="INSERT INTO tbcondpago(cod_condpago,desc_condpago,dias,estatus)
      VALUES('$cod_condpago','$desc_condpago','$dias','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idcondpago,$cod_condpago,$desc_condpago,$dias)
   {
      $sql="UPDATE tbcondpago
      SET
      cod_condpago='$cod_condpago',
      desc_condpago='$desc_condpago',
      dias='$dias'
      WHERE idcondpago='$idcondpago'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idcondpago)
   {
      $sql="DELETE FROM tbcondpago 
      WHERE idcondpago='$idcondpago'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idcondpago)
   {
      $sql="UPDATE tbcondpago 
      SET estatus='1' 
      WHERE idcondpago='$idcondpago'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idcondpago)
   {
      $sql="UPDATE tbcondpago 
      SET estatus='0' 
      WHERE idcondpago='$idcondpago'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idcondpago, 
      cod_condpago, 
      desc_condpago,   
      dias,
      estatus
      FROM tbcondpago";
      return ejecutarConsulta($sql);
   }

   //Implementamos Mostrar
   public function Mostrar($idcondpago)
   {
      $sql="SELECT 
      idcondpago, 
      cod_condpago, 
      desc_condpago, 
      dias,
      estatus
      FROM tbcondpago 
      WHERE idcondpago='$idcondpago'";
      return ejecutarConsultaSimpleFila($sql);
   }

  //Implementamos Select
  public function Select()
  {
      $sql="SELECT 
      idcondpago, 
      cod_condpago, 
      desc_condpago, 
      dias,
      estatus
      FROM tbcondpago WHERE estatus='1'
      ORDER BY dias ASC";
      return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
      $sql="SELECT 
      idcondpago, 
      cod_condpago, 
      desc_condpago, 
      dias,
      estatus
      FROM tbcondpago
      ORDER BY cod_condpago ASC";
      return ejecutarConsulta($sql);
  }

}

?>