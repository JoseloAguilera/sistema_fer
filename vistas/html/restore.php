<?php
/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Configuracion";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title         = "Backup";
$Configuracion = 1;
header("Content-Type: text/html;charset=utf-8");
setlocale(LC_ALL, 'es_ES');

error_reporting(E_ALL - E_NOTICE);
ini_set('upload_max_filesize', '80M');
ini_set('post_max_size', '80M');
ini_set('memory_limit', '-1'); //evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('max_execution_time', 300); // es lo mismo que set_time_limit(300) ;
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
// En MYSQL archivo "my.ini" o "my.cnf" ==> max_allowed_packet = 22M
//"SET GLOBAL max_allowed_packet = 22M;"
//"SET GLOBAL net_read_timeout=50;"
//esto no se si solo es modificable en php.ini:
ini_set('file_uploads', 'On');
ini_set('upload_tmp_dir', 'upload');
set_time_limit(300); //alarga el timeout

$host    = empty($_POST["host"]) ? "localhost" : $_POST["host"]; //valor predeterminado
$usuario = empty($_POST["usuario"]) ? "root" : $_POST["usuario"]; //valor predeterminado
$passwd  = empty($_POST["passwd"]) ? "" : $_POST["passwd"]; //valor predeterminado
$BD      = $_POST["BD"];

function convertir_utf8($cadena)
{
    if (strlen(utf8_decode($cadena)) == strlen($cadena)) {
        // $cadena is not UTF-8
        return iconv("ISO-8859-1", "UTF-8//TRANSLIT", $cadena);
    } else {
        // already UTF-8
        return $cadena;
    }
    // Alternativa0 $strSQLs = mb_convert_encoding($strSQLs, 'HTML-ENTITIES', "UTF-8");
    // Alternativa1 $strSQLs = iconv('ISO-8859-1','UTF-8//TRANSLIT',$strSQLs);
    // Alternativa2 $strSQLs = mb_convert_encoding($strSQLs, 'UTF-8',  mb_detect_encoding($strSQLs, 'UTF-8, ISO-8859-1', true));
}

function Debug($Texto, $variable, $crear = false)
{
    if ($gestor = fopen("log.txt", ($crear) ? 'w' : 'a')) {
        $t     = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        fwrite($gestor, date("Y-m-d H:i:s.") . $micro . "==***==== $Texto ===***===\r\n" . print_r($variable, true) . "\r\n");
        fclose($gestor);
    } else {
        die("NO SE PUEDE CREAR log.txt");
    }

}
function CadenaAcotada($Cadena, $CadenaInicio, $CadenaFinal)
{
    $inicio = stripos(" " . $Cadena, $CadenaInicio); //ponemos un espacio para distinguir entre no encontrado o estar al prinicipio
    if ($inicio) {
        $inicio += strlen($CadenaInicio) - 1;
        $fin = stripos($Cadena, $CadenaFinal, $inicio);
        if (!$fin) {
            return false;
        }

        return substr($Cadena, $inicio, $fin - $inicio);
    } else {
        return false;
    }

}
function TableToHTML($conexion, $strSQL)
{
    //$conexion  viene de hacer $conexion = new mysqli(...);
    //$strSQL es el SQL que retorna tegistos p.ej. SELECT
    $rs       = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
    $num_rows = $rs->num_rows;
    if ($num_rows != 0) {
        $regSELECT = $rs->fetch_assoc();
        $strHTML   = '<table border="1" cellpadding="10" cellspacing="1" > <thead> <tr>';
        $x         = 0;
        foreach ($regSELECT as $key => $value) {
            $strHTML .= "<th><b>" . $key . "</b></th>";
        }
        $strHTML .= "</tr> </thead> <tbody>";
        do {
            $strHTML .= "<tr>";
            $x = 0;
            foreach ($regSELECT as $value) {
                $strHTML .= "<td > " . $value . " </td>";
            }
            $strHTML .= "</tr>";
        } while ($regSELECT = $rs->fetch_assoc());
        $strHTML .= " </tbody> </table>";
        return nl2br($strHTML);
    }
    return "Sin registros en resultado";
}

