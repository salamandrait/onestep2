<?php
require_once "../database/Ajustep.php";
$ajustep=new Ajustep();

$idajustep=isset($_POST["idajustep"])? limpiarCadena($_POST["idajustep"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_ajustep=isset($_POST["cod_ajustep"])? limpiarCadena($_POST["cod_ajustep"]):"";
$desc_ajustep=isset($_POST["desc_ajustep"])? limpiarCadena($_POST["desc_ajustep"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_POST['opcion']){
   case 'guardaryeditar':
   if (empty($idajustep)){
      $rspta=$ajustep->Insertar($idusuario,$cod_ajustep,$desc_ajustep,$tipo,$fechareg,
      $_POST['idarticulo'],$_POST['tasa'],$_POST['tipoprecio'],$_POST['mgp'],$_POST['precio'],$_POST['costo']);
      $rspta=$ajustep->ActCod();
      echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;       
   } 
   break;

   case 'mostrarCod':
       
      $rspta=$ajustep->MostrarCod($_POST['cod']);
      echo json_encode($rspta);
   break;

   case 'procesarc':
      $rspta=$ajustep->Procesar($idajustep); 
      $rspta=$ajustep->ProcesarC($_POST['idarticulo'],$_POST['costo']);
      echo $rspta=='1'?"Registro Procesado Correctamente!":$rspta;
   break;

   case 'procesarp':
      $rspta=$ajustep->Procesar($idajustep); 
      $rspta=$ajustep->ProcesarP($_POST['tipoprecio'],$_POST['idarticulo'],$_POST['mgp'],$_POST['precio']);
       echo $rspta=='1'?"Registro Procesado Correctamente!":$rspta;
   break;

   case 'anular':
      $rspta=$ajustep->Anular($idajustep);
      echo $rspta=='1'?"Registro Desactivado Correctamente!":$rspta;
   break;

   case 'eliminar':
      $rspta=$ajustep->Eliminar($idajustep);
      echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
   break;

   case 'mostrar':
		$rspta=$ajustep->Mostrar($idajustep);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
   break;

   case 'mostrarDetalle':
      $fila='';
      $cont=0;
      $parfila='type="text" class="form-control text-right" onchange="modificarSubtotales();" readonly style="height:25px; width:';
      switch ($tipo) {
         case 'Precio':
          $rspta=$ajustep->MostrarDetalle($idajustep,$tipo);
            echo '<thead class="btn-primary">
               <th class="nd text-center" style="width:30px;">R</th>
               <th class="nd text-center" style="width:150px;">Código</th>
               <th class="nd text-center" style="width:400px;">Artículo</th>
               <th class="nd text-center" style="width:150px;">Precio</th>
               <th class="nd text-center" style="width:60px;">MG(%)</th>
               <th class="nd text-center" style="width:150px;">Precio+MG.</th>
               <th class="nd text-center" style="width:150px;">Precio+Imp.</th>
            </thead>';
            while ($reg=$rspta->fetch_object()){
            echo
               $fila='<tr class="filas" id="fila'.($cont+1).'" style="border:1px solid #ddd">
               <td><span class="label label-danger pull-right">'.($cont+1).'</span>
               <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="hidden">
               <input name="tasa[]" id="tasa[]" value="'.$reg->tasa.'" type="hidden">
               <input name="tipoprecio[]" id="tipoprecio[]" value="'.$reg->tipoprecio.'" type="hidden">
               <input name="costo[]" id="costo[]" value="0" type="hidden">
               <input name="precio[]" id="precio[]" value="'.$reg->precio.'" onchange="modificarSubtotales();" type="hidden">
               <input name="mgp[]" id="mgp[]" value="'.$reg->mgp.'" onchange="modificarSubtotales();" type="hidden">
               </td>
               <td><h5 style="width:150px;">'.$reg->cod_articulo.'</h5></td>
               <td><h5 style="width:400px">'.$reg->desc_articulo.'</h5></td>
               <td><h5 style="width:150px;" class="text-right">'.number_format($reg->precio,2,'.',',').'</h5></td>
               <td><h5 style="width:60px;" class="text-right">'.number_format($reg->mgp,0).'</h5></td>
               <td><h5 style="width:150px;" class="numberf text-right" name="subtotal">0</h5></td>
               <td><h5 style="width:150px;" class="numberf text-right" name="totalp">0</h5></td>
               </tr>';
               $cont++;
            };
            echo 
               '<tfoot>
               <th><input id="detalles" value="'.($cont++).'" class="hidden"></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               </tfoot>'; 
         break;

         case 'Costo':
           $rspta=$ajustep->MostrarDetalle($idajustep,$tipo);
            echo '<thead class="btn-primary">
               <th class="nd text-center" style="width:30px;">R</th>
               <th class="nd text-center" style="width:150px;">Código</th>
               <th class="nd text-center" style="width:400px;">Artículo</th>
               <th class="nd text-center" style="width:150px;">Cósto</th>
               <th class="nd text-center" style="width:120px;">Impuesto</th>
               <th class="nd text-center" style="width:150px;">Total Costo</th>
            </thead>';
            while ($reg=$rspta->fetch_object()){
            echo
               $fila='<tr class="filas" id="fila'.($cont+1).'" style="border:1px solid #ddd">
               <td><span class="label label-danger pull-right">'.($cont+1).'</span>
               <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="hidden">
               <input name="tasa[]" id="tasa[]" value="'.$reg->tasa.'" type="hidden">
               <input name="tipoprecio[]" id="tipoprecio[]" value="0" type="hidden">
               <input name="costo[]" id="costo[]" value="'.$reg->costo.'" onchange="modificarSubtotales();" type="hidden">
               <input name="precio[]" id="precio[]" value="0" type="hidden">
               <input name="mgp[]" id="mgp[]" value="0" type="hidden">
               </td>
               <td><h5 style="width:150px;">'.$reg->cod_articulo.'</h5></td>
               <td><h5 style="width:400px">'.$reg->desc_articulo.'</h5></td>
               <td><h5 style="width:150px;" class="numberf text-right">'.$reg->costo.'</h5></td>
               <td><h5 style="width:120px;" class="numberf text-right" name="imp">0</h5></td>
               <td><h5 style="width:150px;" class="numberf text-right" name="totalc">0</h5></td>
               </tr>';
               $cont++;
            };
            echo 
               '<tfoot>
               <th><input id="detalles" value="'.($cont++).'" class="hidden"></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               </tfoot>'; 
         break;  
      }
   break;
   
   case 'listar':
      $rspta=$ajustep->Listar();
      //Vamos a declarar un array
      $data= Array();

         while ($reg=$rspta->fetch_object()){

            $al='style="text-align:';
            $w='; width:';

               if ($reg->estatus=='Registrado') {
                  $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-green">Registrado</span></h5>';         
               } else if ($reg->estatus=='Anulado'){
                  $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-red-active">Anulado</span></h5>';         
               }else if ($reg->estatus=='Procesado'){
                  $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado</span></h5>';         
               }

            $data[]=array(

            "0"=>($reg->estatus=='Registrado')?
				'<h5 small '.$al.'center'.$w.'120px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idajustep.',\''.$reg->tipo.'\')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="anular('.$reg->idajustep.')" data-toggle="tooltip" data-placement="right" title="Anular"><i class="glyphicon glyphicon-ban-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idajustep.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="glyphicon glyphicon-remove-sign"></i></button></h5>'	 	 	
				:
				'<h5 small '.$al.'center'.$w.'120px;" class="small">
				<button class="btn btn-primary btn-xs" onclick="mostrar('.$reg->idajustep.',\''.$reg->tipo.'\')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-warning btn-xs" disabled onclick="anular('.$reg->idajustep.')" data-toggle="tooltip" data-placement="right" title="Anular"><i class="glyphicon glyphicon-exclamation-sign"></i></button>'.
				'<button class="btn btn-danger btn-xs" disabled onclick="eliminar('.$reg->idajustep.')" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="glyphicon glyphicon-remove-sign"></i></button></h5>'	 
				,
				"1"=>'<h5 '.$al.'center'.$w.'100px;">'.$reg->fechareg.'</h5>',
            "2"=>'<h5 '.$al.'center'.$w.'120px;">'.$reg->cod_ajustep.'</h5>',
            "3"=>'<h5>'.$reg->desc_ajustep.'</h5>',
				"4"=>'<h5 '.$al.'center'.$w.'100px;">'.$reg->tipo.'</h5>',  
				"5"=>$estatus
         );
      }
      $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
      echo json_encode($results);
   break;

   case 'listarArticulo':
      require '../database/Articulo.php';
      $articulo= new Articulo();
      $fila='';
      $cont=0;
      $parfila='type="text" class="form-control input-sm text-right" onchange="modificarSubtotales();" style="height:25px; font-size:14px; width:';
      $tipo=$_POST['tipo'];

      switch ($tipo) {
         case 'Precio':
          $rspta=$articulo->SelectAjustePrecio($_POST['tipop'],$_POST['costoaprecio']);
            echo '<thead class="btn-primary">
               <th class="nd text-center" style="width:30px;">R</th>
               <th class="nd text-center" style="width:150px;">Código</th>
               <th class="nd text-center" style="width:400px;">Artículo</th>
               <th class="nd text-center" style="width:150px;">Precio</th>
               <th class="nd text-center" style="width:60px;">MG(%)</th>
               <th class="nd text-center" style="width:150px;">Precio+MG.</th>
               <th class="nd text-center" style="width:150px;">Precio+Imp.</th>
            </thead>';
            while ($reg=$rspta->fetch_object()){
            echo
               $fila='<tr class="filas" id="fila'.($cont+1).'" style="border:1px solid #ddd">
               <td><h5 class="text-center" style="width:30px">
               <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle('.($cont+1).')">
               <span class="fa fa-times-circle"></span></button></h5>
               <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="hidden">
               <input name="tasa[]" id="tasa[]" value="'.$reg->tasa.'" type="hidden">
               <input name="tipoprecio[]" id="tipoprecio[]" value="'.$_POST['tipop'].'" type="hidden">
               <input name="costo[]" id="costo[]" value="0" type="hidden">
               </td>
               <td><h5 style="width:150px;">'.$reg->cod_articulo.'</h5></td>
               <td><h5 style="width:400px">'.$reg->desc_articulo.'</h5></td>
               <td><input name="precio[]" id="precio[]" value="'.$reg->precio.'" '.$parfila.'150px;"></td>
               <td><input name="mgp[]" id="mgp[]" value="'.number_format($reg->mgp,0).'" '.$parfila.'60px;"></td>
               <td><h5 style="width:150px;" class="numberf text-right" name="subtotal">0</h5></td>
               <td><h5 style="width:150px;" class="numberf text-right" name="totalp">0</h5></td>
               </tr>';
               $cont++;
            };
            echo 
               '<tfoot>
               <th><input id="detalles" value="'.($cont++).'" class="hidden"></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               </tfoot>'; 
         break;

         case 'Costo':
            $rspta=$articulo->SelectAjusteCosto();
            echo '<thead class="btn-primary">
               <th class="nd text-center" style="width:30px;">R</th>
               <th class="nd text-center" style="width:150px;">Código</th>
               <th class="nd text-center" style="width:400px;">Artículo</th>
               <th class="nd text-center" style="width:150px;">Cósto</th>
               <th class="nd text-center" style="width:120px;">Impuesto</th>
               <th class="nd text-center" style="width:150px;">Total Costo</th>
            </thead>';
            while ($reg=$rspta->fetch_object()){
            echo
               $fila='<tr class="filas" id="fila'.($cont+1).'" style="border:1px solid #ddd">
               <td><h5 class="text-center" style="width:30px">
               <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle('.($cont+1).')">
               <span class="fa fa-times-circle"></span></button></h5>
               <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="hidden">
               <input name="tipoprecio[]" id="tipoprecio[]" value="" type="hidden">
               <input name="precio[]" id="precio[]" value="0" type="hidden">
               <input name="mgp[]" id="mgp[]" value="0" type="hidden">
               <input name="tasa[]" id="tasa[]" value="'.$reg->tasa.'" type="hidden">
               </td>
               <td><h5 style="width:150px;">'.$reg->cod_articulo.'</h5></td>
               <td><h5 style="width:400px">'.$reg->desc_articulo.'</h5></td>
               <td><input name="costo[]" id="costo[]" value="'.$reg->costo.'" '.$parfila.'150px;"></td>
               <td><h5 style="width:120px;" class="numberf text-right" name="imp">0</h5></td>
               <td><h5 style="width:150px;" class="numberf text-right" name="totalc">0</h5></td>
               </tr>';
               $cont++;
            };
            echo 
               '<tfoot>
               <th><input id="detalles" value="'.($cont++).'" class="hidden"></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               </tfoot>'; 

         break;  
      }
   break;

}
?>