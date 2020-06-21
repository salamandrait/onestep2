<?php
require "../config/Conexion.php";

class Pais{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_pais,$idmoneda,$desc_pais)
   {
      $sql="INSERT INTO tbpais(cod_pais,idmoneda,desc_pais)
      VALUES('$cod_pais','$idmoneda','$desc_pais)";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idpais,$idmoneda,$cod_pais,$desc_pais)
   {
      $sql="UPDATE tbpais
      SET
      cod_pais='$cod_pais',
      idmoneda='$idmoneda',
      desc_pais='$desc_pais'
      WHERE idpais='$idpais'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idpais)
   {
      $sql="DELETE FROM tbpais 
      WHERE idpais='$idpais'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      p.idpais, 
      p.cod_pais, 
      p.desc_pais,
      m.cod_moneda,
      m.desc_moneda
      FROM tbpais p
      INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
   public function Mostrar($idpais)
   {
      $sql="SELECT 
      p.idpais, 
      p.idmoneda,
      p.cod_pais, 
      p.desc_pais,
      m.cod_moneda,
      m.desc_moneda
      FROM tbpais p
      INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda 
      WHERE p.idpais='$idpais'";
      return ejecutarConsultaSimpleFila($sql);
   }

  //Implementamos Select
  public function Select()
  {
      $sql="SELECT 
      p.idpais, 
      p.cod_pais, 
      p.desc_pais,
      m.cod_moneda,
      m.desc_moneda
      FROM tbpais p
      INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda
      WHERE p.estatus='1'
      ORDER BY p.cod_pais ASC";
      return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    p.idpais, 
    p.cod_pais, 
    p.desc_pais,
    m.cod_moneda,
    m.desc_moneda
    FROM tbpais p
    INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda
    ORDER BY p.cod_pais ASC";
    return ejecutarConsulta($sql);
  }

}

?>