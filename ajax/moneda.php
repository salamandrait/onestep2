<?php
require_once "../database/Moneda.php";
$moneda=new Moneda();

$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_moneda=isset($_POST["cod_moneda"])? limpiarCadena($_POST["cod_moneda"]):"";
$desc_moneda=isset($_POST["desc_moneda"])? limpiarCadena($_POST["desc_moneda"]):"";
$base=isset($_POST["base"])? limpiarCadena($_POST["base"]):"";
$factor=isset($_POST["factor"])? limpiarCadena($_POST["factor"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idmoneda)){
       $rspta=$moneda->Insertar($cod_moneda,$desc_moneda,$factor,$base);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$moneda->Editar($idmoneda,$cod_moneda,$desc_moneda,$factor,$base);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$moneda->Desactivar($idmoneda);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$moneda->Eliminar($idmoneda);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$moneda->Activar($idmoneda);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$moneda->Mostrar($idmoneda);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$moneda->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmoneda.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idmoneda.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmoneda.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmoneda.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idmoneda.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmoneda.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_moneda.'</h5>',
            "2"=>'<h5>'.$reg->desc_moneda.'</h5>',
            "3"=>$reg->base==1?
				'<h5 '.$al.'center'.$w.'100px;"><span class="label bg-green">Base</h5>':
				'<h5 '.$al.'center'.$w.'100px;"><span class="label bg-red">General</h5>',
				"4"=>'<h5 '.$al.'center'.$w.'100px;">'.number_format($reg->factor,2,",",".").'</h5>',             
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