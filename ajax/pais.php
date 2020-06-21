<?php
require_once "../database/Pais.php";
$pais=new Pais();

$idpais=isset($_POST["idpais"])? limpiarCadena($_POST["idpais"]):"";
$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_pais=isset($_POST["cod_pais"])? limpiarCadena($_POST["cod_pais"]):"";
$desc_pais=isset($_POST["desc_pais"])? limpiarCadena($_POST["desc_pais"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idpais)){
       $rspta=$pais->Insertar($cod_pais,$idmoneda,$desc_pais);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$pais->Editar($idpais,$idmoneda,$cod_pais,$desc_pais);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$pais->Desactivar($idpais);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$pais->Eliminar($idpais);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$pais->Activar($idpais);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$pais->Mostrar($idpais);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$pais->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(
            "0"=>'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idpais.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idpais.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idpais.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button>
            </h5>'	 
				,
            "1"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_pais.'</h5>',
            "2"=>'<h5>'.$reg->desc_pais.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'150px;">'.$reg->cod_moneda.'-'.$reg->desc_moneda.'</h5>'
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case 'selectMoneda':
      require_once '../database/Moneda.php';
      $moneda=new Moneda();
      $rspta=$moneda->Select();

      while ($reg=$rspta->fetch_object()) 
      {
         echo '<option value='.$reg->idmoneda.'>'.$reg->cod_moneda.'-'.$reg->desc_moneda.'</option>';
      }
   break;

}
?>