<?php
/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Medicamentos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
//Parametros de conexion, Se puden pasar como argumentos GET     ?host=10.44.130.21&bd=bdprincipal o esperar a un formulario
$host    = empty($_GET["host"]) ? "localhost" : $_GET["host"]; //valor predeterminado
$usuario = empty($_GET["usuario"]) ? "root" : $_GET["usuario"]; //valor predeterminado
#if (empty($_GET["passwd"]) || empty($_GET["bd"])){ //OBLIGATORIOS
if (empty($_GET["bd"])) {
    //OBLIGATORIOS SIN PASS
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">

                <FORM action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" >
                    <div class="row">
                     <div class="col-md-6">
                         <label for="field-2" class="control-label">Host:</label>
                         <INPUT type="text" class="form-control" name="host" id ="host" value="localhost"><br>
                            <label for="field-2" class="control-label">Base de Datos;</label>
                            <INPUT type="text" class="form-control" name="bd" id ="bd" placeholder="My base" required><br>
                            </div>
                            <div class="col-md-6">
                             <label for="field-2" class="control-label">Usuario:</label>
                             <INPUT type="text" class="form-control" name="usuario" id ="usuario" value="root"><br>
                                 <label for="field-2" class="control-label">Contraseña:</label>
                                 <INPUT class="form-control" type="text" name="passwd" id="passwd" value=""><br>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-4">
                                  <b>Compresion : </b><select class="form-control" name="compresion" >
                                  <option value="false" selected="selected">Sin compresion</option>
                                  <option value="zip">zip</option>
                                  <option value="gz">gz</option>
                                  <option value="bz2">bz2</option>
                              </select><br />
                          </div>

                          <div class="col-md-8">
                              <b>lista de tablas :</b> <INPUT class="form-control" type="text" name="tablas" id ="tablas" value="" size="80" TITLE="Dejar en blanco para copiar todas las tablas, o bien escribir el nombre de tablas separado por coma. ">
                          </div>
                      </div>
                      <div class="col-md-12">
                          <br><input name="SoloTablas" id="SoloTablas" type="checkbox" value="true" TITLE="No copiar vistas, triggers, function y procedures."/>  <b>Solo tablas (sin routinas de triggers, procedures, functions o eventos)</b>
                          <br><input name="EstructuraBD" id="EstructuraBD" type="checkbox" value="true" checked="checked" TITLE="Copiar  definiciones de estructura de Base de datos"/>  <b>Definicion de Estructura </b>
                          <br><input name="InsertDatos" id="InsertDatos" type="checkbox" value="true" checked="checked" TITLE="Copiar  inserciones de datos "/>  <b>Inserciones de Datos</b>
                          <br><b><input name="CreateDataBase" id="CreateDataBase" type="checkbox" value="true" checked="checked" TITLE="Este dato se usa para copias de seguridad que no tienen el nombre de la base de datos y por tanto se pueden restaurar en cualquier otra." />  Generar CREATE DATABASE IF NOT EXISTS</b>
                          <br /><br />
                          <div class="col-md-6" align="right">
                              <b>DELIMITER en triggers,procedures, function:</b>
                          </div>
                          <div class="col-md-6" align="center">
                              <INPUT class="form-control" type="text" name="DELIMITER" id ="DELIMITER" value="$$" TITLE="Caracteres que limitaran el final de una routina(funciones, procedores, triggers y events) ">
                              </div><br><br>
                              <div class="col-md-12" align="center">
                                  <INPUT type="submit" class="btn btn-danger" name="upload" value="[ Crear copia ]">
                                  </div>
                              </FORM>



                              </div>
                          </div>
                      </div>


    <?php
exit();
}

