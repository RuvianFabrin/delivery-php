<?php
session_start();
//session_start();// and $_SESSION["id_empresa"]!="72"
function mostraErros() {
    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);
    error_reporting(E_ALL);
}
mostraErros();
?>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="cache-control" content="max-age=180" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<title>Delivery</title>
<?php
//print_r($_SESSION);
if (isset($_SESSION["idusuario"]) && isset($_SESSION["idempresa"]) && $_SESSION["idusuario"] > 0 && $_SESSION["idempresa"] > 0 ) {
   // if($_SESSION["usuario_status"] =="Ativo"){
        require_once('main.php');
    /*}else{        
        session_unset();
        echo "<script language='javaScript'>window.location.href='index.php'</script>";
    }*/
} else {    
    require_once('logon/logon.php');
}
?>