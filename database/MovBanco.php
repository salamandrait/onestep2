<?php
require "../config/Conexion.php";

class MovBanco{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   public function ActCod()
   {
     $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbmovbanco' AND estatus='1'";
     return ejecutarConsulta($sql);
   }

   //Implementamos Insertar
   public function Insertar($idcuenta,$idoperacion,$idusuario,$cod_movbanco,$desc_movbanco,$tipo,
   $origen,$numerod,$numeroc,$montod,$montoh,$saldoinicial,$fechareg)
   {
      $sql="INSERT INTO tbmovbanco (idcuenta,idoperacion,idusuario,cod_movbanco,desc_movbanco,
      tipo,estatus,origen,numerod,numeroc,montod,montoh,saldoinicial,fechareg,fechadb) 
      VALUES('$idcuenta','$idoperacion','$idusuario','$cod_movbanco','$desc_movbanco','$tipo','Registrado',
      '$origen','$numerod','$numeroc','$montod','$montoh','$saldoinicial',STR_TO_DATE('$fechareg','%d/%m/%Y'),NOW())";
      return ejecutarConsulta($sql);
   }

   //Implementamos Editar
   public function Editar($idmovbanco,$idcuenta,$idoperacion,$idusuario,$cod_movbanco,$desc_movbanco,$tipo,
   $estatus,$origen,$numerod,$numeroc,$montod,$montoh,$saldoinicial,$fechareg)
   {
      $sql="UPDATE 
      tbmovbanco 
      SET
      idcuenta = '$idcuenta',
      idoperacion = '$idoperacion',
      idusuario = '$idusuario',
      cod_movbanco = '$cod_movbanco',
      desc_movbanco = '$desc_movbanco',
      tipo = '$tipo',
      estatus = '$estatus',
      origen = '$origen',
      numerod = '$numerod',
      numeroc = '$numeroc',
      montod = '$montod',
      montoh = '$montoh',
      saldoinicial = '$saldoinicial',
      fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y'),
      fechadb = NOW() 
      WHERE idmovbanco = '$idmovbanco'";
      return ejecutarConsulta($sql);
   }

   public function ActSaldoCuenta($idcuenta)
   {

		$sql="UPDATE tbcuenta 
		SET 
		saldoh =(SELECT IFNULL(SUM(montoh),0) FROM tbmovbanco WHERE idcuenta='$idcuenta' AND estatus<>'Anulado'),
		saldod =(SELECT IFNULL(SUM(montod),0) FROM tbmovbanco WHERE idcuenta='$idcuenta' AND estatus<>'Anulado'),
		saldot = saldod - saldoh
		WHERE idcuenta = '$idcuenta'";
		return ejecutarConsulta($sql);
	}

   //Implementamos Eliminar
   public function Eliminar($idmovbanco)
   {
      $sql="DELETE FROM tbmovbanco 
      WHERE idmovbanco='$idmovbanco'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Anulado($idmovbanco)
   {
      $sql="UPDATE tbmovbanco 
      SET estatus='Anulado' 
      WHERE idmovbanco='$idmovbanco'";
      return ejecutarConsulta($sql);
   } 

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT 
      mb.idmovbanco,mb.idcuenta,mb.idoperacion,mb.idusuario,mb.cod_movbanco,mb.desc_movbanco,
      c.cod_cuenta,c.desc_cuenta,c.numcuenta,c.saldot,b.cod_banco,b.desc_banco,m.cod_moneda,
      m.desc_moneda,op.cod_operacion,op.desc_operacion,u.cod_usuario,u.desc_usuario,
      CASE 
      WHEN mb.tipo = 'NC' THEN 'Nota de Credito' 
      WHEN mb.tipo = 'INT' THEN 'Interes'
      WHEN mb.tipo = 'TPOS' THEN 'Transferencia (+)'
      WHEN mb.tipo = 'DEP' THEN 'Deposito'
      WHEN mb.tipo = 'CHEQ' THEN 'Cheque Emitido (-)'
      WHEN mb.tipo = 'TNEG' THEN 'Transferencia (-)'
      WHEN mb.tipo = 'ND' THEN 'Nota de Debito'
      WHEN mb.tipo = 'ITF' THEN 'Imp TF(-)' END AS tipo,
      mb.estatus,mb.origen,mb.numerod,mb.numeroc,mb.montod,mb.montoh,mb.saldoinicial,
      DATE_FORMAT(mb.fechareg,'%d/%m/%Y') AS fechareg 
      FROM tbmovbanco mb
      INNER JOIN tbcuenta c ON c.idcuenta=mb.idcuenta
      INNER JOIN tbbanco b ON c.idbanco=b.idbanco
      INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
      INNER JOIN tbusuario u ON u.idusuario=mb.idusuario
      INNER JOIN tboperacion op ON op.idoperacion=mb.idoperacion";
      return ejecutarConsulta($sql);
   }

     //Implementamos Mostrar
  public function Mostrar($idmovbanco)
  {
    $sql="SELECT 
    mb.idmovbanco,mb.idcuenta,mb.idoperacion,mb.idusuario,mb.cod_movbanco,mb.desc_movbanco,c.cod_cuenta,
    c.desc_cuenta,b.cod_banco,b.desc_banco,m.cod_moneda,m.desc_moneda,c.numcuenta,c.saldot,op.cod_operacion,
    op.desc_operacion,u.cod_usuario,u.desc_usuario,mb.tipo,mb.estatus,mb.origen,mb.numerod,mb.numeroc,
    mb.montod,mb.montoh,mb.saldoinicial,DATE_FORMAT(mb.fechareg,'%d/%m/%Y') AS fechareg
    FROM tbmovbanco mb
    INNER JOIN tbcuenta c ON c.idcuenta=mb.idcuenta
    INNER JOIN tbbanco b ON c.idbanco=b.idbanco
    INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
    INNER JOIN tbusuario u ON u.idusuario=mb.idusuario
    INNER JOIN tboperacion op ON op.idoperacion=mb.idoperacion 
    WHERE mb.idmovbanco='$idmovbanco'";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementamos Select
  public function Select()
  {
    $sql="SELECT 
    mb.idmovbanco,mb.idcuenta,mb.idoperacion,mb.idusuario,mb.cod_movbanco,mb.desc_movbanco,c.cod_cuenta,
    c.desc_cuenta,b.cod_banco,b.desc_banco,m.cod_moneda,m.desc_moneda,c.numcuenta,c.saldot,op.cod_operacion,
    op.desc_operacion,u.cod_usuario,u.desc_usuario,mb.tipo,mb.estatus,mb.origen,mb.numerod,mb.numeroc,
    mb.montod,mb.montoh,mb.saldoinicial,DATE_FORMAT(mb.fechareg,'%d/%m/%Y') AS fechareg 
    FROM tbmovbanco mb
    INNER JOIN tbcuenta c ON c.idcuenta=mb.idcuenta
    INNER JOIN tbbanco b ON c.idbanco=b.idbanco
    INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
    INNER JOIN tbusuario u ON u.idusuario=mb.idusuario
    INNER JOIN tboperacion op ON op.idoperacion=mb.idoperacio
    ORDER BY mb.cod_movbanco ASC";
    return ejecutarConsulta($sql);
  }

  //Implementamos Listar
  public function RptListar()
  {
    $sql="SELECT 
    mb.idmovbanco,
    mb.idcuenta,
    mb.idoperacion,
    mb.idusuario,
    mb.cod_movbanco,
    mb.desc_movbanco,
    c.cod_cuenta,
    c.desc_cuenta,
    c.numcuenta,
    c.saldot,
    b.cod_banco,
    b.desc_banco,
    m.cod_moneda,
    m.desc_moneda,
    op.cod_operacion,
    op.desc_operacion,
    u.cod_usuario,
    u.desc_usuario,
    CASE 
    WHEN mb.tipo = 'NC' THEN 'Nota de Credito' 
    WHEN mb.tipo = 'INT' THEN 'Interes'
    WHEN mb.tipo = 'TPOS' THEN 'Transferencia (+)'
    WHEN mb.tipo = 'DEP' THEN 'Deposito'
    WHEN mb.tipo = 'CHEQ' THEN 'Cheque Emitido (-)'
    WHEN mb.tipo = 'TNEG' THEN 'Transferencia (-)'
    WHEN mb.tipo = 'ND' THEN 'Nota de Debito'
    WHEN mb.tipo = 'ITF' THEN 'Imp TF(-)' END AS tipo,
    mb.estatus,
    mb.origen,
    mb.numerod,
    mb.numeroc,
    mb.montod,
    mb.montoh,
    mb.saldoinicial,
    DATE_FORMAT(mb.fechareg,'%d/%m/%Y') AS fechareg 
    FROM tbmovbanco mb
    INNER JOIN tbcuenta c ON c.idcuenta=mb.idcuenta
    INNER JOIN tbbanco b ON c.idbanco=b.idbanco
    INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
    INNER JOIN tbusuario u ON u.idusuario=mb.idusuario
    INNER JOIN tboperacion op ON op.idoperacion=mb.idoperacion
    ORDER BY mb.cod_movbanco ASC";
    return ejecutarConsulta($sql);
  }

}

?>