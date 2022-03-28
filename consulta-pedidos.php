<?php

// Include config file
session_start();
require("config.php");

$id_user = $_SESSION["id"];
$pag=$_GET["pag"];

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dir = "upload/";
    $file = $_FILES["file"];
    $doc = $file["name"];
    $pedido = trim($_POST["pedido"]);

if (move_uploaded_file($file["tmp_name"], "$dir/" . $file["name"])) {

    $link->query("INSERT INTO documento_comprovativo_sala (documentos, diretorio, id_operacao_sala) VALUES ('$doc', '$dir', '$pedido')");
    if($link->error){
        $_SESSION["return"] = "<p style='color: red'>Erro ao enviar o formulario, tente novamente!</p>";
    }else{
        $_SESSION["return"] = "<p style='color: chartreuse'>Formulario enviado com sucesso.</p>";
    }

    }
    // Prepare an insert statement
}
?>
<?php include "header.php" ?>
<body>
    <main class="main-int_LNEC main-consulta-pedidos">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">CONSULTA DE PEDIDOS</h1>
                    <h2 class="h2-int">LISTA DE PEDIDOS DE ALUGUER DE SALA</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content">
                    <div class="left-all_mid-content">
                        <div class="search-result-show_LNEC">
                            <div class="content-result">
                                <?php if (isset($_SESSION["return"])) {
                                    echo $_SESSION["return"];
                                    unset($_SESSION["return"]);
                                } ?>
                                <table class="search-result-table_LNEC">
                                    <tr class="rowhd-item_table">
                                        <th>Nº de pedido</th>
                                        <th>Assunto</th>
                                        <th>Data Pretendida</th>
                                        <th>Estado</th>
                                    </tr>

                                    <?php

                                    $limite = $_GET["pag"] * 10;
                                    $inicio = $limite-10;
                                    $sql = "SELECT idpedido_sala, assunto, CAST(data_pedido AS DATE), estado FROM pedido_sala INNER JOIN estado_pedido_sala ON pedido_sala.estado_idestado = estado_pedido_sala.idestado where user_iduser = $id_user LIMIT 10 OFFSET $inicio";



                                    if ($stmt = mysqli_prepare($link, $sql)) {

                                    // Attempt to execute the prepared statement
                                    if (mysqli_stmt_execute($stmt)) {
                                    // Redirect to login page
                                    mysqli_stmt_store_result($stmt);

                                    // Check if username exists, if yes then verify password
                                    if (mysqli_stmt_num_rows($stmt) >= 1) {
                                    // Bind resultado variables
                                    mysqli_stmt_bind_result($stmt, $n_id,$assunto, $data, $estado);
                                    while (mysqli_stmt_fetch($stmt)){


                                    ?>

                                    <tr class="row-item_table"  onclick="location.href = 'consulta-pedidos.php?id=<?php echo $n_id; ?>&pag=<?php echo $pag; ?>';">
                                        <td class="cell-item_table">
                                            <div class="title-item_table">
                                                <span class="Txttitle-item_table"><?php echo $n_id; ?></span>
                                            </div>
                                        </td>
                                        <td class="cell-item_table middle">
                                            <div class="title-item_table">
                                                <span class="Txttitle-item_table"><?php echo $assunto; ?></span>
                                            </div>
                                        </td>
                                        <td class="cell-item_table  middle">
                                            <div class="title-item_table">
                                                <span class="Txttitle-item_table"><?php echo $data; ?></span>
                                            </div>
                                        </td>
                                        <td class="cell-item_table">
                                            <div class="expand-item_table">
                                                <button action="" class="status-button  <?php if($estado=="Em análise"){echo "status-analise";}elseif ($estado=="Finalizado"){echo "status-encerrado";} ?>">
                                                    <span class="status-name "><?php echo $estado; ?></span>
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

                    <div class="right-all_mid-content" id="teste">
                        <div class="content-right">
                            <?php

                            if(isset($_GET['id'])) {
                                $id=($_GET['id']);
                                $sql = "SELECT idpedido_sala, observacao FROM pedido_sala where idpedido_sala = $id ";



                            if ($stmt = mysqli_prepare($link, $sql)) {

                            // Attempt to execute the prepared statement
                            if (mysqli_stmt_execute($stmt)) {
                            // Redirect to login page
                            mysqli_stmt_store_result($stmt);

                            // Check if username exists, if yes then verify password
                            if (mysqli_stmt_num_rows($stmt) >= 1) {
                                // Bind resultado variables
                                mysqli_stmt_bind_result($stmt, $pedido, $observacaco);
                                mysqli_stmt_fetch($stmt);
                            ?>
                            <div class="blocktxt-pedido">
                                <span class="alert-label">ATRIBUTOS DO PEDIDO</span>
                                <p  class="desc-pedido"><?php echo $observacaco; ?> </p>
                            </div>
                            <form method="post" enctype="multipart/form-data">
                            <div class="input-item_form divider-item-form">
                                <label  class="alert-label">Submeter documentos </label>
                                <div class="item-radio-form">
                                    <input type="file"  name="file" >
                                </div>
                                <input type="text" name="pedido" value="<?php echo $pedido; ?>" hidden>
                            </div>
                                <div class="input-item_form box-button_form">
                                    <button type="submit" value="Submit" class="button-submit_LNEC">SUBMETER</button>
                                </div>
                            </form>
                                <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>

            <?php
            $resultado = $link->query("SELECT * FROM pedido_sala");
            $final =$resultado->num_rows;
            $pagina = ($final/10) % 10;
            if($final<=10){
                $pagina=1;
            }
            $i=1;
            while ($i <= $pagina) {
                echo'<a href="consulta-pedidos.php?pag='.$i.'" style="  padding: 5px;background-color: red;color: white;border-radius: 50%;text-decoration: none;
">'.$i.'</a>&nbsp;&nbsp;';
                $i++;
            }
            ?>
        </section>

        <?php include "sidebar-int.php" ?>
    </main>


</body>
    