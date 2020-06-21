<?php
require_once "../database/Deposito.php";
$deposito=new Deposito();

$iddeposito=isset($_POST["iddeposito"])? limpiarCadena($_POST["iddeposito"]):"";
$cod_deposito=isset($_POST["cod_deposito"])? limpiarCadena($_POST["cod_deposito"]):"";
$desc_deposito=isset($_POST["desc_deposito"])? limpiarCadena($_POST["desc_deposito"]):"";
$responsable=isset($_POST["responsable"])? limpiarCadena($_POST["responsable"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$solocompra=isset($_POST["solocompra"])? limpiarCadena($_POST["solocompra"]):"";
$soloventa=isset($_POST["soloventa"])? limpiarCadena($_POST["soloventa"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($iddeposito)){
       $rspta=$deposito->Insertar($cod_deposito,$desc_deposito,$responsable,$direccion,
       $fechareg,$solocompra,$soloventa);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$deposito->Editar($iddeposito,$cod_deposito,$desc_deposito,$responsable,$direccion,
       $fechareg,$solocompra,$soloventa);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$deposito->Desactivar($iddeposito);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$deposito->Eliminar($iddeposito);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$deposito->Activar($iddeposito);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$deposito->Mostrar($iddeposito);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$deposito->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->iddeposito.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->iddeposito.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->iddeposito.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->iddeposito.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->iddeposito.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->iddeposito.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_deposito.'</h5>',
            "2"=>'<h5 '.$al.''.$w.'300px;">'.$reg->desc_deposito.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'150px;">'.$reg->responsable.'</h5>',
            "4"=>($reg->solocompra)?'<h5 '.$al.'center'.$w.'110px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':'<h5 '.$al.'center'.$w.'110px;"><span class="fa fa-circle-o text-red"></span></h5>',
				"5"=>($reg->soloventa)?'<h5 '.$al.'center'.$w.'110px;"><span class="fa fa-dot-circle-o text-green"></span></h5>':'<h5 '.$al.'center'.$w.'110px;"><span class="fa fa-circle-o  text-red"></span></h5>',              
				"6"=>($reg->estatus)?
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