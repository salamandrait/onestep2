<?php
require '../config/Conexion.php';

class Compra{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Funcion para Generar Codigo automatico segun tipo de documento
   public function GenerarCod($ftipo)
   {
     if ($ftipo=='Cotizacion') {
       $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum,estatus
       FROM tbcorrelativo WHERE tabla='tbccompra'";
       return ejecutarConsultaSimpleFila($sql);
     } elseif ($ftipo=='Pedido') {
       $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum ,estatus
       FROM tbcorrelativo WHERE tabla='tbpcompra'";
       return ejecutarConsultaSimpleFila($sql);
     } elseif ($ftipo=='Factura') {
       $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum ,estatus
       FROM tbcorrelativo WHERE tabla='tbfcompra'";
       return ejecutarConsultaSimpleFila($sql);
     }
   }

   //Funcion para Actualizar Codigo automatico segun tipo de documento
   public function ActCod($tipo)
   {
      if ($tipo=='Cotizacion') {
      
         $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbccompra'";
         return ejecutarConsulta($sql);
      
      } else if ($tipo=='Pedido'){
      
         $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbpcompra'";
         return ejecutarConsulta($sql);
      
      } else if ($tipo=='Factura'){
      
         $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbfcompra'";
         return ejecutarConsulta($sql);
      }
   }

   //Funcion Insertar
   public function Insertar($idproveedor,$idcondpago,$idusuario,$cod_compra,$desc_compra,$numerod,$numeroc,$tipo,$origend,
   $origenc,$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,$idarticulo,$iddeposito,$idartunidad,$cantidad,$costo,$tasa){

      $sql="INSERT INTO tbcompra(idproveedor,idcondpago,idusuario,cod_compra,desc_compra,numerod,
      numeroc,tipo,origend,origenc,subtotalh,impuestoh,totalh,saldoh,fechareg,fechaven,estatus,fechadb)
      VALUES('$idproveedor','$idcondpago','$idusuario','$cod_compra','$desc_compra','$numerod',
      '$numeroc','$tipo','$origend','$origenc','$subtotalh','$impuestoh','$totalh','$saldoh',
      STR_TO_DATE('$fechareg','%d/%m/%Y'),STR_TO_DATE('$fechaven','%d/%m/%Y'),'Registrado',NOW())";
      $idcompra=ejecutarConsulta_retornarID($sql);  

         $num_elementos=0;
         $sw=true;

