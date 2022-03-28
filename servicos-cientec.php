<?Php
session_start();



$id = $_SESSION["id"];
require("config.php");

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

// Define variables and initialize with empty values
$nome_p = $entidade = $email = $assunto = $msg = "";
$nome_err = $entidade_err = $email_err = $assunto_err = $msg_err = $my_captcha_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nome
    if (empty(trim($_POST["nome"]))) {
        $nome_err = "Por favor introduza o seu nome.";
    } else {

        $nome_p = trim($_POST["nome"]);
    }

    // Validate entidade
    if (empty(trim($_POST["entidade"]))) {
        $entidade_err = "Por favor introduza uma entidade";
    } else {
        $entidade = trim($_POST["entidade"]);

    }


    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor introduza um email.";
    } else {
        $email = trim($_POST["email"]);
    }


    // Validate assunto
    if (empty(trim($_POST["assunto"]))) {
        $assunto_err= "Por favor introduza um assunto.";
    } else {

        $assunto = trim($_POST["assunto"]);
    }

    // Validate mensagem
    if (empty(trim($_POST["msg"]))) {
        $msg_err = "Por favor introduza uma mensagem.";
    } else {

        $msg = trim($_POST["assunto"]);
    }


    if($_POST['t1'] == $_SESSION['my_captcha']){
    // Check input errors before inserting in database
    if (empty($nome_err) && empty($assunto_err) && empty($email_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO pedido_contato (nome, entidade, email, assunto, msg, user_iduser) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_nome, $param_entidade, $param_email, $param_assunto, $param_msg, $param_user);

            // Set parameters
            $param_nome = $nome_p;
            $param_entidade = $entidade;
            $param_email = $email;
            $param_assunto = $assunto;
            $param_msg = $msg;
            $param_user = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $_SESSION["return"] = "<p style='color: chartreuse'>Pedido enviado com sucesso.</p>";
            } else {
                printf("Error: %s.\n", mysqli_stmt_error($stmt));
                echo "4";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}else{
        $my_captcha_err = "Código errado. Tente Novamente!";
    }
    unset($_SESSION['my_captcha']);
    // Close connection
    mysqli_close($link);
}

?>
<?php include "header.php" ?>
<body>
    <main class="main-int_LNEC">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">PEDIDO DE SERVIÇOS</h1>
                    <h2 class="h2-int">SERVIÇOS DE CIÊNCIA E TECNOLOGIA</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content">
                    <div class="box-form_LNEC">
                        <span class="alert-label">Formulário de Contacto</span>
                        <form class="form-LNEC" method="post">
                            <?php if(isset($_SESSION["return"])) { echo $_SESSION["return"]; unset($_SESSION["return"]); }?>

                            <div class="input-item_form">
                                <label>Nome*</label>
                                <input type="text" name="nome"/>
                                <p style="color: red"><?php echo (!empty($nome_err)) ? $nome_err: ''; ?> </p>

                            </div>
                            <div class="input-item_form">
                                <label>Entidade*</label>
                                <input type="text" name="entidade"/>
                                <p style="color: red"><?php echo (!empty($entidade_err)) ? $entidade_err: ''; ?> </p>

                            </div>
                            <div class="input-item_form">
                                <label>Email*</label>
                                <input type="text" name="email"/>
                                <p style="color: red"><?php echo (!empty($email_err)) ? $email_err: ''; ?> </p>

                            </div>
                            <div class="input-item_form">
                                <label>Assunto*</label>
                                <input type="text" name="assunto"/>
                                <p style="color: red"><?php echo (!empty($assunto_err)) ? $assunto_err: ''; ?> </p>

                            </div>
                            <div class="input-item_form">
                                <label>Mensagem*</label>
                                <textarea name="msg"></textarea >
                                <p style="color: red"><?php echo (!empty($msg_err)) ? $msg_err: ''; ?> </p>

                            </div>
                            <div class="infos-user">
                                <label  class="alert-label">CÓDIGO DE SEGURANÇA*</label>
                                <input type="text" name="t1"><br>
                                <img src="captcha/captcha-image.php" id="capt" style=" margin-right: 5px; margin-left: 5px;">
                                <input type=button onClick=reload(); value='Actualizar' style=" margin-right: 5px; margin-left: 5px;"><br>
                                <p style="color: red"><?php echo (!empty($my_captcha_err)) ? $my_captcha_err: ''; ?> </p>

                            </div>
                            <div class="input-item_form">
                                <span>Por favor, copie os caracteres da imagem para o campo ao lado.</span>
                            </div>
                            <div class="input-item_form box-button_form">
                                <button type="reset" value="Reset" class="button-reset_LNEC">LIMPAR</button>
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
        function reload()
        {
            img = document.getElementById("capt");
            img.src="captcha/captcha-image.php?rand_number=" + Math.random();
        }
    </script>
</body>
    