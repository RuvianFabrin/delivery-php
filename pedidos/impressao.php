<?php

session_start();
require_once('../liam_framework/bd.php');


$obj = new db();
$p["sql"]="SELECT *
    , DATE_FORMAT(p_data, '%d/%m/%Y') dataPedido  
    , (select c_nome from cliente  where c_id=p_id_cliente) as nome
    , (select concat(ce_logradouro,', ',ce_numero) from cliente_endereco  where ce_id=p_id_entrega) as rua
    , (select ce_bairro from cliente_endereco  where ce_id=p_id_entrega) as bairro
    , (select ce_cep from cliente_endereco  where ce_id=p_id_entrega) as cep
    FROM pedido 
    WHERE  p_id= :id ";
$p["id"]= $_REQUEST["p"];

$s = $obj->run($p);
$rowPedido = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();


$obj = new db();
$j["sql"]="SELECT  
            pi_id id,
            concat(if(pi_tipo='Produto','',concat('&emsp;',pi_tipo_sigla)),' ',pi_descricao) nome,
            FORMAT(pi_quantidade,0,'de_DE') qtd,
            FORMAT(pi_valor_unitario,2,'de_DE') valor_un,
            FORMAT(pi_valor_final,2,'de_DE') valor_final                   
            FROM   pedido_itens 
            WHERE  pi_id_pedido_fk= :idPedido order by pi_vinculo_adicional desc";   

$j["idPedido"]= $_REQUEST["p"];
$s = $obj->run($j);
$itens = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();

?>
<style>
    .titulo{
        font-size: 20px; 
        font-weight: bold;
        text-align:center;
    }
    .corpo{
        font-size: 14px; 
        font-weight: bold;
        text-align:center;
    }
    .corpoL{
        font-size: 14px; 
        font-weight: bold;
        text-align:left;
    }
    .corpoR{
        font-size: 14px; 
        font-weight: bold;
        text-align:right;
    }
</style>
<body style="font-family: Segoe UI ;">
    <table style="width: 80mm;">
        <tr>
            <td class="titulo">Smash Hamburgueria</td>
        </tr>
        <tr>
            <td class="corpo" >Rua Irineu Gonçalves Padilha Filho, 32</td>
        </tr>
        <tr>
            <td class="corpo" >Cidade Industrial - Curitiba/PR</td>
        </tr>
        <tr>
            <td class="corpo" >(41) 98799-8422</td>
        </tr>
        <tr>
            <td class="corpo" >CNPJ: 00.563.829/0001-00</td>
        </tr>
        <tr>
            <td class="corpo" ><hr style="border-top: 4px solid black;"></td>
        </tr>
        <tr>
            <td class="corpo" >CUPON NÃO FISCAL</td>
        </tr>
        <tr>
            <td class="corpo" ><hr style="border-top: 4px solid black"></td>
        </tr>
        <tr>
            <td class="corpoL">Pedido: <?= $rowPedido[0]["p_num_pedido"]?></td>
        </tr>
        <tr>
            <td class="corpoL">Data: <?= $rowPedido[0]["dataPedido"]?></td>
        </tr>
        <tr>
            <td class="corpoL">Cliente: <?= $rowPedido[0]["nome"]?></td>
        </tr>
        <tr>
            <td class="corpoL">Rua: <?= $rowPedido[0]["rua"]?></td>
        </tr>
        <tr>
            <td class="corpoL">Bairro: <?= $rowPedido[0]["bairro"]?></td>
        </tr>
        <tr>
            <td class="corpoL">CEP: <?= $rowPedido[0]["cep"]?></td>
        </tr>        
        <tr>
            <td class="corpo" ><hr style="border-top: 4px solid black"></td>
        </tr>
        <tr>
            <td>
                <table style="width: 80mm;">
                    <tr>
                        <td class="corpoL" style="width: 40mm;">Descrição</td>
                        <td class="corpo" style="width: 20mm;">Unit(R$)</td>
                        <td class="corpo" style="width: 20mm;">Total(R$)</td>
                    </tr>
            <?php 
            $total=0;
            foreach ($itens as $key => $value) {
                $total+=str_replace(",", ".", $value["valor_final"]);
            ?>
                    <tr>
                        <td class="corpo" ><hr style="border-top: 3px solid black"></td>
                        <td class="corpo" ><hr style="border-top: 3px solid black"></td>
                        <td class="corpo" ><hr style="border-top: 3px solid black"></td>
                    </tr>
                    <tr>
                        <td class="corpoL" style="width: 40mm;"><?=$value["qtd"]?> <?=$value["nome"]?></td>
                        <td class="corpo" style="width: 20mm;"><?=$value["valor_un"]?></td>
                        <td class="corpo" style="width: 20mm;"><?=$value["valor_final"]?></td>
                    </tr>
                <?php }?>                    
                </table>
            </td>
        </tr>
        <tr>
            <td class="corpo" ><hr style="border-top: 4px solid black"></td>
        </tr>
        <tr>
            <td>
                <table style="width: 80mm;">            
                    <tr>
                        <td class="corpoL" style="width: 40mm;"></td>
                        <td class="corpoR" style="width: 20mm;">SubTotal(R$)</td>
                        <td class="corpoR" style="width: 20mm;"><?=number_format($total, 2, ',', ' ')?></td>
                    </tr>
                    <tr>
                        <td class="corpoL" style="width: 40mm;"></td>
                        <td class="corpoR" style="width: 20mm;">Taxa(R$)</td>
                        <td class="corpoR" style="width: 20mm;"><?=number_format($rowPedido[0]["p_taxa_entrega"], 2, ',', ' ')?></td>
                    </tr>
                    <tr>
                        <td class="corpoL" style="width: 40mm;"></td>
                        <td class="corpoR" style="width: 20mm;">Total(R$)</td>
                        <td class="corpoR" style="width: 20mm;"><?=number_format($total+$rowPedido[0]["p_taxa_entrega"], 2, ',', ' ')?></td>
                    </tr>
                    <tr>
                        <td class="corpoL" style="width: 40mm;">Pagamento</td>
                        <td class="corpoR" style="width: 20mm;">Dinheiro</td>
                        <td class="corpoR" style="width: 20mm;"><?=number_format($rowPedido[0]["p_valor_pago"], 2, ',', ' ')?></td>
                    </tr>
                    <tr>
                        <td class="corpoL" style="width: 40mm;"></td>
                        <td class="corpoR" style="width: 20mm;">Troco</td>
                        <td class="corpoR" style="width: 20mm;"><?=number_format($rowPedido[0]["p_troco"], 2, ',', ' ')?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="corpo" ><hr style="border-top: 4px solid black"></td>
        </tr>
        <tr>
            <td class="corpo">Obrigado, sempre que bater a fome, </td>
        </tr>
        <tr>
            <td class="corpo">conte conosco, bom apetite !!! </td>
        </tr>
    </table>
</body>