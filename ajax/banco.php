<?php
require_once "../database/Banco.php";
$banco=new Banco();

$idbanco=isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_banco=isset($_POST["cod_banco"])? limpiarCadena($_POST["cod_banco"]):"";
$desc_banco=isset($_POST["desc_banco"])? limpiarCadena($_POST["desc_banco"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$plazo1=isset($_POST["plazo1"])? limpiarCadena($_POST["plazo1"]):"";
$plazo2=isset($_POST["plazo2"])? limpiarCadena($_POST["plazo2"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idbanco)){
       $rspta=$banco->Insertar($idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$banco->Editar($idbanco,$idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$banco->Desactivar($idbanco);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$banco->Eliminar($idbanco);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$banco->Activar($idbanco);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$banco->Mostrar($idbanco);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$banco->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idbanco.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idbanco.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idbanco.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idbanco.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idbanco.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idbanco.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_banco.'</h5>',
            "2"=>'<h5>'.$reg->desc_banco.'</h5>', 
            "3"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_moneda.'-'.$reg->desc_moneda.'</h5>',          
				"4"=>($reg->estatus)?
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