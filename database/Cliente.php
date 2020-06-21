<?php
require "../config/Conexion.php";

class Cliente{

   //Implementamos nuestro constructor 
   public function __construct()
   {   
   }

   //funcion para Insertar Registros
   public function Insertar($idvendedor,$idtipocliente,$idoperacion,$idcondpago,$idzona,$idimpuestoi,$cod_cliente,$desc_cliente,
   $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten)
   {
      $sql="INSERT INTO tbcliente (idvendedor,idtipocliente,idoperacion,idcondpago,idzona,idimpuestoi,cod_cliente,desc_cliente,rif,
      direccion,ciudad,codpostal,contacto,telefono,movil,email,web,limite,montofiscal,fechareg,aplicareten,estatus) 
      VALUES('$idvendedor','$idtipocliente','$idoperacion','$idcondpago','$idzona','$idimpuestoi','$cod_cliente','$desc_cliente','$rif',
      '$direccion','$ciudad','$codpostal','$contacto','$telefono','$movil','$email','$web',REPLACE('$limite',',',''),'$montofiscal',
      STR_TO_DATE('$fechareg','%d/%m/%Y'),'$aplicareten','1')";
      return ejecutarConsulta($sql);
   }

   public function InsertarDirecto($cod_cliente,$rif,$desc_cliente){
      $sql="INSERT INTO tbcliente(cod_cliente,rif,desc_cliente,idtipocliente,idoperacion,idcondpago,idzona,idvendedor,
      idimpuestoi,fechareg,estatus)
      VALUES('$cod_cliente','$rif','$desc_cliente',
      (SELECT MAX(idtipocliente) FROM tbtipocliente),
      (SELECT MAX(idoperacion) FROM tboperacion WHERE esventa='1'),
      (SELECT MIN(idcondpago) FROM tbcondpago),
      (SELECT MIN(idzona) FROM tbzona),
      (SELECT MIN(idvendedor) FROM tbvendedor),
      (SELECT idimpuestoi FROM tbimpuestoi WHERE idimpuestoi='3'), DATE(NOW()),'1')";
      return ejecutarConsulta($sql);   
   }

   //funcion para Editar Registros
   public function Editar($idcliente,$idvendedor,$idtipocliente,$idoperacion,$idcondpago,$idzona,$idimpuestoi,$cod_cliente,$desc_cliente,
   $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten)
   {
      $sql="UPDATE 
      tbcliente 
      SET
      idvendedor='$idvendedor',
      idtipocliente = '$idtipocliente',
      idoperacion = '$idoperacion',
      idcondpago='$idcondpago',
      idzona = '$idzona',
      idimpuestoi='$idimpuestoi',
      cod_cliente = '$cod_cliente',
      desc_cliente = '$desc_cliente',
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
      WHERE idcliente = '$idcliente'";
      return ejecutarConsulta($sql);
   }

   //funcion para Eliminar Registros
   public function Eliminar($idcliente)
   {
      $sql="DELETE FROM tbcliente 
      WHERE idcliente='$idcliente'";
      return ejecutarConsulta($sql);
   }

   //funcion para Activar Registros Inactivos
   public function Activar($idcliente)
   {
      $sql="UPDATE tbcliente 
      SET estatus='1' 
      WHERE idcliente='$idcliente'";
      return ejecutarConsulta($sql);
   }

   //funcion para Desactivar Registros Activos
   public function Desactivar($idcliente)
   {
      $sql="UPDATE tbcliente 
      SET estatus='0' 
      WHERE idcliente='$idcliente'";
      return ejecutarConsulta($sql);
   } 

   //funcion para Listar Registros Ingresados
   public function Listar()
   {
      $sql="SELECT 
      cl.idcliente,
      cl.idvendedor,
      cl.idtipocliente,
      cl.idoperacion,
      cl.idcondpago,
      cl.idzona,
      cl.idimpuestoi,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.direccion,
      cl.ciudad,
      cl.codpostal,
      cl.contacto,
      cl.telefono,
      cl.movil,
      cl.email,
      cl.web,
      cl.limite,
      cl.montofiscal,
      DATE_FORMAT(cl.fechareg, '%d/%m/%Y') AS fechareg,
      cl.aplicareten,
      cl.estatus,
      v.cod_vendedor,
      v.desc_vendedor,
      tc.cod_tipocliente,
      tc.desc_tipocliente,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbventa WHERE idcliente = cl.idcliente AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbcliente AS cl
      INNER JOIN tbvendedor AS v ON (cl.idvendedor = v.idvendedor) 
      INNER JOIN tbtipocliente AS tc ON (cl.idtipocliente = tc.idtipocliente) 
      INNER JOIN tboperacion AS t ON (cl.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (cl.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (cl.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = cl.idimpuestoi)";
      return ejecutarConsulta($sql);
   }

   //funcion para Mostrar Registros 
   public function Mostrar($idcliente)
   {
      $sql="SELECT 
      cl.idcliente,
      cl.idvendedor,
      cl.idtipocliente,
      cl.idoperacion,
      cl.idcondpago,
      cl.idzona,
      cl.idimpuestoi,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.direccion,
      cl.ciudad,
      cl.codpostal,
      cl.contacto,
      cl.telefono,
      cl.movil,
      cl.email,
      cl.web,
      cl.limite,
      cl.montofiscal,
      DATE_FORMAT(cl.fechareg, '%d/%m/%Y') AS fechareg,
      cl.aplicareten,
      cl.estatus,
      v.cod_vendedor,
      v.desc_vendedor,
      tc.cod_tipocliente,
      tc.desc_tipocliente,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbventa WHERE idcliente = cl.idcliente AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbcliente AS cl
      INNER JOIN tbvendedor AS v ON (cl.idvendedor = v.idvendedor) 
      INNER JOIN tbtipocliente AS tc ON (cl.idtipocliente = tc.idtipocliente) 
      INNER JOIN tboperacion AS t ON (cl.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (cl.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (cl.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = cl.idimpuestoi) 
      WHERE cl.idcliente='$idcliente'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //funcion para Seleccionar Registros
   public function Select()
   {
      $sql="SELECT 
      cl.idcliente,
      cl.idvendedor,
      cl.idtipocliente,
      cl.idoperacion,
      cl.idcondpago,
      cl.idzona,
      cl.idimpuestoi,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.direccion,
      cl.ciudad,
      cl.codpostal,
      cl.contacto,
      cl.telefono,
      cl.movil,
      cl.email,
      cl.web,
      cl.limite,
      cl.montofiscal,
      DATE_FORMAT(cl.fechareg, '%d/%m/%Y') AS fechareg,
      cl.aplicareten,
      cl.estatus,
      v.cod_vendedor,
      v.desc_vendedor,
      tc.cod_tipocliente,
      tc.desc_tipocliente,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbventa WHERE idcliente = cl.idcliente AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbcliente AS cl
      INNER JOIN tbvendedor AS v ON (cl.idvendedor = v.idvendedor) 
      INNER JOIN tbtipocliente AS tc ON (cl.idtipocliente = tc.idtipocliente) 
      INNER JOIN tboperacion AS t ON (cl.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (cl.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (cl.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = cl.idimpuestoi) 
      WHERE cl.estatus='1'
      ORDER BY cl.cod_cliente ASC";
      return ejecutarConsulta($sql);
   }

   //funcion para Emitir Reporte General de Registros
   public function RptListar()
   {
      $sql="SELECT 
      cl.idcliente,
      cl.idvendedor,
      cl.idtipocliente,
      cl.idoperacion,
      cl.idcondpago,
      cl.idzona,
      cl.idimpuestoi,
      cl.cod_cliente,
      cl.desc_cliente,
      cl.rif,
      cl.direccion,
      cl.ciudad,
      cl.codpostal,
      cl.contacto,
      cl.telefono,
      cl.movil,
      cl.email,
      cl.web,
      cl.limite,
      cl.montofiscal,
      DATE_FORMAT(cl.fechareg, '%d/%m/%Y') AS fechareg,
      cl.aplicareten,
      cl.estatus,
      v.cod_vendedor,
      v.desc_vendedor,
      tc.cod_tipocliente,
      tc.desc_tipocliente,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbventa WHERE idcliente = cl.idcliente AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbcliente AS cl
      INNER JOIN tbvendedor AS v ON (cl.idvendedor = v.idvendedor)  
      INNER JOIN tbtipocliente AS tc ON (cl.idtipocliente = tc.idtipocliente) 
      INNER JOIN tboperacion AS t ON (cl.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (cl.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (cl.idzona = z.idzona) 
      INNER JOIN tbimpuestoi AS i ON (i.idimpuestoi = cl.idimpuestoi)
      ORDER BY cl.cod_cliente ASC";
      return ejecutarConsulta($sql);
   }

}

?>