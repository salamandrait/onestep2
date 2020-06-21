<?php
require "../config/Conexion.php";

class Correlativo{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_correlativo,$desc_correlativo,$grupo,$tabla,$cadena,$precadena,$cod_num,$largo)
   {
      $sql="INSERT INTO tbcorrelativo(cod_correlativo,desc_correlativo,grupo,tabla,cadena,precadena,cod_num,largo,estatus)
      VALUES('$cod_correlativo','$desc_correlativo','$grupo','$tabla','$cadena','$precadena','$cod_num','$largo','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idcorrelativo,$cod_correlativo,$desc_correlativo,$grupo,$tabla,$cadena,$precadena,$cod_num,$largo)
   {
      $sql="UPDATE tbcorrelativo
      SET
      cod_correlativo='$cod_correlativo',
      desc_correlativo='$desc_correlativo',
      grupo='$grupo',
      tabla='$tabla',
      cadena='$cadena',
      precadena='$precadena',
      cod_num='$cod_num',
      largo='$largo'
      WHERE idcorrelativo='$idcorrelativo'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idcorrelativo)
   {
      $sql="DELETE FROM tbcorrelativo 
      WHERE idcorrelativo='$idcorrelativo'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idcorrelativo)
   {
      $sql="UPDATE tbcorrelativo 
      SET estatus='1' 
      WHERE idcorrelativo='$idcorrelativo'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idcorrelativo)
   {
      $sql="UPDATE tbcorrelativo 
      SET estatus='0' 
      WHERE idcorrelativo='$idcorrelativo'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idcorrelativo, 
      cod_correlativo, 
      desc_correlativo,
      grupo,
		tabla,
		precadena,
		REPEAT(cadena,largo) AS cadena,
		CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS cod_num,
		largo,
      estatus
      FROM tbcorrelativo";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idcorrelativo)
  {
    $sql="SELECT 
    idcorrelativo, 
    cod_correlativo, 
    desc_correlativo,
    grupo,
    tabla,
    precadena,
    cadena,
    largo,
    cod_num,
    estatus
    FROM tbcorrelativo 
    WHERE idcorrelativo='$idcorrelativo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
      $sql="SELECT 
      idcorrelativo, 
      cod_correlativo, 
      desc_correlativo,
      grupo,
      tabla,
      precadena,
      REPEAT(cadena,largo) AS cadena,
      CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS cod_num,
      largo,
      estatus
      FROM tbcorrelativo WHERE estatus='1'
      ORDER BY cod_correlativo ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
      $sql="SELECT 
      idcorrelativo, 
      cod_correlativo, 
      desc_correlativo,
      grupo,
      tabla,
      precadena,
      REPEAT(cadena,largo) AS cadena,
      CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS cod_num,
      largo,
      estatus
      FROM tbcorrelativo
      ORDER BY cod_correlativo ASC";
    return ejecutarConsulta($sql);
  }

  public function GenerarCod($tabla)
  {
      $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum,estatus
      FROM tbcorrelativo WHERE tabla='$tabla'";
      return ejecutarConsultaSimpleFila($sql);  
  }

  public function ActCod($tabla)
  {
      $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='$tabla'";
      return ejecutarConsulta($sql);
  }

}

?>