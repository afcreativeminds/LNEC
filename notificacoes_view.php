<?php

// Include config file
session_start();
require("config.php");

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

$id = $_SESSION["id"];
$not = $_GET["not"];
if($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "UPDATE notificacao_geral SET leitura = ? WHERE id = $not";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_1);

        // Set parameters
        $param_1 = '1';
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to login page
            //Notificação lida
        } else {
            printf("Error: %s.\n", mysqli_stmt_error($stmt));
            echo "4";
        }
    } else {
        printf("Error: %s.\n", mysqli_stmt_error($stmt));
    }
}
// Atualizar dados
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
                    <h1 class="h1-int">NOTIFICAÇÕES</h1>
                    <h2 class="h2-int">LISTA DE NOTIFICAÇÕES</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content">
                    <div class="search-result-show_LNEC">
                        <div class="content-result">
                            <table class="search-result-table_LNEC">

                                <?php

                                $sql = "SELECT titulo, descricao, descricao_2 FROM notificacao_geral where id =  $not";



                                if ($stmt = mysqli_prepare($link, $sql)) {

                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                mysqli_stmt_store_result($stmt);

                                // Check if username exists, if yes then verify password
                                if (mysqli_stmt_num_rows($stmt) >= 1) {
                                // Bind resultado variables
                                mysqli_stmt_bind_result($stmt, $titulo, $desc, $desc2);
                                mysqli_stmt_fetch($stmt);

                                        }
                                     }
                                }
                                ?>
                                <tr class="rowhd-item_table">
                                        <th><?php echo $titulo; ?></th>
                                </tr>

                            </table>
                            <p><?php echo $desc; ?></p>
                            <p><?php echo $desc2; ?></p>
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
    