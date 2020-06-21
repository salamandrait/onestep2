<?php
require "../config/Conexion.php";

class Empresa{

   //Implementamos nuestro constructor
   public function __construct()
   {   
   }

   //Implementamos Insertar
   public function Insertar($cod_empresa,$desc_empresa,$rif,$direccion,$codpostal,$telefono,$movil,
   $contacto,$email,$web,$imagen1,$imagen2,$esfiscal,$montofiscal,$cheque,$deposito,$pagoe,$ticketa,
   $efectivo,$tdc,$tdd,$divisas,$invnegativo,$inumdecimal,$pnumdecimal)
   {
      $sql="INSERT INTO tbempresa (cod_empresa,desc_empresa,rif,direccion,codpostal,telefono,movil,
      contacto,email,web,imagen1,imagen2,esfiscal,montofiscal,cheque,deposito,pagoe,ticketa,efectivo,
      tdc,tdd,divisas,invnegativo,inumdecimal,pnumdecimal)
      VALUES ('$cod_empresa','$desc_empresa','$rif','$direccion','$codpostal','$telefono','$movil','$contacto',
      '$email','$web','$imagen1','$imagen2','$esfiscal','$montofiscal',$cheque','$deposito','$pagoe','$ticketa',
      '$efectivo','$tdc','$tdd','$divisas','$invnegativo','$inumdecimal','$pnumdecimal')";
      return ejecutarConsulta($sql);
   }
   
   //Implementamos Editar
   public function Editar($idempresa,$cod_empresa,$desc_empresa,$rif,$direccion,$codpostal,$telefono,$movil,
	$contacto,$email,$web,$imagen1,$imagen2,$esfiscal,$montofiscal,$cheque,$deposito,$pagoe,$ticketa,$efectivo,
   $tdc,$tdd,$divisas,$invnegativo,$inumdecimal,$pnumdecimal)
	{
      $sql="UPDATE tbempresa 
      SET
      cod_empresa = '$cod_empresa',
      desc_empresa = '$desc_empresa',
      rif = '$rif',
      direccion = '$direccion',
      codpostal = '$codpostal',
      telefono = '$telefono',
      movil = '$movil',
      contacto = '$contacto',
      email = '$email',
      web = '$web',
      imagen1 = '$imagen1',
      imagen2 = '$imagen2',
      esfiscal = '$esfiscal',
      montofiscal = '$montofiscal',
      cheque= '$cheque',
      deposito='$deposito',
      pagoe='$pagoe',
      ticketa ='$ticketa',
      efectivo='$efectivo',
      tdc='$tdc',
      tdd ='$tdd',
      divisas='$divisas',
      invnegativo='$invnegativo',
      inumdecimal='$inumdecimal',
      pnumdecimal='$pnumdecimal'
      WHERE idempresa = '$idempresa'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Eliminar
   public function Eliminar($idempresa)
   {
      $sql="DELETE FROM tbempresa 
      WHERE idempresa='$idempresa'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Activar
   public function Activar($idempresa)
   {
      $sql="UPDATE tbempresa 
      SET estatus='1' 
      WHERE idempresa='$idempresa'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Descativar
   public function Desactivar($idempresa)
   {
      $sql="UPDATE tbempresa 
      SET estatus='0' 
      WHERE idempresa='$idempresa'";
      return ejecutarConsulta($sql);
   }

   //Implementamos Listar
   public function Listar()
   {
      $sql="SELECT   
      idempresa,
      cod_empresa,
      desc_empresa,
      rif,
      direccion,
      codpostal,
      telefono,
      movil,
      contacto,
      email,
      web,
      imagen1,
      imagen2,
      esfiscal,
      montofiscal,
      cheque,
      deposito,
      pagoe,
      ticketa,
      efectivo,
      tdc,
      tdd,
      divisas,
      invnegativo,
      inumdecimal,
      pnumdecimal
      FROM tbempresa";
      return ejecutarConsulta($sql);	
   }

   //Implementamos Mostrar
   public function Mostrar($idempresa)
   {
      $sql="SELECT   
      idempresa,
      cod_empresa,
      desc_empresa,
      rif,
      direccion,
      codpostal,
      telefono,
      movil,
      contacto,
      email,
      web,
      imagen1,
      imagen2,
      esfiscal,
      montofiscal,
      cheque,
      deposito,
      pagoe,
      ticketa,
      efectivo,
      tdc,
      tdd,
      divisas,
      invnegativo,
      inumdecimal,
      pnumdecimal
      FROM tbempresa WHERE idempresa='$idempresa'";
      return ejecutarConsultaSimpleFila($sql);
   }

   //Implementamos Select
   public function Select()
   {
      $sql="SELECT 
      idempresa,
      cod_empresa,
      desc_empresa,
      rif,
      direccion,
      codpostal,
      telefono,
      movil,
      contacto,
      email,
      web,
      imagen1,
      imagen2,
      esfiscal,
      montofiscal,
      divisas,
      invnegativo,
      inumdecimal,
      pnumdecimal,
      DATE_FORMAT(CURDATE(),'%d-%m-%Y') AS fecharpt,
      DATE_FORMAT(CURTIME(),'%l:%i %p') AS timerpt 
      FROM tbempresa
      ORDER BY cod_empresa ASC";
      return ejecutarConsulta($sql);
   }

   //Implementamos Listar
   public function RptListar()
   {
      $sql="SELECT 
      idempresa,
      cod_empresa,
      desc_empresa,
      rif,
      direccion,
      codpostal,
      telefono,
      movil,
      contacto,
      email,
      web,
      imagen1,
      imagen2,
      esfiscal,
      montofiscal,
      divisas,
      invnegativo,
      inumdecimal,
      pnumdecimal,
      DATE_FORMAT(CURDATE(),'%d-%m-%Y') AS fecharpt,
      DATE_FORMAT(CURTIME(),'%l:%i %p') AS timerpt 
      FROM tbempresa
      ORDER BY cod_empresa ASC";
      return ejecutarConsulta($sql);
   }
   
}