<?php
require "../config/Conexion.php";

class Pago{

   //Funcion constructor
   public function __construct(){   
   }

   public function ActCod()
   {
      $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbpago' AND estatus='1'";
      return ejecutarConsulta($sql);
   }  

   //Funcion Insertar Registros
   public function InsertarBanco($idusuario,$idproveedor,$cod_pago,$desc_pago,$tipo,$origend,$origenc,$totalh,$fechareg,
   $idcompra,$montoh,$idcuenta,$idoperacion,$cod_movbanco,$tipoban,$numerocb,$fecharegb){

      $sql="INSERT INTO tbpago (idusuario,idproveedor,cod_pago,desc_pago,tipo,origend,origenc,estatus,totalh,fechareg,fechadb)
      VALUES('$idusuario','$idproveedor','$cod_pago','$desc_pago','$tipo','$origend','$origenc','Registrado','$totalh',
      STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      $idpago=ejecutarConsulta_retornarID($sql);

      $swmovbanco=true;
      $swpd=true;
      $swcompra = true;

      $sql_movbanco="INSERT INTO tbmovbanco(idcuenta,idoperacion,idusuario,cod_movbanco,desc_movbanco,tipo,estatus,origen,
      numerod,numeroc,montod,montoh,saldoinicial,fechareg,fechadb)
      VALUES('$idcuenta','$idoperacion','$idusuario','$cod_movbanco',CONCAT('Registro de ','$tipo',' N°',' ','$cod_pago',' de Fecha ','$fechareg'),
      '$tipoban','Registrado','$tipo','$cod_pago','$numerocb','0','$montoh','0',STR_TO_DATE('$fecharegb','%d/%m/%Y'),NOW())";
      $idmovbanco=ejecutarConsulta_retornarID($sql_movbanco) or $swmovbanco = false;

      $sqlactcodban="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbmovbanco' AND estatus='1'";
      ejecutarConsulta($sqlactcodban);

      $sql_detalle ="INSERT INTO tbpagod (idpago,idcompra,idmovbanco,idmovcaja,montoh) 
      VALUES ('$idpago','$idcompra','$idmovbanco','0','$montoh')";
      ejecutarConsulta($sql_detalle) or $swpd = false;

      $sql_comp="UPDATE 
      tbcompra
      SET
      estatus=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago Parc.'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pagado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN 'Registrado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN 'Registrado'
      END),
      origend=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN tipo
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN tipo
      END),
      origenc=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN ''
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN ''
      END),
      saldoh=totalh-(IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)),
      fechadb=NOW()
      WHERE idcompra='$idcompra'";
      ejecutarConsulta($sql_comp) or $swcompra = false;
      return $swpd.$swmovbanco.$swcompra;
   }


   public function InsertarCaja($idusuario,$idproveedor,$cod_pago,$desc_pago,$tipo,$origend,$origenc,$totalh,$fechareg,
   $idcaja,$idoperacion,$cod_movcaja,$idcompra,$montoh,$fecharegc){
      
      $sql="INSERT INTO tbpago(idusuario,idproveedor,cod_pago,desc_pago,tipo,origend,origenc,estatus,totalh,fechareg,fechadb)
      VALUES('$idusuario','$idproveedor','$cod_pago','$desc_pago','$tipo','$origend','$origenc','Registrado',
      '$totalh',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      $idpago=ejecutarConsulta_retornarID($sql);

      $swmovcaja=true;
      $swpd=true;
      $swcompra = true;

      $sql_movcaja="INSERT INTO tbmovcaja(idcaja,idbanco,idoperacion,idusuario,cod_movcaja,desc_movcaja,
      estatus,tipo,forma,numerod,numeroc,origen,montod,montoh,saldoinicial,fechareg,fechadb) 
      VALUES('$idcaja','0','$idoperacion','$idusuario','$cod_movcaja',CONCAT('Registro de ','$tipo',' N°',' ','$cod_pago',' de Fecha ','$fechareg'),
      'Registrado','Egreso','Efectivo','$cod_pago','','$tipo','0','$montoh','0',STR_TO_DATE('$fecharegc','%d/%m/%Y'),NOW())";
      $idmovcaja=ejecutarConsulta_retornarID($sql_movcaja) or $swmovcaja = false;

      $sqlactcodcaj="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbmovcaja' AND estatus='1'";
      ejecutarConsulta($sqlactcodcaj);
      
      $sql_detalle ="INSERT INTO tbpagod (idpago,idcompra,idmovbanco,idmovcaja,montoh) 
      VALUES ('$idpago','$idcompra','0','$idmovcaja','$montoh')";
      ejecutarConsulta($sql_detalle) or $swpd = false;

      $sql_comp="UPDATE 
      tbcompra
      SET
      estatus=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago Parc.'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pagado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN 'Registrado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN 'Registrado'
      END),
      origend=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN tipo
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN tipo
      END),
      origenc=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN ''
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN ''
      END),
      saldoh=totalh-(IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)),
      fechadb=NOW()
      WHERE idcompra='$idcompra'";
      ejecutarConsulta($sql_comp) or $swcompra = false;
      return $swpd.$swcompra.$swmovcaja;
   }

   public function InsertarRetIva($idusuario,$idproveedor,$cod_pago,$desc_pago,$tipo,$origend,$origenc,$totalh,$fechareg,
   $idcaja,$idoperacion,$cod_movcaja,$idcompra,$montoh,$fecharegc,$retenciona){
      
      $sql="INSERT INTO tbpago(idusuario,idproveedor,cod_pago,desc_pago,tipo,origend,origenc,estatus,totalh,fechareg,fechadb)
      VALUES('$idusuario','$idproveedor','$cod_pago','$desc_pago','$tipo','$origend','$origenc','Registrado',
      '$totalh',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      $idpago=ejecutarConsulta_retornarID($sql);

      $swmovcaja=true;
      $swpd=true;
      $swcompra = true;

      $sql_movcaja="INSERT INTO tbmovcaja(idcaja,idbanco,idoperacion,idusuario,cod_movcaja,desc_movcaja,
      estatus,tipo,forma,numerod,numeroc,origen,montod,montoh,saldoinicial,fechareg,fechadb) 
      VALUES('$idcaja','0','$idoperacion','$idusuario','$cod_movcaja',CONCAT('Registro de ','$tipo',' N°',' ','$cod_pago',' de Fecha ','$fechareg'),
      'Registrado','Egreso','Efectivo','$cod_pago','','$tipo','0','0','0',STR_TO_DATE('$fecharegc','%d/%m/%Y'),NOW())";
      $idmovcaja=ejecutarConsulta_retornarID($sql_movcaja) or $swmovcaja = false;

      $sqlactcodcaj="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbmovcaja' AND estatus='1'";
      ejecutarConsulta($sqlactcodcaj);
      
      $sql_detalle ="INSERT INTO tbpagod (idpago,idcompra,idmovbanco,idmovcaja,montoh) 
      VALUES ('$idpago','$idcompra','0','$idmovcaja','$montoh')";
      ejecutarConsulta($sql_detalle) or $swpd = false;

      $sql_comp="UPDATE 
      tbcompra
      SET
      estatus=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago Parc.'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pagado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN 'Registrado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN 'Registrado'
      END),
      origend=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN tipo
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN tipo
      END),
      origenc=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN ''
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN ''
      END),
      saldoh=totalh-(IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)),
      retenciona='$retenciona',
      fechadb=NOW()
      WHERE idcompra='$idcompra'";
      ejecutarConsulta($sql_comp) or $swcompra = false;
      return $swpd.$swcompra.$swmovcaja;
   }

   public function Eliminar($idpago){
      $sql="DELETE FROM tbpago
      WHERE idpago='$idpago'";
      return ejecutarConsulta($sql);
   }

   public function Anular($idpago){
      $sql="UPDATE tbpago
      SET
      estatus='Anulado',
      fechadb=NOW()
      WHERE idpago='$idpago'";
      return ejecutarConsulta($sql);
   }

   public function ActDetalle($idpago){
         $sql="UPDATE tbpagod
         SET anulado='1'
         WHERE idpago='$idpago'";
         return ejecutarConsulta($sql);
   }

    //Funcion Listar Registros Existentes
   public function Listar()
   {
      $sql="SELECT
      p.idpago,
      p.idusuario,
      p.idproveedor,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      p.cod_pago,
      p.desc_pago,
      p.tipo,
      p.origend,
      p.origenc,
      p.estatus,
      p.totalh,
      DATE_FORMAT(p.fechareg,'%d/%m/%Y') AS fechareg,
      pd.idcompra,
      IFNULL(pd.idmovbanco,0) AS idmovbanco,
      IFNULL(mb.idcuenta,0) AS idcuenta,
      IFNULL(pd.idmovcaja,0) AS idmovcaja,
      IFNULL(mc.idcaja,0) AS idcaja
      FROM tbpago AS p
      INNER JOIN tbpagod AS pd ON pd.idpago=p.idpago
      INNER JOIN tbcompra AS c ON c.idcompra=pd.idcompra
      LEFT JOIN tbproveedor AS pv ON pv.idproveedor=c.idproveedor
      LEFT JOIN tbmovbanco AS mb ON mb.idmovbanco=pd.idmovbanco
      LEFT JOIN tbmovcaja AS mc ON mc.idmovcaja=pd.idmovcaja";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Seleccionado
   public function Mostrar($idpago)
   {
      $sql="SELECT 
      p.idpago,p.idproveedor,p.idusuario,pd.idcompra,
      p.cod_pago,p.desc_pago,pv.cod_proveedor,pv.desc_proveedor,
      pv.rif,pv.idoperacion, p.tipo,p.estatus,p.origend,p.origenc,
      DATE_FORMAT(p.fechareg, '%d/%m/%Y') AS fechareg,
      c.cod_compra,
      c.tipo AS optipo,
      c.numerod,
      c.numeroc,
      DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fecharegp,
      DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven,
      (SELECT SUM(saldoh) FROM tbcompra WHERE idproveedor=p.idproveedor) AS saldov,
      (SELECT subtotalh FROM tbcompra WHERE idcompra=c.idcompra) AS subtotalop,
      (SELECT impuestoh FROM tbcompra WHERE idcompra=c.idcompra) AS impuestoh,
      p.totalh AS montoh,
      p.totalh AS montov,
      c.totalh AS totalop,
      c.totalh-p.totalh AS saldoh,
      c.retenciona,
      IFNULL(pd.idmovcaja,0) AS idmovcaja,
      IFNULL(mc.numerod,0) AS numerodc,
      IFNULL(mc.cod_movcaja,0) AS cod_movcaja,
      IFNULL(mc.idcaja,0) AS idcaja,
      IFNULL(cj.cod_caja,0) AS cod_caja,
      IFNULL(pd.idmovbanco,0) AS idmovbanco,
      IFNULL(mb.cod_movbanco,0) AS cod_movbanco,
      IFNULL(mb.numerod,0) AS numerodb,
      IFNULL(mb.numeroc,0) AS numerocb,
      IFNULL(mb.idcuenta,0) AS idcuenta,
      IFNULL(ct.cod_cuenta,0) AS cod_cuenta,
      IFNULL(ct.numcuenta,0) AS numcuenta,
      IFNULL(b.cod_banco,0) AS cod_banco,
      IFNULL(DATE_FORMAT(mb.fechareg, '%d/%m/%Y'), DATE_FORMAT(p.fechareg, '%d/%m/%Y')) AS fecharegb,
      IFNULL(DATE_FORMAT(mc.fechareg, '%d/%m/%Y'), DATE_FORMAT(p.fechareg, '%d/%m/%Y')) AS fecharegc
      FROM
      tbpago AS p 
      INNER JOIN tbpagod AS pd ON pd.idpago = p.idpago 
      INNER JOIN tbcompra AS c ON c.idcompra = pd.idcompra 
      LEFT JOIN tbproveedor AS pv ON pv.idproveedor = c.idproveedor 
      LEFT JOIN tbmovcaja AS mc ON mc.idmovcaja = pd.idmovcaja 
      LEFT JOIN tbcaja AS cj ON cj.idcaja=mc.idcaja
      LEFT JOIN tbmovbanco AS mb ON mb.idmovbanco = pd.idmovbanco
      LEFT JOIN tbcuenta AS ct ON ct.idcuenta=mb.idcuenta
      LEFT JOIN tbbanco AS b ON b.idbanco=ct.idbanco
      WHERE p.idpago='$idpago'";
      return ejecutarConsultaSimpleFila($sql);
   }

   public function ActualizarCompra($idcompra,$cod_pago)
   {
      $sql_comp="UPDATE 
      tbcompra
      SET
      estatus=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago Parc.'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pagado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN 'Registrado'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN 'Registrado'
      END),
      origend=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN 'Pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN tipo
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN tipo
      END),
      origenc=(CASE
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) < totalh 
      AND (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) <> 0 THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = totalh THEN '$cod_pago'
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = 0 THEN ''
      WHEN (IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)) = '' THEN ''
      END),
      saldoh=totalh-(IFNULL((SELECT SUM(montoh) FROM tbPagod WHERE idcompra='$idcompra' AND anulado=0),0)),
      fechadb=NOW()
      WHERE idcompra='$idcompra'";
      return ejecutarConsulta($sql_comp);
   }

   public function ActSaldoCuenta($idcuenta)
   {

      $sql="UPDATE tbcuenta 
      SET 
      saldoh =(SELECT IFNULL(SUM(montoh),0) FROM tbmovbanco WHERE idcuenta='$idcuenta' AND estatus='Registrado'),
      saldod =(SELECT IFNULL(SUM(montod),0) FROM tbmovbanco WHERE idcuenta='$idcuenta' AND estatus='Registrado'),
      saldot = saldod - saldoh
      WHERE idcuenta = '$idcuenta'";
      return ejecutarConsulta($sql);
   }

   public function ActSaldoCaja($idcaja)
   {
      $sql="UPDATE tbcaja
      SET 
      saldoefectivo = (SELECT(IFNULL(SUM(montod),0))-(IFNULL(SUM(montoh),0)) FROM tbmovcaja 
      WHERE idcaja='$idcaja' AND forma='Efectivo' AND (estatus <>'Anulado'AND estatus <>'Eliminado')),
      saldodocumento = (SELECT(IFNULL(SUM(montod),0))-(IFNULL(SUM(montoh),0)) FROM tbmovcaja 
      WHERE idcaja='$idcaja' AND (forma='Cheque' OR forma='Tarjeta') AND (estatus <>'Anulado'AND estatus <>'Eliminado')),
      saldototal = saldoefectivo + saldodocumento
      WHERE idcaja = '$idcaja'";
      return ejecutarConsulta($sql);					
   }

   public function AnularMovBanco($idmovbanco)
   {
      $sql="UPDATE 
      tbmovbanco 
      SET
      estatus='Anulado' 
      WHERE idmovbanco='$idmovbanco'";
      return ejecutarConsulta($sql);
   }

   public function EliminarMovBanco($idmovbanco)
   {
      $sql="UPDATE 
      tbmovbanco 
      SET
      estatus='Eliminado' 
      WHERE idmovbanco='$idmovbanco'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function AnularMovCaja($idmovcaja)
   {
      $sql="UPDATE tbmovcaja 
      SET estatus='Anulado' 
      WHERE idmovcaja='$idmovcaja'";
      return ejecutarConsulta($sql);
   }
  
   //Implementamos Descativar
   public function EliminarMovCaja($idmovcaja)
   {
      $sql="UPDATE tbmovcaja 
      SET estatus='Eliminado' 
      WHERE idmovcaja='$idmovcaja'";
      return ejecutarConsulta($sql);
   }   

   //Funcion Listar Registros Existentes para Selleccion
   public function Select()
   {
      $sql="SELECT 
      idpago, 
      cod_pago, 
      desc_pago,
      estatus
      FROM tbpago 
      WHERE estatus='1'
      ORDER BY cod_pago ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Registros
   public function RptListar()
   {
      $sql="SELECT 
      idpago, 
      cod_pago, 
      desc_pago,
      estatus
      FROM tbpago
      ORDER BY cod_pago ASC";
      return ejecutarConsulta($sql);
   }
}

?>