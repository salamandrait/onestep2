<?php
require "../config/Conexion.php";

class Deposito{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_deposito,$desc_deposito,$responsable,$direccion,$fechareg,$solocompra,$soloventa)
   {
      $sql="INSERT INTO tbdeposito(cod_deposito,desc_deposito,responsable,direccion,fechareg,solocompra,soloventa,estatus)
      VALUES('$cod_deposito','$desc_deposito','$responsable','$direccion',STR_TO_DATE('$fechareg','%d/%m/%Y'),'$solocompra','$soloventa','1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($iddeposito,$cod_deposito,$desc_deposito,$responsable,$direccion,$fechareg,$solocompra,$soloventa)
   {
      $sql="UPDATE tbdeposito
      SET
      cod_deposito='$cod_deposito',
      desc_deposito='$desc_deposito',
      responsable = '$responsable',
      direccion = '$direccion',
      fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y'),
      solocompra = '$solocompra',
      soloventa = '$soloventa'
      WHERE iddeposito='$iddeposito'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($iddeposito)
   {
      $sql="DELETE FROM tbdeposito 
      WHERE iddeposito='$iddeposito'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($iddeposito)
   {
      $sql="UPDATE tbdeposito 
      SET estatus='1' 
      WHERE iddeposito='$iddeposito'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($iddeposito)
   {
      $sql="UPDATE tbdeposito 
      SET estatus='0' 
      WHERE iddeposito='$iddeposito'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      iddeposito, 
      cod_deposito, 
      desc_deposito,
      responsable,
      direccion,
      DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
      solocompra,
      soloventa,
      estatus 
      FROM tbdeposito";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($iddeposito)
  {
    $sql="SELECT 
    iddeposito, 
    cod_deposito, 
    desc_deposito,
    responsable,
    direccion,
    DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
    solocompra,
    soloventa,
    estatus 
    FROM tbdeposito 
    WHERE iddeposito='$iddeposito'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    iddeposito, 
    cod_deposito, 
    desc_deposito,
    responsable,
    direccion,
    DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
    solocompra,
    soloventa,
    estatus 
    FROM tbdeposito WHERE estatus='1'
    ORDER BY cod_deposito ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    iddeposito, 
    cod_deposito, 
    desc_deposito,
    responsable,
    direccion,
    DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
    solocompra,
    soloventa,
    estatus 
    FROM tbdeposito
    ORDER BY cod_deposito ASC";
    return ejecutarConsulta($sql);
  }

  public function ListarStock($idarticulo)
  {
    $sql="SELECT 
    s.iddeposito,
    d.cod_deposito,
    d.desc_deposito,
    IFNULL(s.cantidad,0) AS stock
    FROM tbstock s
    INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
    WHERE s.idarticulo='$idarticulo'";
    return ejecutarConsulta($sql);		
  }

}

?>