$bd     = empty($_GET["bd"]) ? die("se precisa el argumento bd") : $_GET["bd"]; //parametro obligatorio
$passwd = $_GET["passwd"];
// Tipo de compresion.
// Puede ser "zip", "gz", "bz2", o false (sin comprimir)
$compresion = empty($_GET["compresion"]) ? "zip" : $_GET["compresion"];
// Determina si será borrada el objeto (si existe) cuando  restauremos .
$drop           = empty($_GET["drop"]) ? true : $_GET["drop"]; //valor predeterminadotrue;
$DELIMITER      = empty($_GET["DELIMITER"]) ? "$$" : $_GET["DELIMITER"]; //valor predeterminadotrue;
$SoloTablas     = isset($_GET["SoloTablas"]) && ($_GET['SoloTablas'] == "true") ? true : false;
$EstructuraBD   = isset($_GET["EstructuraBD"]) && ($_GET['EstructuraBD'] == "true") ? true : false;
$InsertDatos    = isset($_GET["InsertDatos"]) && ($_GET['InsertDatos'] == "true") ? true : false;
$CreateDataBase = isset($_GET['CreateDataBase']) && ($_GET['CreateDataBase'] == "true") ? true : false;
if (empty($_GET["tablas"])) {
    $tablas = false;
}
//un array con las tablas de la bd que se desean copiar.
else {
    $tablas = explode(",", $_GET["tablas"]);
    foreach ($tablas as $num => $tabla) {
        $tablas[$num] = trim($tabla);
    }

}
//--------------------- PARAMETRIZACION: --------------------------------------------------------------------

//las Views de la bd que se desean copiar en el orden adecuado. Puede atacar a una tabla que liste en el orden deseado las views para tener encuenta las dependencias
$viewSQL  = "SHOW FULL TABLES FROM `" . $bd . "` WHERE Table_Type='VIEW';"; //SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table
$tablaSQL = "SHOW FULL TABLES FROM $bd WHERE Table_Type='BASE TABLE';"; //SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table
set_time_limit(300); //alarga el timeout

// CONEXION
$conexion = new mysqli($host, $usuario, $passwd, $bd);
if ($conexion->connect_errno) {
    printf("No se puede conectar con el servidor MySQL: %s\n", $conexion->connect_error);
    #echo "<script>alert('No se puede conectar con el servidor MySQL')</script>";
    exit();
}
//SET NAMES
//$consulta="SHOW CREATE DATABASE `".$bd."`;";
//$respuesta = $conexion->query($consulta)or die("No se puede ejecutar la consulta: $consulta MySQL: \n". $conexion->error);
//if ($fila = $respuesta->fetch_array(MYSQLI_NUM)) {//CREATE DATABASE `kk` /*!40100 DEFAULT CHARACTER SET latin1 */
//  $s= stristr($fila[1]," SET ");
//  $z=explode(" ",$s);
//  $SetNames="/*!40101 SET NAMES ".$z[2]." */;";
//}else $SetNames="/*!40101 SET NAMES utf8 */;";
//$respuesta->free();

// Se busca las tablas en la base de datos
if (empty($tablas)) {
    $respuesta = $conexion->query($tablaSQL) or die("No se puede ejecutar la consulta: $tablaSQL MySQL: \n" . $conexion->error);
    while ($fila = $respuesta->fetch_array(MYSQLI_NUM)) {
        $tablas[] = $fila[0];
    }
    $respuesta->free();
}

/* Se crea la cabecera del archivo */
$info['dumpversion'] = "2.15";
$info['fecha']       = date("d-m-Y");
$info['hora']        = date("h:m:s A");
$info['mysqlver']    = $conexion->server_info;
$info['phpver']      = phpversion();
ob_start();
$representacion = ob_get_contents();
ob_end_clean();
preg_match_all('/(\[\d+\] => .*)\n/', $representacion, $matches);
$info['tablas'] = implode(";  ", $tablas);

