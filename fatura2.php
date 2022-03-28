<?php
session_start();
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "Drufa5p0u05!";
$dbname = "lnec_reservado2";

$link = new mysqli($host, $user, $password, $dbname, $port, $socket)
or die ('Could not connect to the database server' . mysqli_connect_error());
$link->set_charset("utf8");
$fatura = $_GET["id"];
$sql = "SELECT NUMDOCUM, CAST(faturacao.DATA AS DATE), VALORLIQ, VSEMIVA, IVA FROM faturacao INNER JOIN faturacao_linhas ON faturacao_linhas.CODRECEI = faturacao.CODRECEI WHERE faturacao.CODRECEI = '$fatura'";



if ($stmt = mysqli_prepare($link, $sql)) {

// Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
// Redirect to login page
        mysqli_stmt_store_result($stmt);

// Check if username exists, if yes then verify password
        if (mysqli_stmt_num_rows($stmt) >= 1) {
// Bind resultado variables
            mysqli_stmt_bind_result($stmt, $id_f, $datas, $valor_ili, $sIVA, $IVAT);
            mysqli_stmt_fetch($stmt);

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" >

<head >
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles_fatura.css">
    <title> Fatura LNEC </title>
</head>

<body >
    <div class="grid" >
        <header >
            <img src="logo.png" alt="logo">
        </header>

        <div class="grid headline">
            <div class="g-col-6 title">
                <p>Portugal</p>
            </div>
            <div class="g-col-6">
                <div class="box-infoshadow"></div>
            </div>
        </div>

        <div class="grid heading client-desc" style="--bs-gap: 3px; --bs-columns: 4;">
            <div class="g-col-3 g-start-6">NIF Cliente:288000555</div>
            <div class="g-col-4 g-start-6">Data:<?php echo $datas; ?></div>
            <div class="g-col-4 g-start-6">Visualização</div>
            <div class="g-col-4 g-start-6">Registo:</div>
        </div>


        <div class="grid heading mt-5" style="--bs-columns: 2;">
            <div class="g-col-3 g-start-6">Assunto: </div>
            <div class="g-col-4 g-start-6">Data de vencimento:12/12/2021</div>
        </div>

        <div class="d-flex container">
            <div class="box-n">Este documento não serve de fatura</div>
        </div>

        <div class="grid heading client-desc mt-5" style="--bs-gap: 3px; --bs-columns: 8;">
            <div class="g-col-3 g-start-6">Quantidade</div>
            <div class="g-col-4 g-start-6">Designação</div>
            <div class="g-col-4 g-start-6">Preço Unitário</div>
            <div class="g-col-4 g-start-6">IVA</div>
            <div class="g-col-4 g-start-6">IVA OBS</div>
            <div class="g-col-4 g-start-6">TOTAL</div>
        </div>
        <table class="table">
            <tbody>
            <?php

            $sql = "SELECT QTD, DESCARTI, PRUNIT, VALORILI, AIVA, VALOR_IVA FROM faturacao INNER JOIN faturacao_linhas ON faturacao_linhas.CODRECEI = faturacao.CODRECEI WHERE faturacao.CODRECEI = '$fatura'";


            if ($stmt = mysqli_prepare($link, $sql)) {

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            // Redirect to login page
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) >= 1) {
            // Bind resultado variables
            mysqli_stmt_bind_result($stmt, $qtd, $desc, $preunit, $valor, $aiva, $iva);
            while (mysqli_stmt_fetch($stmt)){


            ?>
            <tr>
                <td><?php echo $qtd; ?></td>
                <td><?php echo $desc; ?></td>
                <td><?php echo $preunit; ?></td>
                <td><?php echo $aiva; ?>%</td>
                <td><?php echo number_format( $iva, 2, '.', ',' ) ?>€</td>
                <td><?php echo $valor; ?>€</td>
            </tr>
                <?php
                            }
                        }
                 }
            }
            ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <div class="grid heading mt-5 iva-table iva iva-info-container"
                style="--bs-columns: 3; height: fit-content; width: 35vw;">
                <div class="g-col g-start-6">TAXA: </div>
                <div class="g-col g-start-6">INCIDÊNCIA</div>
                <div class="g-col g-start-6">VALOR</div>
            </div>

            <div class="table-iva-value">
                <div style="--bs-columns: 2;">
                    <p>Valor ilíquido</p>
                    <p>Descontos (sem IVA)</p>
                    <p>Valor do IVA</p>
                    <p>Valor Líquido</p>
                </div>
                <div>
                    <p><?php echo $valor_ili; ?></p>
                    <p><?php echo $aiva; ?>%</p>
                    <p><?php echo $IVAT; ?>€</p>
                    <p><?php echo $sIVA?> €</p>
                </div>
            </div>
        </div>

        <div class="grid heading client iva-obs-container mt-5 ">
            <div class="g-col g-start-6">IVA - OBSERVAÇÕES</div>
        </div>
        <div class="grid heading client iva-obs-container">
            <div class="g-col g-start-6 iva-obs-description">Descrição</div>
        </div>

        <footer class="heading info-procces">
            <div>
                <p>
                    Processado por computador ao abrigo do art. 7.º do Decreto-Lei n.º 45/89 <br>
                    Processado por programa certificado n.º 1178/AT - Quidgest, SA.
                </p>
            </div>
        </footer>
    </div>
    <script>
        window.onload = function() {

                window.print();

                var time = window.setTimeout(function() {
                    imprimir.style.display = 'block';
                }, 1000);

        }
    </script>
</body>

</html>

