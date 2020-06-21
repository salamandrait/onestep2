<?php
require_once "../database/IPago.php";
$ipago=new IPago();

$idipago=isset($_POST["idipago"])? limpiarCadena($_POST["idipago"]):"";
$cod_ipago=isset($_POST["cod_ipago"])? limpiarCadena($_POST["cod_ipago"]):"";
$desc_ipago=isset($_POST["desc_ipago"])? limpiarCadena($_POST["desc_ipago"]):"";
$comision=isset($_POST["comision"])? limpiarCadena($_POST["comision"]):"";
$recargo=isset($_POST["recargo"])? limpiarCadena($_POST["recargo"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idipago)){
       $rspta=$ipago->Insertar($cod_ipago,$desc_ipago,$comision,$recargo);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$ipago->Editar($idipago,$cod_ipago,$desc_ipago,$comision,$recargo);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$ipago->Desactivar($idipago);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$ipago->Eliminar($idipago);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$ipago->Activar($idipago);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$ipago->Mostrar($idipago);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$ipago->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idipago.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idipago.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idipago.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idipago.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idipago.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idipago.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_ipago.'</h5>',
            "2"=>'<h5>'.$reg->desc_ipago.'</h5>', 
            "3"=>'<h5 '.$al.'right'.$w.'80px;">'.number_format($reg->comision,2,",",".").'</h5>',   
				"4"=>'<h5 '.$al.'right'.$w.'80px;">'.number_format($reg->recargo,2,",",".").'</h5>',        
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
}
?>