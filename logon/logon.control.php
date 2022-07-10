<?php
header('Content-type: text/html; charset=UTF-8');
function mostraErros() {
    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);
    error_reporting(E_ALL);
}
foreach ($_REQUEST as $key => $value) {
    if(isset($value)){
        $param[$key] = $value;
    }
}
$caminho[0] = 'logon/logon.class.php';
for($j=0;$j<count($caminho);$j++){
    for($i=0;$i<4;$i++){
        if(file_exists($caminho[$j])){
            require_once($caminho[$j]);
            break;
        }else{
            $caminho[$j] = "../".$caminho[$j];
        }
    }
}
$param["logon"] = new logon(); $retorno = array();
switch ($param['op']) {
    case "submit_form": {
        if($param["element"] == "frm_logon"){
            $retorno = $param["logon"]->frm_logon($param);
        }
        echo json_encode($retorno);
        break;
    }
    case "COMBOBOX" : {
            if($param["element"] == "cbx_unidade"){$retorno = $param["logon"]->cbx_pesquisa_planta($param);}
            echo json_encode($retorno);
            break;
        }
   case "POST" : {
            if($param["element"] == "cbx_unidade"){$retorno = $param["logon"]->setar_planta($param);}
            echo json_encode($retorno);
            break;
        }
    case "mudarStatusLogon" : {
        $_SESSION["LOGADO"]="1";
        break;
    }
    default:{
        $retorno["retorno"] = "non_op";
        echo json_encode($retorno);
        break;
    }
}