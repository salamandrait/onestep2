<?php
require_once "../database/Articulo.php";
$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idlinea=isset($_POST["idlinea"])? limpiarCadena($_POST["idlinea"]):"";
$idimpuesto=isset($_POST["idimpuesto"])? limpiarCadena($_POST["idimpuesto"]):"";
$cod_articulo=isset($_POST["cod_articulo"])? limpiarCadena($_POST["cod_articulo"]):"";
$desc_articulo=isset($_POST["desc_articulo"])? limpiarCadena($_POST["desc_articulo"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$artref=isset($_POST["artref"])? limpiarCadena($_POST["artref"]):"";
$stockmin=isset($_POST["stockmin"])? limpiarCadena($_POST["stockmin"]):"";
$stockmax=isset($_POST["stockmax"])? limpiarCadena($_POST["stockmax"]):"";
$stockped=isset($_POST["stockped"])? limpiarCadena($_POST["stockped"]):"";
$alto=isset($_POST["alto"])? limpiarCadena($_POST["alto"]):"";
$ancho=isset($_POST["ancho"])? limpiarCadena($_POST["ancho"]):"";
$peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
$comision=isset($_POST["comision"])? limpiarCadena($_POST["comision"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$costo=isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";
$mgp1=isset($_POST["mgp1"])? limpiarCadena($_POST["mgp1"]):"";
$mgp2=isset($_POST["mgp2"])? limpiarCadena($_POST["mgp2"]):"";
$mgp3=isset($_POST["mgp3"])? limpiarCadena($_POST["mgp3"]):"";
$precio1=isset($_POST["precio1"])? limpiarCadena($_POST["precio1"]):"";
$precio2=isset($_POST["precio2"])? limpiarCadena($_POST["precio2"]):"";
$precio3=isset($_POST["precio3"])? limpiarCadena($_POST["precio3"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$costoprecio=isset($_POST["costoprecio"])? limpiarCadena($_POST["costoprecio"]):"";
$imagen=isset($_POST["imagena"])? limpiarCadena($_POST["imagena"]):"";
$condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";
$iddeposito=isset($_POST["iddeposito"])? limpiarCadena($_POST["iddeposito"]):"";
$pnumdecimal=2;
$inumdecimal=0;

switch ($_POST['opcion']){

   case 'guardaryeditar':

      if (!file_exists($_FILES['imagena']['tmp_name']) || !is_uploaded_file($_FILES['imagena']['tmp_name'])){
			$imagen=$_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["imagena"]["name"]);
			$_FILES['imagena']['tmp_name']=="../files/articulos/".$cod_articulo.'.'.end($ext)?
			unlink("../files/articulos/".$cod_articulo.'.'.end($ext)):'';
			if (
				$_FILES['imagena']['type'] == "image/jpg" || 
				$_FILES['imagena']['type'] == "image/jpeg" || 
				$_FILES['imagena']['type'] == "image/bmp" ||
				$_FILES['imagena']['type'] == "image/png"){
				$imagen = $cod_articulo.'.'.end($ext);
				move_uploaded_file($_FILES["imagena"]["tmp_name"], "../files/articulos/".$imagen);
			}
		}


    if (empty($idarticulo)){
       $rspta=$articulo->Insertar($idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,$artref,
       $stockmin,$stockmax,$stockped,$alto,$ancho,$peso,$comision,$costo,$mgp1,$mgp2,$mgp3,$precio1,$precio2,$precio3,$fechareg,$costoprecio,
       $imagen);
       echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
   } else {
       $rspta=$articulo->Editar($idarticulo,$idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,
       $origen,$artref,$stockmin,$stockmax,$stockped,$alto,$ancho,$peso,$comision,$costo,$mgp1,$mgp2,$mgp3,$precio1,$precio2,$precio3,
       $fechareg,$imagen,$costoprecio);
       echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
   }
   break;

   case 'desactivar':
      $rspta=$articulo->Desactivar($idarticulo);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$articulo->Eliminar($idarticulo);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'activar':
      $rspta=$articulo->Activar($idarticulo);
      echo $rspta=='1'?"Registro Activado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$articulo->Mostrar($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;

   case 'mostrarCod':
      $rspta=$articulo->MostrarCod($_POST['cod']);
      echo json_encode($rspta);
   break;
   
   case 'listar':
      $rspta=$articulo->Listar();
      //Vamos a declarar un array
      $data= Array();

      while ($reg=$rspta->fetch_object()){

         $al='style="text-align:';
         $w='; width:';
         $data[]=array(

            "0"=>($reg->estatus)?
				'<h5 small '.$al.'center'.$w.'150px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="desactivar('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button>'.
            '<button class="btn bg-aqua-active btn-xs" onclick="mostrarUnidad('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Unidades y Stock"><i class="fa fa-cube"></i></button>'.	
            '<button class="btn bg-green-active btn-xs" onclick="mostrarCostoPrecio('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Costos y Precios"><i class="fa fa-money"></i></button>'.	
            '<button class="btn bg-purple-active btn-xs" onclick="mostrarImagen('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Imagen"><i class="fa fa-image"></i></button>'.
            '</h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'150px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" onclick="activar('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button>'.
            '<button class="btn bg-aqua-active btn-xs" onclick="mostrarUnidad('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Unidades y Stock"><i class="fa fa-cube"></i></button>'.	
            '<button class="btn bg-green-active btn-xs" onclick="mostrarCostoPrecio('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Costos y Precios"><i class="fa fa-money"></i></button>'.	
            '<button class="btn bg-purple-active btn-xs" onclick="mostrarImagen('.$reg->idarticulo.')" data-toggle="tooltip" data-placement="right" title="Imagen"><i class="fa fa-image"></i></button>'.
            '</h5>'	 
				,
				"1"=>'<h5 '.$al.''.$w.'150px;">'.$reg->cod_articulo.'</h5>',
            "2"=>'<h5 '.$al.''.$w.'420px;">'.$reg->desc_articulo.'</h5>',
            "3"=>'<h5 '.$al.''.$w.'300px;">'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</h5>',
            "4"=>'<h5 '.$al.''.$w.'250px;">'.$reg->desc_linea.'</h5>',
            "5"=>'<h5 '.$al.''.$w.'150px;">'.$reg->artref.'</h5>',
            "6"=>'<h5 '.$al.'right'.$w.'80px;">'.number_format($reg->stock,$inumdecimal).'</h5>',
            "7"=>'<h5 '.$al.'right'.$w.'150px;">'.number_format($reg->costo,$pnumdecimal,",",".").'</h5>',
            "8"=>'<h5 '.$al.'right'.$w.'150px;">'.number_format($reg->precio1,$pnumdecimal,",",".").'</h5>',   
				"9"=>($reg->estatus)?
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

   case "selectUnidad":
		require_once "../database/Unidad.php";
		$unidad = new Unidad();

		$rspta = $unidad->Select();

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idunidad.'>'.$reg->cod_unidad.'-'.$reg->desc_unidad.'</option>';
		}
	break;

   case 'listarUnidad':
		$rspta=$articulo->ListarArtUnidad($idarticulo);
		//Vamos a declarar un array
		$data= Array();

		while ($reg=$rspta->fetch_object()){
		$data[]=array(
			"0"=>
			'<h5 small style="text-align:center; width:50px" class="small btn-group">
			<button type="button" class="btn btn-primary btn-xs" onclick="editarUnidad('.$reg->idarticulo.',\''.$reg->idartunidad.'\')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
			'<button type="button" class="btn btn-danger btn-xs" onclick="eliminarUnidad('.$reg->idartunidad.',\''.$reg->idarticulo.'\')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>',
			"1"=>'<h5 style="width:200px;">'.$reg->cod_unidad.'-'.$reg->desc_unidad.'</h5>',
			"2"=>'<h5 class="text-right" style="width:50px;">'.number_format($reg->valor,$inumdecimal).'</h5>',
			"3"=>($reg->principal)?
			'<h5 class="text-center"><input type="checkbox" value="1" checked></h5>':
			'<h5 class="text-center"><input type="checkbox"value="0"></h5>',	
		);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
   break;

   case 'mostrarUnd':
		$rspta=$articulo->MostrarArtUnidad($idarticulo,$_POST['idartunidad']);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;
   
   case 'eliminarUnd':
		$rspta=$articulo->EliminarUnidad($_POST['idartunidad']);
		echo $rspta ? "Registro Eliminado correctamente!":"Registro no se puede Eliminar!";	
	break;

	case 'guardareditarUnidad':

		$idartunidad=$_POST['idartunidad'];

		if (empty($idartunidad)){
			$rspta=$articulo->InsertarArtUnidad($_POST['idarticulou'],$_POST['idunidad'],$_POST['principal'],$_POST['valor']);
			echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
		} else{
			$rspta=$articulo->EditarArtUnidad($_POST['idartunidad'],$_POST['idunidad'],$_POST['principal'],$_POST['valor']);
			echo $rspta=='1'?"Registro Actualizado Correctamente!":$rspta;
		}
	break;

   case "selectCategoria":
		require_once "../database/Categoria.php";
		$categoria = new Categoria();
		$rspta = $categoria->Select();

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcategoria.'>'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</option>';
		}
	break;

	case "selectLinea":
		require_once "../database/Linea.php";
		$linea = new Linea();
		$rspta = $linea->SelectCT($idcategoria);

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idlinea.'>'.$reg->cod_linea.'-'.$reg->desc_linea.'</option>';	
		}
	break;

	case "Linea":
		require_once "../database/Linea.php";
		$linea = new Linea();

		$rspta = $linea->SelectL($_POST['id']);

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idlinea.'>'.$reg->cod_linea.'-'.$reg->desc_linea.'</option>';
		}
   break;
   
   case 'ListarStock':
		require_once "../database/Deposito.php";
		$deposito = new Deposito();

		$rspta=$deposito->ListarStock($_POST['id']);
		//Vamos a declarar un array
		$totalst=0;

		echo '
		<thead class="bg-gray-active">
			<th style="text-align:center;" class="nd">Deposito</th>
			<th style="width:100px; text-align:center;" class="nd">Stock</th>
		</thead>
		';
		while ($reg = $rspta->fetch_object())
		{
		echo $fila=
			'<tr class="filas">
				<td>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</td>
				<td style="text-align:right; width:100px;"><span class="numberf">'.number_format($reg->stock,$inumdecimal,",",".").'</span></td>
				</tr>',
			$totalst+=$reg->stock;		
		}
		echo '<tfoot>      
				<th><h5 style="text-align:right;"><B>Total Unidad(s) en Stock :</B></h5></th>
				<th><h4 style="text-align:right;"><B><span id="lbtotalstock">'.number_format($totalst,$inumdecimal,",",".").'</span></B></h4></th>
			</tfoot>';
	break;


	case "selectImpuesto":
		require_once "../database/Impuesto.php";
		$impuesto = new Impuesto();

		$rspta = $impuesto->Select();

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idimpuesto.'>'.$reg->simbolo.'</option>';
		}
	break;

	case 'Impuesto':
		require_once "../database/Impuesto.php";
		$impuesto = new Impuesto();

		$rspta=$impuesto->Mostrar($_POST['id']);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;

}
?>