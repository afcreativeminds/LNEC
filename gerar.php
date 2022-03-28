<?php
require "vendor/autoload.php";

 $html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <style>
   * {
    max-width: 1200px;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html{
    margin: 1rem;
}
header img{
    margin-top: 1rem;
    margin-left: 7rem;
}

.headline{
    margin: 2rem auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.title{
    margin-left: 8rem;
}

.box-infoshadow {
    background: #EEE;
    width: 300px;
    height: 70px;
    margin-right: 4rem;
}

.heading{
    width: 100%;
    display: flex;
    justify-content: space-evenly;
}

.client {
    max-width: 1200px;
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    color: #708090;
}

.client-desc {
    background-color: #EEE;
    border-top: 6px solid rgb(88, 0, 0);
    margin-right: 2px;
    padding: 10px 5px;
}

.container{
    display: flex;
    justify-content: end;
    margin-top: 1rem;
    margin-bottom: 1.5rem;
}
.box-n {
    border: 1px solid #a9a9a9;
    color: #708090;
    max-width: 400px;
    display: flex;
    justify-content: center;
    align-content: flex-end;
    margin-right: 3rem;
    padding: 0 3rem;
}

.iva-info-container{
    max-width: 1200px;
    margin-top: 2rem;
    margin-left: 1.8rem;
    display: flex;
    justify-content: space-evenly;
    flex-direction: row;
}
.iva-table{
    margin-top: 15px;
    font-size: 12px;
    font-weight: 900;
    height: fit-content; 
    width: 35vw;
}
.iva{
    background-color: #EEE;
    border-bottom: 5px solid rgb(88, 0, 0);
    margin-right: 2px;
    color: rgb(88, 0, 0);
}

.table-iva-value{
    height: fit-content; 
    width: 45vw;
    margin-top: 2rem;
    border: 2px solid #EEE;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #708090;
}

.iva-obs-container{
    background-color: #EEE;
    color: rgb(88, 0, 0);
    margin-top: 15px;
    font-size: 12px;
    font-weight: 900;
}

.iva-obs-description{
    color: #a9a9a9;
}

.info-procces{
    margin-top: 8rem;
    display: flex;
    justify-content: flex-start;
    color: #708090;
    font-size: 10px;
}
</style>
    <title> Fatura LNEC </title>
</head>

<body>
    <div class="grid">
        <header>
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
            <div class="g-col-4 g-start-6">Data:12/12/2021</div>
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
                    <p>-</p>
                    <p>-</p>
                    <p>-</p>
                    <p>-</p>
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
</body>

</html>';

 $mpdf = new \Mpdf\Mpdf();
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->WriteHTML($html);
 $mpdf->Output('Fatura01.php','I');

 exit;