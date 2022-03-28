<?Php
session_start();


$id = $_SESSION["id"];
require("config.php");
// Check if the user is

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

// Define variables and initialize with empty values
$nome = $apelido = $empresa = $endereco = $postal_localidade = $pais = $email = $tel = "";
$instituicao_emp = $endereco_emp = $postal_localidade_emp = $pais_emp = $nif_emp = "";

$nome_err = $apelido_err = $empresa_err = $endereco_err = $postal_localidade_err = $pais_err = $email_err = $tel_err = "";
$instituicao_emp_err = $endereco_emp_err = $postal_localidade_emp_err = $pais_emp_err = $nif_emp_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nome
    if (empty(trim($_POST["nome"]))) {
        $nome_err = "Por favor introduza o seu nome.";
    } else {

        $nome = trim($_POST["nome"]);
    }

    // Validate apelido
    if (empty(trim($_POST["apelido"]))) {
        $apelido_err = "Por favor introduza o seu apelido";
    } else {
        $apelido = trim($_POST["apelido"]);

    }

    // Validate empresa
    if (empty(trim($_POST["empresa"]))) {
        $empresa_err = "Por favor introduza uma empresa";
    } else {
        $empresa = trim($_POST["empresa"]);

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
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor introduza um email.";
    } else {
        $email = trim($_POST["email"]);
    }


    // Validate telefone
    if (empty(trim($_POST["tel"]))) {
        $tel_err = "Por favor introduza um telefone valido.";
    } else {

        $tel = trim($_POST["tel"]);
    }

    // Validate Instituição
    if (empty(trim($_POST["instituicao_emp"]))) {
        $instituicao_emp_err = "Por favor introduza uma Instituição/Empresa.";
    } else {

        $instituicao_emp = trim($_POST["instituicao_emp"]);
    }

    // Validate endereço/empresa
    if (empty(trim($_POST["endereco_emp"]))) {
        $endereco_emp_err = "Por favor introduza um endereço.";
    } else {

        $endereco_emp = trim($_POST["endereco_emp"]);
    }


    // Validate localidade/empresa
    if (empty(trim($_POST["postal_localidade_emp"]))) {
        $postal_localidade_emp_err = "Por favor introduza uma localidade.";
    } else {

        $postal_localidade_emp = trim($_POST["postal_localidade_emp"]);
    }


    // Validate pais/empresa
    if (empty(trim($_POST["pais_emp"]))) {
        $pais_emp_err = "Por favor introduza um pais.";
    } else {

        $pais_emp = trim($_POST["pais_emp"]);
    }


    // Validate nif/empresa
    if (empty(trim($_POST["endereco_emp"]))) {
        $nif_emp_err = "Por favor introduza um NIF.";
    } else {

        $nif_emp = trim($_POST["nif_emp"]);
    }


    if ($_POST['t1'] == $_SESSION['my_captcha']) {
        // Check input errors before inserting in database
        if (empty($nome_err) && empty($instituicao_emp_err) && empty($email_err)) {

            $dir = "upload/";
            $file = $_FILES["file"];
            $doc = $file["name"];

            $inscricao = $_POST["inscricao"];
            $pagamento = $_POST["pagamento"];
            $workshop = $_POST["workshop"];


            // Move o arquivo da pasta temporaria de upload para a pasta de destino
            if (move_uploaded_file($file["tmp_name"], "$dir/" . $file["name"])) {
                // Prepare an insert statement

                $sql = "INSERT INTO evento_particular (nome, apelido, instituicao, endereco, codigo_postal, pais, email, telefone, user_iduser, tipo_inscricao_idtipo_inscricao, tipo_pagamento_idtipo_pagamento, workshop_idworkshop)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssssssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6, $param_7, $param_8, $param_9, $param_10, $param_11, $param_12);

                    // Set parameters
                    $param_1 = $nome;
                    $param_2 = $apelido;
                    $param_3 = $empresa;
                    $param_4 = $endereco;
                    $param_5 = $postal_localidade;
                    $param_6 = $pais;
                    $param_7 = $email;
                    $param_8 = $tel;
                    $param_9 = $id;
                    $param_10 = $inscricao;
                    $param_11 = $pagamento;
                    $param_12 = $workshop;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        $ultimo = $link->insert_id;
                        $link->query("INSERT INTO evento_empresa (nome, endereco, codigo_postal, pais, nif, evento_particular_idevento_particular) VALUES ('$instituicao_emp', '$endereco_emp', '$postal_localidade_emp', '$pais_emp', '$nif_emp', '$ultimo')");
                        $link->query("INSERT INTO documentos (documentos, diretorio, id_operacao_evento) VALUES ('$doc', '$dir', '$ultimo')");
                        $_SESSION["return"] = "<p style='color: chartreuse'>Formulario enviado com sucesso.</p>";

                    } else{
                        $_SESSION["return"] = "<p style='color: red'>Erro ao enviar o formulario, tente novamente!</p>";
                        //printf("Error: %s.\n", mysqli_stmt_error($stmt));
                        //echo "4" . $link->insert_id;;
                    }
                } else {
                    printf("Error: %s.\n", mysqli_stmt_error($stmt));
                }


            } else {
                // Prepare an insert statement
                $sql = "INSERT INTO evento_particular (nome, apelido, instituicao, endereco, codigo_postal, pais, email, telefone, user_iduser, tipo_inscricao_idtipo_inscricao, tipo_pagamento_idtipo_pagamento, workshop_idworkshop) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssssssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6, $param_7, $param_8, $param_9, $param_10, $param_11, $param_12);

                    // Set parameters
                    $param_1 = $nome;
                    $param_2 = $apelido;
                    $param_3 = $empresa;
                    $param_4 = $endereco;
                    $param_5 = $postal_localidade;
                    $param_6 = $pais;
                    $param_7 = $email;
                    $param_8 = $tel;
                    $param_9 = $id;
                    $param_10 = $inscricao;
                    $param_11 = $pagamento;
                    $param_12 = $workshop;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        $ultimo = $link->insert_id;
                        // Redirect to login page
                        if ($link->query("INSERT INTO evento_empresa (nome, endereco, codigo_postal, pais, nif, evento_particular_idevento_particular) VALUES ('$instituicao_emp', '$endereco_emp', '$postal_localidade_emp', '$pais_emp', '$nif_emp', '$ultimo')")) ;
                        $_SESSION["return"] = "<p style='color: chartreuse'>Formulario enviado com sucesso.</p>";
                    } else {
                        $_SESSION["return"] = "<p style='color: red'>Erro ao enviar o formulario, tente novamente!</p>";
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
    } else {
        $my_captcha_err = "Código errado. Tente Novamente!";
    }
    unset($_SESSION['my_captcha']);
    // Close connection

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
                <h1 class="h1-int">PEDIDO DE SERVIÇOS</h1>
                <h2 class="h2-int">INSCRIÇÕES EM EVENTOS</h2>
            </div>
        </div>

        <div class="mid-content">
            <div class="all_mid-content">


                <div class="box-form_LNEC">
                    <?php if (isset($_SESSION["return"])) {
                        echo $_SESSION["return"];
                        unset($_SESSION["return"]);
                    } ?>
                    <span class="alert-label">Ficha de INSCRIÇÃO</span>
                    <form class="form-LNEC" method="post" enctype="multipart/form-data">
                        <div class="input-item_form">
                            <label>Nome*</label>
                            <input type="text" name="nome"/>
                            <p style="color: red"><?php echo (!empty($nome_err)) ? $nome_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Apelido*</label>
                            <input type="text" name="apelido"/>
                            <p style="color: red"><?php echo (!empty($apelido_err)) ? $apelido_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Empresa/Instituição*</label>
                            <input type="text" name="empresa"/>
                            <p style="color: red"><?php echo (!empty($empresa_err)) ? $empresa_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Endereço*</label>
                            <input type="text" name="endereco"/>
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
                            <input type="text" name="email"/>
                            <p style="color: red"><?php echo (!empty($email_err)) ? $email_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form">
                            <label>Telefone*</label>
                            <input type="text" name="tel"/>
                            <p style="color: red"><?php echo (!empty($tel_err)) ? $tel_err : ''; ?> </p>
                        </div>
                        <div class="input-item_form divider-item-form">
                            <label class="alert-label">INSCRIÇÃO</label>
                            <?php
                            $sql = "SELECT * FROM tipo_inscricao";
                            $result = $link->query($sql);
                            $result->num_rows;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    ?>
                                    <div class="item-radio-form">
                                        <input type="radio" name="inscricao"
                                               value="<?php echo $row['idtipo_inscricao']; ?>" <?php if ($row['idtipo_inscricao'] == '1') echo "checked"; ?> />
                                        <label for="normal"><?php echo $row['tipo_inscricao']; ?> <?php echo $row['preco']; ?>
                                            (IVA incluído)</label>
                                        <span class="sub-radio-form"><?php if ($row['descri'] != null) echo $row['descri']; ?></span>

                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>

                        <div class="input-item_form divider-item-form">
                            <label class="alert-label">SRU2019 - WORKSHOPS :</label>
                            <?php
                            $sql = "SELECT * FROM workshop where isPublic = 1";
                            $result = $link->query($sql);
                            $result->num_rows;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    ?>
                                    <div class="item-radio-form">
                                        <input type="radio" name="workshop"
                                               value="<?php echo $row['idworkshop']; ?>" <?php if ($row['idworkshop'] == 1) echo "checked"; ?>/>
                                        <label for="normal"><?php echo $row['workshop']; ?></label>
                                        <span class="sub-radio-form">(<?php echo $row['data']; ?> - <?php echo $row['hora_inicio']; ?> às <?php echo $row['hora_fim']; ?>)</span>
                                    </div>
                                    <?php
                                }
                            }
                            ?>


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
                                <input type="file" name="file">
                            </div>
                        </div>

                        <div class="input-item_form divider-item-form">
                            <label class="alert-label">FICHA DE INSCRIÇÃO</label>
                            <div class="input-item_form">
                                <label>Nome / Empresa / Instituição*</label>
                                <input type="text" name="instituicao_emp"/>
                                <p style="color: red"><?php echo (!empty($instituicao_emp_err)) ? $instituicao_emp_err : ''; ?> </p>
                            </div>
                            <div class="input-item_form">
                                <label>Endereço*</label>
                                <input type="text" name="endereco_emp"/>
                                <p style="color: red"><?php echo (!empty($endereco_emp_err)) ? $endereco_emp_err : ''; ?> </p>
                            </div>
                            <div class="input-item_form">
                                <label>Código Postal - Localidade*</label>
                                <input type="text" name="postal_localidade_emp"/>
                                <p style="color: red"><?php echo (!empty($postal_localidade_emp_err)) ? $postal_localidade_emp_err : ''; ?> </p>
                            </div>
                            <div class="input-item_form">
                                <label>País*</label>
                                <input type="text" name="pais_emp"/>
                                <p style="color: red"><?php echo (!empty($pais_emp_err)) ? $pais_emp_err : ''; ?> </p>
                            </div>
                            <div class="input-item_form">
                                <label>NIF*</label>
                                <input type="text" name="nif_emp"/>
                                <p style="color: red"><?php echo (!empty($nif_emp_err)) ? $nif_emp_err : ''; ?> </p>
                            </div>

                            <div class="infos-user">
                                <label class="alert-label">CÓDIGO DE SEGURANÇA*</label>
                                <input type="text" name="t1"><br>
                                <img src="captcha/captcha-image.php" id="capt"
                                     style=" margin-right: 5px; margin-left: 5px;">
                                <input type=button onClick=reload(); value='Actualizar'
                                       style=" margin-right: 5px; margin-left: 5px;"><br>
                                <p style="color: red"><?php echo (!empty($my_captcha_err)) ? $my_captcha_err : ''; ?> </p>

                            </div>
                            <div class="input-item_form">
                                <span>Por favor, copie os caracteres da imagem para o campo ao lado.</span>
                            </div>
                            <div class="input-item_form box-button_form">
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
    