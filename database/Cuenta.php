<?php
require "../config/Conexion.php";

class Cuenta{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
   $telefono,$email,$fechareg)
   {
      $sql="INSERT INTO tbcuenta(idbanco,cod_cuenta,desc_cuenta,tipo,numcuenta,agencia,ejecutivo,direccion,
      telefono,email,fechareg,estatus,saldod,saldoh,saldot)
      VALUES('$idbanco','$cod_cuenta','$desc_cuenta','$tipo','$numcuenta','$agencia','$ejecutivo','$direccion',
      '$telefono','$email',STR_TO_DATE('$fechareg','%d/%m/%Y'),'1','0','0','0')";
      return ejecutarConsulta($sql);

   }

   //Implementamos Editar
   public function Editar($idcuenta,$idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
   $telefono,$email,$fechareg)
   {
      $sql="UPDATE tbcuenta
      SET
      idbanco = '$idbanco',
      cod_cuenta = '$cod_cuenta',
      desc_cuenta = '$desc_cuenta',
      tipo = '$tipo',
      numcuenta = '$numcuenta',
      agencia = '$agencia',
      ejecutivo = '$ejecutivo',
      direccion = '$direccion',
      telefono = '$telefono',
      email = '$email',
      fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y')
      WHERE idcuenta='$idcuenta'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idcuenta)
   {
      $sql="DELETE FROM tbcuenta 
      WHERE idcuenta='$idcuenta'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idcuenta)
   {
      $sql="UPDATE tbcuenta 
      SET estatus='1' 
      WHERE idcuenta='$idcuenta'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idcuenta)
   {
      $sql="UPDATE tbcuenta 
      SET estatus='0' 
      WHERE idcuenta='$idcuenta'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT
      c.idcuenta,
      c.idbanco,
      c.cod_cuenta,
      c.desc_cuenta,
      c.tipo,
      c.numcuenta,
      b.cod_banco,
      b.desc_banco,
      m.cod_moneda,
      m.desc_moneda,
      c.agencia,
      c.ejecutivo,
      c.direccion,
      c.telefono,
      c.email,
      c.saldod,
      c.saldoh,
      c.saldot,
      DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
      c.estatus
      FROM tbcuenta c
      INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
      INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda)";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idcuenta)
  {
    $sql="SELECT
    c.idcuenta,
    c.idbanco,
    c.cod_cuenta,
    c.desc_cuenta,
    c.tipo,
    c.numcuenta,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    c.agencia,
    c.ejecutivo,
    c.direccion,
    c.telefono,
    c.email,
    c.saldod,
    c.saldoh,
    c.saldot,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus
    FROM tbcuenta c
    INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
    INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda) 
    WHERE c.idcuenta='$idcuenta'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT
    c.idcuenta,
    c.idbanco,
    c.cod_cuenta,
    c.desc_cuenta,
    c.tipo,
    c.numcuenta,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    c.agencia,
    c.ejecutivo,
    c.direccion,
    c.telefono,
    c.email,
    c.saldod,
    c.saldoh,
    c.saldot,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus
    FROM tbcuenta c
    INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
    INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda)
    WHERE c.estatus='1'
    ORDER BY c.cod_cuenta ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT
    c.idcuenta,
    c.idbanco,
    c.cod_cuenta,
    c.desc_cuenta,
    c.tipo,
    c.numcuenta,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    c.agencia,
    c.ejecutivo,
    c.direccion,
    c.telefono,
    c.email,
    c.saldod,
    c.saldoh,
    c.saldot,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus
    FROM tbcuenta c
    INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
    INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda)
    ORDER BY c.cod_cuenta ASC";
    return ejecutarConsulta($sql);
  }

}

?>