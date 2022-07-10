<?php
$caminho[0] = 'model/config/config.php';
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
class logon extends config {
    public function frm_logon($param) {
        $retorno["retorno"] = "error";
        $user_data = $this->validade_logon($param);
        
        /*if(isset($param["main"]) and isset($user_data[0])){
            $minutes_to_add = $_SESSION["cli_temp_session"];

            $time = new DateTime();
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $stamp = $time->format('d-m-Y H:i:s');
            $_SESSION["cli_data_login"] = $stamp;
            $_SESSION["LOGADO"]="1";
            $retorno["retorno"] ="success";
        }else */
        if (isset($user_data[0])) {
            $_SESSION["idusuario"]=$user_data[0]["u_id"];
            $_SESSION["idempresa"]=$user_data[0]["u_id_empresa"];
            /*$param = $user_data[0];
            //$empresa_data = $this->select_column("nome,estatus","empresa","idempresa='{$user_data[0]["id_empresa"]}'");
            $empresa_data = $this->pesquisaCNPJUsuario($param);
            
            if(isset($empresa_data[0])){ 
                //$retorno["retorno"] = $this->make_session($user_data,$empresa_data);
                //$empresa_data[0]["status"] != "2" && 
                if( $empresa_data[0]["status"] != "3"){
                    $retorno["retorno"] = $this->make_session($user_data,$empresa_data);
                }/*else if($empresa_data[0]["status"]=="2"){
                    $retorno["retorno"] = $this->make_session($user_data,$empresa_data);
                    //$retorno["retorno"] = "user-warning";
                }*//*
                else if($empresa_data[0]["status"]=="3"){
                    $retorno["retorno"] = "no-access";
                }
            }else{ $retorno["retorno"] = "no-company"; } */
            
            
            

        }else{ $retorno["retorno"] = "no-user"; }
        //$retorno["solicita_unidade"] = (isset($_SESSION["solicita_unidade"]))?$_SESSION["solicita_unidade"]:"0";
        return $retorno;
    }
    public function validade_logon($param) {
        $this->start_session(180);
        $table = "usuarios";
        $where = "
            u_login='{$param["login"]}' AND
            u_senha='{$param["senha"]}' AND (
                u_status='Ativo'
            )";
        $fields = "
            u_id,
            u_id_empresa";
        return $this->select_column($fields,$table,$where);
    }
} 
    
    
    /*
    public function pesquisaCNPJUsuario($param){
        $campos = "
			cli.idcliente,
			cli.cli_temp_session,
            cli.cli_empresa_tela_preta,
			cn.cnpj_categoria_de_acesso,
			cn.cnpj_status_acesso as status,
            cn.cnpj_dono as dono,
			cli.nome,
			cn.caminho_logo
        ";
        $where = "cli.idempresa='{$param["id_empresa"]}'";// and cli.idempresa<>'72'
        $where .= " and cli.cnpj=cn.cnpj_cnpj ";
        $where .=" and cli.cli_empresa_tela_preta='1'";//Empresa principal tela preta

		$tabela="cliente as cli, CNPJ as cn";

        $ret = $this->select_column($campos,$tabela,$where);
        return $ret;
    }
    //Sistema estará temporariamente fora do ar para a realização da separação do sistema conforme solicitado pela diretoria.
    public function validade_logon($param) {
        $this->start_session(180);
        $table = "usuarios";
        $where = "
            u_login='{$param["login"]}' AND
            u_senha='{$param["senha"]}' AND (
                u_status='Ativo'
            )";
        $fields = "
            u_id,
            u_id_empresa,
            us_sobrenome";
        return $this->select_column($fields,$table,$where);
    }
    public function start_session($time) {
        //session_cache_limiter('private');
        //session_cache_expire($time);
        $tempodevida = 2678400; // 1 Mês
        session_set_cookie_params($tempodevida);
        session_start();
        session_regenerate_id();
    }
    public function make_session($user_data,$empresa_data) {
        #Valores de usuario ######################################################################
            #Dados do select do usuario
                foreach ($user_data[0] as $key => $value) {
                    $_SESSION[$key] = $value;
                }

            #Nome completo
                $_SESSION["usuario_nome_completo"] = "{$user_data[0]["us_nome"]} {$user_data[0]["us_sobrenome"]}";
            #Retrato
                $_SESSION["retrato_usuario"] = (file_exists("../{$_SESSION["us_arquivo"]}"))? $_SESSION["us_arquivo"] : "foto/default.jpg";
            #Setor
                $setor_id = $this->select_column("us_id_setor","usuario_setor","us_id_usuario='{$_SESSION['idusuario']}' AND us_status_setor_principal='1'");
                if(isset($setor_id[0])){
                    $validate_setor =$this->select_column("s_descricao","processo","s_id='{$setor_id[0]["us_id_setor"]}'");
                    $_SESSION["setor_principal"] = (isset($validate_setor[0]))? $validate_setor[0]["s_descricao"] : "N/A";
                    $_SESSION["setor_principal_id"] = (isset($validate_setor[0]))? $setor_id[0]["us_id_setor"] : "0";
                }
            #Função
                $funcao_id = $this->select_column("ufr_id_funcao_fk","usuario_funcao","ufr_id_usuario_fk='{$_SESSION['idusuario']}' AND ufr_status_funcao_principal='1'");
                if(isset($funcao_id[0])){
                    $validate_funcao = $this->select_column("fun_nome","adm_funcao","fun_id='{$funcao_id[0]["ufr_id_funcao_fk"]}'");
                    $_SESSION["funcao_principal"] = (isset($validate_funcao[0]))? $validate_funcao[0]["fun_nome"] : "N/A";
                    $_SESSION["funcao_principal_id"] = (isset($validate_funcao[0]))? $funcao_id[0]["ufr_id_funcao_fk"] : "0";
                }
        #Valores de empresa e Empresa propia #####################################################
            #Status - 1 - Normal | 2 - Alerta de atraso NO pagamento | 3 - Bloqueado acesso (Fica igual o nivel 2 ou seja só vê os registros já feitos sem poder fazer novos)
                $_SESSION["status_do_login"] = $empresa_data[0]["status"];
            #Dono (1-quality | 2-K&L | 3 - outras empresas)
                $_SESSION["dono"]=$empresa_data[0]["dono"];
            #Nome da empresa
                $_SESSION["nome_empresa"] = $empresa_data[0]["nome"];#$_SESSION["nome"] = $empresa_data[0]["nome"];
            #Logo da empresa
                //$company_logo = "foto/".$this->select_data("foto","empresa", "idempresa='{$_SESSION["id_empresa"]}'");
                $_SESSION["company_logo"] = $empresa_data[0]["caminho_logo"];//(file_exists("../{$company_logo}"))? $company_logo : "foto/default.jpg";
            #Nome da empresa propia
                $empresa_propia_data = $this->select_column("nome,cnpj,cli_temp_session","cliente","idcliente='{$_SESSION["id_empresa_propia"]}'");
                $_SESSION["nome_empresa_propia"] = (isset($empresa_propia_data[0]))?$empresa_propia_data[0]["nome"] : "Planta não encontrada";
                $_SESSION["cnpj_empresa"] = (isset($empresa_propia_data[0]["cnpj"]))? $empresa_propia_data[0]["cnpj"]:"";
                $_SESSION["cli_temp_session"] = (isset($empresa_propia_data[0]["cli_temp_session"]))?$empresa_propia_data[0]["cli_temp_session"] : "30";
                $_SESSION["cli_temp_session_original"]=$_SESSION["cli_temp_session"];
                $dataAtual = new DateTime("+".$_SESSION["cli_temp_session"]." minute");
                //$dataAtual = new DateTime("+1 minute");
                $_SESSION["cli_data_login"] = $dataAtual->format('d-m-Y H:i:s');
                $_SESSION["LOGADO"]="1";


                $_SESSION["solicita_unidade"] = "0";//verificar se tem mais de uma empresa própria para esse usuario
                $permissao_id = $this->select_column("upe_id","usuario_permissoes_especiais","upe_id_usuario_fk='{$_SESSION['idusuario']}' AND upe_id_permisao_fk='8'");
                if(isset($permissao_id[0])){
                    $unidades = $this->select_column("*","usuario_unidades","uu_id_funcionario_fk='{$_SESSION['idusuario']}' and uu_staus_ativo='1'");
                    //se tem ao menos uma unidade marcada pergunta a unidade que quer logar
                    $_SESSION["solicita_unidade"] = (isset($unidades[0]))? "1":"0";
                } 

            #Logo da quality
                $quality_logo = $this->select_data("caminho_logo","cliente as cli,CNPJ as cn", "idempresa='19' and cli_empresa_tela_preta='1' and cli.cnpj=cnpj_cnpj");
                $_SESSION["quality_logo"] = (file_exists("../{$quality_logo}"))? $quality_logo : "foto/default.jpg";
        #Valores da tabela CNPJ ##################################################################
            $type_lab = $this->select_column("cnp_metrologia","CNPJ","cnpj_cnpj='{$_SESSION["cnpj_empresa_propia"]}'");
            $_SESSION["modulo_metrologia"] = (isset($type_lab[0]))? $type_lab[0]["cnp_metrologia"] : "0";
        #Informações do sistema ##################################################################
            $sistem_data = $this->select_column("eiv_versao,eiv_build","isoeasy_versoes", "1=1");
            $_SESSION["versao_sistema"] = (isset($sistem_data[0]))? $sistem_data[0]["eiv_versao"] : "N/A";
            $_SESSION["build_sistema"] = (isset($sistem_data[0]))? $sistem_data[0]["eiv_build"] : "N/A";
        #Criando codificão########################################################################
            
                $_SESSION["SECRET"] = pack('a16',"quality".$_SESSION["idusuario"]);//session_id()
                $_SESSION["SECRET_IV"] = pack('a16',"learning".$_SESSION["id_empresa"]);  

                //verificando o Status dos EIMEs da Empresa
                $this->verificarEIME();
            
            
        return "success";
    }

    public function verificarEIME(){
        #vencido
        $string_sql["action"] = "update";
		$string_sql["table"] = "cad_eime_novo";
		$string_sql["where"] = "cde_id_empresa_fk='{$_SESSION["id_empresa"]}' and cde_data_alerta_vencido<=CURDATE() and cde_data_alerta_vencido IS NOT NULL";
		$string_sql["cde_status_quatro"] = "3";
		$this->sql($string_sql);

        #vencendo
        $string_sql["action"] = "update";
		$string_sql["table"] = "cad_eime_novo";
		$string_sql["where"] = "cde_id_empresa_fk='{$_SESSION["id_empresa"]}' and cde_data_alerta_vencido>CURDATE() and cde_data_alerta_vencido IS NOT NULL and cde_data_alerta_vencendo<=CURDATE() and cde_data_alerta_vencendo IS NOT NULL";
		$string_sql["cde_status_quatro"] = "2";
		$this->sql($string_sql);
    }
    public function cbx_pesquisa_planta($param){
        session_start();
        $unidades = $this->select_column("*","usuario_unidades","uu_id_funcionario_fk='{$_SESSION['idusuario']}' and uu_staus_ativo='1'");
        $retorno = Array();
        $select = T_REQUIRE_ONCE;
        foreach ($unidades as $key => $value) {
            if($value['uu_cnpj_unidade']!=""){
                $cliente = $this->select_column("idcliente,nome","cliente","cnpj='{$value['uu_cnpj_unidade']}'");
                 $cnpj = $this->select_column("fantasia_cnpj","CNPJ","cnpj_cnpj='{$value['uu_cnpj_unidade']}'");
                 $nome = (strlen($cliente[0]["nome"])>3)?$cliente[0]["nome"]:$cnpj[0]["fantasia_cnpj"];
                $retorno[$key]["id"]=$cliente[0]["idcliente"];
                $retorno[$key]["text"]=$nome;
                if($select){
                     $retorno[$key]["selected"]=true;
                }
            }

        }

        return $retorno;

    }
    public function setar_planta($param){
        session_start();
        $_SESSION["id_empresa_propia"] = $param["ide"];
		$empresa_propria_data = $this->select_column("nome,cnpj,cli_temp_session","cliente","idcliente='{$param["ide"]}'");
        $_SESSION["nome_empresa_propia"] = (isset($empresa_propria_data[0]))?$empresa_propria_data[0]["nome"] : "Planta não encontrada";
        $_SESSION["cnpj_empresa"] = (isset($empresa_propria_data[0]["cnpj"]))? $empresa_propria_data[0]["cnpj"]:"";
        $_SESSION["cli_temp_session"] = (isset($empresa_propria_data[0]["cli_temp_session"]))?$empresa_propria_data[0]["cli_temp_session"] : "5";
        //echo "Entrou";

        //print_r($_SESSION);

    }

}


//Código de logon por empresa (Forma Antiga)

/*
$caminho[0] = 'model/config/config.php';
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
class logon extends config {
    public function frm_logon($param) {
        $retorno["retorno"] = "error";
        $user_data = $this->validade_logon($param);
        $retorno["ide"]="0";
        if (isset($user_data[0])) {
            $retorno["ide"] = $user_data[0]["id_empresa"];
            $empresa_data = $this->select_column("nome,estatus","empresa","idempresa='{$user_data[0]["id_empresa"]}'");
            if(isset($empresa_data[0]) && $empresa_data[0]["estatus"] != "2" && $empresa_data[0]["estatus"] != "3"){
                $retorno["retorno"] = $this->make_session($user_data,$empresa_data);
            }
            else if(isset($empresa_data[0])&&($empresa_data[0]["status"]=="2"||$empresa_data[0]["status"]=="3")){
                if($empresa_data[0]["status"]=="2"){
                    $retorno["retorno"] = "user-warning";
                }
                else if($empresa_data[0]["status"]=="3"){
                    $retorno["retorno"] = "no-access";
                }
            }
            else if(!isset($empresa_data[0])){
                //$retorno["retorno"] = "no-company";
            }

        }
        else{
            $retorno["retorno"] = "no-user";
        }
        $retorno["solicita_unidade"] = (isset($_SESSION["solicita_unidade"]))?$_SESSION["solicita_unidade"]:"0";
        return $retorno;
    }
    public function validade_logon($param) {
        $this->start_session(180);
        $table = "usuario";
        $where = "
            login='{$param["login"]}' AND
            senha='{$param["senha"]}' AND (
                us_status_situacao='1' OR
                us_status_situacao='7'
            )";
        $fields = "
            idusuario,
            id_empresa,
            us_arquivo,
            us_sobrenome,
            login,
            nome AS us_nome,
            us_id_empresa_propia_fk AS id_empresa_propia,
            us_cnpj_empresa_propia_fk AS cnpj_empresa_propia,
            us_id_cnpj_fk AS id_cnpj_empresa_propia,
            email_eime AS Email_Eime,
            email AS usuario_email";
        return $this->select_column($fields,$table,$where);
    }
    public function start_session($time) {
        //session_cache_limiter('private');
        //session_cache_expire($time);
        session_start();
        session_regenerate_id();
    }
    public function make_session($user_data,$empresa_data) {
        #Valores de usuario ######################################################################
            #Dados do select do usuario
                foreach ($user_data[0] as $key => $value) {
                    $_SESSION[$key] = $value;
                }
            #Nome completo
                $_SESSION["usuario_nome_completo"] = "{$user_data[0]["us_nome"]} {$user_data[0]["us_sobrenome"]}";
            #Retrato
                $_SESSION["retrato_usuario"] = (file_exists("../{$_SESSION["us_arquivo"]}"))? $_SESSION["us_arquivo"] : "foto/default.jpg";
            #Setor
                $setor_id = $this->select_column("us_id_setor","usuario_setor","us_id_usuario='{$_SESSION['idusuario']}' AND us_status_setor_principal='1'");
                if(isset($setor_id[0])){
                    $validate_setor =$this->select_column("s_descricao","processo","s_id='{$setor_id[0]["us_id_setor"]}'");
                    $_SESSION["setor_principal"] = (isset($validate_setor[0]))? $validate_setor[0]["s_descricao"] : "N/A";
                }
            #Função
                $funcao_id = $this->select_column("ufr_id_funcao_fk","usuario_funcao","ufr_id_usuario_fk='{$_SESSION['idusuario']}' AND ufr_status_funcao_principal='1'");
                if(isset($funcao_id[0])){
                    $validate_funcao = $this->select_column("fun_nome","adm_funcao","fun_id='{$funcao_id[0]["ufr_id_funcao_fk"]}'");
                    $_SESSION["funcao_principal"] = (isset($validate_funcao[0]))? $validate_funcao[0]["fun_nome"] : "N/A";
                }
        #Valores de empresa e Empresa propia #####################################################
            #Nome da empresa
                $_SESSION["nome_empresa"] = $empresa_data[0]["nome"];#$_SESSION["nome"] = $empresa_data[0]["nome"];
            #Logo da empresa
                $company_logo = "foto/".$this->select_data("foto","empresa", "idempresa='{$_SESSION["id_empresa"]}'");
                $_SESSION["company_logo"] = (file_exists("../{$company_logo}"))? $company_logo : "foto/default.jpg";
            #Nome da empresa propia
                $empresa_propia_data = $this->select_column("nome,cnpj,cli_temp_session","cliente","idcliente='{$_SESSION["id_empresa_propia"]}'");
                $_SESSION["nome_empresa_propia"] = (isset($empresa_propia_data[0]))?$empresa_propia_data[0]["nome"] : "Planta não encontrada";
                $_SESSION["cnpj_empresa"] = (isset($empresa_propia_data[0]["cnpj"]))? $empresa_propia_data[0]["cnpj"]:"";
                $_SESSION["cli_temp_session"] = (isset($empresa_propia_data[0]["cli_temp_session"]))?$empresa_propia_data[0]["cli_temp_session"] : "5";
                $dataAtual = new DateTime("+".$_SESSION["cli_temp_session"]." minute");
                //$dataAtual = new DateTime("+1 minute");
                $_SESSION["cli_data_login"] = $dataAtual->format('d-m-Y H:i:s');


                $_SESSION["solicita_unidade"] = "0";//verificar se tem mais de uma empresa própria para esse usuario
                $permissao_id = $this->select_column("upe_id","usuario_permissoes_especiais","upe_id_usuario_fk='{$_SESSION['idusuario']}' AND upe_id_permisao_fk='8'");
                if(isset($permissao_id[0])){
                    $unidades = $this->select_column("*","usuario_unidades","uu_id_funcionario_fk='{$_SESSION['idusuario']}' and uu_staus_ativo='1'");
                    //se tem ao menos uma unidade marcada pergunta a unidade que quer logar
                    $_SESSION["solicita_unidade"] = (isset($unidades[0]))? "1":"0";
                }

            #Logo da quality
                $quality_logo = "foto/".$this->select_data("foto","empresa", "idempresa='19'");
                $_SESSION["quality_logo"] = (file_exists("../{$quality_logo}"))? $quality_logo : "foto/default.jpg";
        #Valores da tabela CNPJ ##################################################################
            $type_lab = $this->select_column("cnp_metrologia","CNPJ","cnpj_cnpj='{$_SESSION["cnpj_empresa_propia"]}'");
            $_SESSION["modulo_metrologia"] = (isset($type_lab[0]))? $type_lab[0]["cnp_metrologia"] : "0";
        #Informações do sistema ##################################################################
            $sistem_data = $this->select_column("eiv_versao,eiv_build","isoeasy_versoes", "1=1");
            $_SESSION["versao_sistema"] = (isset($sistem_data[0]))? $sistem_data[0]["eiv_versao"] : "N/A";
            $_SESSION["build_sistema"] = (isset($sistem_data[0]))? $sistem_data[0]["eiv_build"] : "N/A";
        #Criando codificão########################################################################
            $_SESSION["SECRET"] = pack('a16',session_id().$_SESSION["idusuario"]);
            $_SESSION["SECRET_IV"] = pack('a16',session_id().$_SESSION["id_empresa"]);
        return "success";
    }

    public function cbx_pesquisa_planta($param){
        session_start();
        $unidades = $this->select_column("*","usuario_unidades","uu_id_funcionario_fk='{$_SESSION['idusuario']}' and uu_staus_ativo='1'");
        $retorno = Array();
        $select = T_REQUIRE_ONCE;
        foreach ($unidades as $key => $value) {
            if($value['uu_cnpj_unidade']!=""){
                $cliente = $this->select_column("idcliente,nome","cliente","cnpj='{$value['uu_cnpj_unidade']}'");
                 $cnpj = $this->select_column("fantasia_cnpj","CNPJ","cnpj_cnpj='{$value['uu_cnpj_unidade']}'");
                 $nome = (strlen($cliente[0]["nome"])>3)?$cliente[0]["nome"]:$cnpj[0]["fantasia_cnpj"];
                $retorno[$key]["id"]=$cliente[0]["idcliente"];
                $retorno[$key]["text"]=$nome;
                if($select){
                     $retorno[$key]["selected"]=true;
                }
            }

        }

        return $retorno;

    }
    public function setar_planta($param){
        session_start();
        $_SESSION["id_empresa_propia"] = $param["ide"];
        $empresa_propria_data = $this->select_column("nome,cnpj,cli_temp_session","cliente","idcliente='{$param["ide"]}'");
        $_SESSION["nome_empresa_propia"] = (isset($empresa_propria_data[0]))?$empresa_propria_data[0]["nome"] : "Planta não encontrada";
        $_SESSION["cnpj_empresa"] = (isset($empresa_propria_data[0]["cnpj"]))? $empresa_propria_data[0]["cnpj"]:"";
        $_SESSION["cli_temp_session"] = (isset($empresa_propria_data[0]["cli_temp_session"]))?$empresa_propria_data[0]["cli_temp_session"] : "5";
        //echo "Entrou";

        //print_r($_SESSION);

    }

}*/

