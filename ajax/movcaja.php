<?php
require_once "../database/MovCaja.php";
$movcaja=new MovCaja();

$idmovcaja = isset($_POST["idmovcaja"])? limpiarCadena($_POST["idmovcaja"]):"";
$idcaja = isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$idbanco = isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
$idoperacion = isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_movcaja=isset($_POST["cod_movcaja"])? limpiarCadena($_POST["cod_movcaja"]):"";
$desc_movcaja=isset($_POST["desc_movcaja"])? limpiarCadena($_POST["desc_movcaja"]):"";
$tipo = isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$forma = isset($_POST["forma"])? limpiarCadena($_POST["forma"]):"";
$numerod = isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
$numeroc = isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
$origen = isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$estatus = isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$montod = isset($_POST["montod"])? limpiarCadena($_POST["montod"]):"";
$montoh = isset($_POST["montoh"])? limpiarCadena($_POST["montoh"]):"";
$saldoinicial = isset($_POST["saldoinicial"])? limpiarCadena($_POST["saldoinicial"]):"";
$fechareg = isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idmovcaja)){
       $rspta=$movcaja->Insertar($idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,
       $tipo,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg);
       $rspta=$movcaja->ActSaldoCaja($idcaja);
       $rspta=$movcaja->ActCod();
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
      $rspta=$movcaja->Editar($idmovcaja,$idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,$estatus,
      $tipo,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg);
      $rspta=$movcaja->ActSaldoCaja($idcaja);
      echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'anular':
      $rspta=$movcaja->Anular($idmovcaja);
      $rspta=$movcaja->ActSaldoCaja($idcaja);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':    
      $rspta=$movcaja->Eliminar($idmovcaja);
      $rspta=$movcaja->ActSaldoCaja($idcaja);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$movcaja->Mostrar($idmovcaja);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$movcaja->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $dtg='data-toggle="tooltip" data-placement="right" title="';

            $url='../reportes/rptMovCaja.php?id=';
            
            if ($reg->estatus=='Registrado') {
               $estatus='<h5 '.$al.'center'.$w.'100px;"><span class="label bg-green">Registrado</span></h5>';         
            } else if ($reg->estatus=='Anulado'){
               $estatus='<h5 '.$al.'center'.$w.'100px;"><span class="label bg-red-active">Anulado</span></h5>';         
            }else if ($reg->estatus=='Procesado'){
               $estatus='<h5 '.$al.'center'.$w.'100px;"><span class="label bg-primary">Procesado</span></h5>';         
            }
        
            if($reg->estatus=='Registrado'&& $reg->origen=='Banco')
				{
					$tipoorigen='<h5 small '.$al.'center'.$w.'110px;" class="small">
					<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovcaja.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
					'<button class="btn btn-success btn-xs" onclick="anular('.$reg->idmovcaja.',\''.$reg->idcaja.'\')" '.$dtg.'Anular"><i class="fa fa-check-square"></i></button>'.
					'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmovcaja.',\''.$reg->idcaja.'\')" '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
					'<a target="_blank" href="'.$url.$reg->idmovcaja.'"><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button></a>
					</h5>';
				}else if($reg->estatus=='Registrado'&& $reg->origen!='Banco')
				{
					$tipoorigen='<h5 small '.$al.'center'.$w.'110px;" class="small">
					<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovcaja.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
					'<button class="btn btn-success btn-xs" disabled '.$dtg.'Anular"><i class="fa fa-check-square"></i></button>'.
					'<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
					'<a target="_blank" href="'.$url.$reg->idmovcaja.'"><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button></a>
					</h5>';
				}
				else if($reg->estatus=='Procesado')
				{
					$tipoorigen='<h5 small '.$al.'center'.$w.'110px;" class="small">
					<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovcaja.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
					'<button class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="fa fa-trash"></i></button>'.
					'<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
					'<a target="_blank" href="'.$url.$reg->idmovcaja.'" ><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i>
					</button></a>
					</h5>';
				}
				else
				{
					$tipoorigen='<h5 small '.$al.'center'.$w.'110px;" class="small">
					<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idmovcaja.')" '.$dtg.'Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
					'<button class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="fa fa-trash"></i></button>'.
					'<button class="btn btn-danger btn-xs" disabled '.$dtg.'Eliminar"><i class="fa fa-remove"></i></button>'.
					'<a target="_blank" href="'.$url.$reg->idmovcaja.'" ><button class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i>
					</button></a>
					</h5>';
            }
            
            $data[]=array(

            "0"=>$tipoorigen,
            "1"=>'<h5 '.$al.'center'.$w.'90px;">'.$reg->fechareg.'</h5>',
            "2"=>'<h5 '.$al.''.$w.'100px;">'.$reg->cod_movcaja.'</h5>',
				"3"=>'<h5 '.$al.''.$w.'200px;">'.$reg->cod_caja.'-'.$reg->desc_caja.'</h5>',        
				"4"=>'<h5 '.$al.'center'.$w.'80px;">'.$reg->tipo.'</h5>',
				"5"=>'<h5 '.$al.'center'.$w.'80px;">'.$reg->forma.'</h5>',
				"6"=>($reg->montod==0)?
				'<h5 '.$al.'right'.$w.'150px;">'.number_format($reg->montoh,2,",",".").'</h5>':
				'<h5 '.$al.'right'.$w.'150px;">'.number_format($reg->montod,2,",",".").'</h5>', 
				"7"=>'<h5 '.$al.''.$w.'120px;">'.$reg->numerod.'</h5>',
				"8"=>'<h5 '.$al.''.$w.'120px;">'.$reg->numeroc.'</h5>',
				"9"=>$estatus,
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case 'selectOperacion':
      require_once '../database/Operacion.php';
      $operacion=new Operacion();
      $origen=$_POST['origen'];

      $rspta=$operacion->SelectOp($origen);
  
      while ($reg=$rspta->fetch_object()) {
         echo '<option value="'.$reg->idoperacion.'">'.$reg->cod_operacion.'-'.$reg->desc_operacion.'</option>';     
      }
   break;

   case 'caja':
      require_once '../database/Caja.php';
      $caja=new Caja();
      $op=$_POST['op'];

      if ($op=='select') {
         $rspta=$caja->Select();
   
          while ($reg=$rspta->fetch_object()) {
             echo '<option value="'.$reg->idcaja.'">'.$reg->desc_caja.'</option>';
         }
      } 
      elseif ($op=='data'){

      $rspta=$caja->Mostrar($_POST['id']);         
      echo json_encode($rspta);
      }
   break;

   case 'banco':
      require_once '../database/Banco.php';
      $banco=new Banco();
      $op=$_POST['op'];

      if ($op=='select') {
         $rspta=$banco->Select();
   
          while ($reg=$rspta->fetch_object()) {
             echo '<option value="'.$reg->idbanco.'">'.$reg->desc_banco.'</option>';
         }
      } 
      elseif ($op=='data'){

      $rspta=$banco->Mostrar($_POST['id']);         
      echo json_encode($rspta);
      }
   break;
}
?>