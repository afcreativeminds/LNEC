<?php

// Include config file
session_start();
require("config.php");

$id = $_SESSION["id"];

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}


?><?php include "header.php" ?>
<body>
    <main class="main-int_LNEC main-notificacoes">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">FATURAS EMITIDIAS</h1>
                    <h2 class="h2-int">LISTA DE FATURAS EMITIDAS</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content">
                    <div class="search-result-show_LNEC">
                        <div class="content-result">
                            <table class="search-result-table_LNEC">
                                <tr class="rowhd-item_table">
                                    <th>AVISOS POR LER</th>
                                </tr>
                                <?php

                                $sql = "SELECT id, titulo, CAST(data AS DATE) FROM notificacao_geral where iduser = $id and leitura = '0'";



                                if ($stmt = mysqli_prepare($link, $sql)) {

                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                mysqli_stmt_store_result($stmt);

                                // Check if username exists, if yes then verify password
                                if (mysqli_stmt_num_rows($stmt) >= 1) {
                                // Bind resultado variables
                                mysqli_stmt_bind_result($stmt, $id_not, $titulo, $data_n);
                                while (mysqli_stmt_fetch($stmt)){


                                ?>
                                <tr class="row-item_table">
                                    <td class="cell-item_table  cell-2">
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table"><?php echo $data_n; ?></span>
                                        </div>
                                    </td>
                                    <td class="cell-item_table  cell-2" style="padding-left: 0px;">
                                        <div class="title-item_table">
                                            <a href="notificacoes_view.php?not=<?php echo $id_not; ?>"><span class="Txttitle-item_table"><?php echo $titulo; ?></span></a>
                                        </div>
                                    </td>
                                    <td class="cell-item_table cell-1">
                                        <div class="expand-item_table">
                                            <button action="" class="close-button">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                    <?php
                                }
                                }else{
                                    ?>
                                <tr class="row-item_table">
                                    <td class="cell-item_table cell-3">
                                        <p> Nenhuma notificão lida...</p>
                                    </td>
                                </tr>
                                <?php
                                }
                                }
                                }
                                ?>
                            </table>
                        </div>
                        <div class="content-result">
                            <table class="search-result-table_LNEC">
                                <tr class="rowhd-item_table list_check">
                                    <th>AVISOS LIDOS</th>
                                </tr>
                                <?php

                                $sql = "SELECT id, titulo, CAST(data AS DATE) FROM notificacao_geral where iduser = $id and leitura = '1'";



                                if ($stmt = mysqli_prepare($link, $sql)) {

                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                mysqli_stmt_store_result($stmt);

                                // Check if username exists, if yes then verify password
                                if (mysqli_stmt_num_rows($stmt) >= 1) {
                                // Bind resultado variables
                                mysqli_stmt_bind_result($stmt, $id_not, $titulo, $data_n);
                                while (mysqli_stmt_fetch($stmt)){


                                ?>
                                    <tr class="row-item_table">
                                        <td class="cell-item_table  cell-2">
                                            <div class="title-item_table">
                                                <span class="Txttitle-item_table"><?php echo $data_n; ?></span>
                                            </div>
                                        </td>
                                        <td class="cell-item_table  cell-2" style="padding-left: 0px;">
                                            <div class="title-item_table">
                                               <a href="notificacoes_view.php?not=<?php echo $id_not; ?>"><span class="Txttitle-item_table"><?php echo $titulo; ?></span></a>
                                            </div>
                                        </td>
                                        <td class="cell-item_table cell-3">
                                            <div class="expand-item_table">
                                                <a href="delete_notificacao.php?id=<?php echo $id_not; ?>"  onclick="return confirm('Gostaria de eliminar essa notificação?')"><i class="fas fa-times-circle"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                }else{
                                    ?>
                                    <tr class="row-item_table">
                                        <td class="cell-item_table cell-3">
                                            <p> Nenhuma notificão por ler...</p>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom-content">
                
            </div>
        </section>

        <?php include "sidebar-int.php" ?>
    </main>

</body>
    