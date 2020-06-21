<?php
require_once "../database/Traslado.php";
$traslado=new Traslado();

$idtraslado=isset($_POST["idtraslado"])? limpiarCadena($_POST["idtraslado"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_traslado=isset($_POST["cod_traslado"])? limpiarCadena($_POST["cod_traslado"]):"";
$desc_traslado=isset($_POST["desc_traslado"])? limpiarCadena($_POST["desc_traslado"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

//valores Array para Proceso por POST
//  name="idarticulo[]" id="idarticulo" value="'+idarticulov+'">'+
//  name="iddepositoi[]" id="iddepositoi" value="'+iddepositoi+'">'+
//  name="iddepositod[]" id="iddepositod" value="'+iddepositod+'">'+
//  name="disp[]" id="disp[]" value="'+dispv+'">'+
//  name="stock[]" id="stock[]" value="'+stockv+'">'+
//  name="tipo[]" id="tipo[]" value="'+tipov+'">'+
//  name="valor[]" id="valor[]" value="'+valorv+'">'+
//  name="idartunidad[]" id="idartunidadr[]" value="'+idartunidadv+'"></td>'+

switch ($_POST['opcion']){

   case 'guardaryeditar':
    if (empty($idtraslado)){
      $rspta=$traslado->Insertar($idusuario,$cod_traslado,$desc_traslado,$totalh,$fechareg,$_POST["idarticulo"],$_POST["iddepositoi"],
      $_POST["iddepositod"],$_POST["cantidad"],$_POST["costo"],$_POST["idartunidad"]);
      $rspta=$traslado->RemoveStockArt($_POST["idarticulo"],$_POST["iddepositoi"],$_POST["cantidad"],$_POST["valor"]);
      $rspta=$traslado->AddStockArt($_POST["idarticulo"],$_POST["iddepositod"],$_POST["cantidad"],$_POST['valor'],$_POST["disp"],$_POST["tipo"]);
      $rspta=$traslado->ActCod();
      echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } 
   break;

   case 'anular':
      $rspta=$traslado->Anular($idtraslado);
      $rspta=$traslado->AnularStock($idtraslado);
      echo $rspta=='1'?"Registro Anulado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$traslado->AnularStock($idtraslado);
      $rspta=$traslado->Eliminar($idtraslado);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$traslado->Mostrar($idtraslado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$traslado->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         if ($reg->estatus=='Registrado') {
               $estatus='<h5 '.$al.'center'.$w.'80px;"><span class="label bg-green">Registrado</span></h5>';         
         } else if ($reg->estatus=='Anulado'){
               $estatus='<h5 '.$al.'center'.$w.'80px;"><span class="label bg-red-active">Anulado</span></h5>';         
         }else if ($reg->estatus=='Procesado'){
               $estatus='<h5'.$al.'center'.$w.'80px;"><span class="label bg-primary">Procesado</span></h5>';         
         }
         $url='../reportes/rptFormatoTraslado.php?id=';
         $data[]=array(

            "0"=>($reg->estatus=='Registrado')?
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idtraslado.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="anular('.$reg->idtraslado.')" data-toggle="tooltip" data-placement="right" title="Anular"><i class="glyphicon glyphicon-ban-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idtraslado.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'70px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idtraslado.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="anular('.$reg->idtraslado.')" data-toggle="tooltip" data-placement="right" title="Anulado"><i class="glyphicon glyphicon-exclamation-sign"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idtraslado.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 
				,
            
            "1"=>'<h5 '.$al.'center'.$w.'90px;">'.$reg->fechareg.'</h5>',
            "2"=>'<h5 '.$al.'center'.$w.'100px;">'.$reg->cod_traslado.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'220px;">'.$reg->cod_depositoi.'-'.$reg->desc_depositoi.'</h5>',
            "4"=>'<h5 '.$al.''.$w.'220px;">'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</h5>',
            "5"=>'<h5 '.$al.'right'.$w.'150px;">'.number_format($reg->totalh,2,",",".").'</h5>',
            "6"=>$estatus,
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case 'listarDetalle':
		//Recibimos el idingreso
        $id=$_POST['id'];
        $cont=0;
        $al='style="text-align:';
        $w='; width:';

		$rspta=$traslado->listarDetalle($id);
        echo 
            '<thead class="btn-primary">
			<th '.$al.'center'.$w.'25px;" class="nd">E</th>
            <th '.$al.'center'.$w.'120px;" class="nd">Codigo</th>
            <th style="width:350px;">Artículo</th>
            <th '.$al.'center'.$w.'90px;" class="nd">Unidad</th>
            <th '.$al.'right'.$w.'70px;" class="nd">Cantidad</th>
            <th '.$al.'right'.$w.'120px;" class="nd">Costo</th>
            <th '.$al.'right'.$w.'150px;" class="nd">Total Reng.</th>
            </thead>';
            while ($reg = $rspta->fetch_object())
                {
                echo
            $fila='<tr class="filas id="fila'.($cont+1).'">
                <td style="width:25px;"><span style="width:25px; "text-align:center;" class="label bg-red">'.($cont+1).'</span></td>
                <td style="width:120px;">'.$reg->cod_articulo.'</td>
                <td style="width:350px;"><span style="font-size:12px">'.$reg->desc_articulo.'</span></td>
                <td '.$al.''.$w.'90px;">'.$reg->desc_unidad.'</td>
                <td '.$al.'right'.$w.'70px; padding-right:4px">'.number_format($reg->cantidad,0).'</td>
                <td '.$al.'right'.$w.'120px; padding-right:4px">'.number_format($reg->costo,2,",",".").'</span></td>
                <td '.$al.'right'.$w.'150px; padding-right:4px">'.number_format($reg->totald,2,",",".").'</span></td>
               </tr>',
               $cont++;
            };
   break;  

   case "listarArticulos":
      require_once "../database/Articulo.php";
      $articulo = new Articulo();

      $rspta=$articulo->SelectTraslado($_POST['deporigen'],$_POST['depdestino']);

      //Vamos a declarar un array
      $data= Array();

      //idarticulo,iddeposito,cod_articulo,desc_articulo,tipor,costo,stock,disp

      while ($reg=$rspta->fetch_object()){
          $data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="agregarDetalle
            ('.$reg->idarticulo.',\''.$reg->iddeposito.'\',\''.$reg->cod_articulo.'\',\''.$reg->desc_articulo.'\',
             \''.$reg->tipo.'\',\''.$reg->costo.'\',\''.number_format($reg->stock,0).'\',\''.$reg->disp.'\')" 
            keyup="modificarSubototales();" style="text-align:center; width:20px;"><span class="fa fa-plus"></span></button>',
            "1"=>'<h5 style="width:150px;">'.$reg->cod_articulo.'</h5>',
            "2"=>'<h5 style="width:400px;">'.$reg->desc_articulo.'</h5>',
            "3"=>'<h5 style="text-align:right; width:110px;">'.$reg->artref.'</h5>',
            "4"=>'<h5 style="text-align:right; width:50px;">'.number_format($reg->stock,0).'</h5>',
            "5"=>'<h5 style="text-align:right; width:120px;">'.number_format($reg->costo,2,",",".").'</h5>',
            );}  
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
      echo json_encode($results);
   break;

   case "selectUnidad":
      require_once "../database/Articulo.php";
      $articulo = new Articulo();

    $rspta = $articulo->ListarArtUnidad($_POST['idarticulo']);

    while ($reg = $rspta->fetch_object())
    {
       echo '<option value='.$reg->idartunidad.'>'.$reg->desc_unidad.'</option>';
    }
   break;

   case "Unidad":
      require_once "../database/Articulo.php";
      $articulo = new Articulo();

      $rspta = $articulo->MostrarArtUnidadId($_POST['id']);
      echo json_encode($rspta);
   break;

   case "selectDeposito":
      require_once "../database/Deposito.php";
      $deposito = new Deposito();

      $rspta = $deposito->select();

      while ($reg = $rspta->fetch_object())
      {
         echo '<option value='.$reg->iddeposito.'>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</option>';
      }
  break;
  
   case "Moneda":
      require_once "../database/Moneda.php";
      $moneda = new Moneda();

      $rspta = $moneda->SelectOp();

      while ($reg = $rspta->fetch_object())
      {
         echo $reg->cod_moneda;
      }
   break;
}
?>