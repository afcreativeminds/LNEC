<?php

// Include config file
session_start();
require("config.php");

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

$id = $_SESSION["id"];
// Atualizar dados
?><?php include "header.php" ?>
<body>
    <main class="main-int_LNEC main-aquisicao-publicacoes">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">PEDIDO DE SERVIÇOS</h1>
                    <h2 class="h2-int">AQUISIÇÃO DE PUBLICACÕES</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content">
                    <div class="box-content">
                        <a href="http://www.lnec.pt/pt/servicos/livraria/" class="link-libary"><img src="assets/image/logo-icon.png"  class="icon-link" /><span class="text-black pre-link">LIVRARIA ON-LINE LNEC - </span> O SITE DE MOMENTO SÓ SUPORTA OS BROWSERS: Firefox, Mozilla, Netscape. Internet Explorer e Opera</a>
                    </div>
                </div>
            </div>

            <div class="bottom-content">
            </div>
        </section>

        <?php include "sidebar-int.php" ?>
    </main>


</body>
    