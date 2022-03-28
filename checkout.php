<?Php
session_start();


$id = $_SESSION["id"];
require("config.php");
// Check if the user is


if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}


$carrinho = count($_SESSION["carrinho"]);

// Define variables and initialize with empty values
$nome_emp = $endereco = $postal_localidade = $pais = $email = $tel = "";

$nome_emp_err = $endereco_err = $postal_localidade_err = $pais_err = $email_err = $tel_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nome_emp
    if (empty(trim($_POST["nome_emp"]))) {
        $nome_emp_err = "Por favor introduza o um nome.";
    } else {

        $nome_emp = trim($_POST["nome_emp"]);
    }

    // Validate endereço
    if (empty(trim($_POST["endereco"]))) {
        $endereco_err = "Por favor introduza um endereco";
    } else {
        $endereco = trim($_POST["endereco"]);

    }

    // Validate Código-Postal - Localidade
    if (empty(trim($_POST["postal_localidade"]))) {
        $postal_localidade_err = "Por favor introduza um Código-Postal";
    } else {
        $postal_localidade = trim($_POST["postal_localidade"]);

    }

    // Validate pais
    if (empty(trim($_POST["pais"]))) {
        $pais_err = "Por favor introduza um Pais";
    } else {
        $pais = trim($_POST["pais"]);

    }

    // Validate email
    if (empty(trim($_POST["email_emp"]))) {
        $email_emp_err = "Por favor introduza um email.";
    } else {
        $email_emp = trim($_POST["email_emp"]);
    }


    // Validate telefone
    if (empty(trim($_POST["tel"]))) {
        $tel_err = "Por favor introduza um telefone valido.";
    } else {

        $tel = trim($_POST["tel"]);
    }



        // Check input errors before inserting in database
        if (empty($nome_err) && empty($email_emp_err) && $carrinho>=1) {

            $dir = "upload/";
            $file = $_FILES["files"];
            $doc = $file["name"];

            $pagamento = $_POST["pagamento"];
            $valor = $_POST["valor"];



            // Move o arquivo da pasta temporaria de upload para a pasta de destino
            if (move_uploaded_file($file["tmp_name"], "$dir/" . $file["name"])) {
                // Prepare an insert statement

                $link->query("INSERT INTO pre_encomenda (id_user) VALUES ('$id')");
                $encomenda = $link->insert_id;
                $sql = "INSERT INTO faturas (tipo_pagamento, valor, nome_emp, endereco, codigo_postal, pais, tel, email, estado_fatura_idestado_fatura, id_encomenda)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6, $param_7, $param_8, $param_9, $param_10);

                    // Set parameters
                    $param_1 = $pagamento;
                    $param_2 = $valor;
                    $param_3 = $nome_emp;
                    $param_4 = $endereco;
                    $param_5 = $postal_localidade;
                    $param_6 = $pais;
                    $param_7 = $tel;
                    $param_8 = $email_emp;
                    $param_9 = '1';
                    $param_10 = $encomenda;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        $ultimo = $link->insert_id;
                        foreach($_SESSION['carrinho'] as $id_servico => $qtd) {
                            $link->query("INSERT INTO encomenda_servico (id_fatura, id_servico) VALUES ('$ultimo', '$id_servico')");
                        }
                        $link->query("INSERT INTO documento_comprovativo (documentos, diretorio, id_operacao) VALUES ('$doc', '$dir', '$ultimo')");
                        unset($_SESSION["carrinho"]);
                        $_SESSION["return"] = "<p style='color: chartreuse'>A sua pre-encomenda foi enviada com sucesso.</p>";
                        header("location: ensaios-calibracoes.php");
                    } else {
                        $_SESSION["returnf"] = "<p style='color: red'>Erro ao fazer pre-encomenda, tente novamente!</p>";
                        // printf("Error: %s.\n", mysqli_stmt_error($stmt));
                        // echo "4";
                    }
                } else {
                    printf("Error: %s.\n", mysqli_stmt_error($stmt));
                }


            } else {
                // Prepare an insert statement

                $link->query("INSERT INTO pre_encomenda (id_user) VALUES ('$id')");
                $encomenda = $link->insert_id;

                $sql = "INSERT INTO faturas (tipo_pagamento, valor, nome_emp, endereco, codigo_postal, pais, tel, email, estado_fatura_idestado_fatura, id_encomenda)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6, $param_7, $param_8, $param_9, $param_10);

                    // Set parameters
                    $param_1 = $pagamento;
                    $param_2 = $valor;
                    $param_3 = $nome_emp;
                    $param_4 = $endereco;
                    $param_5 = $postal_localidade;
                    $param_6 = $pais;
                    $param_7 = $tel;
                    $param_8 = $email;
                    $param_9 = '1';
                    $param_10 = $encomenda;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        $ultimo = $link->insert_id;
                        foreach($_SESSION['carrinho'] as $id_servico => $qtd) {
                            $link->query("INSERT INTO encomenda_servico (id_fatura, id_servico) VALUES ('$ultimo', '$id_servico')");
                        }
                        unset($_SESSION["carrinho"]);
                        $_SESSION["return"] = "<p style='color: chartreuse'>A sua pre-encomenda foi enviada com sucesso.</p>";
                        header("location: ensaios-calibracoes.php");

                    } else {
                        $_SESSION["returnf"] = "<p style='color: red'>Erro ao fazer pre-encomenda, tente novamente!</p>";
                       // printf("Error: %s.\n", mysqli_stmt_error($stmt));
                       // echo "4";
                    }
                } else {
                    printf("Error: %s.\n", mysqli_stmt_error($stmt));
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    // Close connection
    $_SESSION["returnf"] = "<p style='color: red'>Erro ao fazer pre-encomenda, tente novamente!</p>";
}
// Informações do user
if ($id!=null) {
    // Prepare a select statement
    $sql = "SELECT nome, email, telefone, morada, morada_outra FROM users WHERE iduser = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store resultado
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind resultado variables
                mysqli_stmt_bind_result($stmt, $nome_user, $email, $telefone, $morada, $morada_outra);
                mysqli_stmt_fetch($stmt);
            }
        }
    } else {
        echo "Oops! .";
    }
}
?>
<?php include "header.php" ?>
<body>
<main class="main-int_LNEC">
    <?php include "side-menu.php" ?>

    <section class="content-int_LNEC">
        <div class="top-content">
            <div class="breadcrumb-int">
                <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES
                    DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
            </div>

            <div class="title-int">
                <h1 class="h1-int">PRÉ-ENCOMENDAR ENSAIOS</h1>
                <h2 class="h2-int">CHECKOUT</h2>
            </div>
        </div>

        <div class="mid-content" style="margin-left: 0px;">
            <div class="all_mid-content">
                <div class="search-result-show_LNEC" >
                    <div class="content-result" style="padding-left: 0px;">
                        <table class="table table-strip">
                            <caption><h2 class="card-title" style="border-bottom: 2px solid #e20613;">Carrinho</h2></caption>
                            <thead>
                            <tr>
                                <td width="200"><b>Produto</b></td>
                                <td width="300"><b>Pre&ccedil;o</b></td>
                                <td width="150"><b>QTD</b></th>
                                <td width="200"><b>SubTotal</b></td>

                            </tr>
                            </thead>
                            <form action="?acao=up" method="post">
                                <tbody>
                                <?php
                                if(count($_SESSION['carrinho']) == 0){
                                    echo '
                                <tr>
                                    <td colspan="5">Não há produto no carrinho</td>
                                </tr>
                                ';
                                } else{
                                    $total=0;
                                    foreach($_SESSION['carrinho'] as $id_s => $qtd) {

                                        $sql = "SELECT *  FROM servico WHERE idservico = $id_s";

                                        $result = $link->query($sql);
                                        $ln = $result->fetch_assoc();
                                        $sub   = number_format($ln['preco'] * $qtd, 2, ',', '.');
                                        $nome = $ln['servico'];
                                        $preco = number_format($ln['preco'], 2, ',', '.');
                                        $total += $ln['preco'] * $qtd;
                                        echo'
              <tr>      	
                <td>' . $nome . '</td>
				<td>' . $preco . ' Euros</td>
                <td class="-align-center">'.$qtd.'</td>
                
                <td>' . $sub . ' Euros</td>
               
                            </tr>';
                                    }
                                    $total = number_format($total, 2, ',', '.');
                                    echo '<br><tr>                         
                                    <td colspan="5"></td>
                                </tr>';
                                    echo '<br><tr>                         
                                    <td colspan="3"><b>Total</b></td>
                                    <td>'.$total. ' Euros</td>
                    </tr>';

                                }  ?>
                                </tbody>

                        </table>
                        </form>

                    </div>
                </div>
                <div class="bottom-content">

                </div>
                <div class="box-form_LNEC">
                    <?php if (isset($_SESSION["returnf"])) {
                        echo $_SESSION["returnf"];
                        unset($_SESSION["returnf"]);
                    } ?>
                    <span class="alert-label">Dados de Faturação</span>
                    <form class="form-LNEC" method="post" enctype="multipart/form-data">
                        <div class="input-item_form">
                            <input name="valor" value="<?php  if(!empty($total))echo $total; ?>" hidden>
                            <label>Nome / Empresa / Instituição*</label>
                            <input type="text" name="nome_emp" value="<?php  if(!empty($nome_user))echo $nome_user; ?>"/>
                            <p style="color: red"><?php echo (!empty($nome_err)) ? $nome_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Endereço*</label>
                            <input type="text" name="endereco" value="<?php  if(!empty($morada))echo $morada; ?>"/>
                            <p style="color: red"><?php echo (!empty($endereco_err)) ? $endereco_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Código-Postal - Localidade*</label>
                            <input type="text" name="postal_localidade"/>
                            <p style="color: red"><?php echo (!empty($postal_localidade_err)) ? $postal_localidade_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>País*</label>
                            <input type="text" name="pais"/>
                            <p style="color: red"><?php echo (!empty($pais_err)) ? $pais_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>E-mail*</label>
                            <input type="text" name="email_emp" value="<?php  if(!empty($email))echo $email; ?>"/>
                            <p style="color: red"><?php echo (!empty($email_err)) ? $email_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Telefone*</label>
                            <input type="text" name="tel" value="<?php  if(!empty($telefone))echo $telefone; ?>"/>
                            <p style="color: red"><?php echo (!empty($tel_err)) ? $tel_err : ''; ?> </p>
                        </div>


                        <div class="input-item_form divider-item-form">
                            <label class="alert-label">PAGAMENTO</label>
                            <?php
                            $sql = "SELECT * FROM tipo_pagamento";
                            $result = $link->query($sql);
                            $result->num_rows;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    ?>
                                    <div class="item-radio-form">
                                        <input type="radio" name="pagamento"
                                               value="<?php echo $row['idtipo_pagamento']; ?>"
                                            <?php if ($row['idtipo_pagamento'] == 1) echo "checked"; ?>>
                                        <label for="normal"><?php if ($row['info1'] != null) echo $row['info1']; ?></label>
                                        <span class="sub-radio-form"><?php if ($row['info2'] != null) echo $row['info2']; ?>
                                        <br><?php if ($row['info3'] != null) echo $row['info3']; ?>
                                        <br><?php if ($row['info4'] != null) echo $row['info4']; ?>
                                    </span>
                                    </div>
                                    <?php
                                }
                            }
                            mysqli_close($link);
                            ?>
                        </div>

                        <div class="input-item_form divider-item-form">
                            <label class="alert-label">Anexar comprovativo de pagamento: </label>
                            <div class="item-radio-form">
                                <input type="file" name="files">
                            </div>
                        </div>

                            <div class="input-item_form box-button_form">
                                <button type="reset" value="Reset" class="button-reset_LNEC" onclick="location.href = 'carrinho.php'">Voltar</button>
                                <button type="submit" value="Submit" class="button-submit_LNEC">SUBMETER</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bottom-content">
        </div>
    </section>

    <?php include "sidebar-int.php" ?>
</main>

<script type="text/javascript">
    function reload() {
        img = document.getElementById("capt");
        img.src = "captcha/captcha-image.php?rand_number=" + Math.random();
    }
</script>
</body>
    