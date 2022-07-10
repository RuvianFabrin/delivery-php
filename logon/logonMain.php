<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/anim.css">
<link rel="stylesheet" type="text/css" href="../css/theme.css">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
<link href="../js/jquery-easyui-1.8.1/themes/material-teal/easyui.css" rel="stylesheet" type="text/css"/>
<link href="../js/jquery-easyui-1.8.1/themes/icon.css" rel="stylesheet" type="text/css"/>
<link href="../js/jquery-easyui-1.8.1/themes/color.css" rel="stylesheet" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<div class="easyui-layout">
    <div class="col-sm-4">        
        <div class="form-group">
            <form id="frm_logon" name="flogon" method="post" enctype="multipart/form-data" novalidate>
                <div role="form" class="form-horizontal aparecer-lento">
                    <div class="form-border ">
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" placeholder="Login" required name="login" id="login" style="width:100%;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-11">
                                <input type="password" class="form-control" placeholder="Senha" required name="senha" id="senha" style="width:100%;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input class="btn btn-default" type="button" id="btn_logon" value="Entrar" style="background-color:#222;color:white;width:100%; margin-top:10px;"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
<div class="easyui-window" id="window_unidade" title="Escolha a Unidade para Logar" style="width:40%;height:20%;" data-options="modal:true,closed:true,maximizable:false,minimizable:false,collapsible:false,resizable:false,border:false">	
    <div class="data-region" data-options="region:'center'" style="width:100%; height:100%;">
        <form class="a-form" id="frm_ciclos_acao" method="post" enctype="multipart/form-data" novalidate>
            <div role="form" class="form-horizontal" style="width:100%;">
                <div class="col-sm-9">
                   <input class="easyui-combobox" name="cbx_unidade" id="cbx_unidade" style="width:100%;" data-options="	label:'Unidade:',labelPosition:'top',valueField: 'id',textField: 'text'">
                </div>
                <div class="col-sm-3">
                    <a id="btn_continuar" class="btn btn-success" style="width:100%; margin-top:30px;" onclick="btn_logarComUnidade()">Continuar</a>
                </div>
               
            </div>           
        </form>
    </div>   
			
</div>

<script src="../js/jquery-1.11.1.js?v0.1" type="text/javascript"></script>
<?php require_once('../js/funcoes.php'); ?>
<script src="../js/jquery-easyui-1.8.1/jquery.min.js" type="text/javascript"></script>
<script src="../js/jquery-easyui-1.8.1/jquery.easyui.min.js" type="text/javascript"></script>
<script src="../js/jquery-easyui-1.8.1/datagrid-filter.js" type="text/javascript"></script>
<script src="../js/jquery-easyui-1.8.1/jquery.edatagrid.js" type="text/javascript"></script>
<script src="../js/jquery-easyui-1.8.1/datagridview/datagrid-detailview.js" type="text/javascript"></script>
<script src="../js/jquery-easyui-1.8.1/locale/easyui-lang-pt_BR.js" type="text/javascript"></script>
<script src="../js/noty-2.3.4-mensagem/js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
<?php require_once '../logon/js/logonMain.javascript.php';?>