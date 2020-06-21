<?php
require "../config/Conexion.php";

class MovCaja{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   public function ActCod()
   {
     $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbmovcaja' AND estatus='1'";
     return ejecutarConsulta($sql);
   }

   //Implementamos Insertar
   public function Insertar($idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,
   $tipo,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg)
   {
      $sql="INSERT INTO tbmovcaja (idcaja,idbanco,idoperacion,idusuario,cod_movcaja,desc_movcaja,
      estatus,tipo,forma,numerod,numeroc,origen,montod,montoh,saldoinicial,fechareg,fechadb) 
      VALUES('$idcaja','$idbanco','$idoperacion','$idusuario','$cod_movcaja','$desc_movcaja',
      'Registrado','$tipo','$forma','$numerod','$numeroc','$origen','$montod','$montoh','
      $saldoinicial',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      return ejecutarConsulta($sql);
   }

  //Implementamos Editar
  public function Editar($idmovcaja,$idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,$estatus,
  $tipo,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg)
  {
    $sql="UPDATE 
    tbmovcaja 
    SET
    idcaja = '$idcaja',
    idbanco = '$idbanco',
    idoperacion = '$idoperacion',
    idusuario = '$idusuario',
    cod_movcaja = '$cod_movcaja',
    desc_movcaja = '$desc_movcaja',
    estatus = '$estatus',
    tipo = '$tipo',
    forma = '$forma',
    numerod = '$numerod',
    numeroc = '$numeroc',
    origen = '$origen',
    montod = '$montod',
    montoh = '$montoh',
    saldoinicial = '$saldoinicial',
    fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y'),
    fechadb = NOW() 
    WHERE idmovcaja = '$idmovcaja'";
    return ejecutarConsulta($sql);
  }

   //Metodo para Actualizar el Saldo de Caja
   public function ActSaldoCaja($idcaja)
   {
      $sql="UPDATE 
      tbcaja 
      SET 
      saldoefectivo =(SELECT IFNULL(SUM(montod),0)-IFNULL(SUM(montoh),0) 
      FROM tbmovcaja WHERE idcaja='$idcaja' AND forma='Efectivo' AND estatus<>'Anulado'),
      saldodocumento =(SELECT IFNULL(SUM(montod),0)-IFNULL(SUM(montoh),0) 
      FROM tbmovcaja WHERE idcaja='$idcaja' AND forma<>'Efectivo' AND estatus<>'Anulado'),
      saldototal=saldoefectivo+saldodocumento
      WHERE idcaja = '$idcaja'";
      return ejecutarConsulta($sql);					
   }

   //Implementamos Eliminar
   public function Eliminar($idmovcaja)
   {
      $sql="DELETE FROM tbmovcaja 
      WHERE idmovcaja='$idmovcaja'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Anular($idmovcaja)
   {
      $sql="UPDATE tbmovcaja 
      SET estatus='Anulado' 
      WHERE idmovcaja='$idmovcaja'";
      return ejecutarConsulta($sql);
   }


   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT
      mc.cod_movcaja,
      mc.desc_movcaja,
      c.cod_caja,
      c.desc_caja,
      c.saldototal,
      op.cod_operacion,
      op.desc_operacion,
      b.cod_banco,
      b.desc_banco,
      u.cod_usuario,
      u.desc_usuario,
      mc.estatus,
      mc.tipo,
      mc.forma,
      mc.numerod,
      mc.numeroc,
      mc.origen,
      mc.montod,
      mc.montoh,
      mc.saldoinicial,
      mc.idcaja,
      mc.idmovcaja,
      mc.idbanco,
      mc.idoperacion,
      mc.idusuario,
      DATE_FORMAT(mc.fechareg,'%d/%m/%Y') AS fechareg
      FROM
      tbmovcaja AS mc
      LEFT JOIN tbbanco AS b ON (b.idbanco = mc.idbanco)
      INNER JOIN tbcaja AS c ON (mc.idcaja = c.idcaja)
      INNER JOIN tboperacion AS op ON (mc.idoperacion = op.idoperacion)
      INNER JOIN tbusuario AS u ON (u.idusuario = mc.idusuario)";
      return ejecutarConsulta($sql);
   }

