<?php
require '../Config/Conexion.php';

class Escritorio{

   public function __construct() {

   }

    public function TotalStockCategoria()
    {
        $sql="SELECT      
        c.desc_categoria AS categoria,
        CONVERT((SUM(cantidad)*100)/(SELECT SUM(cantidad) FROM tbstock WHERE cantidad>0),DECIMAL(3,0)) AS stockp, 
        SUM(CONVERT(cantidad,INT)) AS stockn
        FROM tbstock s
        INNER JOIN tbarticulo a ON a.idarticulo=s.idarticulo
        INNER JOIN tbcategoria c ON c.idcategoria=a.idcategoria
        WHERE s.cantidad>0
        GROUP BY a.idcategoria
        ORDER BY desc_categoria";
        return ejecutarConsulta($sql);
    }

    public function TotalStockArticulo()
    {
        $sql="SELECT COUNT(s.idarticulo) AS art,
        CONVERT(SUM(s.cantidad),INT) AS stock
        FROM tbstock s
        INNER JOIN tbarticulo a ON a.idarticulo=s.idarticulo
        WHERE s.cantidad<>0";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function ArticuloMasVentas() 
    {
        $sql="SELECT vd.idarticulo,
        a.desc_articulo AS descart,
        cantidad
        FROM tbventa v
        INNER JOIN tbventad vd ON vd.idventa=v.idventa
        INNER JOIN tbarticulo a ON a.idarticulo=vd.idarticulo
        WHERE v.estatus<>'Anulado' AND v.tipo='Factura'
        GROUP BY cod_venta
        ORDER BY vd.cantidad DESC
        LIMIT 0,10";
        return ejecutarConsulta($sql);
    }

    public function TotalClientes()
    {
        $sql="SELECT
        COUNT(IFNULL(idcliente,0)) AS totalcl,
        (SELECT SUM(IFNULL(saldoh,0)) FROM tbventa WHERE tipo <> 'Cotizacion' AND estatus <> 'Anulado') AS saldot
        FROM tbcliente";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function Ultimas10Ventas() {
        $sql="SELECT
        CASE 
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=1 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Ene')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=2 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Feb')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=3 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Mar')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=4 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Abr')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=5 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','May')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=6 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Jun')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=7 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Jul')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=8 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Ago')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=9 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Seb')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=10 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Oct')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=11 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Nov')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=12 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Dic')
        END AS fecha,
        SUM(totalh) AS totalh
        FROM tbventa
        WHERE tipo<>'Cotizacion' 
        AND estatus<>'Anulado'
        GROUP BY fechareg
        ORDER BY fechareg ASC
        LIMIT 0,10";
        return ejecutarConsulta($sql);
    }

    public function TotalPedidosV()
    {
        $sql="SELECT COUNT(idventa) AS totalp,
        IFNULL(SUM(saldoh),0) AS saldoh
        FROM tbventa 
        WHERE tipo='Pedido' AND saldoh<>0";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function TotalFacturasV()
    {
        $sql="SELECT COUNT(idventa) AS totalf,
        IFNULL(SUM(saldoh),0) AS saldoh
        FROM tbventa 
        WHERE tipo='Factura' AND saldoh<>0";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function TotalProveedores()
    {
        $sql="SELECT
        COUNT(IFNULL(idproveedor,0)) AS totalpv,
        (SELECT SUM(IFNULL(saldoh,0)) FROM tbcompra 
        WHERE tipo <> 'Cotizacion' AND estatus <> 'Anulado') AS saldot
        FROM tbproveedor";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function TotalPedidosC()
    {
        $sql="SELECT COUNT(idcompra) AS totalp,
        IFNULL(SUM(saldoh),0) AS saldoh
        FROM tbcompra 
        WHERE tipo='Pedido' AND saldoh<>0";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function TotalFacturasC()
    {
        $sql="SELECT COUNT(idcompra) AS totalf,
        IFNULL(SUM(saldoh),0) AS saldoh
        FROM tbcompra 
        WHERE tipo='Factura' AND saldoh<>0";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function Ultimas10Compras() {
        $sql="SELECT
        CASE 
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=1 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Ene')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=2 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Feb')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=3 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Mar')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=4 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Abr')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=5 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','May')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=6 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Jun')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=7 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Jul')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=8 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Ago')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=9 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Seb')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=10 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Oct')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=11 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Nov')
        WHEN LEFT(DATE_FORMAT(fechareg,'%m-%Y'),2)=12 THEN CONCAT((LEFT(DATE_FORMAT(fechareg,'%d-%m-%Y'),2)),'-','Dic')
        END AS fecha,
        SUM(totalh) AS totalh
        FROM tbcompra
        WHERE tipo<>'Cotizacion' 
        AND estatus<>'Anulado'
        GROUP BY fechareg
        ORDER BY fechareg ASC
        LIMIT 0,10";
        return ejecutarConsulta($sql);
    }


   // public function __construct() {

   // }
   // public function __construct() {

   // }
}
?>