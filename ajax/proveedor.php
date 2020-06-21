<?php
require_once "../database/Proveedor.php";
$proveedor=new Proveedor();

$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idtipoproveedor=isset($_POST["idtipoproveedor"])? limpiarCadena($_POST["idtipoproveedor"]):"";
$idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$idimpuestoi=isset($_POST["idimpuestoi"])? limpiarCadena($_POST["idimpuestoi"]):"";
$cod_proveedor=isset($_POST["cod_proveedor"])? limpiarCadena($_POST["cod_proveedor"]):"";
$desc_proveedor=isset($_POST["desc_proveedor"])? limpiarCadena($_POST["desc_proveedor"]):"";
$rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";
$codpostal=isset($_POST["codpostal"])? limpiarCadena($_POST["codpostal"]):"";
$contacto=isset($_POST["contacto"])? limpiarCadena($_POST["contacto"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$movil=isset($_POST["movil"])? limpiarCadena($_POST["movil"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$web=isset($_POST["web"])? limpiarCadena($_POST["web"]):"";
$limite=isset($_POST["limite"])? limpiarCadena($_POST["limite"]):"";
$saldo=isset($_POST["saldo"])? limpiarCadena($_POST["saldo"]):"";
$montofiscal=isset($_POST["montofiscal"])? limpiarCadena($_POST["montofiscal"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$aplicareten=isset($_POST["aplicareten"])? limpiarCadena($_POST["aplicareten"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
   if (empty($idproveedor)){
      $rspta=$proveedor->Insertar($idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoi,$cod_proveedor,$desc_proveedor,
      $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten);
      echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
      $rspta=$proveedor->Editar($idproveedor,$idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoi,$cod_proveedor,$desc_proveedor,
      $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten);
      echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$proveedor->Desactivar($idproveedor);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$proveedor->Eliminar($idproveedor);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$proveedor->Activar($idproveedor);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$proveedor->Mostrar($idproveedor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$proveedor->Listar();
      //Vamos a declarar un array
      $data= Array();

         while ($reg=$rspta->fetch_object()){

            $al='style="text-align:';
            $w='; width:';
            $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'90px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idproveedor.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idproveedor.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idproveedor.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'90px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idproveedor.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idproveedor.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idproveedor.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_proveedor.'</h5>',
            "2"=>'<h5 '.$al.''.$w.'400px;">'.$reg->desc_proveedor.'</h5>',
            "3"=>'<h5 '.''.'center'.$w.'100px;">'.$reg->rif.'</h5>',
				"4"=>'<h5 '.$al.''.$w.'250px;">'.$reg->cod_tipoproveedor.'-'.$reg->desc_tipoproveedor.'</h5>',
				"5"=>'<h5 '.$al.''.$w.'250px;">'.$reg->cod_operacion.'-'.$reg->desc_operacion.'</h5>',
				"6"=>'<h5 '.$al.''.$w.'250px;">'.$reg->contacto.'</h5>',
				"7"=>'<h5 '.$al.''.$w.'160px;">'.$reg->telefono.'</h5>',
				"8"=>'<h5 '.$al.''.$w.'160px;">'.$reg->movil.'</h5>',
				"9"=>'<h5 '.$al.''.$w.'250px;">'.$reg->email.'</h5>',
				"10"=>'<h5 '.$al.'right'.$w.'130px;">'.number_format($reg->limite,2,",",".").'</h5>', 
				"11"=>'<h5 '.$al.'right'.$w.'150px;">'.number_format($reg->saldo,2,",",".").'</h5>',   
				"12"=>($reg->estatus)?
				'<h5 '.$al.'center'.$w.'80px;"><span class="label bg-green">Activado</span></h5>':
				'<h5 '.$al.'center'.$w.'80px;"><span class="label bg-red">Desactivado</span></h5>'
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

	case "selectTipoProveedor":
		require_once "../database/TipoProveedor.php";
		$tipoproveedor = new TipoProveedor();

		$rspta = $tipoproveedor->Select();

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idtipoproveedor.'>'.$reg->desc_tipoproveedor.'</option>';
		}
   break;
   
	case "selectZona":
		require_once "../database/Zona.php";
		$zona = new Zona();

		$rspta = $zona->Select();

		while ($reg = $rspta->fetch_object()){
					echo '<option value='.$reg->idzona.'>'.$reg->desc_zona.'</option>';
		}
   break;
   
   case "selectOperacion":
		require_once "../database/Operacion.php";
		$operacion = new Operacion();

		$rspta = $operacion->SelectOp($_POST['op']);

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idoperacion.'>'.$reg->desc_operacion.'</option>';
		}
   break;
   
   case "selectCondPago":
		require_once "../database/CondPago.php";
		$condpago = new CondPago();

		$rspta = $condpago->Select();

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcondpago.'>'.$reg->desc_condpago.'</option>';
		}
   break;
   
   case 'selectImpuestoi':
		require_once "../database/Impuestoi.php";
		$impuestoi = new Impuestoi();

		$rspta=$impuestoi->Select();

		while ($reg=$rspta->fetch_object()) {

			echo'<option value='.$reg->idimpuestoi.'>'.$reg->desc_impuestoi.'</option>';
		}
	break;
}
?>