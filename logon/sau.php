<?php
/*$caminho[0] = 'model/config/config.php';
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

$Obj  = new config();
$usu = $Obj->select_column("*","usuario"," id_empresa>0 and (us_id_empresa_propia_fk<>'1862' or us_id_empresa_propia_fk<>'1863') order by id_empresa");

foreach ($usu as $key => $value) {
	$where = "idempresa='{$value["id_empresa"]}' and tipoComercial='4' ";
	$empPropria = $Obj->select_column("*","cliente",$where);
	if (isset($empPropria[0])) {
		$ar["id"]=$empPropria[0]["idcliente"];
		$ar["cnpj"]=$empPropria[0]["cnpj"];
		$ar["id_usu"]=$value["idusuario"];
		echo $empPropria[0]["nome"]."<br>";
		updateUsuario($ar);
	}
	
}


function updateUsuario($param){
		$Obj  = new config();		
		$string["table"] = "usuario";
		$string["action"] = "update";		
		$string["where"] = " idusuario='{$param["id_usu"]}' ";		
		$string["us_id_empresa_propia_fk"] = $param["id"];
		$string["us_cnpj_empresa_propia_fk"] = $param["cnpj"];		
		$retorno = $Obj->sql($string);
}function updateEP($param){
		$Obj  = new config();		
		$string["table"] = "cliente";
		$string["action"] = "update";		
		$string["where"] = "idcliente='{$param["id"]}'";
		$string["cli_empresa_tela_preta"] = "1";		
		$retorno = $Obj->sql($string);
}

*/