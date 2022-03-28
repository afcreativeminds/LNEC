<?php
session_start();
require("config.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)) {
    $id = $_GET['id'];
    $notificacao = "DELETE FROM notificacao_geral WHERE id='$id'";
    $resultado = mysqli_query($link, $notificacao);

    if (mysqli_affected_rows($link)) {

        header("Location: notificacoes.php?sucesso");

    } else {
        header("Location: notificacoes.php?error");
        }
    }
?>