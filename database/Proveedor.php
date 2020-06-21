<?php
require "../config/Conexion.php";

class Proveedor{

   //Implementamos nuestro constructor 
   public function __construct()
   {   
   }

   //funcion para Insertar Registros
   public function Insertar($idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoi,$cod_proveedor,$desc_proveedor,
   $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten)
   {
      $sql="INSERT INTO tbproveedor (idtipoproveedor,idoperacion,idcondpago,idzona,idimpuestoi,cod_proveedor,desc_proveedor,rif,
      direccion,ciudad,codpostal,contacto,telefono,movil,email,web,limite,montofiscal,fechareg,aplicareten,estatus) 
      VALUES('$idtipoproveedor','$idoperacion','$idcondpago','$idzona','$idimpuestoi','$cod_proveedor','$desc_proveedor','$rif',
      '$direccion','$ciudad','$codpostal','$contacto','$telefono','$movil','$email','$web',REPLACE('$limite',',',''),'$montofiscal',
      STR_TO_DATE('$fechareg','%d/%m/%Y'),'$aplicareten','1')";
      return ejecutarConsulta($sql);
   }

   public function InsertarDirecto($cod_proveedor,$rif,$desc_proveedor){
      $sql="INSERT INTO tbproveedor(cod_proveedor,rif,desc_proveedor,idtipoproveedor,idoperacion,idcondpago,idzona,
      idimpuestoi,fechareg,estatus)
      VALUES('$cod_proveedor','$rif','$desc_proveedor',
      (SELECT MAX(idtipoproveedor) FROM tbtipoproveedor),
      (SELECT MAX(idoperacion) FROM tboperacion WHERE escompra='1'),
      (SELECT MIN(idcondpago) FROM tbcondpago),
      (SELECT MIN(idzona) FROM tbzona),
      (SELECT idimpuestoi FROM tbimpuestoi WHERE idimpuestoi='3'), DATE(NOW()),'1')";
      return ejecutarConsulta($sql);   
   }

   //funcion para Editar Registros
   public function Editar($idproveedor,$idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoi,$cod_proveedor,$desc_proveedor,
   $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten)
   {
      $sql="UPDATE 
      tbproveedor 
      SET
      idtipoproveedor = '$idtipoproveedor',
      idoperacion = '$idoperacion',
      idcondpago='$idcondpago',
      idzona = '$idzona',
      idimpuestoi='$idimpuestoi',
      cod_proveedor = '$cod_proveedor',
      desc_proveedor = '$desc_proveedor',
      rif = '$rif',
      direccion = '$direccion',
      ciudad = '$ciudad',
      codpostal = '$codpostal',
      contacto = '$contacto',
      telefono = '$telefono',
      movil = '$movil',
      email = '$email',
      web = '$web',
      limite = REPLACE('$limite',',',''),
      montofiscal = '$montofiscal',
      fechareg = STR_TO_DATE('$fechareg','%d/%m/%Y'),
      aplicareten = '$aplicareten'
      WHERE idproveedor = '$idproveedor'";
      return ejecutarConsulta($sql);
   }

   //funcion para Eliminar Registros
   public function Eliminar($idproveedor)
   {
      $sql="DELETE FROM tbproveedor 
      WHERE idproveedor='$idproveedor'";
      return ejecutarConsulta($sql);
   }

   //funcion para Activar Registros Inactivos
   public function Activar($idproveedor)
   {
      $sql="UPDATE tbproveedor 
      SET estatus='1' 
      WHERE idproveedor='$idproveedor'";
      return ejecutarConsulta($sql);
   }

   //funcion para Desactivar Registros Activos
   public function Desactivar($idproveedor)
   {
      $sql="UPDATE tbproveedor 
      SET estatus='0' 
      WHERE idproveedor='$idproveedor'";
      return ejecutarConsulta($sql);
   } 

   //funcion para Listar Registros Ingresados
   public function Listar()
   {
      $sql="SELECT 
      pv.idproveedor,
      pv.idtipoproveedor,
      pv.idoperacion,
      pv.idcondpago,
      pv.idzona,
      pv.idimpuestoi,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.direccion,
      pv.ciudad,
      pv.codpostal,
      pv.contacto,
      pv.telefono,
      pv.movil,
      pv.email,
      pv.web,
      pv.limite,
      pv.montofiscal,
      DATE_FORMAT(pv.fechareg, '%d/%m/%Y') AS fechareg,
      pv.aplicareten,
      pv.estatus,
      tc.cod_tipoproveedor,
      tc.desc_tipoproveedor,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbcompra WHERE idproveedor = pv.idproveedor AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbproveedor AS pv 
      INNER JOIN tbtipoproveedor AS tc ON (pv.idtipoproveedor = tc.idtipoproveedor) 
      INNER JOIN tboperacion AS t ON (pv.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (pv.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (pv.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = pv.idimpuestoi)";
      return ejecutarConsulta($sql);
   }

   //funcion para Mostrar Registros 
   public function Mostrar($idproveedor)
   {
      $sql="SELECT 
      pv.idproveedor,
      pv.idtipoproveedor,
      pv.idoperacion,
      pv.idcondpago,
      pv.idzona,
      pv.idimpuestoi,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.direccion,
      pv.ciudad,
      pv.codpostal,
      pv.contacto,
      pv.telefono,
      pv.movil,
      pv.email,
      pv.web,
      pv.limite,
      pv.montofiscal,
      DATE_FORMAT(pv.fechareg, '%d/%m/%Y') AS fechareg,
      pv.aplicareten,
      pv.estatus,
      tc.cod_tipoproveedor,
      tc.desc_tipoproveedor,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbcompra WHERE idproveedor = pv.idproveedor AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbproveedor AS pv 
      INNER JOIN tbtipoproveedor AS tc ON (pv.idtipoproveedor = tc.idtipoproveedor) 
      INNER JOIN tboperacion AS t ON (pv.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (pv.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (pv.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = pv.idimpuestoi) 
      WHERE pv.idproveedor='$idproveedor'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //funcion para Seleccionar Registros
   public function Select()
   {
      $sql="SELECT 
      pv.idproveedor,
      pv.idtipoproveedor,
      pv.idoperacion,
      pv.idcondpago,
      pv.idzona,
      pv.idimpuestoi,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.direccion,
      pv.ciudad,
      pv.codpostal,
      pv.contacto,
      pv.telefono,
      pv.movil,
      pv.email,
      pv.web,
      pv.limite,
      pv.montofiscal,
      DATE_FORMAT(pv.fechareg, '%d/%m/%Y') AS fechareg,
      pv.aplicareten,
      pv.estatus,
      tc.cod_tipoproveedor,
      tc.desc_tipoproveedor,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbcompra WHERE idproveedor = pv.idproveedor AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbproveedor AS pv 
      INNER JOIN tbtipoproveedor AS tc ON (pv.idtipoproveedor = tc.idtipoproveedor) 
      INNER JOIN tboperacion AS t ON (pv.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (pv.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (pv.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = pv.idimpuestoi) 
      WHERE pv.estatus='1'
      ORDER BY pv.cod_proveedor ASC";
      return ejecutarConsulta($sql);
   }

   //funcion para Emitir Reporte General de Registros
   public function RptListar()
   {
      $sql="SELECT 
      pv.idproveedor,
      pv.idtipoproveedor,
      pv.idoperacion,
      pv.idcondpago,
      pv.idzona,
      pv.idimpuestoi,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.direccion,
      pv.ciudad,
      pv.codpostal,
      pv.contacto,
      pv.telefono,
      pv.movil,
      pv.email,
      pv.web,
      pv.limite,
      pv.montofiscal,
      DATE_FORMAT(pv.fechareg, '%d/%m/%Y') AS fechareg,
      pv.aplicareten,
      pv.estatus,
      tc.cod_tipoproveedor,
      tc.desc_tipoproveedor,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbcompra WHERE idproveedor = pv.idproveedor AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbproveedor AS pv 
      INNER JOIN tbtipoproveedor AS tc ON (pv.idtipoproveedor = tc.idtipoproveedor) 
      INNER JOIN tboperacion AS t ON (pv.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (pv.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (pv.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = pv.idimpuestoi)
      ORDER BY pv.cod_proveedor ASC";
      return ejecutarConsulta($sql);
   }

}

?>