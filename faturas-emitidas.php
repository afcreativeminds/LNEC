<?php

// Include config file
session_start();
require("config.php");

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

$pag=$_GET["pag"];
$id_user = $_SESSION["id"];
// Atualizar dados
?>
<?php include "header.php" ?>
<body>
    <main class="main-int_LNEC main-faturas-emitidas">
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
                <div class="all_mid-content" style="width: 90%;">
                    <div class="search-result-show_LNEC">
                        <div class="content-result">
                            <table class="search-result-table_LNEC">
                                <tr class="rowhd-item_table" >
                                    <th>Nº</th>
                                    <th>Tipo Pagamento</th>
                                    <th>Serviço</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Fatura</th>
                                </tr>
                                <?php
                                $limite = $_GET["pag"] * 10;
                                $inicio = $limite-10;

                                $sql = "SELECT idfaturas, estado_fatura, CAST(data_created AS DATE), valor FROM estado_fatura INNER JOIN faturas INNER JOIN pre_encomenda ON estado_fatura.idestado_fatura = faturas.estado_fatura_idestado_fatura and faturas.id_encomenda = pre_encomenda.id WHERE pre_encomenda.id_user = '$id_user' LIMIT 10 OFFSET $inicio;";



                                if ($stmt = mysqli_prepare($link, $sql)) {

                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                mysqli_stmt_store_result($stmt);

                                // Check if username exists, if yes then verify password
                                if (mysqli_stmt_num_rows($stmt) >= 1) {
                                // Bind resultado variables
                                mysqli_stmt_bind_result($stmt, $id_f,$estado, $data, $valor);
                                while (mysqli_stmt_fetch($stmt)){


                                ?>
                                <tr class="row-item_table" onclick="window.open('http://localhost/LNEC/fatura.php?id=<?php echo $id_f; ?>')" >
                                    <td class="cell-item_table">
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table"><?php echo $id_f; ?></span>
                                        </div>
                                    </td>
                                    <td class="cell-item_table middle">
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table">Anual</span>
                                        </div>
                                    </td>
                                    <td class="cell-item_table middle">
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table">Serviço...</span>
                                        </div>
                                    </td>
                                    <td class="cell-item_table  middle">
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table"><?php echo $data; ?></span>
                                        </div>
                                    </td>
                                    <td class="cell-item_table  middle">
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table"><?php echo $valor; ?>€</span>
                                        </div>
                                    </td>
                                    <td class="cell-item_table">
                                        <div class="button-item_table">
                                            <button action="" class="status-button status-analise">
                                                <span class="status-name "><?php echo $estado; ?></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="cell-item_table">
                                        <div class="expand-item_table">
                                            <button action="" class="download-button">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                    <?php
                                }
                                }
                                }
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $resultado = $link->query("SELECT * FROM pre_encomenda INNER JOIN users on pre_encomenda.id_user=users.iduser");
            $final =$resultado->num_rows;
            $pagina = ($final/10) % 10;
            if($final<=10){
                $pagina=1;
            }
            $i=1;
            while ($i <= $pagina) {
                echo'<a href="faturas-emitidas.php?pag='.$i.'" style="  padding: 5px;background-color: red;color: white;border-radius: 50%;text-decoration: none;
">'.$i.'</a>&nbsp;&nbsp;';
                $i++;
            }
            ?>
        </section>


        <?php include "sidebar-int.php"; ?>
    </main>


</body>
    