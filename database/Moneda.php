<?php
require "../config/Conexion.php";

class Moneda{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_moneda,$desc_moneda,$factor,$base)
   {
      $sql="INSERT INTO tbmoneda(cod_moneda,desc_moneda,factor,base,estatus)
      VALUES('$cod_moneda','$desc_moneda',REPLACE('$factor',',',''),'$base','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idmoneda,$cod_moneda,$desc_moneda,$factor,$base)
   {
      $sql="UPDATE tbmoneda
      SET
      cod_moneda='$cod_moneda',
      desc_moneda='$desc_moneda',
      factor=REPLACE('$factor',',',''),
      base='$base'
      WHERE idmoneda='$idmoneda'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idmoneda)
   {
      $sql="DELETE FROM tbmoneda 
      WHERE idmoneda='$idmoneda'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idmoneda)
   {
      $sql="UPDATE tbmoneda 
      SET estatus='1' 
      WHERE idmoneda='$idmoneda'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idmoneda)
   {
      $sql="UPDATE tbmoneda 
      SET estatus='0' 
      WHERE idmoneda='$idmoneda'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idmoneda, 
      cod_moneda, 
      desc_moneda,
      base,
      factor,
      estatus
      FROM tbmoneda";
      return ejecutarConsulta($sql);
   }

   //Implementamos Mostrar
   public function Mostrar($idmoneda)
   {
      $sql="SELECT 
      idmoneda, 
      cod_moneda, 
      desc_moneda,
      base,
      factor,
      estatus
      FROM tbmoneda 
      WHERE idmoneda='$idmoneda'";
      return ejecutarConsultaSimpleFila($sql);
   }

  //Implementamos Select
  public function Select(){
     
      $sql="SELECT 
      idmoneda, 
      cod_moneda, 
      desc_moneda,
      base,
      factor,
      estatus
      FROM tbmoneda WHERE estatus='1'
      ORDER BY cod_moneda ASC";
      return ejecutarConsulta($sql);
  }

   //Implementamos Select
   public function SelectOp(){

      $sql="SELECT 
      idmoneda, 
      cod_moneda, 
      desc_moneda,
      base,
      factor,
      estatus
      FROM tbmoneda WHERE estatus='1' AND base='1'
      ORDER BY cod_moneda ASC";
      return ejecutarConsulta($sql);
   }

  //Implementamos Listar
  public function RptListar(){

      $sql="SELECT 
      idmoneda, 
      cod_moneda, 
      desc_moneda,
      base,
      factor,
      estatus
      FROM tbmoneda
      ORDER BY cod_moneda ASC";
      return ejecutarConsulta($sql);
   }

}

?>