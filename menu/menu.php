<?php require_once('liam_framework/bd.php'); ?>
<link href="menu/css/menu.css" rel="stylesheet" type="text/css"/>
<link href="menu/css/all.css" rel="stylesheet" type="text/css"/>
<div class="page-wrapper chiller-theme ">
    <!-- Botão que mostra o menu -->
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#" style="padding: 0.05rem 0.5rem !important;">
        <i id="text-button-menu" class="fas fa-bars"></i>
    </a>
    <!-- menu lateral -->
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content" style="padding-bottom:12px;">
            <!-- linha e botão que fecha o menu -->
            <div class="sidebar-brand">
                <a href="index.php">
                  <i class="fa fa-home"></i>
                </a>
                <a href="logout.php">
                  <i class="fa fa-power-off"></i>
                </a>
                <a class="menu123" style="width:230px"></a>
                <div id="close-sidebar">
                    <i style="color:#b8bfce;" class="fas fa-times"></i>
                </div>
            </div>
            <!-- Linha das informaçoes do usuario -->
            <div class="sidebar-header" style="height:120;">
                <!-- imagem do usuario -->
                <div class="user-pic" style="width:100px;">
                    <img class="img-responsive img-rounded" src="<?=$_SESSION["retrato_usuario"] ?>" style="border-radius: 50%;" alt="User picture">
                </div>
                <!-- informaçoes -->
                <div id="user-info" class="user-info">
                    
                    <span class="user-name">
                        <strong>Teste</strong>
                    </span>
                    <span class="user-role"><strong>Empresa: </strong>Trazer</span>
                    <span class="user-role"><strong>Setor: </strong>Trazer</span>
                    <span class="user-role"><strong>Função: </strong>Trazer</span>
                    <span class="user-status">
                        <i class="fa fa-circle"></i>
                        <span>Online</span>
                    </span>
                </div>
            </div>
            <!-- barra de pesquisa -->
            <!--div class="sidebar-search">
                <div>
                    <div class="input-group">
                        <input type="text" class="form-control search-menu" placeholder="Search...">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div-->
            <!-- Menus -->
                <div id="scrollbar-menu" class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Menu's</span>
                        </li>
                            <?php
                               
                               $obj = new db();
                               $p["sql"]="SELECT *                  
                                           FROM   menu 
                                           WHERE  1=1 ";
                           
                           
                               $s = $obj->run($p);
                               $menu = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select
                               foreach ($menu as $key => $valueMenu) {
                                    $icone = "<i class=\"".$valueMenu['icono']."\"></i>";?>
                                        <li class="sidebar-dropdown"  >
                                            <a class="menu123" title="<?= $valueMenu['nome'] ?>" href="<?= $valueMenu['url'] ?>" ><?= $icone ?>
                                                <span><?= $valueMenu["nome"] ?></span>
                                            </a>
                                            <div class="sidebar-submenu">
                                                <ul><?php                                                    
                                                   
                                                    $nomeAnterior = "";
                                                    $p["sql"]="SELECT *                  
                                                                FROM   sub_menu 
                                                                WHERE  1=1 ";
                                                
                                                
                                                    $s = $obj->run($p);
                                                    $submenu = ($s->execute()) ?$s->fetchAll(PDO::FETCH_ASSOC): array();//Select
                                                    foreach ($submenu as $value) {
                                                        if($value['url']!=$nomeAnterior){
                                                            $nomeAnterior= $value['url'];
                                                           ?>
                                                                <!--li>
                                                                    <a class="menu123" href="index.php?p=wKMfh2ck">Campos Subgrupo</a>
                                                                </li-->
                                                                <li>
                                                                    <a class="menu123" href="<?= $value['url']; ?>"><?= $value['nome']; ?>
                                                                    <span class="badge_menu badge_menu-pill badge_menu-success"><?= $budge ?></span></a>
                                                                </li>
                                                            <?
                                                        }
                                                    }?>-
                                                </ul>
                                            </div>
                                        </li><?
                                    }                                
                            ?>
                        <li class="header-menu">
                        <span>Outros</span>
                      </li>


                                <!--
                      <li class="sidebar-dropdown">
                        <a class="menu123" href="#">
                          <i class="fa fa-comment-dots"></i>
                          <span>Chat</span>
                          <span class="badge_menu badge_menu-pill badge_menu-primary">Beta</span>
                        </a>
                        <div class="sidebar-submenu">
                          <ul>teste</ul>
                        </div>
                      </li>  -->



                        <li class="sidebar-dropdown">
                            <a class="menu123" href="#">
                            <i class="fa fa-hand-point-right"></i>
                            <span>Sobre</span>
                            <span class="badge_menu badge_menu-pill badge_menu-primary"></span>
                            </a>
                            <div class="sidebar-submenu">
                            <ul>
                                <div class="about-text">
                                    <span>Delivery | IsoEasy</span>
                                </div>
                                <div class="about-pic">
                                    <img class="img-responsive img-rounded about-img" src=""alt="About picture">
                                </div>
                                <br>
                                <div class="about-copyright">
                                    <span>© Copyright 2022-<?=date("Y")?>Delivery - All Rights Reserved </span>
                                </div>
                            </ul>
                            </div>
                        </li>



                        <li class="sidebar-dropdown">
                            <a class="menu123" href="#">
                            <i class="fas fa-book-reader"></i>
                            <span>Tutoriais</span>
                             <span class="badge_menu badge_menu-pill badge_menu-primary"></span>
                            </a>
                            <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a class="menu123" href="portal/portal_tutorial.php">Como usar - Cadastros
                                    <span class="badge_menu badge_menu-pill badge_menu-success"><?= $budge ?></span></a>
                             </li>
                             <li>
                                    <a class="menu123" href="#">Como usar - Administração
                                 <span class="badge_menu badge_menu-pill badge_menu-success"><?= $budge ?></span></a>
                             </li>
                                <li>
                                 <a class="menu123" href="#">Como usar - Relatórios
                                    <span class="badge_menu badge_menu-pill badge_menu-success"><?= $budge ?></span></a>
                                </li>
                            </ul>
                            </div>
                        </li>








                      <li class="sidebar-dropdown">
                        <a class="menu123" href="#">
                          <i class="fas fa-bible"></i>
                          <span>Biblia</span>
                          <span class="badge_menu badge_menu-pill badge_menu-primary"></span>
                        </a>
                        <div class="sidebar-submenu">
                          <ul>
                            <li>
                                <a class="menu123" href="estudo_biblico/pcp_apontamento.php">Estudo Biblico
                                <span class="badge_menu badge_menu-pill badge_menu-success"><?= $budge ?></span></a>
                            </li>
                            <li>
                                <a class="menu123" href="index.php?p=G0DiSL1FE">Biblia
                                <span class="badge_menu badge_menu-pill badge_menu-success"><?= $budge ?></span></a>
                            </li>
                          </ul>
                        </div>
                      </li>




                    </ul>
            </div>
        </div>
        <!-- Rodape -->
        <div class="sidebar-footer company-div">
            <div class="company-pic">
                <img class="img-responsive img-rounded company-img" src="<?= $_SESSION["company_logo"] ?>"alt="Company picture">
            </div>
        </div>
    </nav>
</div>
<script src="menu/js/menu.js" type="text/javascript"></script>