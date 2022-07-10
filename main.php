
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.01 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/anim.css">
    <link rel="stylesheet" type="text/css" href="css/theme.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="js/jquery-easyui-1.8.1/themes/material-teal/easyui.css" rel="stylesheet" type="text/css"/>
    <link href="js/jquery-easyui-1.8.1/themes/icon.css" rel="stylesheet" type="text/css"/>
    <link href="js/jquery-easyui-1.8.1/themes/color.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    
    <title>Delivery</title>
</head>

<script src="js/jquery-1.11.1.js?v0.1" type="text/javascript"></script>
<script src="js/jquery-easyui-1.8.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery-easyui-1.8.1/jquery.easyui.min.js" type="text/javascript"></script>
<script src="js/jquery-easyui-1.8.1/datagrid-filter.js" type="text/javascript"></script>
<script src="js/jquery-easyui-1.8.1/jquery.edatagrid.js" type="text/javascript"></script>
<script src="js/jquery-easyui-1.8.1/datagridview/datagrid-detailview.js" type="text/javascript"></script>
<script src="js/jquery-easyui-1.8.1/locale/easyui-lang-pt_BR.js" type="text/javascript"></script>
<script src="js/noty-2.3.4-mensagem/js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
<script src="js/funcoes.js?v0.1" type="text/javascript"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

<body id="bodyprincipaldelsistema" style="padding: 0px 0px 0px 0px;font-family: Segoe UI !important;font-size:16px !important;">
    
    <?
    require_once('liam_framework/bd.php');
    //require_once('menu/menu.php');
    $p=(isset($_REQUEST["p"]))?$_REQUEST["p"]:"";
    $obj = new db();
    $pa["sql"]="SELECT  
                caminho,idsub_menu                   
                FROM   sub_menu 
                WHERE  referencia= :referencia  ";

    $pa["referencia"]= trim($p);

    $s = $obj->run($pa);
    $menu = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select

    $entra = false;
    if (isset($menu[0])) {
        $entra =  true;
    }
    //print_r($menu);

    if ($p != "") { ?>
        <!-- Conteudo principal -->
        <div id="main-conteudo">
            <?php require_once($menu[0]["caminho"]); ?>
            
        </div>        
    <?php
    } else {
        //redirecionar para o main
        //echo "Bem vindo ao Delivery";
        require_once("pedidos/pedidos.php");
        
    } ?>
    
</body>

</html>

