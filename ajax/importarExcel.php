<?php
   $tipo='';
   // Importante - conexión con la base de datos 
   $cn = mysqli_connect ("localhost","root","","admindb") or die ("ERROR EN LA CONEXION CON LA BD");

      /** Llamamos las clases necesarias PHPEcel */
      require_once('../public/PHPExcel/Classes/PHPExcel.php');
      require_once('../public/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');   

      $allowedFileType = 'xlsx';

      //cargamos el fichero
      $archivo = $_FILES['formato']['name'];
      $tipo = $_FILES['formato']['type'];
      $ruta = "../formatos/".$archivo;
      copy($_FILES['formato']['tmp_name'],$ruta);


      if (file_exists ($ruta) &&  ($tipo=='text/xlsx'||$tipo=='text/xls'
      ||$tipo=='application/vnd.ms-excel'||$tipo=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')){              
         // Cargando la hoja de excel
         $objReader = new PHPExcel_Reader_Excel2007();
         $objPHPExcel = $objReader->load($ruta);
         $objFecha = new PHPExcel_Shared_Date();       
         // Asignamon la hoja de excel activa
         $objPHPExcel->setActiveSheetIndex(0);

         // Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido
         $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
         $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

         //Creamos un array con todos los datos del Excel importado
         for ($i=2;$i<=$filas;$i++){
               $_DATOS_EXCEL[$i]['cod_unidad'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
               $_DATOS_EXCEL[$i]['desc_unidad'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
               $_DATOS_EXCEL[$i]['estatus']= 1;
         }       
            $errores=0;

         foreach($_DATOS_EXCEL as $campo => $valor){
            $sql = "INSERT INTO tbunidad(cod_unidad,desc_unidad,estatus) 
            VALUES ('";foreach ($valor as $campo2 => $valor2){
               $campo2 == "estatus" ? $sql.= $valor2."');" : $sql.= $valor2."','";
            }

            $result = mysqli_query($cn,$sql);
               if (!$result)
               { echo "Error al insertar registro  Linea Error **".$campo; 
               $errores+=1;}
            }  

            $conexion->query($sql);		
		      return $conexion->insert_id; 
            echo '<label>Total '.$campo.' Registros Ingreados correctamente y '.$errores.' Total Registros con Errores!</label>';

            unlink($ruta);
                    
      }
      else {
            echo "<label>Primero debes cargar el archivo con Extencion .XLSX</label>";
            unlink($ruta);
      }
            
?>
