<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Fin
//Archivo de funciones PHP
require_once "../funciones.php";
//FIN
$vendedor = intval($_REQUEST['vendedor']);
$daterange = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
$tables    = "detalle_fact_ventas,  productos, facturas_ventas";
$campos    = "*";
$sWhere    = "productos.id_producto=detalle_fact_ventas.id_producto and facturas_ventas.id_factura=detalle_fact_ventas.id_factura";
if ($vendedor > 0) {
    $sWhere .= " and facturas_ventas.id_users_factura = '" . $vendedor . "'";
}
if (!empty($daterange)) {
    list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
    list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
    $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
    list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
    $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";
    $sWhere .= " and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' ";
}
$sWhere .= " group by detalle_fact_ventas.id_producto";
//$consulta = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere ");

$consulta  = "SELECT $campos FROM $tables WHERE $sWhere";
$resultado = $conexion->query($consulta);
if ($resultado->num_rows > 0) {
    date_default_timezone_set('America/Mexico_City');
    if (PHP_SAPI == 'cli') {
        die('Este archivo solo se puede ver desde un navegador web');
    }
    /** Se agrega la libreria PHPExcel */
    require_once 'lib/PHPExcel/PHPExcel.php';
    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();
    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
        ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
        ->setTitle("Reporte Excel con PHP y MySQL")
        ->setSubject("Reporte Excel con PHP y MySQL")
        ->setDescription("Reporte de Financiero")
        ->setKeywords("reporte financiero")
        ->setCategory("Reporte excel");
    $tituloReporte   = "Reporte Financiero";
    $titulosColumnas = array('CODIGO', 'PRODUCTO', 'CANT.', 'COSTO', 'T. COSTO', 'P.VENDIDO', 'DESC.', 'T.VENDIDO', 'UTILIDAD');
    $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:I1');
    // Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', $tituloReporte)
        ->setCellValue('A3', $titulosColumnas[0])
        ->setCellValue('B3', $titulosColumnas[1])
        ->setCellValue('C3', $titulosColumnas[2])
        ->setCellValue('D3', $titulosColumnas[3])
        ->setCellValue('E3', $titulosColumnas[4])
        ->setCellValue('F3', $titulosColumnas[5])
        ->setCellValue('G3', $titulosColumnas[6])
        ->setCellValue('H3', $titulosColumnas[7])
        ->setCellValue('I3', $titulosColumnas[8]);
    //Se agregan los datos de los alumnos
    $i = 4;
    while ($fila = $resultado->fetch_array()) {

        //calculos de totales
        $sql         = mysqli_query($conexion, "select sum(cantidad) as cant, sum(desc_venta) as d, sum(importe_venta) as pv from detalle_fact_ventas, facturas_ventas where facturas_ventas.id_factura=detalle_fact_ventas.id_factura and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' and  detalle_fact_ventas.id_producto='" . $fila['id_producto'] . "'");
        $rw          = mysqli_fetch_array($sql);
        $cantidad    = $rw['cant'];
        $desc_venta  = $rw['d'];
        $total_costo = $cantidad * $fila['costo_producto'];
        $total_pv    = $rw['pv'];

        $final_items = rebajas($total_pv, $desc_venta); //Aplicando el descuento
        $descuento   = $total_pv - $final_items;
        $utilidad    = $final_items - $total_costo;
        //$sumador_total = $sumador_total + $utilidad;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $fila['codigo_producto'])
            ->setCellValue('B' . $i, $fila['nombre_producto'])
            ->setCellValue('C' . $i, $cantidad)
            ->setCellValue('D' . $i, $fila['costo_producto'])
            ->setCellValue('E' . $i, $total_costo)
            ->setCellValue('F' . $i, $fila['precio_venta'])
            ->setCellValue('G' . $i, $descuento)
            ->setCellValue('H' . $i, $final_items)
            ->setCellValue('I' . $i, $utilidad);
        $i++;
    }
    $estiloTituloReporte = array(
        'font'      => array(
            'name'   => 'Verdana',
            'bold'   => true,
            'italic' => false,
            'strike' => false,
            'size'   => 16,
            'color'  => array(
                'rgb' => '1C2833', //Color de la Letra
            ),
        ),
        'fill'      => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'D6DBDF'),
        ),
        'borders'   => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE,
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'       => true,
        ),
    );
    $estiloTituloColumnas = array(
        'font'      => array(
            'name'   => 'Arial',
            'bold'   => true,
            'italic' => false,
            'strike' => false,
            'size'   => 8,
            'color'  => array(
                'rgb' => '1C2833', //color de las letras
            ),
        ),
        'fill'      => array(
            'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
            'rotation'   => 90,
            'startcolor' => array(
                'rgb' => 'D6DBDF', //color de fonto1
            ),
            'endcolor'   => array(
                'argb' => 'D6DBDF', //color de fonto2
            ),
        ),
        'borders'   => array(
            'top'    => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                'color' => array(
                    'rgb' => '143860',
                ),
            ),
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                'color' => array(
                    'rgb' => '143860',
                ),
            ),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true,
        ));
    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
        array(
            'font'    => array(
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => '000000',
                ),
            ),
            'fill'    => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FFd9b7f4'),
            ),
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'rgb' => '3a2a47',
                    ),
                ),
            ),
        ));
    $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($estiloTituloColumnas);
    //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:G" . ($i - 1));
    $objPHPExcel->getActiveSheet()->getStyle('D4:D' . ($i - 1))->getNumberFormat()->setFormatCode('#,#0;[Red]-#,#0'); //FORMATO NUMERICO
    $objPHPExcel->getActiveSheet()->getStyle('E4:E' . ($i - 1))->getNumberFormat()->setFormatCode('#,#0;[Red]-#,#0'); //FORMATO NUMERICO
    $objPHPExcel->getActiveSheet()->getStyle('F4:F' . ($i - 1))->getNumberFormat()->setFormatCode('#,#0;[Red]-#,#0'); //FORMATO NUMERICO
    $objPHPExcel->getActiveSheet()->getStyle('G4:G' . ($i - 1))->getNumberFormat()->setFormatCode('#,#0;[Red]-#,#0'); //FORMATO NUMERICO
    $objPHPExcel->getActiveSheet()->getStyle('H4:H' . ($i - 1))->getNumberFormat()->setFormatCode('#,#0;[Red]-#,#0'); //FORMATO NUMERICO
    $objPHPExcel->getActiveSheet()->getStyle('I4:I' . ($i - 1))->getNumberFormat()->setFormatCode('#,#0;[Red]-#,#0'); //FORMATO NUMERICO

    for ($i = 'A'; $i <= 'I'; $i++) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->getColumnDimension($i)->setAutoSize(true);
    }
    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Financiero');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reportefinanciero.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
} else {
    echo "<script>alert('No hay resultados para mostrar')</script>";
    echo "<script>window.close();</script>";
    //echo "<script>window.location.replace('../html/rep_pagos.php');</script>";
    header("Location:../html/rep_financiero.php");
    exit;
    //print_r('No hay resultados para mostrar, Seleccionar un Paciente');
}
