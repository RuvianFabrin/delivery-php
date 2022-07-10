<div class="container" id="compartimento">
    <div class="row"><div class="col"><h2 id="tituloPedido">Pedido: 0</h2></div></div>
    <input type="hidden" id="idPedido" value="0" />
    <div class="row">
      <div class="col">
        <input class="easyui-textbox" label="Empresa:" value="Smash Hamburgueria" labelPosition="top" data-options="
        label: 'Icons:',
        labelPosition: 'top',
        prompt: 'Empresa',
        iconWidth: 22,
        icons: [{
            iconCls:'icon-search',
            handler: function(e){
                var v = $(e.data.target).textbox('getValue');
                verEmpresa();
            }
        }]
        " style="width:100%;">
      </div>
      <div class="col">
        <input class="easyui-combobox" name="cbx_cliente" id="cbx_cliente" label="Cliente:" labelPosition="top" data-options="prompt:'Pesquise ...',valueField: 'id',textField: 'text',onSelect:selecionaCliente,iconWidth: 22,
        icons: [{
            iconCls:'icon-search',
            handler: function(e){
                var v = $(e.data.target).textbox('getValue');
                verCliente();
            }
        }]" style="width:100%;" />
        
      </div>
      <div class="col">
        <input class="easyui-combobox" name="cbx_endereco" id="cbx_endereco" label="Entrega:" labelPosition="top" data-options="valueField: 'id',textField: 'text',onSelect:selecionaEntrega" style="width:100%;" />
        
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <input class="easyui-textbox" name="txt_obs" id="txt_obs" label="Observação:" labelPosition="top" data-options="valueField: 'id',textField: 'text',onChange:salvaObs" style="width:100%;" />
      </div>
      <div class="col-1">
        <input class="easyui-numberbox" name="txt_taxa" id="txt_taxa" label="Taxa:" labelPosition="top" data-options="valueField: 'id',textField: 'text',onChange:salvaTaxa,min:0,precision:2,groupSeparator:' ',decimalSeparator:','" style="width:100%;" />
      </div>
      <div class="col-3">
        <input class="easyui-combobox" name="cbx_pagamento" id="cbx_pagamento" label="Pagamento:" labelPosition="top" data-options="valueField: 'id',textField: 'text',onSelect:selecionaPagamento" style="width:100%;" />
        
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <input class="easyui-combobox" name="cbx_itens" id="cbx_itens" label="Item:" labelPosition="top" data-options="valueField: 'id',textField: 'text'" style="width:100%;" />
      </div>
      <div class="col-1">
        <input class="easyui-numberbox" name="txt_qtd" id="txt_qtd" label="Qtd:" labelPosition="top" data-options="valueField: 'id',textField: 'text',min:0,precision:2,groupSeparator:' ',decimalSeparator:','" style="width:100%;" />
      </div>
      <div class="col-2">
        <button type="button" class="btn btn-success" onclick="adicionarItem();" style="font-size: 16px;margin-top: 25px;">Adicionar</button>
      </div>
    </div>


    
    <div class="row">
        <div class="col" style="padding-top: 25px;">
            <table class="easyui-datagrid" title="Lista de Itens" id="itensPedido" style="width:100%;height:250px;"
                data-options="singleSelect:true,collapsible:true,method:'post'">
                <thead>
                    <tr>
                        <th data-options="field:'qtd',width:'10%'">Qtd.</th>
                        <th data-options="field:'nome',width:'60%'">Descrição</th>
                        <th data-options="field:'valor_un',width:'15%',align:'right'">Valor Un.</th>
                        <th data-options="field:'valor_final',width:'15%',align:'right'">Total</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="row">
      <div class="col-2" style="padding-top: 25px;">
          <h3 id="totalPedido">0,00</h3>
      </div>  
      <div class="col-2">
        <input class="easyui-numberbox" name="txt_valor_pago" id="txt_valor_pago" label="Valor Pago:" labelPosition="top" data-options="valueField: 'id',textField: 'text',min:0,precision:2,groupSeparator:' ',decimalSeparator:',',onChange:salvaValorPago" style="width:100%;" />
      </div> 
      <div class="col-2" style="padding-top: 25px;">
          <h3 id="troco">Troco: 0,00</h3>
      </div>      
  </div>
    <div class="row">
        <div class="col-1" style="padding-top: 25px;">
            <button type="button" class="btn btn-success" style="font-size: 16px;">Finalizar</button>
        </div> 
                      
    </div>
    <div class="row">
      <div class="col" style="padding-top: 25px;">
          <table class="easyui-datagrid" title="Lista de Pedidos" id="pedidos" style="width:100%;height:250px;"
              data-options="singleSelect:true,collapsible:true,method:'post'">
              <thead>
                  <tr>
                      <th data-options="field:'numPedido',width:'10%',align:'center'">Pedido</th>
                      <th data-options="field:'cliente',width:'40%'">cliente</th>
                      <th data-options="field:'total',width:'10%',align:'center'">total</th>
                      <th data-options="field:'obs',width:'30%',align:'left'">obs</th>
                      <th data-options="field:'status',width:'10%',align:'center',formatter: impressao">Print</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

  <!-- janela -->

