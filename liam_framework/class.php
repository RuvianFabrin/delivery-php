<?php
 
$caminhoConfig = 'model/config/config.php';

for($i=0;$i<4;$i++){
    if(file_exists($caminhoConfig)){
        break;
    }else{
        $caminhoConfig = "../".$caminhoConfig ;
    }
}
require_once($caminhoConfig);
class liamClass extends config{
    public function encriptSelect($string){
        $retorno=array();
        $encriptRetorno = (isset($string["encript_retorno"]))?"1":"0";
        unset($string["encript_retorno"]);
       
        $data = $this->sql($string);
            foreach($data as $key=>$value){
                foreach($value as $chave=>$valor){
                    //Se for dados dos campos que são digitados na tela
                    $termoUm = '_dice';
                    $termoDois = 'id_action';
                    $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key
                    $patternDois = '/' . $termoDois . '/';//Padrão a ser encontrado na string $key
                    if (preg_match($pattern, $chave) or preg_match($patternDois, $chave)) {
                        $termoData = '_date_br';
                        $patternData = '/' . $termoData . '/';
                        if (preg_match($patternData, $chave)){
                            $chaveEncript =  ($encriptRetorno=="0")?$this->encript_tela($chave): $chave;
                            $dataUs["date"] = $valor;
                            //$date_br = $this->date_converter($dataUs);
                            //$retorno[$key][$chaveEncript] = $date_br["date_br"];
                        }else{
                            $chaveEncript =  ($encriptRetorno=="0")?$this->encript_tela($chave):str_replace("_dice", "",$chave);
                            $retorno[$key][$chaveEncript] = $valor;
                        }
                    }
                }
            }
        
        return $retorno;
    }
    public function encriptSelectComum($string){
        return $this->RunSelect($string);
    }
    public function preparaCampos($data_param){
        $data["action"]="insert";
        foreach ($data_param as $key => $value) {
            //Não mude a ordem, pois na tela os campos são prenchidos em ordem
            $termoNove = '_id_action';
            $patternNove = '/' . $termoNove . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternNove, $key)) {
                $data["action"] = ($value=="-1")?"insert":"update";
                $newKey = str_replace($termoNove,"",$key);
                //$data[$newKey] = $value;
                $key = $newKey;
            }
            if($value!="-1"){
                //Se campos que o valor foi digitado pelo programador
                $termoTres = 'table';
                $patternTres = '/' . $termoTres . '/';//Padrão a ser encontrado na string $key
                if (preg_match($patternTres, $key)) {
                        $newKey = $termoTres;
                        $data[$newKey] = $value;
                }
                if($data["action"] == "update" or $data["action"] == "select"){
                            $termoQuatro = '_where_igual';
                            $patternQuatro = '/' . $termoQuatro . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternQuatro, $key)) {
                                //Se tem -1 não faz o where
                                    $newKey = str_replace($termoQuatro, "",$key);
                                    $data["where"] = $newKey."='".$value."'";
                            }
                            $termoCinco = '_where_diferente';
                            $patternCinco = '/' . $termoCinco . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternCinco, $key)) {
                                    $newKey = str_replace($termoCinco, "",$key);
                                    $data["where"] = $newKey."<>'".$value."'";
                            }
                            $termoAtualUm = '_and_igual';
                            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualUm, $key)) {
                                    $newKey = str_replace($termoAtualUm, "",$key);
                                    $data["where"] .= " and ".$newKey."='".$value."'";
                            }
                    $termoAtualUm = '_and_menor_igual';
                            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualUm, $key)) {
                                    $newKey = str_replace($termoAtualUm, "",$key);
                                    $data["where"] .= " and ".$newKey."<='".$value."'";
                            }
                    $termoAtualUm = '_and_maior_igual';
                            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualUm, $key)) {
                                    $newKey = str_replace($termoAtualUm, "",$key);
                                    $data["where"] .= " and ".$newKey.">='".$value."'";
                            }
                    $termoAtualUm = '_or_menor_igual';
                            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualUm, $key)) {
                                    $newKey = str_replace($termoAtualUm, "",$key);
                                    $data["where"] .= " or ".$newKey."<='".$value."'";
                            }
                    $termoAtualUm = '_or_maior_igual';
                            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualUm, $key)) {
                                    $newKey = str_replace($termoAtualUm, "",$key);
                                    $data["where"] .= " or ".$newKey.">='".$value."'";
                            }
                            $termoAtualDois = '_and_diferente';
                            $patternAtualDois = '/' . $termoAtualDois . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualDois, $key)) {
                                    $newKey = str_replace($termoAtualDois, "",$key);
                                    $data["where"] .= " and ".$newKey."<>'".$value."'";
                            }$termoAtualTres = '_or_igual';
                            $patternAtualTres = '/' . $termoAtualTres . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualTres, $key)) {
                                    $newKey = str_replace($termoAtualTres, "",$key);
                                    $data["where"] .= " or ".$newKey."='".$value."'";
                            }
                            $termoAtualQuatro = '_or_diferente';
                            $patternAtualQuatro = '/' . $termoAtualQuatro . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualQuatro, $key)) {
                                    $newKey = str_replace($termoAtualQuatro, "",$key);
                                    $data["where"] .= " or ".$newKey."<>'".$value."'";
                            }
                    $termoAtualOrder = '_order_by';
                            $patternAtualQuatro = '/' . $termoAtualQuatro . '/';//Padrão a ser encontrado na string $key
                            if (preg_match($patternAtualQuatro, $key)) {
                                    $newKey = str_replace($termoAtualQuatro, "",$key);
                                    $data["where"] .= "'".$value."'";
                            }
                }else{
                    $termoAtual = 'where_insert';
                    $patternAtual = '/' . $termoAtual . '/';//Padrão a ser encontrado na string $key
                    if (preg_match($patternAtual, $key)) {
                            $data["where"] = $value;
                    }
                }
                //Se for dados dos campos que são digitados na tela
                $termoUm = '_dice';
                $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key
                if (preg_match($pattern, $key)) {
                    $termoData = '_date_br';
                    $patternData = '/' . $termoData . '/';
                    if (preg_match($patternData, $key)){
                        //$valueNew = $this->dateBR_ToUS($value);
                        $newKeyUm = str_replace($termoData, "",$key);
                        $newKey = str_replace($termoUm,"",$newKeyUm);
                        //$data[$newKey] = $valueNew;
                    }else{
                        $newKey = str_replace($termoUm, "",$key);
                        $data[$newKey] = $value;
                    }
                }
            }
        }
        //unset($data["param"]);
        return $data;
    }
    public function encript_tela($data){
        $openSSL =  openssl_encrypt(
             $data,
             'AES-128-CBC',
             $_SESSION["SECRET"],
             0,
             $_SESSION["SECRET_IV"]);
        $preparaUm = str_replace("/","_brr_",$openSSL);
        $preparaDois = str_replace("=","_gl_",$preparaUm);
        $retorno = str_replace("+","_ms_",$preparaDois);
        return "xtdrk_".$retorno;
    }
    public function decript_tela($data){
        $preparaU = str_replace("xtdrk_","",$data);
        $preparaUm = str_replace("_ms_","+",$preparaU);
        $preparaDois = str_replace("_brr_","/",$preparaUm);
        $dado = str_replace("_gl_","=",$preparaDois);
        //echo "<br>";
        //print_r($dado);
        //echo "<br>";
        $retorno = openssl_decrypt(
             $dado,
             'AES-128-CBC',
             $_SESSION["SECRET"],
             0,
             $_SESSION["SECRET_IV"]);
            return ($retorno)?$retorno:$data;
    }
    public function numero_para_tela($array, $nome){
        for ($i = 0; $i < count($array); $i++){
            $array[$i][$nome] = str_replace(".",",",$array[$i][$nome]);
        }
        return $array;
    }
    public function numero_para_bd($value){
        $num = str_replace(".","",$value);//tira todos os pontos
        return str_replace(",",".",$value);//troca virgula por ponto
    }
    public function empty_values($data){
        for ($i = 0; $i <count($data) ; $i++) {
            foreach ($data[$i] as $key => $value) {
                $data[$i][$key] = ($data[$i][$key] == "")? "N/A" : $data[$i][$key];
            }
            $data[$i]["id"] = $data[$i]["idproduto"];
            $data[$i]["text"] = $data[$i]["nome_peca"];
        }
        return $data;
    }
    public function replace_empty_values($data){
        if(isset($data[0])){
            for ($i = 0; $i <count($data) ; $i++) {
                foreach ($data[$i] as $key => $value) {
                    $data[$i][$key] = ($data[$i][$key] == "")? "N/A" : $data[$i][$key];
                }
            }
        }else{
            unset($data[1]);
        }
        return $data;
    }

    public function criandoCBXLiam($param){
        $cLiam = "liam_framework/control.php";//Caminho
        $cLiam .="?". $this->encript_tela("op")."=".$this->encript_tela("select_str");

        //Não precisa mexer aqui .......
        $param["id"] = $this->encript_tela('id');//id usado para o Select e nome do combobox
        $param["text"] = $this->encript_tela('text');//text usado para o Select e nome do combobox
        $param["select"] = "select {$param["campoID"]} as {$param["id"]} ,{$param["campoText"]} as {$param["idNameDoCampo"]} from {$param["tabela"]} where  {$param["where"]} ";
        $param["str"] ="&". $this->encript_tela("select")."=".$this->encript_tela($param["select"]);
        $param["url"]=$cLiam.$param["str"];
        //Não precisa mexer aqui .......


        $ad = $param["adicionais"];
        $cbx = "<input class='easyui-combobox'  
            name='{$param["idNameDoCampo"]}'
            ".$ad." 
            id='{$param["idNameDoCampo"]}' 
            label='{$param["tituloCBX"]}' 
            labelPosition='top' 
            valueField='{$param["id"]}' 
            textField='{$param["idNameDoCampo"]}' 
            url='{$param["url"]}'
            style='width:100%;'>";
            

        return $cbx;
    }


    public function criaSelect($param){
        $retorno="select ";//array();
        $vir="";
        $identificador="";
        $tabela="";
        foreach($param as $chave=>$valor){
            $termo = '/_tableLiam/';
            if (preg_match($termo, $chave)){
                $campo = str_replace("_tableLiam", "",$chave);
                $identificador=$campo;
                $tabela=$valor;
                
            }      
                  
            
        }
        foreach($param as $chave=>$valor){
            $termo = '/_campo'.$identificador.'Liam/';
            if (preg_match($termo, $chave)){
                $campo = str_replace("_campo".$identificador."Liam", "",$chave);
                $retorno.=$vir.$campo." as ".$this->encript_tela($chave);//$this->encript_tela($param["select"])
                $vir=",";
            }      
                  
            
        }
        $retorno.=" from {$tabela}";
        
        $retorno.=" where ";
        foreach($param as $key=>$value){
            $termo = '/_'.$identificador.'whereLiam/';
            if (preg_match($termo, $key)){
                $campo = str_replace("_'.$identificador.'whereLiam", "",$key);
                $retorno.=$value;
               
            } 
            $termoQuatro = '_'.$identificador.'where_igual';
            $patternQuatro = '/' . $termoQuatro . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternQuatro, $key)) {
                //Se tem -1 não faz o where
                    $newKey = str_replace($termoQuatro, "",$key);
                    $retorno.= $newKey."='".$value."'";
            }
            $termoCinco = '_'.$identificador.'where_diferente';
            $patternCinco = '/' . $termoCinco . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternCinco, $key)) {
                    $newKey = str_replace($termoCinco, "",$key);
                    $retorno.= $newKey."<>'".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'and_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno.= " and ".$newKey."='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'and_menor_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno.= " and ".$newKey."<='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'and_maior_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno.= " and ".$newKey.">='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'or_menor_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno.= " or ".$newKey."<='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'or_maior_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno.= " or ".$newKey.">='".$value."'";
            }
            $termoAtualDois = '_'.$identificador.'and_diferente';
            $patternAtualDois = '/' . $termoAtualDois . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualDois, $key)) {
                    $newKey = str_replace($termoAtualDois, "",$key);
                    $retorno.= " and ".$newKey."<>'".$value."'";
            }
            $termoAtualTres = '_'.$identificador.'or_igual';
            $patternAtualTres = '/' . $termoAtualTres . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualTres, $key)) {
                    $newKey = str_replace($termoAtualTres, "",$key);
                    $retorno.= " or ".$newKey."='".$value."'";
            }
            $termoAtualQuatro = '_'.$identificador.'or_diferente';
            $patternAtualQuatro = '/' . $termoAtualQuatro . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualQuatro, $key)) {
                    $newKey = str_replace($termoAtualQuatro, "",$key);
                    $retorno.= " or ".$newKey."<>'".$value."'";
            }     
                  
            
        }
        
        return $retorno;
    }

    public function criaUpdate($param){
        $retorno["sql"]="update ";//array();
        $retorno["url"]="";
        /*UPDATE tabela
            SET coluna = novo_valor_armazenado
            WHERE coluna = valor_filtro;*/
        $vir="";
        $identificador="";
        $tabela="";
        foreach($param as $chave=>$valor){
            $termo = '/_tableLiam/';
            if (preg_match($termo, $chave)){
                $campo = str_replace("_tableLiam", "",$chave);
                $identificador=$campo;
                $tabela=$valor;
                
            }      
                  
            
        }
        $retorno["sql"].=" {$tabela} set ";
        foreach($param as $chave=>$valor){
            $termo = '/_campo'.$identificador.'Liam/';
            if (preg_match($termo, $chave)){
                $campo = str_replace("_campo".$identificador."Liam", "",$chave);
                $retorno["sql"].=$vir.$campo." = '{$valor}'";
                $vir=",";
            } 
            
            $termo = '/_file'.$identificador.'Liam/';
            if (preg_match($termo, $chave)){   
                       
                if($param[$chave]["error"] != 4){
                    $campo = str_replace("_file".$identificador."Liam", "",$chave);
                    $caminho = $this->make_file(array(
                        "file" => $param[$chave],
                        "path" => "controle_projetos/img"
                    ));
                
                    $retorno["sql"].=$vir.$campo." = '{$caminho}'";
                    $vir=",";
                    $retorno["url"]=$caminho;
                }
            }

                  
            
        }
        
        
        $retorno["sql"].=" where ";
        foreach($param as $key=>$value){
            $termo = '/_'.$identificador.'whereLiam/';
            if (preg_match($termo, $key)){
                $campo = str_replace("_'.$identificador.'whereLiam", "",$key);
                $retorno["sql"].=$value;
               
            } 
            $termoQuatro = '_'.$identificador.'where_igual';
            $patternQuatro = '/' . $termoQuatro . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternQuatro, $key)) {
                //Se tem -1 não faz o where
                    $newKey = str_replace($termoQuatro, "",$key);
                    $retorno["sql"].= $newKey."='".$value."'";
            }
            $termoCinco = '_'.$identificador.'where_diferente';
            $patternCinco = '/' . $termoCinco . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternCinco, $key)) {
                    $newKey = str_replace($termoCinco, "",$key);
                    $retorno["sql"].= $newKey."<>'".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'and_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno["sql"].= " and ".$newKey."='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'and_menor_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno["sql"].= " and ".$newKey."<='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'and_maior_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno["sql"].= " and ".$newKey.">='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'or_menor_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno["sql"].= " or ".$newKey."<='".$value."'";
            }
            $termoAtualUm = '_'.$identificador.'or_maior_igual';
            $patternAtualUm = '/' . $termoAtualUm . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualUm, $key)) {
                    $newKey = str_replace($termoAtualUm, "",$key);
                    $retorno["sql"].= " or ".$newKey.">='".$value."'";
            }
            $termoAtualDois = '_'.$identificador.'and_diferente';
            $patternAtualDois = '/' . $termoAtualDois . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualDois, $key)) {
                    $newKey = str_replace($termoAtualDois, "",$key);
                    $retorno["sql"].= " and ".$newKey."<>'".$value."'";
            }
            $termoAtualTres = '_'.$identificador.'or_igual';
            $patternAtualTres = '/' . $termoAtualTres . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualTres, $key)) {
                    $newKey = str_replace($termoAtualTres, "",$key);
                    $retorno["sql"].= " or ".$newKey."='".$value."'";
            }
            $termoAtualQuatro = '_'.$identificador.'or_diferente';
            $patternAtualQuatro = '/' . $termoAtualQuatro . '/';//Padrão a ser encontrado na string $key
            if (preg_match($patternAtualQuatro, $key)) {
                    $newKey = str_replace($termoAtualQuatro, "",$key);
                    $retorno["sql"].= " or ".$newKey."<>'".$value."'";
            }     
                  
            
        }
        
        return $retorno;
    }
  
    public function OGHBJQMTOEGMLYXF($param){
        $retorno=array();
        //Aqui vai fazer update. insert, delete, select
        $paramNovo=$this->formato_liam($param);
        $retornarForm="0";                  
        $retornarURL="";                  
        $pastaArquivo="0"; //Exemplo: controle_projetos/img 
        //print_r($paramNovo);                
        if(isset($paramNovo["pastaArquivo"])){
            $pastaArquivo=$paramNovo["pastaArquivo"];
            unset($paramNovo["pastaArquivo"]);
        }
        if(isset($paramNovo["tipo"])){
            $retornarForm="1";
            unset($paramNovo["tipo"]);
        }            
        if(isset($paramNovo["url"])){
            $retornarURL=$paramNovo["url"];
            unset($paramNovo["url"]);
        }            
        
        //print_r($paramNovo);
        $row = $this->sql($paramNovo);//Esse faz todos update/insert/select - mande em forma de array
        
        
        $retorno = ($retornarForm=="0")?$row:$row[0];
        if($paramNovo["action"]=="update" || $paramNovo["action"]=="insert"){
            $retorno["url"]=$retornarURL;
        }
        return $retorno;
    }

    public function formato_liam($param){
        #Desincriptar
        foreach ($param as $key => $value) {
        
            $termoUm = '_LiamF';
            $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key       
            
            $newKeyK = $this->decript_tela($key); 
            if(preg_match($pattern, $newKeyK)){
                if($newKeyK=="columns_LiamF" || $newKeyK=="fields_LiamF"){
                    $newKeyK = str_replace("_LiamF", "",$newKeyK);
                    $novo="sim";
                    $listaN=array();
                    $i=0;
                    foreach ($value as $key => $valor) {
                        $lista = $this->decript_tela($valor);
                        $listaN[$i]=$lista;
                        $i++;
                    }
                    $paramNovo[$newKeyK]=$listaN;
                    
                }else{
                    $newKeyK = str_replace("_LiamF", "",$newKeyK);
                    $novo="sim";
                    if($newKeyK!="where"){
                        $paramNovo[$newKeyK]=$this->decript_tela($value);
                    }
                }
            }
            
        }
        
        if($paramNovo["action"]=="update" || $paramNovo["action"]=="insert"){        
            foreach ($_FILES as $key => $value) {
                $caminho="";
                $termoUm = '_LiamF';
                $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key
                $newKeyK = $this->decript_tela($key);
                if(preg_match($pattern, $newKeyK)){
                    $newKeyK = str_replace("_LiamF", "",$newKeyK);
                    if($_FILES[$key]["error"] != 4){
                        $paramNovo[$newKeyK] = $this->make_file(array(
                            "file" => $_FILES[$key],
                            "path" => $paramNovo["pastaArquivo"]
                        ));
                        $paramNovo["url"]=$paramNovo[$newKeyK];
                    }
                }
            }
        }

        if($paramNovo["action"]=="delete" || $paramNovo["action"]=="update" || $paramNovo["action"]=="select"){ 
            foreach ($param as $key => $value) {
                $whereArray = $value;
            
                $termoUm = '_LiamF';
                $pattern = '/' . $termoUm . '/';//Padrão a ser encontrado na string $key       
                
                $newKeyK = $this->decript_tela($key); 
                if(preg_match($pattern, $newKeyK)){
                    if($newKeyK=="where_LiamF"){
                        $newKeyK = str_replace("_LiamF", "",$newKeyK);
                        $novo="sim";
                        $where="";
                        if(gettype($value)!="array"){
                            //print_r($value."<br>");
                            //print_r(gettype($value."<br>"));
                            $whereArray=explode(",",$whereArray);//feito isso porque do form está vindo como string
                            
                        }
                        
                        foreach ($whereArray as $key => $valor) {
                            $lista = $this->decript_tela($valor);
                            $where.=$lista;
                        }
                        $paramNovo[$newKeyK]=$where;
                        
                    }                  
                }
            }
        }
        
        //print_r($paramNovo);
        return $paramNovo;
    }
}
?>