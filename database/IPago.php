<?php
require "../config/Conexion.php";

class IPago{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_ipago,$desc_ipago,$comision,$recargo)
   {
      $sql="INSERT INTO tbipago(cod_ipago,desc_ipago,comision,recargo,estatus)
      VALUES('$cod_ipago','$desc_ipago','$comision','$recargo','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idipago,$cod_ipago,$desc_ipago,$comision,$recargo)
   {
      $sql="UPDATE tbipago
      SET
      cod_ipago='$cod_ipago',
      desc_ipago='$desc_ipago',
      comision='$comision',
      recargo='$recargo'
      WHERE idipago='$idipago'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idipago)
   {
      $sql="DELETE FROM tbipago 
      WHERE idipago='$idipago'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idipago)
   {
      $sql="UPDATE tbipago 
      SET estatus='1' 
      WHERE idipago='$idipago'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idipago)
   {
      $sql="UPDATE tbipago 
      SET estatus='0' 
      WHERE idipago='$idipago'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idipago, 
      cod_ipago, 
      desc_ipago,
      comision,
      recargo,
      estatus
      FROM tbipago";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idipago)
  {
    $sql="SELECT 
    idipago, 
    cod_ipago, 
    desc_ipago,
    comision,
    recargo,
    estatus
    FROM tbipago 
    WHERE idipago='$idipago'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idipago, 
    cod_ipago, 
    desc_ipago,
    comision,
    recargo,
    estatus
    FROM tbipago WHERE estatus='1'
    ORDER BY cod_ipago ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idipago, 
    cod_ipago, 
    desc_ipago,
    comision,
    recargo,
    estatus
    FROM tbipago
    ORDER BY cod_ipago ASC";
    return ejecutarConsulta($sql);
  }

}

?>