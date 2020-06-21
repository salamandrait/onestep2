<?php
require "../config/Conexion.php";

class Banco{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2)
   {
      $sql="INSERT INTO tbbanco(idmoneda,cod_banco,desc_banco,telefono,plazo1,plazo2,estatus)
      VALUES('$idmoneda','$cod_banco','$desc_banco','$telefono','$plazo1','$plazo2','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idbanco,$idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2)
   {
      $sql="UPDATE tbbanco
      SET
      cod_banco='$cod_banco',
      idmoneda='$idmoneda',
      desc_banco='$desc_banco',
      telefono='$telefono',
      plazo1='$plazo1',
      plazo2='$plazo2'
      WHERE idbanco='$idbanco'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idbanco)
   {
      $sql="DELETE FROM tbbanco 
      WHERE idbanco='$idbanco'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idbanco)
   {
      $sql="UPDATE tbbanco 
      SET estatus='1' 
      WHERE idbanco='$idbanco'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idbanco)
   {
      $sql="UPDATE tbbanco 
      SET estatus='0' 
      WHERE idbanco='$idbanco'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      b.idbanco,
      b.idmoneda,
      b.cod_banco,
      b.desc_banco,
      m.cod_moneda,
      m.desc_moneda,
      b.telefono,
      b.plazo1,
      b.plazo2,
      b.estatus 
      FROM 
      tbbanco b 
      INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idbanco)
  {
    $sql="SELECT 
    b.idbanco,
    b.idmoneda,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    b.telefono,
    b.plazo1,
    b.plazo2,
    b.estatus 
    FROM 
    tbbanco b 
    INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda 
    WHERE b.idbanco='$idbanco'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    b.idbanco,
    b.idmoneda,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    b.telefono,
    b.plazo1,
    b.plazo2,
    b.estatus 
    FROM 
    tbbanco b 
    INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda 
    WHERE b.estatus='1'
    ORDER BY b.cod_banco ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    b.idbanco,
    b.idmoneda,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    b.telefono,
    b.plazo1,
    b.plazo2,
    b.estatus 
    FROM 
    tbbanco b 
    INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
    ORDER BY b.cod_banco ASC";
    return ejecutarConsulta($sql);
  }

}

?>