<div id="win_cad_empresa" class="easyui-window" title="Cadastro de Empresa" data-options="modal:true,closed:true" style="width:90%;height:400px;padding:10px;display:none;">
    <div class="container">
        <div class="row">
          <div class="col">
            <input class="easyui-textbox" id="txt_emp_nome" name="txt_emp_nome" label="Nome:"  labelPosition="top" style="width:100%;">
          </div>
          <div class="col">
            <input class="easyui-textbox" id="txt_emp_logradouro" name="txt_emp_logradouro"  label="Logradouro:" labelPosition="top" style="width:100%;">
          </div>
        </div>
        <div class="row">
            <div class="col-2">
              <input class="easyui-textbox" id="txt_emp_numero" name="txt_emp_numero" label="Nº:" labelPosition="top" style="width:100%;">
            </div>
            <div class="col-2">
              <input class="easyui-textbox" id="txt_emp_bairro" name="txt_emp_bairro"  label="Bairro:" labelPosition="top" style="width:100%;">
            </div>
            <div class="col-2">
                <input class="easyui-textbox" id="txt_emp_cidade" name="txt_emp_cidade"  label="cidade:" labelPosition="top" style="width:100%;">
            </div>            
            <div class="col-2">
                <input class="easyui-textbox" id="txt_emp_estado" name="txt_emp_estado"  label="Estado:" labelPosition="top" style="width:100%;">
            </div>
            <div class="col-2">
                <input class="easyui-textbox" id="txt_emp_telefone" name="txt_emp_telefone"  label="Telefone:" labelPosition="top" style="width:100%;">
            </div>
            <div class="col-2">
                <input class="easyui-textbox" id="txt_emp_cnpj" name="txt_emp_cnpj"  label="CNPJ:" labelPosition="top" style="width:100%;">
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <input class="easyui-textbox" id="txt_emp_msg" name="txt_emp_msg"  label="Mensagem Impressão:" labelPosition="top" style="width:100%;">
            </div>
        </div>
    </div>

</div>


