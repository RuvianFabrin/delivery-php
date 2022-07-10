var caminhoe = "pedidos/e.php";
$(document).ready(function() {        
    $("#cbx_cliente").combobox('reload',caminhoe+"?op=g&action=clientes");
    $("#cbx_itens").combobox('reload',caminhoe+"?op=g&action=itensCombobox");
    $("#cbx_pagamento").combobox('reload',caminhoe+"?op=g&action=tiposPagamento");
    proximoPedido();
    pedidos();
    
    
});
    
function verEmpresa(){
    $("#win_cad_empresa").window("open");
}

function selecionaCliente(rec) {
    
    $("#cbx_endereco").combobox('reload',caminhoe+"?op=g&action=enderecos&idCliente="+rec.id);
    salvarClienteNoPedido(rec.id);
}
function selecionaEntrega(rec) {    
    
    salvarEntregaNoPedido(rec.id);
}
function salvaObs(newV, oldV) {
    salvarObsPedido(newV);
}

function salvaTaxa(newV, oldV) {
    
    salvarTaxaPedido(newV);
}

function proximoPedido() {
    $.post(caminhoe, {op: 'g',action:'pedido'}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        $("#tituloPedido").html("Pedido: "+data[0].id);
        $("#idPedido").val(data[0].id);
        $("#cbx_cliente").combobox("setValue",data[0].cliente);
        $("#cbx_endereco").combobox("setValue",data[0].entrega);
        $("#txt_obs").textbox("setValue",data[0].obs);
        $("#txt_taxa").numberbox("setValue",data[0].taxa);
        $("#totalPedido").html("R$"+data[0].total);
        $("#cbx_pagamento").combobox("setValue",data[0].pagamento);
        
        $("#itensPedido").datagrid({
            url:caminhoe,
            queryParams: {
                op:"g",
                action:"listaItens",
                id: data[0].id
            }
        }, "reload");
    });
}

function pedidos(){
    $("#pedidos").datagrid({
        url:caminhoe,
        queryParams: {
            op:"g",
            action:"pedidos"
        }
    }, "reload");
}

function verCliente(){
    $("#win_cad_cliente").window("open");
    listaClientes();
    $("#btnInserirEndereco").attr("disabled",true);
}

function listaClientes(){
    $("#listaClientes").datagrid({
        url:caminhoe,
        queryParams: {
            op:"g",
            action:"listaClientes"
        }
    }, "reload");
}

function inserirCliente(){
    $.post(caminhoe, {
            op: 'g',
            action:'inserirCliente',
            nome: $("#txt_cli_nome").textbox("getValue"),
            telefone: $("#txt_cli_telefone").textbox("getValue"),
            cep: $("#txt_end_cep").textbox("getValue"),
            logradouro: $("#txt_end_logradouro").textbox("getValue"),
            numero: $("#txt_end_numero").textbox("getValue"),
            bairro: $("#txt_end_bairro").textbox("getValue"),
            cidade: $("#txt_end_cidade").textbox("getValue"),
            estado: $("#txt_end_estado").textbox("getValue")
        }, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        $("#cbx_cliente").combobox('reload',caminhoe+"?op=g&action=clientes");

        $("#txt_cli_nome").textbox("clear");
        $("#txt_cli_telefone").textbox("clear");
        $("#txt_end_cep").textbox("clear");
        $("#txt_end_logradouro").textbox("clear");
        $("#txt_end_numero").textbox("clear");
        $("#txt_end_bairro").textbox("clear");
        $("#txt_end_cidade").textbox("clear");
        $("#txt_end_estado").textbox("clear");
        $("#cbx_endereco").combobox("clear");

        $("#listaClientes").datagrid({
            url:caminhoe,
            queryParams: {
                op:"g",
                action:"listaClientes"
            }
        }, "reload");
    });
}

function onSelectCliente(index,row) {
    $("#btnInserirEndereco").attr("disabled",false);
    var row = $("#listaClientes").datagrid("getSelected");
    $("#listaEnderecos").datagrid({
        url:caminhoe,
        queryParams: {
            op:"g",
            action:"listaEnderecos",
            idCliente:row.id
        }
    }, "reload");
}