   //Implementamos Mostrar
   public function Mostrar($idmovcaja)
   {
      $sql="SELECT
      mc.cod_movcaja,
      mc.desc_movcaja,
      c.cod_caja,
      c.desc_caja,
      c.saldototal,
      op.cod_operacion,
      op.desc_operacion,
      b.cod_banco,
      b.desc_banco,
      u.cod_usuario,
      u.desc_usuario,
      mc.estatus,
      mc.tipo,
      mc.forma,
      mc.numerod,
      mc.numeroc,
      mc.origen,
      mc.montod,
      mc.montoh,
      mc.saldoinicial,
      mc.idcaja,
      mc.idmovcaja,
      mc.idbanco,
      mc.idoperacion,
      mc.idusuario,
      DATE_FORMAT(mc.fechareg,'%d/%m/%Y') AS fechareg
      FROM
      tbmovcaja AS mc
      LEFT JOIN tbbanco AS b ON (b.idbanco = mc.idbanco)
      INNER JOIN tbcaja AS c ON (mc.idcaja = c.idcaja)
      INNER JOIN tboperacion AS op ON (mc.idoperacion = op.idoperacion)
      INNER JOIN tbusuario AS u ON (u.idusuario = mc.idusuario) 
      WHERE mc.idmovcaja='$idmovcaja'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Implementamos Select
   public function Select()
   {
      $sql="SELECT
      mc.cod_movcaja,
      mc.desc_movcaja,
      c.cod_caja,
      c.desc_caja,
      c.saldototal,
      op.cod_operacion,
      op.desc_operacion,
      b.cod_banco,
      b.desc_banco,
      u.cod_usuario,
      u.desc_usuario,
      mc.estatus,
      mc.tipo,
      mc.forma,
      mc.numerod,
      mc.numeroc,
      mc.origen,
      mc.montod,
      mc.montoh,
      mc.saldoinicial,
      mc.idcaja,
      mc.idmovcaja,
      mc.idbanco,
      mc.idoperacion,
      mc.idusuario,
      DATE_FORMAT(mc.fechareg,'%d/%m/%Y') AS fechareg
      FROM
      tbmovcaja AS mc
      LEFT JOIN tbbanco AS b ON (b.idbanco = mc.idbanco)
      INNER JOIN tbcaja AS c ON (mc.idcaja = c.idcaja)
      INNER JOIN tboperacion AS op ON (mc.idoperacion = op.idoperacion)
      INNER JOIN tbusuario AS u ON (u.idusuario = mc.idusuario) 
      WHERE mc.estatus='1'
      ORDER BY mc.cod_movcaja ASC";
      return ejecutarConsulta($sql);
   }

   //Implementamos Listar
   public function RptListar()
   {
      $sql="SELECT
      mc.cod_movcaja,
      mc.desc_movcaja,
      c.cod_caja,
      c.desc_caja,
      c.saldototal,
      op.cod_operacion,
      op.desc_operacion,
      b.cod_banco,
      b.desc_banco,
      u.cod_usuario,
      u.desc_usuario,
      mc.estatus,
      mc.tipo,
      mc.forma,
      mc.numerod,
      mc.numeroc,
      mc.origen,
      mc.montod,
      mc.montoh,
      mc.saldoinicial,
      mc.idcaja,
      mc.idmovcaja,
      mc.idbanco,
      mc.idoperacion,
      mc.idusuario,
      DATE_FORMAT(mc.fechareg,'%d/%m/%Y') AS fechareg
      FROM
      tbmovcaja AS mc
      LEFT JOIN tbbanco AS b ON (b.idbanco = mc.idbanco)
      INNER JOIN tbcaja AS c ON (mc.idcaja = c.idcaja)
      INNER JOIN tboperacion AS op ON (mc.idoperacion = op.idoperacion)
      INNER JOIN tbusuario AS u ON (u.idusuario = mc.idusuario) 
      ORDER BY mc.cod_movcaja ASC";
      return ejecutarConsulta($sql);
   }

}

?>