$FicheroOUT = $bd . "_backup_" . $info['fecha'] . ".sql"; //Este es el nombre del archivo a generar
$dump       = <<<EOT
# +===================================================================
# | Generado el {$info['fecha']} a las {$info['hora']}
# | Servidor: {$_SERVER['HTTP_HOST']}
# | MySQL Version: {$info['mysqlver']}
# | PHP Version: {$info['phpver']}
# | Base de datos: '$bd'
# | Tablas: {$info['tablas']}
# +-------------------------------------------------------------------
# Si tienen tablas con relacion y no estan en orden dara problemas al recuperar datos. Para evitarlo:
SET FOREIGN_KEY_CHECKS=0;
SET time_zone = '+00:00';
SET sql_mode = '';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

EOT;

if ($CreateDataBase && $EstructuraBD) {
    $dump .= <<<EOT

CREATE DATABASE IF NOT EXISTS `$bd`;

USE `$bd`;

EOT;
}

foreach ($tablas as $tabla) {
    $drop_table_query   = "";
    $create_table_query = "";
    $insert_into_query  = "";
    if ($EstructuraBD) {
        // Se halla el query que será capaz vaciar la tabla.
        if ($drop) {
            $drop_table_query = "DROP TABLE IF EXISTS `" . $tabla . "`;";
        } else {
            $drop_table_query = "# No especificado DROP.";
        }

        // Se halla el query que será capaz de recrear la estructura de la tabla.
        $create_table_query = "";
        $consulta           = "SHOW CREATE TABLE `" . $tabla . "`;";
        $respuesta          = $conexion->query($consulta) or die("No se puede ejecutar la consulta: $consulta MySQL: " . $conexion->error);
        while ($fila = $respuesta->fetch_array(MYSQLI_NUM)) {
            $create_table_query = $fila[1] . ";";
        }
        $respuesta->free();
        $dump .= <<<EOT
# | Vaciado de tabla '$tabla'
# +-------------------------------------
$drop_table_query

# | Estructura de la tabla '$tabla'
# +-------------------------------------
$create_table_query

EOT;
    }
    // Se generan los INSERT de los datos.
    if ($InsertDatos && ($tabla != "audittrail")) {
//no salvamos datos de audittrail
        $insert_into_query = "";
        $consulta          = "SELECT * FROM `" . $tabla . "`;";
        $respuesta         = $conexion->query($consulta) or die("No se puede ejecutar la consulta: $consulta MySQL: " . $conexion->error);
        if ($fila = $respuesta->fetch_array(MYSQLI_ASSOC)) {
            //generar una sola vez la cabecera del insert
            foreach ($fila as $columna => $valor) {
                $campos[] = "`" . $conexion->real_escape_string($columna) . "`";
            }
            $insertSQLHead = "\r\nCOMMIT;\r\nINSERT IGNORE INTO `$tabla` (" . implode(", ", $campos) . ") VALUES ";
            unset($campos);
            $x = 1;
            do {
                foreach ($fila as $columna => $valor) {
                    if (gettype($valor) == "NULL") {
                        $values[] = "NULL";
                    } else {
                        $values[] = "'" . $conexion->real_escape_string($fila[$columna]) . "'"; //guardar cada valor de campo
                    }
                }
                $regs[] = "\r\n      (" . implode(", ", $values) . ")"; //meter en un array todos los valores de cada registro entre () y separado por ,
                unset($values);
                if ($x++ == 300) {
                    $insert_into_query .= $insertSQLHead . implode(", ", $regs) . ";"; //generar un insert cada 300 registros
                    unset($regs);
                    $x = 1;
                }
            } while ($fila = $respuesta->fetch_array(MYSQLI_ASSOC));
            if ($x == 1) {
                $insert_into_query .= "\r\nCOMMIT;\r\n";
            } else {
                $insert_into_query .= $insertSQLHead . implode(", ", $regs) . ";\r\nCOMMIT;\r\n";
                unset($regs);
            }
        }
        $respuesta->free();
        $dump .= "
# | Carga de datos de la tabla '$tabla'
# +-------------------------------------
$insert_into_query
";
    } // insert
}
if (!$SoloTablas && $EstructuraBD) {
// copiar ROUTINAS (PROCEDURE o FUNCTION  (se funde con un array de Views para evitar posibles dependencias en la restaruación (una vista basada en otra)
    // tanto de otras routinas como de vistas no creadas).
    // Falla si hay una function o un procedure que se llame igual que una vista.
    $arrRoutinasViews = array();
    //$arraySQL=array("SELECT `ROUTINE_TYPE`as `Type`,`ROUTINE_SCHEMA` as `Db`, `ROUTINE_NAME` AS `Name` FROM INFORMATION_SCHEMA.`ROUTINES` WHERE INFORMATION_SCHEMA.ROUTINES.`ROUTINE_SCHEMA` LIKE '". $bd ."';");
    $arraySQL = array("SHOW FUNCTION STATUS where Db like '" . $bd . "';", "SHOW PROCEDURE STATUS where Db like '" . $bd . "';");
    foreach ($arraySQL as $sql) {
        $routinasSQL = $conexion->query($sql) or die("No se puede ejecutar la consulta: $sql MySQL: " . $conexion->error);
        while ($routina = $routinasSQL->fetch_array(MYSQLI_ASSOC)) {
            $nombre                    = "`" . $routina["Db"] . "`.`" . $routina["Name"] . "`";
            $sql                       = 'SHOW CREATE ' . $routina["Type"] . ' ' . $nombre;
            $routinaDDL                = $conexion->query($sql) or die("No se puede ejecutar la consulta: $sql MySQL: " . $conexion->error);
            $rowDDL                    = $routinaDDL->fetch_array(MYSQLI_BOTH);
            $codigo                    = "CREATE " . stristr($rowDDL[2], $routina["Type"]);
            $arrRoutinasViews[$nombre] = "\r\n\r\n";
            if ($drop) {
                $arrRoutinasViews[$nombre] .= "DROP " . $routina["Type"] . " IF EXISTS " . $nombre . ";\r\n";
            }

            if ($DELIMITER == ";") {
                $arrRoutinasViews[$nombre] .= "\r\n" . $codigo . ";\r\n# ------------------------------------------------------------------------------------------";
            } else {
                $arrRoutinasViews[$nombre] .= "DELIMITER " . $DELIMITER . "\r\n" . $codigo . "\r\n" . $DELIMITER . "\r\nDELIMITER ;\r\n# ------------------------------------------------------------------------------------------";
            }

            $routinaDDL->free();
        }
        $routinasSQL->free();
    }
//VIEWs
    $respuesta = $conexion->query($viewSQL) or die("No se puede ejecutar la consulta: MySQL: $viewSQL " . $conexion->error);
    while ($fila = $respuesta->fetch_array(MYSQLI_NUM)) {
        $consulta      = "SHOW CREATE VIEW `" . $bd . "`.`" . $fila[0] . "`;";
        $respuestaView = $conexion->query($consulta) or die("No se puede ejecutar la consulta: $consulta MySQL: " . $conexion->error);
        $filaView      = $respuestaView->fetch_array(MYSQLI_NUM);
        // vamos a eliminar lo que hay entre CREATE y VIEW para evitar que falle pq los usuarios creadores no existan en la máquina de restaruación
        $codigo                     = "CREATE " . stristr($filaView[1], "View");
        $arrRoutinasViews[$fila[0]] = "\r\n";
        if ($drop) {
            $arrRoutinasViews[$fila[0]] .= "DROP VIEW IF EXISTS `" . $bd . "`.`" . $fila[0] . "`;\r\n";
        }

        $arrRoutinasViews[$fila[0]] .= $codigo . "; \r\n";
        $respuestaView->free();
    }
    $respuesta->free();

    // cargar VIEWs y ROUTINAS de modo que evite las dependencias en restauración:
    // cada elemento busca si está contenido en la definición de otros pendientes de definir en cuyo caso espera a definir primero los que él depende.
    $ciclos = 0;
    while ((count($arrRoutinasViews) > 0) && (++$ciclos < 30)) {
        foreach ($arrRoutinasViews as $indice => $valor) {
            $encontrado = false;
            foreach ($arrRoutinasViews as $key => $val) {
//buscar en los restantes
                if ($indice != $key) {
                    if (stripos($valor, "`" . $key . "`") !== false) {
                        // lo ponemos entre "`" para garantizar que no es un prefijo de otra palabra. Esto obliga que las definiciones usen esta nomenclatura.
                        $encontrado = true;
                        break;
                    }
                }
            }
            if (!$encontrado) {
                //imprimirlo y borrar elemento de array
                $dump .= $valor;
                unset($arrRoutinasViews[$indice]);
            }
        }
    }
    if ($ciclos >= 30) {
        echo "SET NEW='Superados 30 ciclos en busqueda de dependencias jerarquicas (quizas hay dependencias circulares mutuas)';";
        $FicheroOUT = "ERROR_bucle_$bd.sql";
    }

    //TRIGGERs. Al estar al final no hay problema de que dependa de funciones o vistas, pues a estas alturas de restaruaciónya estarán creadas.
    $consulta  = "SHOW FULL TRIGGERS FROM `" . $bd . "`;"; //SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table
    $respuesta = $conexion->query($consulta) or die("No se puede ejecutar la consulta: $consulta MySQL:" . $conexion->error);
    while ($fila = $respuesta->fetch_array(MYSQLI_NUM)) {
        if ($drop) {
            $dump .= "\r\nDROP TRIGGER IF EXISTS `" . $bd . "`.`" . $fila[0] . "`;\r\n";
        }

        if ($DELIMITER != ";") {
            $dump .= "\r\nDELIMITER $DELIMITER\r\n";
        }

        $dump .= "Create trigger `" . $bd . "`.`" . $fila[0] . "`  " . $fila[4] . " " . $fila[1] . " ON `" . $fila[2] . "` \r\n";
        $dump .= "      for each row \r\n";
        $dump .= $fila[3];
        if ($DELIMITER != ";") {
            $dump .= "\r\n" . $DELIMITER . "\r\nDELIMITER  ";
        }

        $dump .= ";\r\n";
    }
    $respuesta->free();
} // not $SoloTablas
//cerramos la conexión con la BBDD
$conexion->close();

