<?php
require "../config/Conexion.php";

class Categoria{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_categoria,$desc_categoria)
   {
      $sql="INSERT INTO tbcategoria(cod_categoria,desc_categoria,estatus)
      VALUES('$cod_categoria','$desc_categoria','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idcategoria,$cod_categoria,$desc_categoria)
   {
      $sql="UPDATE tbcategoria
      SET
      cod_categoria='$cod_categoria',
      desc_categoria='$desc_categoria'
      WHERE idcategoria='$idcategoria'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idcategoria)
   {
      $sql="DELETE FROM tbcategoria 
      WHERE idcategoria='$idcategoria'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idcategoria)
   {
      $sql="UPDATE tbcategoria 
      SET estatus='1' 
      WHERE idcategoria='$idcategoria'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idcategoria)
   {
      $sql="UPDATE tbcategoria 
      SET estatus='0' 
      WHERE idcategoria='$idcategoria'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idcategoria, 
      cod_categoria, 
      desc_categoria,
      estatus
      FROM tbcategoria";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idcategoria)
  {
    $sql="SELECT 
    idcategoria, 
    cod_categoria, 
    desc_categoria,
    estatus
    FROM tbcategoria 
    WHERE idcategoria='$idcategoria'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idcategoria, 
    cod_categoria, 
    desc_categoria,
    estatus
    FROM tbcategoria WHERE estatus='1'
    ORDER BY cod_categoria ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idcategoria, 
    cod_categoria, 
    desc_categoria,
    estatus
    FROM tbcategoria
    ORDER BY cod_categoria ASC";
    return ejecutarConsulta($sql);
  }

}

?>