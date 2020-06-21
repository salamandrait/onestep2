<?php
require_once "../database/Cuenta.php";
$cuenta=new Cuenta();

$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
$idbanco=isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
$cod_cuenta=isset($_POST["cod_cuenta"])? limpiarCadena($_POST["cod_cuenta"]):"";
$desc_cuenta=isset($_POST["desc_cuenta"])? limpiarCadena($_POST["desc_cuenta"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$numcuenta=isset($_POST["numcuenta"])? limpiarCadena($_POST["numcuenta"]):"";
$agencia=isset($_POST["agencia"])? limpiarCadena($_POST["agencia"]):"";
$ejecutivo=isset($_POST["ejecutivo"])? limpiarCadena($_POST["ejecutivo"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$saldod=isset($_POST["saldod"])? limpiarCadena($_POST["saldod"]):"";
$saldoh=isset($_POST["saldoh"])? limpiarCadena($_POST["saldoh"]):"";
$saldot=isset($_POST["saldot"])? limpiarCadena($_POST["saldot"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";;

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idcuenta)){
       $rspta=$cuenta->Insertar($idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
       $telefono,$email,$fechareg);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$cuenta->Editar($idcuenta,$idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
       $telefono,$email,$fechareg);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$cuenta->Desactivar($idcuenta);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$cuenta->Eliminar($idcuenta);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$cuenta->Activar($idcuenta);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$cuenta->Mostrar($idcuenta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$cuenta->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcuenta.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idcuenta.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcuenta.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idcuenta.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idcuenta.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcuenta.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_cuenta.'</h5>',
            "2"=>'<h5>'.$reg->desc_cuenta.'</h5>', 
            "3"=>'<h5 '.$al.'center'.$w.'200px;">'.$reg->numcuenta.'</h5>',
				"4"=>'<h5 '.$al.'center'.$w.'100px;">'.$reg->cod_banco.'</h5>',
				"5"=>'<h5 '.$al.'right'.$w.'130px;">'.number_format($reg->saldot,2,",",".").'</h5>',             
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

   case 'selectBanco':
      require_once '../database/Banco.php';
      $banco= new Banco();
      $rspta=$banco->Select();

      while ($reg=$rspta->fetch_object()) {

      echo '<option value="'.$reg->idbanco.'">'.$reg->desc_banco.'</option>';

      }
   break;
   
   case 'Banco':
      require_once '../database/Banco.php';
      $banco= new Banco();

      $rspta=$banco->Mostrar($_POST['id']);
      echo json_encode($rspta);
   break;   


}
?>