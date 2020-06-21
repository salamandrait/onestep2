<?php
require "../config/Conexion.php";

class Beneficiario{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($idimpuestoi,$cod_beneficiario,$desc_beneficiario,$rif,$direccion,$telefono,$fechareg)
   {
      $sql="INSERT INTO tbbeneficiario(idimpuestoi,cod_beneficiario,desc_beneficiario,rif,direccion,telefono,fechareg,estatus)
      VALUES('$idimpuestoi','$cod_beneficiario','$desc_beneficiario','$rif','$direccion','$telefono',STR_TO_DATE('$fechareg','%d/%m/%Y'),'1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idimpuestoi,$idbeneficiario,$cod_beneficiario,$desc_beneficiario,$rif,$direccion,$telefono,$fechareg)
   {
      $sql="UPDATE tbbeneficiario
      SET
      idimpuestoi='$idimpuestoi',
      cod_beneficiario='$cod_beneficiario',
      desc_beneficiario='$desc_beneficiario',
      rif='$rif',
      direccion='$direccion',
      fechareg=STR_TO_DATE('$fechareg','%d/%m/%Y'),
      telefono='$telefono'
      WHERE idbeneficiario='$idbeneficiario'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idbeneficiario)
   {
      $sql="DELETE FROM tbbeneficiario 
      WHERE idbeneficiario='$idbeneficiario'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idbeneficiario)
   {
      $sql="UPDATE tbbeneficiario 
      SET estatus='1' 
      WHERE idbeneficiario='$idbeneficiario'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idbeneficiario)
   {
      $sql="UPDATE tbbeneficiario 
      SET estatus='0' 
      WHERE idbeneficiario='$idbeneficiario'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      idbeneficiario,
      idimpuestoi,
      cod_beneficiario,
      desc_beneficiario,
      rif,
      direccion,
      telefono,
      DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
      estatus 
      FROM
      tbbeneficiario";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idbeneficiario)
  {
    $sql="SELECT 
    idbeneficiario,
    idimpuestoi,
    cod_beneficiario,
    desc_beneficiario,
    rif,
    direccion,
    telefono,
    DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
    estatus 
    FROM
    tbbeneficiario 
    WHERE idbeneficiario='$idbeneficiario'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    idbeneficiario,
    idimpuestoi,
    cod_beneficiario,
    desc_beneficiario,
    rif,
    direccion,
    telefono,
    DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
    estatus 
    FROM
    tbbeneficiario
    WHERE estatus='1'
    ORDER BY cod_beneficiario ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    idbeneficiario,
    idimpuestoi,
    cod_beneficiario,
    desc_beneficiario,
    rif,
    direccion,
    telefono,
    DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
    estatus 
    FROM
    tbbeneficiario
    ORDER BY cod_beneficiario ASC";
    return ejecutarConsulta($sql);
  }

}

?>