<?php
require "../config/Conexion.php";

class Linea{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_linea,$idcategoria,$desc_linea)
   {
      $sql="INSERT INTO tblinea(cod_linea,idcategoria,desc_linea,estatus)
      VALUES('$cod_linea','$idcategoria','$desc_linea','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idlinea,$idcategoria,$cod_linea,$desc_linea)
   {
      $sql="UPDATE tblinea
      SET
      cod_linea='$cod_linea',
      idcategoria='$idcategoria',
      desc_linea='$desc_linea'
      WHERE idlinea='$idlinea'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idlinea)
   {
      $sql="DELETE FROM tblinea 
      WHERE idlinea='$idlinea'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idlinea)
   {
      $sql="UPDATE tblinea 
      SET estatus='1' 
      WHERE idlinea='$idlinea'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idlinea)
   {
      $sql="UPDATE tblinea 
      SET estatus='0' 
      WHERE idlinea='$idlinea'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      l.idlinea, 
      l.cod_linea, 
      l.desc_linea,
      c.cod_categoria,
      c.desc_categoria,
      l.estatus
      FROM tblinea l
      INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
   public function Mostrar($idlinea)
   {
      $sql="SELECT 
      l.idlinea, 
      l.idcategoria,
      l.cod_linea, 
      l.desc_linea,
      c.cod_categoria,
      c.desc_categoria,
      l.estatus
      FROM tblinea l
      INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria 
      WHERE l.idlinea='$idlinea'";
      return ejecutarConsultaSimpleFila($sql);
   }

   public function SelectCT($idcategoria)
   {
      $sql="SELECT 
      l.idlinea, 
      l.cod_linea, 
      l.desc_linea,
      c.cod_categoria,
      c.desc_categoria,
      l.estatus
      FROM tblinea l
      INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria 
      WHERE l.idcategoria='$idcategoria'";
      return ejecutarConsulta($sql);
   }

   public function SelectL($idlinea)
   {
      $sql="SELECT 
      l.idlinea, 
      l.cod_linea, 
      l.desc_linea,
      c.cod_categoria,
      c.desc_categoria,
      l.estatus
      FROM tblinea l
      INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria 
      WHERE l.idlinea='$idlinea'";
      return ejecutarConsulta($sql);
   }

  //Implementamos Select
  public function Select()
  {
      $sql="SELECT 
      l.idlinea, 
      l.cod_linea, 
      l.desc_linea,
      c.cod_categoria,
      c.desc_categoria,
      l.estatus
      FROM tblinea l
      INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria
      WHERE l.estatus='1'
      ORDER BY l.cod_linea ASC";
      return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    l.idlinea, 
    l.cod_linea, 
    l.desc_linea,
    c.cod_categoria,
    c.desc_categoria,
    l.estatus
    FROM tblinea l
    INNER JOIN tbcategoria c ON c.idcategoria=l.idcategoria
    ORDER BY l.cod_linea ASC";
    return ejecutarConsulta($sql);
  }

}

?>