<div id="win_cad_cliente" class="easyui-window" title="Cadastro de Cliente" data-options="modal:true,closed:true" style="width:50%;height:550px;padding:10px;display:none;">
    <div class="container">
        <div class="row">
          <div class="col-6">
            <input class="easyui-textbox" id="txt_cli_nome" name="txt_cli_nome" label="Nome:"  labelPosition="top" style="width:100%;">
          </div>
          <div class="col-2">
            <input class="easyui-textbox" id="txt_cli_telefone" name="txt_cli_telefone"  label="Telefone:" labelPosition="top" style="width:100%;">
          </div>
        </div>
       
        <div class="row">
          <div class="col-4">
            <input class="easyui-textbox" id="txt_end_cep" name="txt_end_cep"  label="CEP:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-8">
            <input class="easyui-textbox" id="txt_end_logradouro" name="txt_end_logradouro"  label="Logradouro:" labelPosition="top" style="width:100%;">
          </div>
        </div>
       
        <div class="row">
          
          <div class="col-2">
            <input class="easyui-textbox" id="txt_end_numero" name="txt_end_numero"  label="Número:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-3">
            <input class="easyui-textbox" id="txt_end_bairro" name="txt_end_bairro"  label="Bairro:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-3">
            <input class="easyui-textbox" id="txt_end_cidade" name="txt_end_cidade"  label="Cidade:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-3">
            <input class="easyui-textbox" id="txt_end_estado" name="txt_end_estado"  label="Estado:" labelPosition="top" style="width:100%;">
          </div>
        </div>

        <div class="row">          
          <div class="col-2">
            <button type="button" class="btn btn-success" style="font-size: 16px;margin-top: 25px;" onclick="inserirCliente();">Inserir</button>
          </div>
        </div>

        <div class="row">
          <div class="col" style="padding-top: 25px;">
              <table class="easyui-datagrid" title="Clientes" id="listaClientes" style="width:100%;height:250px;"
                  data-options="singleSelect:true,collapsible:true,method:'post',onSelect:onSelectCliente">
                  <thead>
                      <tr>
                          <th data-options="field:'nome',width:'70%',align:'left'">Nome</th>
                          <th data-options="field:'telefone',width:'20%',align:'center'">Telefone</th>
                          <th data-options="field:'numPedidos',width:'10%',align:'center',align:'center'">Pedidos</th>
                      </tr>
                  </thead>
              </table>
          </div>
      </div>
        <hr>
        <h2>Adicionar Endereço ao Cliente</h2>
        <hr>
      <div class="row">
          <div class="col-4">
            <input class="easyui-textbox" id="txt_end_cep_add" name="txt_end_cep_add"  label="CEP:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-8">
            <input class="easyui-textbox" id="txt_end_logradouro_add" name="txt_end_logradouro_add"  label="Logradouro:" labelPosition="top" style="width:100%;">
          </div>
        </div>
       
        <div class="row">
          
          <div class="col-2">
            <input class="easyui-textbox" id="txt_end_numero_add" name="txt_end_numero_add"  label="Número:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-3">
            <input class="easyui-textbox" id="txt_end_bairro_add" name="txt_end_bairro_add"  label="Bairro:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-3">
            <input class="easyui-textbox" id="txt_end_cidade_add" name="txt_end_cidade_add"  label="Cidade:" labelPosition="top" style="width:100%;">
          </div>
          <div class="col-3">
            <input class="easyui-textbox" id="txt_end_estado_add" name="txt_end_estado_add"  label="Estado:" labelPosition="top" style="width:100%;">
          </div>
        </div>

        <div class="row">          
          <div class="col-2">
            <button id="btnInserirEndereco" type="button" class="btn btn-success" style="font-size: 16px;margin-top: 25px;" onclick="inserirEnderecoAdicional();">Inserir</button>
          </div>
        </div>

        <div class="row">
          <div class="col" style="padding-top: 25px;">
              <table class="easyui-datagrid" title="Endereços" id="listaEnderecos" style="width:100%;height:250px;"
                  data-options="singleSelect:true,collapsible:true,method:'post'">
                  <thead>
                      <tr>
                          <th data-options="field:'cep',width:'10%',align:'left'">CEP</th>
                          <th data-options="field:'logradouro',width:'50%',align:'left'">Logradouro</th>
                          <th data-options="field:'numero',width:'10%',align:'center',align:'center'">Número</th>
                          <th data-options="field:'bairro',width:'10%',align:'center',align:'left'">Bairro</th>
                          <th data-options="field:'cidade',width:'10%',align:'center',align:'left'">Cidade</th>
                          <th data-options="field:'estado',width:'10%',align:'center',align:'left'">Estado</th>
                      </tr>
                  </thead>
              </table>
          </div>
      </div>

    </div>

</div>



<script>
<?php require_once('pedidos/p.js'); ?>
</script>