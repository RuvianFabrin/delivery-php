<?php
header('Content-type: text/html; charset=UTF-8');

//Mostra os erros
function mostraErros() {
    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);
    error_reporting(E_ALL);
}
//mostraErros();
session_start();
 
require_once 'class.php';

$obj = new liamClass();

$op = (isset($_REQUEST["op"])) ? $_REQUEST["op"] : "-1";


$idEmp = $_SESSION["id_empresa"];
$idUsu = $_SESSION["idusuario"];

$param["id_empresa"] = (isset($_SESSION["id_empresa"])) ? $_SESSION["id_empresa"] : "0";
$param["idusuario"] = (isset($_SESSION["idusuario"])) ? $_SESSION["idusuario"] : "0";
  foreach ($_REQUEST as $key => $value) {
        if(isset($value)){
            $termoUm = '_dice_date_br_and';
            $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key
            $newKeyD = $obj->decript_tela($key);
            //echo($newKeyD."<br>");
            if($newKeyD=="columns_dice" or $newKeyD=="fields_dice"){
                $param[$newKeyD] = json_decode($obj->decript_tela($value));
            }else if(preg_match($pattern, $newKeyD) and $value!="-1"){
                
                //Verifica se precisa converter antes do where
                //$valueNew = $obj->dateBR_ToUS($value);
                $newKeyUm = str_replace("_dice_date_br", "",$newKeyD);
                $param[$newKeyUm] = $valueNew;
                unset($param[$newKeyD]);
               
            }else{
                $param[$newKeyD] = $obj->decript_tela($value);
            }
                        
        }
    }   
     
    $paramUpdate=array();
    foreach ($_REQUEST as $key => $value) {
        if(isset($value) && $novo=="nao"){
            $termoUm = '_update';
            $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key
            $newKeyD = $obj->decript_tela($key);
            if(preg_match($pattern, $newKeyD)){
                $valor=$obj->decript_tela($value);
                $newKeyD = str_replace("_update", "",$newKeyD);
                if($newKeyD=="op"){
                    $param["op"]=$valor;
                }else{
                    $paramUpdate[$newKeyD]=$valor;
                }
                
            }
        }
        
    }
    
    foreach ($_FILES as $key => $value) {
        $termoUm = '_update';
        $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key
        $newKeyD = $obj->decript_tela($key);
        if(preg_match($pattern, $newKeyD)){
            $newKeyD = str_replace("_update", "",$newKeyD);
            $paramUpdate[$newKeyD]=$_FILES[$key];
        }
    }


    



    
$op = (isset($param["op"])) ? $param["op"] : "-1";
//$this->oreder();
if (isset($param["idusuario"]) && $param["idusuario"] != "-1"){
    switch ($op) {    
            case "insert_update": {
                $string = $obj->preparaCampos($param);                
                echo json_encode($obj->sql($string));
                break;
            }
            case "select": { 
                $retornarForm="0";
                  
                if(isset($param["tipo"])){
                    $retornarForm="1";
                    unset($param["tipo"]);
                }            
                $string = $obj->preparaCampos($param); 
                //print_r($string);
                $row = $obj->encriptSelect($string);
                $row = ($retornarForm=="0")?$row:$row[0];
                echo json_encode($row);
                break;
            }            
            case "select_str": { 
                
                $retornarForm="0";
                  
                if(isset($param["tipo"])){
                    $retornarForm="1";
                    unset($param["tipo"]);
                }            
                $row = $obj->encriptSelectComum($param["select"]); 
                
                $row = ($retornarForm=="0")?$row:$row[0];
                echo json_encode($row);
                break;
            }
            case "select_multi": { 
                //print_r($param);
                $sql = $obj->criaSelect($param);
                //print_r($sql);
                $row = $obj->encriptSelectComum($sql); 
                echo json_encode($row);
                break;
            }
            case "select_form": { 
                //print_r($param);
                $sql = $obj->criaSelect($param);
                //print_r($sql);
                $row = $obj->encriptSelectComum($sql); 
                echo json_encode($row[0]);
                break;
            }
            case "update": {
                //print_r($paramUpdate);
                
                $sql = $obj->criaUpdate($paramUpdate);
                //print_r($sql["sql"]);
                $retorno["retorno"] = $obj->RunQuery($sql["sql"]);
                $retorno["url"]=$sql["url"];
                echo json_encode($retorno);
                //
                break;
            }
            
        default:{
            $retorno["retorno"] = "non_op";
            echo json_encode($retorno);
            break;
        }
    }
}
else{
    $retorno["retorno"] = "non_session";
    echo json_encode($retorno);
}
?>