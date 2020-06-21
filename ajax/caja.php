<?php
require_once "../database/Caja.php";
$caja=new Caja();

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_caja=isset($_POST["cod_caja"])? limpiarCadena($_POST["cod_caja"]):"";
$desc_caja=isset($_POST["desc_caja"])? limpiarCadena($_POST["desc_caja"]):"";
$saldoefectivo=isset($_POST["saldoefectivo"])? limpiarCadena($_POST["saldoefectivo"]):"";
$saldodocumento=isset($_POST["saldodocumento"])? limpiarCadena($_POST["saldodocumento"]):"";
$saldototal=isset($_POST["saldototal"])? limpiarCadena($_POST["saldototal"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idcaja)){
       $rspta=$caja->Insertar($idmoneda,$cod_caja,$desc_caja,$fechareg);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$caja->Editar($idcaja,$idmoneda,$cod_caja,$desc_caja,$fechareg);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$caja->Desactivar($idcaja);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$caja->Eliminar($idcaja);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$caja->Activar($idcaja);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$caja->Mostrar($idcaja);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$caja->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcaja.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idcaja.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcaja.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcaja.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idcaja.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcaja.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_caja.'</h5>',
            "2"=>'<h5>'.$reg->desc_caja.'</h5>',
            "3"=>'<h5 '.$al.'center'.$w.'80px;">'.$reg->cod_moneda.'</h5>',
				"4"=>'<h5 '.$al.'right'.$w.'120px;">'.number_format($reg->saldototal,2,",",".").'</h5>',       
				"5"=>($reg->estatus)?
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

   case "selectMoneda":
      require_once "../database/Moneda.php";
      $moneda = new Moneda();
   
      $rspta = $moneda->Select();
   
      while ($reg = $rspta->fetch_object()){
         echo '<option value='.$reg->idmoneda.'>'.$reg->cod_moneda.'-'.$reg->desc_moneda.'</option>';
      }
   break;
}
?>