/* Envio */
if (!headers_sent()) {
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-Transfer-Encoding: binary");
    switch ($compresion) {
        case "zip":
            $enzipado = new ZipArchive();
            if ($enzipado->open($FicheroOUT . ".zip", ZIPARCHIVE::CREATE) !== true) {
                exit("No se pudo abrir el archivo\n");
            }

            $enzipado->addFromString($FicheroOUT, $dump);
            $enzipado->close();
            header("Content-Disposition: attachment; filename=$FicheroOUT.zip");
            header("Content-type: application/zip");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            readfile($FicheroOUT . ".zip");
            unlink($FicheroOUT . ".zip");
            break;

        case "gz":
            header("Content-Disposition: attachment; filename=$FicheroOUT.gz");
            header("Content-type: application/x-gzip");
            echo gzencode($dump, 9);
            break;
        case "bz2":
            header("Content-Disposition: attachment; filename=$FicheroOUT.bz2");
            header("Content-type: application/x-bzip2");
            echo bzcompress($dump, 9);
            break;
        default:
            header("Content-Disposition: attachment; filename=$FicheroOUT");
            header("Content-type: application/force-download");
            echo $dump;
    }
} else {
    echo "<b>ATENCION: Probablemente ha ocurrido un error de envio de headers</b><br />\r\n <pre>\r\n $dump\r\n </pre>";
}
?>
