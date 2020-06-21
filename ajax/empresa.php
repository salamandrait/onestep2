<?php
require_once "../database/Empresa.php";
$empresa=new Empresa();

$idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
$cod_empresa=isset($_POST["cod_empresa"])? limpiarCadena($_POST["cod_empresa"]):"";
$desc_empresa=isset($_POST["desc_empresa"])? limpiarCadena($_POST["desc_empresa"]):"";
$rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$codpostal=isset($_POST["codpostal"])? limpiarCadena($_POST["codpostal"]):"";
$contacto=isset($_POST["contacto"])? limpiarCadena($_POST["contacto"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$movil=isset($_POST["movil"])? limpiarCadena($_POST["movil"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$web=isset($_POST["web"])? limpiarCadena($_POST["web"]):"";
$imagen1=isset($_POST["imagen1"])? limpiarCadena($_POST["imagen1"]):"";
$imagen2=isset($_POST["imagen2"])? limpiarCadena($_POST["imagen2"]):"";
$esfiscal=isset($_POST["esfiscal"])? limpiarCadena($_POST["esfiscal"]):"";
$montofiscal=isset($_POST["montofiscal"])? limpiarCadena($_POST["montofiscal"]):"";
$efectivo=isset($_POST["efectivo"])? limpiarCadena($_POST["efectivo"]):"";
$cheque=isset($_POST["cheque"])? limpiarCadena($_POST["cheque"]):"";
$deposito=isset($_POST["deposito"])? limpiarCadena($_POST["deposito"]):"";
$pagoe=isset($_POST["pagoe"])? limpiarCadena($_POST["pagoe"]):"";
$ticketa=isset($_POST["ticketa"])? limpiarCadena($_POST["ticketa"]):"";
$tdc=isset($_POST["tdc"])? limpiarCadena($_POST["tdc"]):"";
$tdd=isset($_POST["tdd"])? limpiarCadena($_POST["tdd"]):"";
$divisas=isset($_POST["divisas"])? limpiarCadena($_POST["divisas"]):"";

switch ($_POST["opcion"]){

   case 'guardaryeditar':
		if (!file_exists($_FILES['imagen1']['tmp_name']) || !is_uploaded_file($_FILES['imagen1']['tmp_name']))
		{
			$imagen1=$_POST["imagen1actual"];
		}
		else 
		{
         $ext = explode(".", $_FILES["imagen1"]["name"]);
			$_FILES['imagen1']['tmp_name']=="../files/logo/".$cod_empresa.'.'.end($ext)?
			unlink("../logo/usuarios/".$cod_empresa.'img1'.'.'.end($ext)):'';
         if (
            $_FILES['imagen1']['type'] == "image/jpg" || 
            $_FILES['imagen1']['type'] == "image/jpeg" || 
            $_FILES['imagen1']['type'] == "image/png")
			{
				$imagen1 = $cod_empresa.'img1'.'.'.end($ext);
				move_uploaded_file($_FILES["imagen1"]["tmp_name"], "../files/logo/".$imagen1);
			}
		}

		if (!file_exists($_FILES['imagen2']['tmp_name']) || !is_uploaded_file($_FILES['imagen2']['tmp_name']))
		{
			$imagen2=$_POST["imagen2actual"];
		}
		else 
		{
         $ext = explode(".", $_FILES["imagen2"]["name"]);
			$_FILES['imagen2']['tmp_name']=="../files/logo/".$cod_empresa.'.'.end($ext)?
         unlink("../logo/usuarios/".$cod_empresa.'img2'.'.'.end($ext)):'';      
         if (
            $_FILES['imagen2']['type'] == "image/jpg" || 
            $_FILES['imagen2']['type'] == "image/jpeg" || 
            $_FILES['imagen2']['type'] == "image/png")
			{
				$imagen2 = $cod_empresa.'img2'.'.'.end($ext);
				move_uploaded_file($_FILES["imagen2"]["tmp_name"], "../files/logo/".$imagen2);
			}
		}

		if (empty($idempresa)){
			$rspta=$empresa->insertar($cod_empresa,$desc_empresa,$rif,$direccion,$codpostal,$telefono,$movil,
			$contacto,$email,$web,$imagen1,$imagen2,$esfiscal,$montofiscal,$cheque,$deposito,$pagoe,$ticketa,$efectivo,$tdc,$tdd,$divisas);
			echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
		}
		else {
			$rspta=$empresa->editar($idempresa,$cod_empresa,$desc_empresa,$rif,$direccion,$codpostal,$telefono,$movil,
			$contacto,$email,$web,$imagen1,$imagen2,$esfiscal,$montofiscal,$cheque,$deposito,$pagoe,$ticketa,$efectivo,$tdc,$tdd,$divisas);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

   case 'desactivar':
      $rspta=$empresa->Desactivar($idempresa);
      echo $rspta ? "Registro Desactivado correctamente!":"Registro no se puede desactivar!";
   break;

   case 'eliminar':
      $rspta=$empresa->Eliminar($idempresa);
      echo $rspta ? "Registro Eliminado correctamente!":"Registro no se puede Eliminar!";
   break;

   case 'activar':
      $rspta=$empresa->Activar($idempresa);
      echo $rspta ? "Registro Activado correctamente!":"Registro no se puede Activar!";
   break;

   case 'mostrar':
      $rspta=$empresa->Mostrar($idempresa);
      //Codificar el resultado utilizando json
      echo json_encode($rspta);
   break;

   case 'listar':
      $rspta=$empresa->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){
      $data[]=array(
         "0"=>
         '<h5 small style="text-align:center; width:120px" class="small">
         <button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idempresa.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
         '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idempresa.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
         '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idempresa.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'
         ,
         "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_empresa.'</h5>',
         "2"=>'<h5>'.$reg->desc_empresa.'</h5>',       
         "3"=>($reg->esfiscal)?
         '<h5 style="text-align:center; width:100px">':
         '<h5 style="text-align:center; width:100px"><span class="label bg-red">Desactivado</h5>',
         "4"=>'<h5 style="text-align:center;width:80px">'.$reg->montofiscal.'</h5>'
      );}
      $results = array("sEcho"=>1,"iTotalRecords"=>count($data),"iTotalDisplayRecords"=>count($data),"aaData"=>$data);
      echo json_encode($results);				
   break;
}
?>