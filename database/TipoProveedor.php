<?php
require "../config/Conexion.php";

class TipoProveedor{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_tipoproveedor,$desc_tipoproveedor)
   {
      $sql="INSERT INTO tbtipoproveedor(cod_tipoproveedor,desc_tipoproveedor,estatus)
      VALUES('$cod_tipoproveedor','$desc_tipoproveedor','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idtipoproveedor,$cod_tipoproveedor,$desc_tipoproveedor)
   {
      $sql="UPDATE tbtipoproveedor
      SET
      cod_tipoproveedor='$cod_tipoproveedor',
      desc_tipoproveedor='$desc_tipoproveedor'
      WHERE idtipoproveedor='$idtipoproveedor'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idtipoproveedor)
   {
      $sql="DELETE FROM tbtipoproveedor 
      WHERE idtipoproveedor='$idtipoproveedor'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idtipoproveedor)
   {
      $sql="UPDATE tbtipoproveedor 
      SET estatus='1' 
      WHERE idtipoproveedor='$idtipoproveedor'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idtipoproveedor)
   {
      $sql="UPDATE tbtipoproveedor 
      SET estatus='0' 
      WHERE idtipoproveedor='$idtipoproveedor'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idtipoproveedor, 
      cod_tipoproveedor, 
      desc_tipoproveedor,
      estatus
      FROM tbtipoproveedor";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idtipoproveedor)
  {
    $sql="SELECT 
    idtipoproveedor, 
    cod_tipoproveedor, 
    desc_tipoproveedor,
    estatus
    FROM tbtipoproveedor 
    WHERE idtipoproveedor='$idtipoproveedor'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idtipoproveedor, 
    cod_tipoproveedor, 
    desc_tipoproveedor,
    estatus
    FROM tbtipoproveedor WHERE estatus='1'
    ORDER BY cod_tipoproveedor ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idtipoproveedor, 
    cod_tipoproveedor, 
    desc_tipoproveedor,
    estatus
    FROM tbtipoproveedor
    ORDER BY cod_tipoproveedor ASC";
    return ejecutarConsulta($sql);
  }

}

?>