function run_sql($strSQLs, $BD, $host, $usuario, $passwd, $DropDataBase, $InsertDatos, $VerSoloErrores, $tblName)
{
    $lines      = explode("\n", $strSQLs);
    $strSQLs    = array();
    $in_comment = false;
    foreach ($lines as $key => $line) {
        $line        = trim($line); //preg_replace("#.*/#","",$line)
        $ignoralinea = (("#" == $line[0]) || ("--" == substr($line, 0, 2)) || (!$line) || ($line == ""));
        if (!$ignoralinea) {
            //Eliminar comentarios que empiezan por /* y terminan por */
            if (preg_match("/^\/\*/", ($line))) {
                $in_comment = true;
            }

            if (!$in_comment) {
                $strSQLs[] = $line;
            }

            if (preg_match("/\*\//", ($line))) {
                $in_comment = false;
            }

        }
    }
    unset($lines);
    // Particionar en sentencias
    $IncludeDelimiter = false;
    $delimiter        = ";";
    $delimiterLen     = 1;
    $sql              = "";
    // CONEXION
    $conexion = new mysqli($host, $usuario, $passwd) or die("No se puede conectar con el servidor MySQL: %s\n" . $conexion->connect_error);
    if ($conexion->connect_errno) {
        printf("No se puede conectar con el servidor MySQL: %s\n", $conexion->connect_error);
        exit();
    }
    if (!$conexion->set_charset("utf8")) {
        // cambiar el conjunto de caracteres a utf8
        printf("Error cargando el conjunto de caracteres utf8: %s\n", $conexion->error);
        exit();
    }
    if ($DropDataBase) {
        $respuesta = $conexion->query("DROP DATABASE " . $BD);
    }

    $NumLin = 0;
    foreach ($strSQLs as $key => $line) {
        if ("DELIMITER" == substr($line, 0, 9)) {
            //empieza por DELIMITER
            $D            = explode(" ", $line);
            $delimiter    = $D[1];
            $delimiterLen = strlen($delimiter);
            $sql          = ($IncludeDelimiter) ? $line . "\n" : "";
        } elseif (substr($line, -1 * $delimiterLen) == $delimiter) {
            //hemos alcanzado el  Delimiter
            if (($NumLinea++ % 100) == 0) {
                // ver con que base de datos estamos para poder reconectar caso de error

                $respuesta = $conexion->query("select database() as db");
                $row       = $respuesta->fetch_array(MYSQLI_NUM);
                $db        = $row[0];
            }
            $sql .= ($IncludeDelimiter) ? $line : substr($line, 0, -1 * $delimiterLen);
            $sqlInsert = (("INSERT" == substr($sql, 0, 6)) || ("COMMIT" == substr($sql, 0, 6)));
            if (($InsertDatos && $sqlInsert) || !$sqlInsert) {
                if (!empty($tblName)) {
                    /* restaurar solo una tabla o una vista --> sólo ejecutar las lineas que empiecen por USE,    DROP TABLE, CREATE TABLE,
                    INSERT IGNORE,    DROP VIEW,    CREATE VIEW, Create trigger
                     */
                    if ("USE" == strtoupper(substr($sql, 0, 3))) {
                        $db     = substr($sql, 5, strlen($sql) - 7);
                        $RunSQL = true;
                    } elseif ("CREATE DATABASE" == strtoupper(substr($sql, 0, 15))) {
                        $RunSQL = true;
                    } else {
                        $Instruccion = strtoupper(substr($sql, 0, 10));
                        $TrozoTXT    = explode("`", $sql);
                        switch ($Instruccion) {
                            case "DROP TABLE":
                            case "CREATE TAB":
                            case "DROP VIEW ":
                            case "CREATE VIE":
                            // $tablePos = 3;
                            // break;
                            case "DROP TRIGG":
                            case "INSERT IGN":
                                $tablePos = 1;
                                break;
                            case "CREATE TRI":
                                $tablePos = 5;
                        }
                        if ($TrozoTXT[$tablePos + 1] === ".") {
                            $tablePos += 2;
                        }
                        //incluye el nombre de BBDD
                        $RunSQL = ($tblName == $TrozoTXT[$tablePos]);
                    }
                } else {
                    $RunSQL = true;
                }
                if ($RunSQL) {
                    $respuesta = $conexion->query($sql);
                    if ($respuesta) {
                        if (!$VerSoloErrores) {
                            echo "<br>$NumLinea Ejecutado:  " . strtr((strlen($sql) > 100) ? substr($sql, 0, 100) . "..." : $sql, array("\n" => " "));
                        }

                    } else {
                        echo "<br><b><u>$NumLinea E R R O R: " . $conexion->errno . " :</u></b>" . $conexion->error . " ====> " . substr($sql, 0, 1022) . "...";
                        if (!$conexion->ping()) {
                            $conexion = new mysqli($host, $usuario, $passwd) or die("No se puede RECONECTAR con el servidor MySQL: %s\n" . $conexion->connect_error);
                            if (!$conexion->set_charset("utf8")) {
                                // cambiar el conjunto de caracteres a utf8
                                printf("Error cargando el conjunto de caracteres utf8: %s\n", $conexion->error);
                                exit();
                            }
                            $conexion->select_db($db);
                            $respuesta = $conexion->query($sql);
                            if ($respuesta) {
                                echo "<br>$NumLinea REEJECUTADO:  " . strtr(substr($sql, 0, 130), array("\n" => " ")) . "...";
                            } else {
                                echo "<br><b><u>$NumLinea REPITE-E R R O R: " . $conexion->errno . " :</u></b>" . $conexion->error . " ====> " . substr($sql, 0, 1022) . "...";
                            }

                        }
                    }
                }
            }
            $sql = "";
        } else {
            //no hemos alcanzado el delimitador el delimitador siempre debe estar al final de linea
            $sql .= $line . "\n";
        }
    }
    $conexion->close();
}
function run_split_sql($uploadfile, $host, $usuario, $passwd, $NewBD, $DropDataBase, $InsertDatos, $VerSoloErrores, $fixUtf8, $tblName)
{
    $x   = explode(".", $uploadfile);
    $ext = end($x);
    switch ($ext) {
        case "sql":
            $strSQLs = file_get_contents($uploadfile);
            unlink($uploadfile);
            break;
        case "zip":
            $zip = new ZipArchive;
            $zip->open($uploadfile);
            $zip->extractTo("./");
            $zip->close();
            unlink($uploadfile); //borra el zip
            $NewFile = stristr($uploadfile, "." . $ext, true); //le quitamos la ext
            $strSQLs = file_get_contents($NewFile);
            break;
        case "gz":
            $strSQLs = implode("", gzfile($uploadfile));
            break;
        case "bz2":
            $bz                = bzopen($uploadfile, "r") or die("No se pudo abrir el fichero $file para lectura");
            $decompressed_file = '';
            while (!feof($bz)) {
                $strSQLs .= bzread($bz, 4096);
            }
            bzclose($bz);
            break;
    }
    // PROBLEMAS EN LA INTERPRETACION DEL JUEGO DE CARACTERES
    $strSQL = convertir_utf8($strSQL);

    // Elimina lineas vacias o que empiezan por -- #   //   o entre /* y */
    // Elimna los espacios en blanco entre ; y \r\n
    // handle DOS and Mac encoded linebreaks
    $strSQLs = preg_replace("/\r\n$/", "\n", $strSQLs);
    $strSQLs = preg_replace("/\r$/", "\n", $strSQLs);
    $strSQLs = trim(preg_replace('/ {2,}/', ' ', $strSQLs)); // ----- remove multiple spaces -----
    $strSQLs = strtr($strSQLs, array("\r" => "")); //los \r\n los dejamos solo en \n
    if ($fixUtf8) {$strSQLs = strtr($strSQLs, array("latin1" => "utf8"));}
    $BD = CadenaAcotada($strSQLs, "USE `", "`");
    if (!empty($NewBD)) {
        if ($BD) {
            $strSQLs = strtr($strSQLs, array("`" . $BD . "`" => "`" . $NewBD . "`"));
        }

        echo "********** $BD --> $NewBD ******************************************";
        $BD = $NewBD;
    }

    run_sql($strSQLs, $BD, $host, $usuario, $passwd, $DropDataBase, $InsertDatos, $VerSoloErrores, $tblName);

    echo " <br>---FIN IMPORTACION---";
    return $BD;
}
?>
<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper">

    <?php require 'includes/menu.php';?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
