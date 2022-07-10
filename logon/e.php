<?php
session_start();
require_once('../liam_framework/bd.php');

$retorno=array("r"=>"deslogado");


if($_REQUEST["op"]=="g"){
    $_SESSION = null;
    $obj = new Logon();
    $retorno = $obj->{$_REQUEST["action"]}();  
}

echo (json_encode($retorno))?json_encode($retorno):'"message":"Erro:'.json_last_error_msg().'"';








#classe genérica para funcionar o function
class Logon{

    function frm_logon(){
        $r["retorno"] = "no-user" ;
        $r["r"] = "" ;
        $obj = new db();
        $p["sql"]="SELECT  
                    u_id, u_id_empresa, u_status                   
                    FROM   usuarios 
                    WHERE  u_login= :login AND
                           u_senha= :senha AND u_status='Ativo' ";
    
        $p["login"]= $_REQUEST["login"];
        $p["senha"]= $_REQUEST["senha"];
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

        if(isset($retorno[0])){
            $_SESSION["idusuario"]=$retorno[0]["u_id"];
            $_SESSION["idempresa"]=$retorno[0]["u_id_empresa"];
            $_SESSION["usuario_status"]=$retorno[0]["u_status"];
            $r["retorno"] = "success";
        }
    
        return $r;
    }    
}