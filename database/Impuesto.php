<?php
require "../config/Conexion.php";

class Impuesto{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_impuesto,$desc_impuesto,$simbolo,$tasa)
   {
      $sql="INSERT INTO tbimpuesto(cod_impuesto,desc_impuesto,simbolo,tasa,estatus)
      VALUES('$cod_impuesto','$desc_impuesto','$simbolo','$tasa','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idimpuesto,$cod_impuesto,$desc_impuesto,$simbolo,$tasa)
   {
      $sql="UPDATE tbimpuesto
      SET
      cod_impuesto='$cod_impuesto',
      desc_impuesto='$desc_impuesto',
      simbolo='$simbolo',
      tasa='$tasa'
      WHERE idimpuesto='$idimpuesto'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idimpuesto)
   {
      $sql="DELETE FROM tbimpuesto 
      WHERE idimpuesto='$idimpuesto'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idimpuesto)
   {
      $sql="UPDATE tbimpuesto 
      SET estatus='1' 
      WHERE idimpuesto='$idimpuesto'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idimpuesto)
   {
      $sql="UPDATE tbimpuesto 
      SET estatus='0' 
      WHERE idimpuesto='$idimpuesto'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idimpuesto, 
      cod_impuesto, 
      desc_impuesto,
      tasa,
      simbolo,
      estatus
      FROM tbimpuesto";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idimpuesto)
  {
    $sql="SELECT 
    idimpuesto, 
    cod_impuesto, 
    desc_impuesto,
    tasa,
    simbolo,
    estatus
    FROM tbimpuesto 
    WHERE idimpuesto='$idimpuesto'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idimpuesto, 
    cod_impuesto, 
    desc_impuesto,
    tasa,
    simbolo,
    estatus
    FROM tbimpuesto WHERE estatus='1'
    ORDER BY tasa DESC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idimpuesto, 
    cod_impuesto, 
    desc_impuesto,
    tasa,
    simbolo,
    estatus
    FROM tbimpuesto
    ORDER BY cod_impuesto ASC";
    return ejecutarConsulta($sql);
  }

}

?>