<?php if ($permisos_ver == 1) {
    ?>
                <div class="col-lg-12">
                    <div class="portlet">
                        <div class="portlet-heading bg-primary">
                            <h3 class="portlet-title">
                                Restaurar Datos
                            </h3>
                            <div class="portlet-widgets">
                                <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                <span class="divider"></span>
                                <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
                                <span class="divider"></span>
                                <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="bg-primary" class="panel-collapse collapse show">
                            <div class="portlet-body">
                               <div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
           <FORM action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
              <div class="col-md-2">
              </div>
              <div class="col-md-8">
                  <p><b>Fichero (*.sql):</b>
                      <INPUT type="file" class="form-control" name="userfile"><br>
                      </div>
                      <div class="col-md-2">
                      </div>
                      <div class="col-md-6">
                          <INPUT type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAXFILESIZE ?>">
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="input-group">
                                      <span class="input-group-addon">Servidor:</span>
                                      <INPUT type="text" class="form-control" name="host" id ="host" value="localhost">
                                      </div><br>
                                  </div>

                                <div class="col-md-4">
                                  <div class="input-group">
                                      <span class="input-group-addon">Usuario:</span>
                                      <INPUT type="text" class="form-control" name="usuario" id ="usuario" value="root">
                                      </div><br>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon">Contraseña:</span>
                                          <INPUT type="text" class="form-control" name="passwd" id="passwd" value="">
                                          </div><br>
                                      </div>
                                      </div>

                                      <div class="col-md-6">
                                          <input name="DropDataBase" id="DropDataBase" type="checkbox" value="true" TITLE="Primero DROP DATABASE"/>  Primero ejecutar DROP DATABASE <br><br>
                                          <input name="InsertDatos" id="InsertDatos" type="checkbox" value="true" checked="checked" TITLE="Restaurar inserciones de datos "/>  Restaurar inserciones de datos <br><br>
                                          <input name="VerSoloErrores" id="VerSoloErrores" type="checkbox" value="true" checked="checked" />  Mostrar solo errores (no cada linea de ejecucion) <br><br>
                                          <input name="fixUtf8" id="fixUtf8" type="checkbox" value="true"  />Cambiar charset a utf8 <br>
                                      </div>
                                      <br>
                                      <div class="col-md-12">
                                          <div align="center"><b>O P C I O N A L </b></div><br>
                                          <div class="row">
                                          <div class="col-md-6">
                                              <b>Restaurar solo la Tabla :</b> <INPUT type="text" class="form-control" name="tblName" id ="tblName" value=""><br>
                                          </div>
                                          <div class="col-md-6">
                                              <b>Restaurar en otra Base de Datos con nombre distinto al que origino la copia: </b>: <INPUT type="text" class="form-control" name="NewBD" id="NewBD" value="">
                                          </div>
                                        </div>
                                      </p>
                                      <div class="col-md-12">
                                        <h6>( <u>nota:</u> Restaurar en otra Base de Datos se usa para restaurar en cualquier otra Base de datos distinta a la que se genero la copia. Si no existe la nueva base de datos, la crea. <br>
                                            SI HAY UNA TABLA o VISTA CON EL MISMO NOMBRE DE LA BASE DE DATOS QUE ORIGINO LA COPIA DE SEGURIDAD, FALLARA LA IMPORTACION EN OTRA BASE DE DATOS CON NOMBRE DISTINTO)</h6>
                                            <div align="center">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light"  name="upload" id="upload">Restaurar</button>
                                            </div>
                                            <BR><BR>
                                            </div>
                                            <div align="center"><b> Base datos para ejecutar SQL:</b>
                                              <br>
                                              <button type="submit" class="btn btn-success waves-effect waves-light" name="runSQL" id="runSQL">Seleccionar Base Datos</button>
                                            </div><br>
                                          </div>
                                      </FORM>

                                      <?PHP

    if (isset($_POST['DoSQL'])) {
        echo "procesando peticion de formulario SQL.....";
        // CONEXION
        $conexion = new mysqli($host, $usuario, $passwd, $BD) or die("No se puede conectar con MySQL: %s\n" . $conexion->connect_error);
        if (!$conexion->set_charset("utf8")) {
            // cambiar el conjunto de caracteres a utf8
            printf("Error cargando el conjunto de caracteres utf8: %s\n", $conexion->error);
            exit();
        }
        if (!empty($_POST['Tablas'])) {
            foreach ($_POST['Tablas'] as $tabla) {
                switch ($_POST['OpSQL']) {
                    case 'Select':
                        $strSQL = "SELECT * FROM `" . $tabla . "`; ";
                        echo "<BR /><BR /><BR /><BR /><BR /><H1><U>" . $tabla . "</U></H1>";
                        echo TableToHTML($conexion, $strSQL);
                        break;
                    case 'Empty':
                        $strSQL    = "TRUNCATE TABLE `" . $tabla . "`; ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        break;
                    case 'Drop':
                        $strSQL    = "DROP TABLE `" . $tabla . "`; ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        break;
                    case 'Rename':
                        $newTabla  = $tabla . date("_d_m_Y");
                        $strSQL    = "RENAME TABLE `" . $tabla . "` TO " . $newTabla . ";  ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        break;
                    case 'Duplicate':
                        $newTabla  = $tabla . date("_d_m_Y");
                        $strSQL    = "CREATE TABLE `" . $newTabla . "` LIKE `" . $tabla . "`;  ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        $strSQL    = "ALTER TABLE `" . $newTabla . "` DISABLE KEYS;  ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        $strSQL    = "INSERT INTO `" . $newTabla . "` SELECT * FROM  `" . $tabla . "`;  ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        $strSQL    = "ALTER TABLE `" . $newTabla . "` ENABLE KEYS; ";
                        $respuesta = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        $strSQL    = 'SELECT CONCAT_WS(" "," CREATE TRIGGER ",CONCAT_WS("_","' . $tabla . '", ACTION_TIMING,EVENT_MANIPULATION), ACTION_TIMING,EVENT_MANIPULATION, " ON ' . $tabla . ' FOR EACH ROW ",ACTION_STATEMENT," " ) AS x
                            FROM INFORMATION_SCHEMA.TRIGGERS
                            WHERE TRIGGER_SCHEMA = database() AND EVENT_OBJECT_TABLE = "' . $tabla . '";';
                        $rs       = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                        $num_rows = $rs->num_rows;
                        if ($num_rows != 0) {
                            while ($regSELECT = $rs->fetch_assoc()) {
                                $strSQL = $regSELECT["x"];
                                $rsRUN  = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
                            }
                        }
                        break;
                    case 'ShowCreateTable':
                        $strSQL = "SHOW CREATE TABLE `" . $tabla . "`";
                        echo "<BR /><BR /><BR /><BR /><BR /><H1><U>" . $strSQL . "</U></H1>";
                        echo TableToHTML($conexion, $strSQL);
                        $strSQL = 'SELECT "' . $tabla . '" as Tabla,CONCAT_WS(" "," CREATE TRIGGER ",CONCAT_WS("_","' . $newTabla . '",ACTION_TIMING,EVENT_MANIPULATION), ACTION_TIMING,EVENT_MANIPULATION, " ON ' . $newTabla . ' FOR EACH ROW ",ACTION_STATEMENT," " ) AS Def_TRIGGER
                            FROM INFORMATION_SCHEMA.TRIGGERS
                            WHERE TRIGGER_SCHEMA = database() AND EVENT_OBJECT_TABLE = "' . $tabla . '";';
                        echo TableToHTML($conexion, $strSQL);
                        break;
                    case 'ShowTableStatus':
                        $strSQL = "SHOW TABLE STATUS LIKE '" . $tabla . "' ";
                        echo "<BR /><BR /><BR /><BR /><BR /><H1><U>" . $strSQL . "</U></H1>";
                        echo TableToHTML($conexion, $strSQL);
                        break;
                }
            }
        }

        if (!empty($_POST["strSQL"])) {
            echo "<BR /><BR /><H6><U>" . $_POST["strSQL"] . "</U></H6>";
            $strSQLs     = $_POST["strSQL"];
            $Instruccion = substr($strSQLs, 0, 4);
            if (false === strripos("SHOW,SELE,DESC", $Instruccion)) {
                run_sql($strSQLs, $BD, $host, $usuario, $passwd, $DropDataBase, $InsertDatos, $VerSoloErrores, $tblName);
            } else {
                echo TableToHTML($conexion, $strSQLs);
            }
        }

        $conexion->close();
    }
    if (isset($_POST['upload'])) {
        //echo "Files ".print_r($_FILES)."<br>";
        //echo "POST ".print_r($_POST);
        $path = dirname(__FILE__);
        $dir  = $path . '/uploads/';
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                die('No se pudo crear el directorio.');
            }
        }
        $uploadfile = $dir . basename($_FILES['userfile']['name']);

        print '<pre>';
        switch ($_FILES['userfile']['error']) {
            case 0: // UPLOAD_ERR_OK
                //Debug("Sin error en fichero",$_FILES['userfile']['error'],true);
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                    //Debug("Archivo subido",$uploadfile);
                    echo "El archivo <b> $uploadfile </b> es v&aacute;lido y fue cargado exitosamente.<br>";
                    $NewBD          = $_POST["NewBD"];
                    $tblName        = $_POST["tblName"];
                    $DropDataBase   = isset($_POST["DropDataBase"]) && ($_POST['DropDataBase'] == "true") ? true : false;
                    $InsertDatos    = isset($_POST["InsertDatos"]) && ($_POST['InsertDatos'] == "true") ? true : false;
                    $VerSoloErrores = isset($_POST["VerSoloErrores"]) && ($_POST['VerSoloErrores'] == "true") ? true : false;
                    $fixUtf8        = isset($_POST["fixUtf8"]) && ($_POST['fixUtf8'] == "true") ? true : false;
                    $BD             = run_split_sql($uploadfile, $host, $usuario, $passwd, $NewBD, $DropDataBase, $InsertDatos, $VerSoloErrores, $fixUtf8, $tblName);
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong>
                           ¡Posible errror en carga de archivos!
                        </div>";
                }

                break;
            case 1: // UPLOAD_ERR_INI_SIZE
                echo "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong>
                           El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini) !
                        </div>";
                break;
            case 2: // UPLOAD_ERR_FORM_SIZE
                echo "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong>
                           El archivo sobrepasa el limite autorizado en el formulario HTML !
                        </div>";
                break;
            case 3: // UPLOAD_ERR_PARTIAL
                echo "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong>
                            El envio del archivo ha sido suspendido durante la transferencia!
                        </div>";
                break;
            case 4: // UPLOAD_ERR_NO_FILE
                echo "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong>
                            El archivo que ha enviado tiene un tamaño nulo !
                        </div>";
                break;
            default:
                echo "<div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong>
                            ERROR DESCONOCIDO !
                        </div>";
                break;
        }
        print "</pre>";
        unset($_POST['upload']);
        $_POST[] = array();
    }
    if (!empty($BD)) {
        $conexion = new mysqli($host, $usuario, $passwd, $BD) or die("No se puede conectar con MySQL: %s\n" . $conexion->connect_error);
        if (!$conexion->set_charset("utf8")) {
            // cambiar el conjunto de caracteres a utf8
            printf("Error cargando el conjunto de caracteres utf8: %s\n", $conexion->error);
            exit();
        }
        $strSQL         = "SHOW FULL TABLES FROM $BD WHERE Table_Type='BASE TABLE';"; //SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table
        $respuesta      = $conexion->query($strSQL) or die("No se puede ejecutar la consulta: $strSQL MySQL: \n" . $conexion->error);
        $NumTablas      = $respuesta->num_rows;
        $opcionesSelect = "";
        while ($tabla = $respuesta->fetch_array(MYSQLI_NUM)) {
            $opcionesSelect .= "<option value='$tabla[0]'> $tabla[0] </option>";
        }
        $respuesta->free();
        $conexion->close();
        $CurrentURL = $_SERVER['PHP_SELF'];
        echo "<form id='formEmptyTables' name='formEmptyTables' method='POST' action='$CurrentURL'>
                <INPUT type='hidden' name='host' value='$host'>
                <INPUT type='hidden' name='usuario' value='$usuario'>
                <INPUT type='hidden' name='passwd' value='$passwd'>
                <INPUT type='hidden' name='BD' value='$BD'>
                <h2>Tablas en la Base de Datos : </h2>
                <label>
                Mantener pulsado la tecla &lt;ctrl&gt; + clic
                </label><BR />
                        <select name='Tablas[]' size='$NumTablas' multiple='multiple' tabindex='1'>
                        $opcionesSelect
                        </select> <BR /><BR />
                    <label> Operacion sobre tablas seleccionadas:        </label><BR />
                        <select name='OpSQL' size='7' >
                            <option value='Select'> Select </option>
                            <option value='Empty'> Empty/Truncate/Delete </option>
                            <option value='Drop'> Drop </option>
                            <option value='Rename'> Rename </option>
                            <option value='Duplicate'> Duplicate/Copy </option>
                            <option value='ShowCreateTable'> Definicion DDL </option>
                            <option value='ShowTableStatus'> Propiedades </option>
                        </select><BR /><BR />
                     <label> Instruccion SQL :  (es idependiente de las tablas seleccionadas)</label><BR />
                            <TEXTAREA name='strSQL' rows='4' cols='80'></TEXTAREA><BR />
                    <input type='submit' name='DoSQL' value='[ Ejecutar ]' tabindex='2' />
                </form>    ";
    }
    ?>


                                  </div>
                              </div>
                          </div>


                            </div>
                        </div>
                    </div>
                </div>
<?php
} else {
    ?>
    <section class="content">
        <div class="alert alert-danger" align="center">
            <h3>Acceso denegado! </h3>
            <p>No cuentas con los permisos necesario para acceder a este módulo.</p>
        </div>
    </section>
    <?php
}
?>


            </div>
            <!-- end container -->
        </div>
        <!-- end content -->

        <?php require 'includes/pie.php';?>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
    <!-- Todo el codigo js aqui
    <!-- ============================================================== -->
    <?php require 'includes/footer_end.php'
?>

