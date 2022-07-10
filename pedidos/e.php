<?php
session_start();
require_once('../liam_framework/bd.php');

$retorno=array("r"=>"deslogado");


if($_REQUEST["op"]=="g"){
    $_SESSION = null;
    $obj = new Pedido();
    $retorno = $obj->{$_REQUEST["action"]}();  
}

echo (json_encode($retorno))?json_encode($retorno):'"message":"Erro:'.json_last_error_msg().'"';








#classe genérica para funcionar o function
class Pedido{

    function clientes(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    c_id id,concat(c_nome,' - ',c_telefone) text                   
                    FROM   cliente 
                    WHERE  c_id_empresa= :idEmpresa AND c_status='Ativo' ";
    
        $p["idEmpresa"]= "1";
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 
    
    function enderecos(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    ce_id id,concat(ce_cep,', ',ce_logradouro,', ',ce_numero,', ',ce_bairro,', ',ce_cidade,', ',ce_estado) text                   
                    FROM   cliente_endereco 
                    WHERE  ce_id_cliente_fk= :idCliente";
    
        $p["idCliente"]= $_REQUEST["idCliente"];
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    }  

    function pedido(){
        //FORMAT(p_total_pedido,2,'de_DE')
        $obj = new db();
        $p["sql"]="SELECT  
                    p_id id
                    ,p_id_cliente cliente
                    ,p_id_entrega entrega
                    ,FORMAT(p_total_pedido,2,'de_DE') total
                    , p_taxa_entrega taxa
                    ,  p_obs_pedido obs                  
                    ,  p_id_pagamento pagamento                  
                    FROM   pedido 
                    WHERE  p_status='Aberto' order by p_id desc";   
        
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 

    function listaItens(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    pi_id id,
                    concat(if(pi_tipo='Produto','',concat('&emsp;',pi_tipo_sigla)),' ',pi_descricao) nome,
                    FORMAT(pi_quantidade,2,'de_DE') qtd,
                    FORMAT(pi_valor_unitario,2,'de_DE') valor_un,
                    FORMAT(pi_valor_final,2,'de_DE') valor_final                   
                    FROM   pedido_itens 
                    WHERE  pi_id_pedido_fk= :idPedido order by pi_vinculo_adicional desc";   
        
        $p["idPedido"]= $_REQUEST["id"];
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 

    function itensCombobox(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    pr_id id,  pr_descricao text                   
                    FROM   podutos 
                    WHERE  pr_tipo='Produto' or pr_tipo='Adicional'";   
        
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 

    function tiposPagamento(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    fp_id id,  fp_descricao text                   
                    FROM   forma_de_pagamento 
                    WHERE  fp_descricao is not null order by fp_descricao desc";   
        
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 

    function pedidos(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    p_num_pedido numPedido
                    ,(select concat(c_nome,' - ',c_telefone) as nome from cliente where c_id=p_id_cliente) cliente                   
                    ,FORMAT(p_total_pedido,2,'de_DE') total                   
                    ,p_obs_pedido obs                   
                    ,p_status status 
                    ,p_id id                  
                    FROM   pedido 
                    WHERE  p_id_cliente is not null order by p_num_pedido desc";   
        
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 


    function listaClientes(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    c_nome nome
                    ,c_telefone telefone                   
                    ,c_id id                   
                    ,c_num_pedidos_feitos numPedidos                   
                    FROM   cliente 
                    WHERE  c_id_empresa= :idEmpresa AND c_status='Ativo' ";
    
        $p["idEmpresa"]= "1";
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 

    function inserirCliente(){
        $row = $this->insertCliente();
        return $this->insertEndereco($row["id"]);
    }
    function insertCliente(){
        $obj = new db();
        $p[1]="1";
        $p[2]=$_REQUEST["nome"];
        $p[3]=$_REQUEST["telefone"];
        $p[4]="Ativo";
        $p[5]=date("Y-m-d");

        $p["sql"]="INSERT INTO cliente 
        (c_id_empresa,c_nome,c_telefone,c_status,c_data_cadastro) 
        VALUES 
        ( ? , ? , ? , ? , ? )"; 
        $statement = $obj->insert($p);
        //var_dump($p);
        return ($statement->execute()) ? array('r' => "ok", "id"=>$obj->ultimoID()): array('r' => "erro", );//Update ou delete
    }

    function insertEndereco($idCliente){
        $obj = new db();
        $p[1]=$idCliente;
        $p[2]=$_REQUEST["logradouro"];
        $p[3]=$_REQUEST["numero"];
        $p[4]=$_REQUEST["bairro"];
        $p[5]=$_REQUEST["cidade"];
        $p[6]=$_REQUEST["estado"];
        $p[7]=$_REQUEST["cep"];

        $p["sql"]="INSERT INTO cliente_endereco 
        (ce_id_cliente_fk,ce_logradouro ,ce_numero ,ce_bairro ,ce_cidade ,ce_estado, ce_cep) 
        VALUES 
        ( ? , ? , ? , ? , ? , ? , ? )"; 
        $statement = $obj->insert($p);
        //var_dump($p);
        return ($statement->execute()) ? array('r' => "ok", "id"=>$obj->ultimoID()): array('r' => "erro", );//Update ou delete
    }

    function listaEnderecos(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    ce_cep cep
                    ,ce_logradouro logradouro                   
                    ,ce_numero numero                   
                    ,ce_bairro bairro                   
                    ,ce_cidade cidade                   
                    ,ce_estado estado                   
                    FROM   cliente_endereco 
                    WHERE  ce_id_cliente_fk= :idCliente ";
    
        $p["idCliente"]= $_REQUEST["idCliente"];
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 
    
    function inserirEnderecoAdicional(){
        
        return $this->insertEndereco($_REQUEST["idCliente"]);
    }

    public function salvarClienteNoPedido(){
        
        $obj = new db();
        $sql="update pedido set 
        p_id_cliente= :idCliente        
        where 
        p_id= :id"; 
        $statement = $obj->sq($sql);
        $statement->bindValue(":idCliente",$_REQUEST["idCliente"]);
        $statement->bindValue(":id",$_REQUEST["id"]);
        
        return ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
        
    }
    public function salvarEntregaNoPedido(){
        
        $obj = new db();
        $sql="update pedido set 
        p_id_entrega= :idEntrega        
        where 
        p_id= :id"; 
        $statement = $obj->sq($sql);
        $statement->bindValue(":idEntrega",$_REQUEST["idEntrega"]);
        $statement->bindValue(":id",$_REQUEST["id"]);
        
        return ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
        
    }

    public function salvarObsPedido(){
        
        $obj = new db();
        $sql="update pedido set 
        p_obs_pedido= :obs        
        where 
        p_id= :id"; 
        $statement = $obj->sq($sql);
        $statement->bindValue(":obs",$_REQUEST["obs"]);
        $statement->bindValue(":id",$_REQUEST["id"]);
        
        return ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
        
    }

    public function salvarTaxaPedido(){
        
        $obj = new db();
        $sql="update pedido set 
        p_taxa_entrega= :taxa        
        where 
        p_id= :id"; 
        $statement = $obj->sq($sql);
        $statement->bindValue(":taxa",$_REQUEST["taxa"]);
        $statement->bindValue(":id",$_REQUEST["id"]);
        
        return ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
        
    }

    public function selecionaPagamento(){
        
        $obj = new db();
        $sql="update pedido set 
        p_id_pagamento= :idPagamento        
        where 
        p_id= :id"; 
        $statement = $obj->sq($sql);
        $statement->bindValue(":idPagamento",$_REQUEST["idPagamento"]);
        $statement->bindValue(":id",$_REQUEST["id"]);
        
        return ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
        
    }

    function inserirItem(){
        //Selecionar dados do Produto
        $row = $this->selecionaProdutos($_REQUEST["item"]);
        $obj = new db();
        $p[1]=$_REQUEST["id"];
        $p[2]="1";
        $p[3]=$_REQUEST["item"];
        $p[4]=$row[0]["pr_descricao"];
        $p[5]=$_REQUEST["qtd"];
        $p[6]=$row[0]["pr_valor"];
        $p[7]=($_REQUEST["qtd"]*$row[0]["pr_valor"]);
        $p[8]=date("Y-m-d h:i:s");
        $p[9]="Produto";

        $p["sql"]="INSERT INTO pedido_itens 
        (pi_id_pedido_fk,pi_id_empresa ,pi_id_produto ,pi_descricao ,pi_quantidade ,pi_valor_unitario, pi_valor_final,pi_data,pi_tipo) 
        VALUES 
        ( ? , ? , ? , ? , ? , ? , ? , ? , ? )"; 
        $statement = $obj->insert($p);
        //var_dump($p);
        return ($statement->execute()) ? array('r' => "ok", "id"=>$obj->ultimoID()): array('r' => "erro", );//Update ou delete
    }

    function selecionaProdutos($idProduto){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    pr_id
                    ,pr_descricao                   
                    ,pr_valor                 
                    FROM   podutos 
                    WHERE  pr_id= :idProduto ";
    
        $p["idProduto"] = $idProduto;
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    
        return $retorno;
    } 

    function atualizaTotal(){
        
        $obj = new db();
        $p["sql"]="SELECT  
                    sum(pi_valor_final) total                 
                    FROM   pedido_itens 
                    WHERE  pi_id_pedido_fk= :id ";
    
        $p["id"] = $_REQUEST["id"];
    
        $s = $obj->run($p);
        $retorno = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

        $objD = new db();
        $pD["sql"]="SELECT  
                    p_taxa_entrega total                 
                    FROM   pedido 
                    WHERE  p_id= :id ";
    
        $pD["id"] = $_REQUEST["id"];
    
        $s = $objD->run($pD);
        $retornoD = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select
        $total["total"] = $retorno[0]["total"] + $retornoD[0]["total"];
        $this->salvarTotalNoPedido($total["total"]);
        $total["total"]=number_format($total["total"], 2, ',', ' ');
        return $total;
    } 

    public function salvarTotalNoPedido($total){
        
        $obj = new db();
        $sql="update pedido set 
        p_total_pedido= :total        
        where 
        p_id= :id"; 
        $statement = $obj->sq($sql);
        $statement->bindValue(":total",$total);
        $statement->bindValue(":id",$_REQUEST["id"]);
        
        return ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
        
    }
}