<?php
header('Content-type: text/html; charset=UTF-8');
//novo op é AODRFDRBWUXNUDGD
//novo html_return é 
function mostraErros() {
    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);
    error_reporting(E_ALL);
}session_start();
require_once 'class.php'; $obj = new liamClass();
$retorno = array("retorno"=>"non_session"); $param = array_merge($_SESSION,$_REQUEST);
if (isset($param["idusuario"]) && $param["idusuario"] > "0"){
    $retorno = array("retorno"=>"non_op");
    if(in_array($param["AODRFDRBWUXNUDGD"],array("OGHBJQMTOEGMLYXF","RVRDXBCGONTUTYVE","do_action"))){
        $type = ($param["AODRFDRBWUXNUDGD"] == "do_action")? "action" : "IFSVOPLNAYOIJYLB"; $retorno = $obj->{$param[$type]}($param);
    }
}
if($param["op"]=="RVRDXBCGONTUTYVE"){
    echo $retorno;
}else{
    echo (json_encode($retorno))?json_encode($retorno):'"message":"Erro:'.json_last_error_msg().'"';

}