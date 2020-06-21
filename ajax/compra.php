<?php
require_once '../database/Compra.php';
$compra=new Compra();

$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_compra=isset($_POST["cod_compra"])? limpiarCadena($_POST["cod_compra"]):"";
$desc_compra=isset($_POST["desc_compra"])? limpiarCadena($_POST["desc_compra"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$numerod=isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
$numeroc=isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
$origend=isset($_POST["origend"])? limpiarCadena($_POST["origend"]):"";
$origenc=isset($_POST["origenc"])? limpiarCadena($_POST["origenc"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$subtotalh=isset($_POST["subtotalh"])? limpiarCadena($_POST["subtotalh"]):"";
$impuestoh=isset($_POST["impuestoh"])? limpiarCadena($_POST["impuestoh"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$saldoh=isset($_POST["saldoh"])? limpiarCadena($_POST["saldoh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$fechaven=isset($_POST["fechaven"])? limpiarCadena($_POST["fechaven"]):"";

switch ($_POST['opcion']) {

  case 'guardaryeditar':

      if (empty($idcompra)) {

        $rspta=$compra->Insertar($idproveedor,$idcondpago,$idusuario,$cod_compra,$desc_compra,$numerod,$numeroc,$tipo,$origend,
        $origenc,$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,
        $_POST['idarticulo'],$_POST['iddeposito'],$_POST["idartunidad"],$_POST['cantidad'],$_POST['costo'],$_POST['tasa']);  

          if ($tipo!='Cotizacion') {

            $rspta=$compra->AddStockArt($_POST['idarticulo'],$_POST['disp'],$_POST['tipoa'],
            $_POST['iddeposito'],$_POST['cantidad'],$_POST['valor']);
            $rspta=$compra->ActualizarCosto($_POST['idarticulo'],$_POST['costo'],$_POST['valor']);

          }

          if (!empty($_POST['idcompraop']) && $origend!='Cotizacion') {
               $rspta=$compra->ActDetalleImp($_POST['idcompraop'],$origenc);
          }
          if (!empty($_POST['idcompraop'])) {
              $rspta=$compra->ProcesarDocumentoImp($_POST['idcompraop']);
          }
          $rspta=$compra->ActCod($tipo);
          echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;

      }
  break;

  case 'guardarproveedor':
    require_once "../database/Proveedor.php";
    $proveedor = new Proveedor();
    $rspta=$proveedor->InsertarDirecto($_POST['cod_proveedora'],$_POST['rifa'],$_POST['desc_proveedora']);
    echo $rspta=='1'?"Registro Ingresado Correctamente!":$rspta;
  break;

  case 'generarCod':
    $rspta=$compra->GenerarCod($tipo);
    echo json_encode($rspta);
  break;

  case 'eliminar':
    if (($tipo!='Cotizacion') && (empty($origenc)) && ($origend!='Cotizacion')){
      $rspta=$compra->ActDetalle($idcompra);
      (!empty($origenc))?$rspta=$compra->AnularProcesarDocumentoImp($origenc,$origend,$totalh):'';
    }  
    $rspta=$compra->Eliminar($idcompra);
    echo $rspta=='1'?"Registro Eliminado Correctamente!":$rspta;
  break;

  case 'anular': 
    if ($tipo!='Cotizacion' && empty($origenc)){
      $rspta=$compra->ActDetalle($idcompra);
    } if ($tipo!='Cotizacion' && !empty($origenc) && $origend=='Cotizacion'){
      $rspta=$compra->ActDetalle($idcompra);
    } 
    (!empty($origenc))?$rspta=$compra->AnularProcesarDocumentoImp($origenc,$origend,$totalh):'';
    $rspta=$compra->Anular($idcompra);
    echo $rspta=='1'?"Registro Anulado Correctamente!":$rspta;
  break;

  case 'mostrarcompra':
    $rspta=$compra->Mostrar($idcompra);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
  break;

  case "mostrarDetalle":
    $fila='';
    $cont=0;
    $deposito='';    
    $rspta=$compra->MostrarDetalle($idcompra);
    echo '<thead class="btn-primary">
            <th style="text-align:center; width:30px;" class="nd">R</th>
            <th style="text-align:center; width:120px;" class="nd">Código</th>
            <th style="text-align:center; width:400px;" class="nd">Artículo</th>
            <th style="text-align:center; width:90px;" class="nd">Unidad</th>
            <th style="text-align:right; width:50px;" class="nd">Cant.</th>
            <th style="text-align:right; width:130px;" class="nd">Costo Und</th>
            <th style="text-align:right; width:130px;" class="nd">Sub Total</th>
            <th style="text-align:right; width:130px;" class="nd">Imp.</th>
            <th style="text-align:right; width:140px;" class="nd">Total Reng.</th>
        </thead>';
    while ($reg=$rspta->fetch_object()) 
    {
        echo
            $fila='<tbody><tr class="filas" id="fila'.($cont+1).'">
            <td><span class="label label-danger pull-right">'.($cont+1).'</span></td>
            <input name="idcomprad[]" id="idcomprad[]" value="'.$reg->idcomprad.'" type="hidden">
            <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="hidden">
            <input type="hidden" name="iddeposito[]" id="iddeposito[]" value="'.$reg->iddeposito.'">
            <input type="hidden" name="idartunidad[]" id="idartunidad[]" value="'.$reg->idartunidad.'">
            <input name="tipoa[]" id="tipoa[]" value="'.$reg->tipo.'" type="hidden">
            <input name="disp[]" id="disp[]" value="'.$reg->disp.'" type="hidden">
            <input name="tasa[]" id="tasa[]" value="'.$reg->tasa.'" type="hidden">
            <input name="valor[]" id="valor[]" value="'.$reg->valor.'" type="hidden">
            <input type="hidden" name="cantidad[]" id="cantidad[]" value="'.$reg->cantidad.'">
            <input type="hidden" name="costo[]" id="costo[]" value="'.$reg->costo.'"></td>
            <td><h5 style="width:120px;">'.$reg->cod_articulo.'</h5></td>
            <td><h5 style="width:400px; font-size:12px;">'.$reg->desc_articulo.'</h5></td>
            <td><h5 style="width:90px;">'.$reg->desc_unidad.'</h5></td>
            <td><h5 style="text-align:right; width:50px;">'.$reg->cantidad.'</h5></td>
            <td><h5 style="text-align:right; width:130px;" class="numberf">'.$reg->costo.'</h5></td>
            <td><h5 id="subtotal" name="subtotal" style="text-align:right; width:130px;" class="numberf" >0</h5></td>
            <td class="hidden"><h5 style="text-align:right; width:28px;">'.$reg->tasa.'</h5></td>
            <td><h5 style="text-align:right; width:130px;"id="subimp" class="numberf" name="subimp">0</h5></td>
            <td><h5 id="total" name="total" style="text-align:right; width:140px;" class="numberf">0</h5></td>
            </tr></tbody>',
            $cont++;
            $deposito=$reg->iddeposito;	
        };
        echo '<tfoot>
                <th><input id="detalles" value="'.($cont++).'" class="hidden"></th>
                <th><input id="iddepositoimp" value="'.$deposito.'" class="hidden"></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>';
  break;

  case 'listar':
    $rspta=$compra->Listar($tipo);
    //Vamos a declarar un array
    $data= array();

    $al='style="text-align:';
    $w='; width';
    $dtg='data-toggle="tooltip" data-placement="right" title=';
    $btn='button class="btn btn-xs btn-';

    while ($reg=$rspta->fetch_object()) {


      if ($reg->estatus=='Registrado') {
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-green">Registrado</span></h5>';         
      } else if ($reg->estatus=='Anulado'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-red-active">Anulado</span></h5>';         
      }else if ($reg->estatus=='Procesado'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado</span></h5>';         
      } else if ($reg->estatus=='Procesado Parc.'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label bg-primary">Procesado Parc.</span></h5>';         
      }else if ($reg->estatus=='Pagado'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label btn-success">Pagado</span></h5>';         
      } else if ($reg->estatus=='Pago Parc.'){
          $estatus='<h5 '.$al.'center'.$w.':100px;"><span class="label btn-success">Pago Parc.</span></h5>';         
      }

      $data[]=array(

        "0"=>($reg->estatus=='Registrado')?
        '<h5 small '.$al.'center'.$w.':120px" class="small">
        <'.$btn.'primary" onclick="mostrar('.$reg->idcompra.')" '.$dtg.'"Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
        '<'.$btn.'success" onclick="anular('.$reg->idcompra.',\''.$reg->tipo.'\',\''.$reg->origenc.'\',\''.$reg->origend.'\',\''.$reg->totalh.'\')" '.$dtg.'"Anular"><i class="fa fa-check-square"></i></button>'.
        '<'.$btn.'danger" onclick="eliminar('.$reg->idcompra.',\''.$reg->tipo.'\',\''.$reg->origenc.'\',\''.$reg->origend.'\',\''.$reg->totalh.'\')" '.$dtg.'"Eliminar"><i class="fa fa-remove"></i></button>'.
        '<'.$btn.'info" onclick="reporteFormaLibre()"><i class="glyphicon glyphicon-file"></i></button>
        </h5>'
        :
        '<h5 small '.$al.'center'.$w.':120px" class="small">
        <'.$btn.'primary" onclick="mostrar('.$reg->idcompra.')" '.$dtg.'"Mostrar"><i class="fa fa-pencil-square-o"></i></button>'.
        '<'.$btn.'warning" disabled '.$dtg.'"Anulado"><i class="fa fa-trash"></i></button>'.
        '<'.$btn.'danger" disabled '.$dtg.'"Eliminar"><i class="fa fa-remove"></i></button>'.
        '<'.$btn.'info" onclick="reporteFormaLibre()"><i class="glyphicon glyphicon-file"></i></button>
        </h5>'
        ,
        "1"=>'<h5 '.$al.'center'.$w.':90px;">'.$reg->fechareg.'</h5>',
        "2"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->cod_compra.'</h5>',
        "3"=>'<h5 '.$al.''.$w.':450px;">'.$reg->desc_proveedor.'</h5>',
        "4"=>'<h5 '.$al.'center'.$w.':100px;">'.$reg->rif.'</h5>',
        "5"=>'<h5 '.$al.''.$w.':100px;">'.$reg->numerod.'</h5>',
        "6"=>'<h5 '.$al.''.$w.':100px;">'.$reg->numeroc.'</h5>',
        "7"=>'<h5 '.$al.'right'.$w.':130px;" class="sum">'.number_format($reg->totalh, 2,",",".").'</h5>',
        "8"=>$estatus,

      );
    }

    $results = array(
      "sEcho"=>1, //Información para el datatables
      "iTotalRecords"=>count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
      "aaData"=>$data);
    echo json_encode($results);
  break;

  case "listarProveedor":
    require_once "../database/Proveedor.php";
    $proveedor = new Proveedor();

    $rspta=$proveedor->Select();
    //Vamos a declarar un array
    $data= array();
    while ($reg=$rspta->fetch_object()) {
        $data[]=array(

          "0"=>'<h5><button class="btn btn-success btn-xs" onclick="agregarProveedor
          ('.$reg->idproveedor.',\''.$reg->cod_proveedor.'\',\''.$reg->desc_proveedor.'\',\''.$reg->rif.'\',
          \''.$reg->idcondpago.'\',\''.$reg->dias.'\',\''.$reg->limite.'\')">
          <span class="fa fa-check-square-o" style="text-align:center; width:15px;"></span></button></h5>',
          "1"=>'<h5 style="width:100px; text-align:center;">'.$reg->cod_proveedor.'</h5>',
          "2"=>'<h5 style="width:400px;">'.$reg->desc_proveedor.'</h5>',
          "3"=>'<h5 style="width:100px; text-align:center;">'.$reg->rif.'</h>',
          "4"=>'<h5 style="width:120px;">'.$reg->desc_condpago.'</h>'
          );
      }
      $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);
      echo json_encode($results);
  break;

  case "listarArticulo":
    require_once "../database/Articulo.php";
    $articulo = new Articulo();

    $rspta=$articulo->SelectCompra($_POST['id']);
    //Vamos a declarar un array
    $data= array();

    while ($reg=$rspta->fetch_object()) {

      $data[]=array(

        "0"=>'<h5><button class="btn btn-success btn-xs" onclick="agregarDetalle('.$reg->idarticulo.',
        \''.$reg->iddeposito.'\',\''.$reg->cod_articulo.'\',\''.$reg->desc_articulo.'\',
        \''.$reg->tipoa.'\',\''.number_format($reg->costo,2,'.','').'\',\''.number_format($reg->tasa,0).'\',\''.$reg->disp.'\')">
        <span class="fa fa-check-square-o"></span></button></h5>',
        "1"=>'<h5 style="width:130px;">'.$reg->cod_articulo.'</h5>',
        "2"=>'<h5 style="width:400px;">'.$reg->desc_articulo.'</h5>',
        "3"=>'<h5 style="width:120px;">'.$reg->artref.'</h>',
        "4"=>'<h5 style="width:50px; text-align:right">'.number_format($reg->stock,0).'</h>',
        );
      }
      $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);
  break;

  case'importarDoc':
    $cont=0;
    $estatus='';
    $data= array();
    $rspta=$compra->ImportarDocumento($_POST['id'],$_POST['estatus'],$_POST['tipo']);

      while ($reg=$rspta->fetch_object()) {

        if ($reg->estatus=='Registrado') {
          $estatus='<h5 style="width:110px; text-align:center"><span class="label bg-green-active">Registrado</span></h5>';
        } else  if ($reg->estatus=='Procesado'){
          $estatus='<h5 style="width:110px; text-align:center"><span class="label bg-primary">Procesado</span></h5>';
        }else  if ($reg->estatus=='Procesado Parcialmente'){
          $estatus='<h5 style="width:110px; text-align:center"><span class="label bg-aqua-active">Parc. Procesado</span></h5>';
        }
      
        $data[]=array(
          "0"=>'<h5><button class="btn btn-success btn-xs" onclick="agregarImportarDoc('.$reg->idcompraop.',\''.$reg->idproveedor.'\',
          \''.$reg->idcondpago.'\',\''.$reg->cod_proveedor.'\',\''.$reg->desc_proveedor.'\',\''.$reg->rif.'\',\''.$reg->dias.'\',
          \''.$reg->limite.'\',\''.$reg->tipo.'\',\''.$reg->origenc.'\')">
          <span class="fa fa-check-square-o" style="text-align:center; width:15px;"></span></button></h5>',
          "1"=>'<h5 style="width:80px; text-align:center">'.$reg->fechareg.'</h5>',
          "2"=>$estatus,
          "3"=>'<h5 style="width:100px; text-align:center">'.$reg->origenc.'</h5>',
          "4"=>'<h5 style="width:380px; font-size:12px">'.$reg->desc_proveedor.'</h5>',
          "5"=>'<h5 style="width:95px; text-align:center">'.$reg->rif.'</h5>',
          "6"=>'<h5 style="width:100px; text-align:center">'.$reg->numerod.'</h5>',
          "7"=>'<h5 style="width:150px; text-align:right">'.number_format($reg->totalh,2,',','.').'</h5>'
        );
      };
      $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);              
  break;

  case "listarImportar":
    $fila='';
    $cont=0;
    $deposito='';    
    $rspta=$compra->ImportarDetalle($_POST['id']);
    echo '<thead class="btn-primary">
            <th style="text-align:center; width:30px;" class="nd">R</th>
            <th style="text-align:center; width:120px;" class="nd">Código</th>
            <th style="text-align:center; width:400px;" class="nd">Artículo</th>
            <th style="text-align:center; width:90px;" class="nd">Unidad</th>
            <th style="text-align:right; width:50px;" class="nd">Cant.</th>
            <th style="text-align:right; width:130px;" class="nd">Costo Und</th>
            <th style="text-align:right; width:130px;" class="nd">Sub Total</th>
            <th style="text-align:right; width:130px;" class="nd">Imp.</th>
            <th style="text-align:right; width:140px;" class="nd">Total Reng.</th>
        </thead>';
    while ($reg=$rspta->fetch_object()) 
    {
        echo
            $fila='<tr class="filas" id="fila'.($cont+1).'">
            <td><span class="label label-danger pull-right">'.($cont+1).'</span></td>
            <input name="idcomprad[]" id="idcomprad[]" value="'.$reg->idcomprad.'" type="hidden">
            <input name="idarticulo[]" id="idarticulo[]" value="'.$reg->idarticulo.'" type="hidden">
            <input type="hidden" name="iddeposito[]" id="iddeposito[]" value="'.$reg->iddeposito.'">
            <input type="hidden" name="idartunidad[]" id="idartunidad[]" value="'.$reg->idartunidad.'">
            <input name="tipoa[]" id="tipoa[]" value="'.$reg->tipo.'" type="hidden">
            <input name="disp[]" id="disp[]" value="'.$reg->disp.'" type="hidden">
            <input name="tasa[]" id="tasa[]" value="'.$reg->tasa.'" type="hidden">
            <input name="valor[]" id="valor[]" value="'.$reg->valor.'" type="hidden">
            <input type="hidden" name="cantidad[]" id="cantidad[]" value="'.$reg->cantidad.'">
            <input type="hidden" name="costo[]" id="costo[]" value="'.$reg->costo.'"></td>
            <td><h5 style="width:120px;">'.$reg->cod_articulo.'</h5></td>
            <td><h5 style="width:400px;">'.$reg->desc_articulo.'</h5></td>
            <td><h5 style="width:90px;">'.$reg->desc_unidad.'</h5></td>
            <td><h5 style="text-align:right; width:50px;">'.$reg->cantidad.'</h5></td>
            <td><h5 style="text-align:right; width:130px;" class="numberf">'.$reg->costo.'</h5></td>
            <td><h5 id="subtotal" name="subtotal" style="text-align:right; width:130px;" class="numberf" >0</h5></td>
            <td class="hidden"><h5>'.$reg->tasa.'</h5></td>
            <td><h5 style="text-align:right; width:130px;"id="subimp" name="subimp" class="numberf" >0</h5></td>
            <td><h5 style="text-align:right; width:140px;" id="total" name="total" class="numberf">0</h5></td>
            </tr>',
            $cont++;
            $deposito=$reg->iddeposito;	

            
        };
        echo '<tfoot>
                <th><input id="detalles" value="'.($cont++).'" class="hidden"></th>
                <th><input id="iddepositoimp" value="'.$deposito.'" class="hidden"></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>';
  break;

  case "Unidad":
    require_once "../database/Articulo.php";
    $articulo = new Articulo();

    $op=$_POST['op'];

    if ($op=='select') {

      $rspta = $articulo->ListarArtUnidad($_POST['id']);

      while ($reg = $rspta->fetch_object())
      {
        echo '<option value='.$reg->idartunidad.'>'.$reg->desc_unidad.'</option>';
      }
    } else if ($op=='data') {
      $rspta = $articulo->MostrarArtUnidadId($_POST['id']);
      echo json_encode($rspta);
    }
  break;

  case "selectDeposito":
    require_once "../database/Deposito.php";
    $deposito = new Deposito();
        
    $rspta = $deposito->Select();
        
    while ($reg = $rspta->fetch_object()) {
        echo '<option value='.$reg->iddeposito.'>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</option>';
    }
  break;

  case 'condpago':
    require_once '../database/CondPago.php';
    $condpago=new CondPago();
    $op=$_POST['op'];

    if ($op=='select') {
       $rspta=$condpago->Select();
 
        while ($reg=$rspta->fetch_object()) {
           echo '<option value="'.$reg->idcondpago.'">'.$reg->desc_condpago.'</option>';
        }
    } 
    elseif ($op=='data'){

    $rspta=$condpago->Mostrar($_POST['id']);         
    echo json_encode($rspta);
    }
  break;
}
?>