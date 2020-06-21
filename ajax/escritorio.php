<?php

require_once "../database/Escritorio.php";
$escritorio=new Escritorio();

switch($_POST["opcion"]){

   case 'categoria1':

      $rspta = $escritorio->TotalStockCategoria();
      $stocknt=0;
      $stockpt=0;

      echo
      '<thead class="btn-primary">
         <th>Categoria</th>
         <th style="text-align:center;">Unds.</th>
         <th style="text-align:center;"> % </th>
      </thead>';         
      while($reg= $rspta->fetch_object()){
        echo 
        '<tr>'.
        '<td>'.$reg->categoria.'</td>'.
        '<td style="text-align:right;">'.$reg->stockn.'</td>'.
        '<td style="text-align:right;">'.$reg->stockp.' %</td>'.
        $stocknt+=$reg->stockn;
        $stockpt+=$reg->stockp;
      '</tr>';
      }
      echo '
      <tfoot>
      <td><h4 class="pull-right"><label>Total Stock:</label></h5></td>
      <td><h4  class="pull-right"><label>'.$stocknt.'</label></h5></td>
      <td><h4  class="pull-right"><label>'.$stockpt.' %</label></h5></td>
      </tfoot>';
   break;

   case 'categoria':
       $rspta = $escritorio->TotalStockCategoria();
      //Codificar el resultado utilizando json
      $data = array();
      foreach ($rspta as $row) {
          $data[] = $row;
      }
      echo json_encode($data);
   break;

   case 'articuloMasVentas': 
      $rspta = $escritorio->ArticuloMasVentas();
            echo
      '<thead class="btn-success">
         <th>Articulo</th>
         <th style="text-align:center;">Unds.</th>
      </thead>';  
      while ($reg=$rspta->fetch_object()) {
         echo '<tr>
               <td><h5>'.$reg->descart.'</h5></td>
               <td><h5 style="80px; padding-right:5px" class="text-right">'.number_format($reg->cantidad,0).'</h5></td>
         </tr>';}

   break;

   case 'Inventario':
      $rspta = $escritorio->TotalStockArticulo();
      echo json_encode($rspta);
   break;
   
   case 'prueba':
      echo '99';
   break;

   case 'totalclientes':
      $rspta = $escritorio->TotalClientes();
      echo json_encode($rspta);
   break;

   case 'totalpedidov':
      $rspta = $escritorio->TotalPedidosV();
      echo json_encode($rspta);
   break;

   case 'totalfacturav':
      $rspta = $escritorio->TotalFacturasV();
      echo json_encode($rspta);
   break;

   case 'ventas10':
      $rspta=$escritorio->Ultimas10Ventas();
      //Codificar el resultado utilizando json
      $data = array();
      foreach ($rspta as $row) {
          $data[] = $row;
      }
      echo json_encode($data);
   break;

   case 'totalproveedores':
      $rspta = $escritorio->TotalProveedores();
      echo json_encode($rspta);
   break;

   case 'totalpedidoc':
      $rspta = $escritorio->TotalPedidosC();
      echo json_encode($rspta);
   break;

   case 'totalfacturac':
      $rspta = $escritorio->TotalFacturasC();
      echo json_encode($rspta);
   break;

   case 'compras10':
      $rspta=$escritorio->Ultimas10Compras();
      //Codificar el resultado utilizando json
      $data = array();
      foreach ($rspta as $row) {
          $data[] = $row;
      }
      echo json_encode($data);
   break;
}

?>