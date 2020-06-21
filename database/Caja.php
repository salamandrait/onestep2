<?php
require "../config/Conexion.php";

class Caja{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($idmoneda,$cod_caja,$desc_caja,$fechareg)
   {
      $sql="INSERT INTO tbcaja(idmoneda,cod_caja,desc_caja,saldoefectivo,saldodocumento,saldototal,fechareg,estatus)
      VALUES('$idmoneda','$cod_caja','$desc_caja','0.00','0.00','0.00',STR_TO_DATE('$fechareg','%d/%m/%Y'),'1')";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idcaja,$idmoneda,$cod_caja,$desc_caja,$fechareg)
   {
      $sql="UPDATE 
      tbcaja 
      SET
      idmoneda = '$idmoneda',
      cod_caja = '$cod_caja',
      desc_caja = '$desc_caja',
      fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y')
      WHERE idcaja = '$idcaja'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idcaja)
   {
      $sql="DELETE FROM tbcaja 
      WHERE idcaja='$idcaja'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idcaja)
   {
      $sql="UPDATE tbcaja 
      SET estatus='1' 
      WHERE idcaja='$idcaja'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idcaja)
   {
      $sql="UPDATE tbcaja 
      SET estatus='0' 
      WHERE idcaja='$idcaja'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      c.idcaja,
      c.idmoneda,
      c.cod_caja,
      c.desc_caja,
      m.cod_moneda,
      m.desc_moneda,
      c.saldoefectivo,
      c.saldodocumento,
      c.saldototal,
      DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
      c.estatus 
      FROM tbcaja c
      INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idcaja)
  {
    $sql="SELECT 
    c.idcaja,
    c.idmoneda,
    c.cod_caja,
    c.desc_caja,
    m.cod_moneda,
    m.desc_moneda,
    c.saldoefectivo,
    c.saldodocumento,
    c.saldototal,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus 
    FROM tbcaja c
    INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda 
    WHERE c.idcaja='$idcaja'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    c.idcaja,
    c.idmoneda,
    c.cod_caja,
    c.desc_caja,
    m.cod_moneda,
    m.desc_moneda,
    c.saldoefectivo,
    c.saldodocumento,
    c.saldototal,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus 
    FROM tbcaja c
    INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda 
    WHERE c.estatus='1'
    ORDER BY c.cod_caja ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    c.idcaja,
    c.idmoneda,
    c.cod_caja,
    c.desc_caja,
    m.cod_moneda,
    m.desc_moneda,
    c.saldoefectivo,
    c.saldodocumento,
    c.saldototal,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus 
    FROM tbcaja c
    INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda
    ORDER BY c.cod_caja ASC";
    return ejecutarConsulta($sql);
  }

}

?>