function inserirEnderecoAdicional(){
    var row = $("#listaClientes").datagrid("getSelected");
    $.post(caminhoe, {
            op: 'g',
            action:'inserirEnderecoAdicional',
            idCliente:row.id,
            cep: $("#txt_end_cep_add").textbox("getValue"),
            logradouro: $("#txt_end_logradouro_add").textbox("getValue"),
            numero: $("#txt_end_numero_add").textbox("getValue"),
            bairro: $("#txt_end_bairro_add").textbox("getValue"),
            cidade: $("#txt_end_cidade_add").textbox("getValue"),
            estado: $("#txt_end_estado_add").textbox("getValue")
        }, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);

        $("#txt_end_cep_add").textbox("clear");
        $("#txt_end_logradouro_add").textbox("clear");
        $("#txt_end_numero_add").textbox("clear");
        $("#txt_end_bairro_add").textbox("clear");
        $("#txt_end_cidade_add").textbox("clear");
        $("#txt_end_estado_add").textbox("clear");
        $("#cbx_endereco_add").combobox("clear");

        var row = $("#listaClientes").datagrid("getSelected");
        $("#listaEnderecos").datagrid({
            url:caminhoe,
            queryParams: {
                op:"g",
                action:"listaEnderecos",
                idCliente:row.id
            }
        }, "reload");
    });
}

function salvarClienteNoPedido(idCliente) {
    $.post(caminhoe, {op: 'g',action:'salvarClienteNoPedido',idCliente:idCliente,id:$("#idPedido").val()}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        msgNoty("Cliente Salvo!", "success", "", 8000);
    });
}

function salvarEntregaNoPedido(idEntrega) {
    $.post(caminhoe, {op: 'g',action:'salvarEntregaNoPedido',idEntrega:idEntrega,id:$("#idPedido").val()}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        msgNoty("Entrega Salvo!", "success", "", 8000);
    });
}
function salvarObsPedido(obs) {
    $.post(caminhoe, {op: 'g',action:'salvarObsPedido',obs:obs,id:$("#idPedido").val()}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        msgNoty("Obs Salvo!", "success", "", 8000);
    });
}

function salvarTaxaPedido(taxa) {
    $.post(caminhoe, {op: 'g',action:'salvarTaxaPedido',taxa:taxa,id:$("#idPedido").val()}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        msgNoty("Taxa Salvo!", "success", "", 8000);
        atualizaTotal();
    });
}

function selecionaPagamento(rec) {
    $.post(caminhoe, {op: 'g',action:'selecionaPagamento',idPagamento:rec.id,id:$("#idPedido").val()}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        msgNoty("Pagamento Salvo!", "success", "", 8000);
    });
}

function adicionarItem() {
    $.post(caminhoe, {
        op: 'g',
        action:'inserirItem',
        id:$("#idPedido").val(),
        item: $("#cbx_itens").combobox("getValue"),
        qtd: $("#txt_qtd").numberbox("getValue")
    }, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);

        $("#cbx_itens").combobox("clear");
        $("#txt_qtd").numberbox("clear");
        atualizaTotal();

        $("#itensPedido").datagrid({
            url:caminhoe,
            queryParams: {
                op:"g",
                action:"listaItens",
                id: $("#idPedido").val()
            }
        }, "reload");
    });
}

function atualizaTotal() {
    $.post(caminhoe, {op: 'g',action:'atualizaTotal',id:$("#idPedido").val()}, function(dados, textStatus, xhr) {
        var data = JSON.parse(dados);
        $("#totalPedido").html("Total: R$"+data.total);
        pedidos();
    });
}

function impressao(value, row, index){
    var imp = '<a class="btn-datagrid" id_datagrid="#pedidos" href="pedidos/impressao.php?p='+row.id+'" target="_blank">Imprimir</a>';
    return imp;
}