<?php
require "../config/Conexion.php";

class Unidad{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_unidad,$desc_unidad)
   {
      $sql="INSERT INTO tbunidad(cod_unidad,desc_unidad,estatus)
      VALUES('$cod_unidad','$desc_unidad','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idunidad,$cod_unidad,$desc_unidad)
   {
      $sql="UPDATE tbunidad
      SET
      cod_unidad='$cod_unidad',
      desc_unidad='$desc_unidad'
      WHERE idunidad='$idunidad'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idunidad)
   {
      $sql="DELETE FROM tbunidad 
      WHERE idunidad='$idunidad'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idunidad)
   {
      $sql="UPDATE tbunidad 
      SET estatus='1' 
      WHERE idunidad='$idunidad'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idunidad)
   {
      $sql="UPDATE tbunidad 
      SET estatus='0' 
      WHERE idunidad='$idunidad'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idunidad, 
      cod_unidad, 
      desc_unidad,
      estatus
      FROM tbunidad";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idunidad)
  {
    $sql="SELECT 
    idunidad, 
    cod_unidad, 
    desc_unidad,
    estatus
    FROM tbunidad 
    WHERE idunidad='$idunidad'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idunidad, 
    cod_unidad, 
    desc_unidad,
    estatus
    FROM tbunidad WHERE estatus='1'
    ORDER BY cod_unidad ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idunidad, 
    cod_unidad, 
    desc_unidad,
    estatus
    FROM tbunidad
    ORDER BY cod_unidad ASC";
    return ejecutarConsulta($sql);
  }

}

?>