      while ($num_elementos < count($idarticulo))
      {
         $sql_detalle ="INSERT INTO tbcomprad (idcompra,idarticulo,iddeposito,idartunidad,cantidad,costo,tasa) 
         VALUES ('$idcompra','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$idartunidad[$num_elementos]',
         '$cantidad[$num_elementos]','$costo[$num_elementos]','$tasa[$num_elementos]')";
         ejecutarConsulta($sql_detalle) or $sw = false;
         $num_elementos=$num_elementos + 1;
      }
      return $sw;
   }

   //Funcion Actualizar Stock en Inventario al Ingresar Documento
   public function AddStockArt($idarticulo,$disp,$tipo,$iddeposito,$cantidad,$valor)
   {
      $num_elementos=0;
      $sw=true;

      while ($num_elementos < count($idarticulo)) 
      {
         switch ($disp[$num_elementos]) {
            
            case 'null':
               if ($tipo[$num_elementos]!='Servicio') {
         
                  $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
                  SELECT '$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',($cantidad[$num_elementos]*$valor[$num_elementos])
                  FROM DUAL WHERE NOT EXISTS (SELECT idarticulo,iddeposito FROM tbstock 
                  WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]')";
                  ejecutarConsulta($sql_detalle) or $sw = false;
               }
               $num_elementos=$num_elementos + 1;
            break;
            
            default:
               $sql_detalle ="UPDATE tbstock SET
               cantidad=cantidad +('$cantidad[$num_elementos]'*'$valor[$num_elementos]')
               WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'
               AND (SELECT tipo FROM tbarticulo WHERE idarticulo='$idarticulo[$num_elementos]')<>'Servicio'";
               ejecutarConsulta($sql_detalle) or $sw = false;
               $num_elementos=$num_elementos + 1;
            break;
         }
      }
      return $sw;
   }

   //Funcion para Actualizar el Costo de los Articulos
	public function ActualizarCosto($idarticulo,$costo,$valor)
	{	
		$num_elementos=0;
		$sw=true;
	
		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle ="UPDATE 
			tbarticulo SET
			costo=$costo[$num_elementos]/$valor[$num_elementos]
			WHERE idarticulo='$idarticulo[$num_elementos]'";
			ejecutarConsulta($sql_detalle) or $sw = false;
         $num_elementos=$num_elementos + 1;
		}
		return $sw;			
   }

   //Funcion Anular Stock en Inventario y asi Desparar Trigger tr_AjStockCompra
   public function ActDetalle($idcompra)
	{
		$sql="UPDATE tbcomprad
      SET 
      anulado='1',
      importado='0'
      WHERE idcompra='$idcompra'";
		return ejecutarConsulta($sql);		
   }

   //Funcion Anular Stock en Inventario Mediante Trigger sql en documentos Importados
   public function ActDetalleImp($idcompraop,$origenc)
   {
      $sql="UPDATE tbcomprad
      SET 
      importado='$origenc'
      WHERE idcompra='$idcompraop'";
      return ejecutarConsulta($sql);  	
   }

   //Funcion Actualizar Documento Importado
   public function ProcesarDocumentoImp($idcompra)
   {
      $sql_detalle="UPDATE tbcompra
      SET 
      estatus='Procesado',
      saldoh=0,
      fechadb=NOW()
      WHERE idcompra='$idcompra'";
      return ejecutarConsulta($sql_detalle);  
   }

   //Funcion Eliminar Compra
   public function Eliminar($idcompra)
   {
      $sql="DELETE FROM tbcompra
      WHERE idcompra='$idcompra'";
      return ejecutarConsulta($sql);
   }

   //Funcion Anular Compra
   public function Anular($idcompra)
   {
     $sql="UPDATE tbcompra 
     SET estatus='Anulado',
     saldoh=0,
     fechadb=NOW() 
     WHERE idcompra='$idcompra'";
     return ejecutarConsulta($sql);
   }

   //Funcion Restablecer Documento Marcado como Procesado
   public function AnularProcesarDocumentoImp($origenc,$origend,$totalh)
   {
      $sql="UPDATE tbcompra
      SET 
      estatus='Registrado',
      saldoh='$totalh',
      fechadb=NOW()
      WHERE idcompra=(SELECT idcompra FROM tbcompra WHERE cod_compra='$origenc' AND tipo='$origend')";
      return ejecutarConsulta($sql);
   }

   //Funcion Listar Documentos
   public function Listar($tipo)
   {
      $sql="SELECT 
      c.idcompra,
      c.idproveedor,
      c.idcondpago,
      c.idusuario,
      c.cod_compra,
      c.desc_compra,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      u.cod_usuario,
      u.desc_usuario,
      c.numerod,
      c.numeroc,
      c.tipo,
      c.origend,
      c.origenc,
      c.estatus,
      c.subtotalh,
      c.impuestoh,
      c.totalh,
      c.saldoh,
      DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven
      FROM
      tbcompra AS c 
      INNER JOIN tbproveedor AS pv ON (c.idproveedor = pv.idproveedor) 
      INNER JOIN tbcondpago AS cp ON (c.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (c.idusuario = u.idusuario)
      WHERE c.tipo='$tipo'";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Documentos
   public function Mostrar($idcompra)
   {
      $sql="SELECT 
      c.idcompra,
      c.idproveedor,
      c.idcondpago,
      c.idusuario,
      c.cod_compra,
      c.desc_compra,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      u.cod_usuario,
      u.desc_usuario,
      c.numerod,
      c.numeroc,
      c.tipo,
      c.origend,
      c.origenc,
      c.estatus,
      c.subtotalh,
      c.impuestoh,
      c.totalh,
      c.saldoh,
      DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbcompra AS c 
      INNER JOIN tbproveedor AS pv ON (c.idproveedor = pv.idproveedor) 
      INNER JOIN tbcondpago AS cp ON (c.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (c.idusuario = u.idusuario) 
      WHERE c.idcompra='$idcompra'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Funcion Mostrar Detalle de Documentos
   public function MostrarDetalle($idcompra){

     $sql="SELECT
     dc.idcomprad,
     dc.idarticulo,
     dc.iddeposito,
     dc.idartunidad,
     a.cod_articulo,
     a.desc_articulo,
     u.desc_unidad,
     a.tipo,
     dc.cantidad,
     CONVERT(dc.costo,DECIMAL(12,2)) AS costo,
     CONVERT(dc.tasa,DECIMAL(12,0)) AS tasa,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito=dc.iddeposito AND idarticulo=a.idarticulo),0) AS disp,
     au.valor
     FROM tbcomprad dc 
     INNER JOIN tbarticulo a ON a.idarticulo=dc.idarticulo
     INNER JOIN tbartunidad au ON au.idartunidad=dc.idartunidad
     INNER JOIN tbunidad u ON u.idunidad=au.idunidad
     WHERE dc.idcompra='$idcompra'";
     return ejecutarConsulta($sql);
   }

   //Funcion  Mostrar Documentos a Importar
   public function ImportarDocumento($idproveedor='',$estatus,$tipo)
   {
      $sql="SELECT 
      c.idcompra AS idcompraop ,c.idproveedor,c.cod_compra AS origenc ,c.estatus,pv.cod_proveedor,pv.desc_proveedor,
      pv.rif,c.idcondpago,pv.limite,cp.cod_condpago,cp.desc_condpago,cp.dias,c.tipo,c.numerod,c.totalh,
      DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg, DATE_FORMAT(c.fechaven,'%d/%m/%Y') AS fechaven
      FROM tbcompra c
      INNER JOIN tbproveedor pv ON pv.idproveedor=c.idproveedor
      INNER JOIN tbcondpago cp ON cp.idcondpago =c.idcondpago
      AND 
      ('$idproveedor'='' OR c.idproveedor='$idproveedor')
      AND (c.tipo='$tipo') 
      AND ( ('$estatus'='todos' AND c.estatus<>'Anulado')
      OR('$estatus'='sinp' AND c.estatus<>'Anulado' AND c.estatus<>'Procesado'))";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar detalle de Documentos a Importar
   public function ImportarDetalle($idcompra){

     $sql="SELECT
     dc.idcomprad,
     dc.idarticulo,
     dc.iddeposito,
     dc.idartunidad,
     a.cod_articulo,
     a.desc_articulo,
     u.desc_unidad,
     a.tipo,
     dc.cantidad,
     CONVERT(dc.costo,DECIMAL(12,2)) AS costo,
     CONVERT(dc.tasa,DECIMAL(12,0)) AS tasa,
     IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito=dc.iddeposito AND idarticulo=a.idarticulo),'null') AS disp,
     au.valor
     FROM tbcomprad dc 
     INNER JOIN tbarticulo a ON a.idarticulo=dc.idarticulo
     INNER JOIN tbartunidad au ON au.idartunidad=dc.idartunidad
     INNER JOIN tbunidad u ON u.idunidad=au.idunidad
     WHERE dc.idcompra='$idcompra'";
     return ejecutarConsulta($sql);
   }

   //Funcion Seleccionar Documentos
   public function Select(){
      $sql="SELECT 
      c.idcompra,
      c.idproveedor,
      c.idcondpago,
      c.idusuario,
      c.cod_compra,
      c.desc_compra,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      u.cod_usuario,
      u.desc_usuario,
      c.numerod,
      c.numeroc,
      c.tipo,
      c.origend,
      c.origenc,
      c.estatus,
      c.subtotalh,
      c.impuestoh,
      c.totalh,
      c.saldoh,
      DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbcompra AS c 
      INNER JOIN tbproveedor AS pv ON (c.idproveedor = pv.idproveedor) 
      INNER JOIN tbcondpago AS cp ON (c.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (c.idusuario = u.idusuario) 
      WHERE c.estatus='1'
      ORDER BY c.cod_compra ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Reporte General de Documentos
   public function RptListar(){
      $sql="SELECT 
      c.idcompra,
      c.idproveedor,
      c.idcondpago,
      c.idusuario,
      c.cod_compra,
      c.desc_compra,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.limite,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      u.cod_usuario,
      u.desc_usuario,
      c.numerod,
      c.numeroc,
      c.tipo,
      c.origend,
      c.origenc,
      c.estatus,
      c.subtotalh,
      c.impuestoh,
      c.totalh,
      c.saldoh,
      DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fechareg,
      DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven 
      FROM
      tbcompra AS c 
      INNER JOIN tbproveedor AS pv ON (c.idproveedor = pv.idproveedor) 
      INNER JOIN tbcondpago AS cp ON (c.idcondpago = cp.idcondpago) 
      INNER JOIN tbusuario AS u ON (c.idusuario = u.idusuario)
      ORDER BY c.cod_compra ASC";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Reporte Documento de Compra
   public function RptCompraH($idcompra){
         $sql="SELECT 
         c.idcompra,
         c.idproveedor,
         c.idcondpago,
         c.idusuario,
         c.cod_compra,
         c.desc_compra,
         pv.cod_proveedor,
         pv.desc_proveedor,
         pv.rif,
         pv.direccion,
         pv.telefono,
         pv.movil,
         pv.contacto,
         pv.email,
         pv.web,
         cp.cod_condpago,
         cp.desc_condpago,
         cp.dias,
         u.cod_usuario,
         u.desc_usuario,
         c.numerod,
         c.numeroc,
         c.tipo,
         c.origend,
         c.origenc,
         c.estatus,
         c.subtotalh,
         c.impuestoh,
         c.totalh,
         c.saldoh,
         DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fechareg,
         DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven 
         FROM
         tbcompra AS c 
         INNER JOIN tbproveedor AS pv ON (c.idproveedor = pv.idproveedor) 
         INNER JOIN tbcondpago AS cp ON (c.idcondpago = cp.idcondpago) 
         INNER JOIN tbusuario AS u ON (c.idusuario = u.idusuario) 
         WHERE c.idcompra='$idcompra'";
      return ejecutarConsulta($sql);
   }

   //Funcion Mostrar Detalle de Reporte Documento de Compra
   public function RptCompraD($idcompra){
      $sql="SELECT
      cd.idcomprad,
      cd.idarticulo,
      cd.iddeposito,
      a.cod_articulo, 
      a.desc_articulo,
      d.cod_deposito,
      d.desc_deposito,
      cd.tasa,
      CONVERT(cd.cantidad, DECIMAL(12,0)) AS cantidad,
      CONVERT(cd.costo, DECIMAL(12,2)) AS costo,
      CONVERT(cd.costo * cd.cantidad, DECIMAL(12,2)) AS subtotald,
      CONVERT(((cd.costo * cd.cantidad) * cd.tasa)/100, DECIMAL(12,2)) AS impsubd,
      CONVERT((((cd.costo * cd.cantidad) * cd.tasa)/100) + (cd.costo * cd.cantidad), DECIMAL(12,2)) AS totald
      FROM tbcomprad cd
      INNER JOIN tbarticulo a ON a.idarticulo=cd.idarticulo
      INNER JOIN tbdeposito d ON d.iddeposito=cd.iddeposito
      WHERE cd.idcompra ='$idcompra'";
      return ejecutarConsulta($sql);
   }

   public function SelectProveedorOp(){
      
    $sql="SELECT c.idcompra,c.idproveedor,p.idoperacion,p.cod_proveedor,p.desc_proveedor,p.rif,
    SUM(c.saldoh) AS saldoh,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    DATE_FORMAT(c.fechaven,'%d/%m/%Y') AS fechaven
    FROM
    tbcompra c
    INNER JOIN tbproveedor p ON (p.idproveedor=c.idproveedor)
    WHERE c.saldoh<>0
    GROUP BY c.idproveedor";
    return ejecutarConsulta($sql);
   }

   public function SelectOp($idproveedor){

      $sql="SELECT 
      c.idcompra,
      c.idproveedor,
      c.cod_compra,
      c.tipo,
      c.numerod,
      c.numeroc,
      c.estatus,
      c.subtotalh,
      c.impuestoh,
      c.totalh,
      c.totalh-c.saldoh AS abono,
      c.saldoh AS saldo,
      DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fecharegl,
      DATE_FORMAT(c.fechaven,'%d/%m/%Y') AS fechavenl,
      (SELECT esfiscal FROM tbempresa) AS esfiscal,
      (SELECT montofiscal FROM tbempresa) AS montofiscal,
      c.retenciona
      FROM tbcompra c
      INNER JOIN tbproveedor pv ON pv.idproveedor=c.idproveedor
      WHERE c.saldoh<> 0 AND c.idproveedor='$idproveedor'";
      return ejecutarConsulta($sql);
   }
}
?>
