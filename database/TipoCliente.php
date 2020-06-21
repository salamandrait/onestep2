<?php
require "../config/Conexion.php";

class TipoCliente{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_tipocliente,$desc_tipocliente)
   {
      $sql="INSERT INTO tbtipocliente(cod_tipocliente,desc_tipocliente,estatus)
      VALUES('$cod_tipocliente','$desc_tipocliente','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idtipocliente,$cod_tipocliente,$desc_tipocliente)
   {
      $sql="UPDATE tbtipocliente
      SET
      cod_tipocliente='$cod_tipocliente',
      desc_tipocliente='$desc_tipocliente'
      WHERE idtipocliente='$idtipocliente'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idtipocliente)
   {
      $sql="DELETE FROM tbtipocliente 
      WHERE idtipocliente='$idtipocliente'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idtipocliente)
   {
      $sql="UPDATE tbtipocliente 
      SET estatus='1' 
      WHERE idtipocliente='$idtipocliente'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idtipocliente)
   {
      $sql="UPDATE tbtipocliente 
      SET estatus='0' 
      WHERE idtipocliente='$idtipocliente'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idtipocliente, 
      cod_tipocliente, 
      desc_tipocliente,
      estatus
      FROM tbtipocliente";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idtipocliente)
  {
    $sql="SELECT 
    idtipocliente, 
    cod_tipocliente, 
    desc_tipocliente,
    estatus
    FROM tbtipocliente 
    WHERE idtipocliente='$idtipocliente'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idtipocliente, 
    cod_tipocliente, 
    desc_tipocliente,
    estatus
    FROM tbtipocliente WHERE estatus='1'
    ORDER BY cod_tipocliente ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idtipocliente, 
    cod_tipocliente, 
    desc_tipocliente,
    estatus
    FROM tbtipocliente
    ORDER BY cod_tipocliente ASC";
    return ejecutarConsulta($sql);
  }

}

?>