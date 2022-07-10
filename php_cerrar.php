<?php
session_start();
$_SESSION['user_name'] = null;
$_SESSION['tipo_user'] = null;
$_SESSION['cod_user']  = null;
header('Location:index.php');
