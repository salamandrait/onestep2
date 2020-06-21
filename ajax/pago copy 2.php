<?php
require_once "../database/Pago.php";
$pago=new Pago();

$idpago=isset($_POST["idpago"])? limpiarCadena($_POST["idpago"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$cod_pago=isset($_POST["cod_pago"])? limpiarCadena($_POST["cod_pago"]):"";
$desc_pago=isset($_POST["desc_pago"])? limpiarCadena($_POST["desc_pago"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$origend=isset($_POST["origend"])? limpiarCadena($_POST["origend"]):"";
$origenc=isset($_POST["origenc"])? limpiarCadena($_POST["origenc"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
      if (empty($idpago) && $_POST['tipopago']=='Banco'){

         $rspta=$pago->InsertarBanco($idusuario,$idproveedor,$cod_pago,$desc_pago,$tipo,$origend,$origenc,$totalh,$fechareg,
         $_POST['idcompra'],$_POST['montoh'],$_POST['idcuenta'],$_POST['idoperacion'],$_POST['cod_movbanco'],$_POST['tipoban'],
         $_POST['numerocb'],$_POST['fecharegb']);
         echo $rspta=='111'?"Registro Ingresado Correctamente!":$rspta;
         $rspta=$pago->ActSaldoCuenta($_POST['idcuenta']);
         $rspta=$pago->ActCod();
        
      } else if (empty($idpago) && $_POST['tipopago']=='Caja'){

         $rspta=$pago->InsertarCaja($idusuario,$idproveedor,$cod_pago,$desc_pago,$tipo,$origend,$origenc,$totalh,$fechareg,
         $_POST['idcaja'],$_POST['idoperacion'],$_POST['cod_movcaja'],$_POST['idcompra'],$_POST['montoh'],$_POST['fecharegc'],
         $_POST['retenciona']);
         echo $rspta=='111'?"Registro Ingresado Correctamente!":$rspta;
         $rspta=$pago->ActSaldoCaja($_POST['idcaja']);
         $rspta=$pago->ActCod();
      }	
	break;

   case 'anular':
      $rspta=$pago->ActDetalle($idpago);
      $rspta=$pago->Anular($idpago);   
      $rspta=$pago->ActualizarCompra($_POST['idcompra'],$_POST['cod_pago']);
        
      ($_POST['idmovbanco']<>0)?$rspta=$pago->AnularMovBanco($_POST['idmovbanco']):'';
      ($_POST['idmovbanco']<>0)?$rspta=$pago->ActSaldoCuenta($_POST['idcuenta']):'';

      ($_POST['idmovcaja']<>0)?$rspta=$pago->AnularMovCaja($_POST['idmovcaja']):'';
      ($_POST['idmovcaja']<>0)?$rspta=$pago->ActSaldoCaja($_POST['idcaja']):'';
		echo $rspta=='1'?"Registro Anulado Correctamente!":$rspta;
	break;

   case 'eliminar':
      $rspta=$pago->ActDetalle($idpago);   
      $rspta=$pago->ActualizarCompra($_POST['idcompra'],$_POST['cod_pago']);

      ($_POST['idmovbanco']<>0)?$rspta=$pago->EliminarMovBanco($_POST['idmovbanco']):'';
      ($_POST['idmovbanco']<>0)?$rspta=$pago->ActSaldoCuenta($_POST['idcuenta']):'';

      ($_POST['idmovcaja']<>0)?$rspta=$pago->EliminarMovCaja($_POST['idmovcaja']):'';
      ($_POST['idmovcaja']<>0)?$rspta=$pago->ActSaldoCaja($_POST['idcaja']):'';
      $rspta=$pago->Eliminar($idpago);
		echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
	break;

   case 'mostrar':
		$rspta=$pago->Mostrar($idpago);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$pago->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         if ($reg->estatus=='Registrado') {
            $estatus='<h5 style="text-align:center; width:100px;"><span class="label bg-green">Registrado</span></h5>';         
         } else if ($reg->estatus=='Anulado'){
            $estatus='<h5 style="text-align:center; width:100px;"><span class="label bg-red-active">Anulado</span></h5>';         
         }else if ($reg->estatus=='Procesado'){
            $estatus='<h5 style="text-align:center; width:100px;"><span class="label bg-primary">Procesado</span></h5>';         
         }

            $al='style="text-align:';
            $w='; width';
            $dtg='data-toggle="tooltip" data-placement="right" title=';
            $btn='button class="btn btn-xs btn-';
            $data[]=array(

            "0"=>($reg->estatus=='Registrado')?
            '<h5 small style="text-align:center; width:120px" class="small">
            <'.$btn.'primary" onclick="mostrar('.$reg->idpago.')" '.$dtg.'"Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<'.$btn.'success" onclick="anular('.$reg->idpago.',\''.$reg->idcompra.'\',\''.$reg->cod_pago.'\',\''.$reg->idmovbanco.'\',\''.$reg->idcuenta.'\',\''.$reg->idmovcaja.'\',\''.$reg->idcaja.'\')" '.$dtg.'"Anular"><i class="fa fa-check-square"></i></button>'.
            '<'.$btn.'danger" onclick="eliminar('.$reg->idpago.',\''.$reg->idcompra.'\',\''.$reg->cod_pago.'\',\''.$reg->idmovbanco.'\',\''.$reg->idcuenta.'\',\''.$reg->idmovcaja.'\',\''.$reg->idcaja.'\')" '.$dtg.'"Eliminar"><i class="fa fa-remove"></i></button>
            </h5>'
            :
            '<h5 small style="text-align:center; width:120px" class="small">
            <'.$btn.'primary" onclick="mostrar('.$reg->idpago.')" '.$dtg.'"Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<'.$btn.'warning" disabled '.$dtg.'"Anulado"><i class="fa fa-trash"></i></button>'.
            '<'.$btn.'danger" disabled '.$dtg.'"Eliminar"><i class="fa fa-remove"></i></button>
            </h5>'	 
				,
            "1"=>'<h5 '.$al.'center'.$w.'100px;">'.$reg->fechareg.'</h5>',
				"2"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_pago.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'120px;">'.$reg->tipo.'</h5>',
				"4"=>'<h5>'.$reg->desc_proveedor.'</h5>',
            "5"=>'<h5 '.$al.'center'.$w.'100px;">'.$reg->rif.'</h5>',
            "6"=>'<h5 style="text-align:right; '.$w.'150px;">'.number_format($reg->totalh,2,",",".").'</h5>',
				"7"=>$estatus
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case "listarProveedor":
		require_once "../database/Compra.php";
		$compra = new Compra();
    
         $rspta=$compra->SelectProveedorOp();
         //Vamos a declarar un array
         $data= array();
         while ($reg=$rspta->fetch_object()){
            $data[]=array(

            "0"=>'<h5><button class="btn btn-success btn-xs" onclick="agregarProveedor
            ('.$reg->idproveedor.',\''.$reg->cod_proveedor.'\',\''.$reg->desc_proveedor.'\',\''.$reg->rif.'\',
            \''.$reg->saldoh.'\',\''.$reg->idoperacion.'\')">
            <span class="fa fa-check-square-o" style="text-align:center; width:15px;"></span></button></h5>',
            "1"=>'<h5 style="width:100px; text-align:center;">'.$reg->cod_proveedor.'</h5>',
            "2"=>'<h5 style="width:320px;">'.$reg->desc_proveedor.'</h5>',
            "3"=>'<h5 style="width:100px; text-align:center;">'.$reg->rif.'</h>',
            "4"=>'<h5 style="width:150px; text-align:right;">'.number_format($reg->saldoh,2,",",".").'</h>'
            );
      }
      $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
      echo json_encode($results);
   break;

   case "listarDoc":
		require_once "../database/Compra.php";
		$compra = new Compra();

      $fila='';
      $cont=0;
		$rspta=$compra->SelectOp($_POST['id']);

		while ($reg=$rspta->fetch_object()){

			$data[]=array(          
         "0"=>'<td><h5 style="text-align:center; width:20px"><button class="btn bg-gray btn-xs" 
         onclick="agergarDocumento('.$reg->idcompra.',\''.$reg->fecharegl.'\',\''.$reg->fechavenl.'\',\''.$reg->cod_compra.'\',
         \''.$reg->tipo.'\',\''.$reg->numerod.'\',\''.$reg->numeroc.'\',\''.$reg->subtotalh.'\',\''.$reg->impuestoh.'\',
         \''.$reg->totalh.'\',\''.$reg->saldo.'\',\''.$reg->esfiscal.'\',\''.$reg->montofiscal.'\',\''.$reg->retenciona.'\');">
         <span class="fa fa-check-circle-o text-green"></span></button></h5></td>',		
			"1"=>'<td><h5 style="width:80px; text-align:center;">'.$reg->fecharegl.'</h5></td>',
			"2"=>'<td><h5 style="width:100px;">'.$reg->cod_compra.'</h5></td>',
			"3"=>'<td><h5 style="width:80px;text-align:center;">'.$reg->tipo.'</h5></td>',
			"4"=>'<td><h5 style="width:100px;">'.$reg->numerod.'</h5></td>',
			"5"=>'<td><h6 style="width:120px; text-align:right;">'.number_format($reg->totalh,2,",",".").'</h6></td>',
			"6"=>'<td><h6 style="width:120px; text-align:right;">'.number_format($reg->abono,2,",",".").'</h6></td>',
			"7"=>'<td><h6 style="width:120px; text-align:right;">'.number_format($reg->saldo,2,",",".").'</h6></td>',
         );
      }
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
   break;
   
   case "Moneda":
		require_once "../database/Moneda.php";
		$moneda = new Moneda();

		$rspta = $moneda->SelectOp();

		while ($reg = $rspta->fetch_object()){

			echo $reg->cod_moneda;
		}
   break;

   case "Caja":
		require_once "../database/Caja.php";
		$caja = new Caja();

      if ($_POST['op']=='select'){
         $rspta = $caja->Select();

         while ($reg = $rspta->fetch_object()){
			echo '<option value="'.$reg->idcaja.'">'.$reg->desc_caja.'</option>';
		   }
      } elseif($_POST['op']=='data') {

         $rspta=$caja->Mostrar($_POST['id']);
         echo json_encode($rspta);
      }
   break;

   case "Cuenta":
		require_once "../database/Cuenta.php";
		$cuenta = new Cuenta();

      if ($_POST['op']=='select'){
         $rspta = $cuenta->Select();

         while ($reg = $rspta->fetch_object()){
			echo '<option value="'.$reg->idcuenta.'">'.$reg->desc_cuenta.'</option>';
		   }
      } elseif($_POST['op']=='data') {

         $rspta=$cuenta->Mostrar($_POST['id']);
         echo json_encode($rspta);
      }
   break;
}
?>