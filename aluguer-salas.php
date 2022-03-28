<?Php
session_start();

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}


$id = $_SESSION["id"];
require("config.php");
// Check if the user is



// Define variables and initialize with empty values
$email = $assunto = $observacao = $tel = "";
$email_err = $assunto_err = $observacao_err = $tel_err = $my_captcha_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor introduza o seu email.";
    } else {

        $email = trim($_POST["email"]);
    }

    // Validate assunto
    if (empty(trim($_POST["assunto"]))) {
        $assunto_err = "Por favor introduza o assunto.";
    } else {
        $assunto = trim($_POST["assunto"]);

    }


    // Validate observação
    if (empty(trim($_POST["observacao"]))) {
        $observacao_err = "Por favor introduza a Observação.";
    } else {
        $observacao = trim($_POST["observacao"]);
    }


    // Validate Telefone
    if (empty(trim($_POST["tel"]))) {
        $tel_err= "Por favor introduza um telefone.";
    } else {

        $tel = trim($_POST["tel"]);
    }

    // Validate data
    if (empty(trim($_POST["data"]))) {
        $data_err = "Por favor selecione uma data";
    } else {

        $data = trim($_POST["data"]);
    }


    if($_POST['t1'] == $_SESSION['my_captcha']){
        // Check input errors before inserting in database
        if (empty($email_err) && empty($assunto_err) && empty($observacao_err)) {

            // Prepare an insert statement
            $sql = "INSERT INTO pedido_sala (email, assunto, observacao,	telefone, data_sala, user_iduser) VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssss", $param_1, $param_2, $param_3, $param_4, $param_5, $param_6);

                // Set parameters
                $param_1 = $email;
                $param_2 = $assunto;
                $param_3 = $observacao;
                $param_4 = $tel;
                $param_5 = $data;
                $param_6 = $id;



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
    <main class="main-int_LNEC main-aluguer-salas">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">PEDIDO DE SERVIÇOS</h1>
                    <h2 class="h2-int">ALUGUER DE SALAS</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content mid-full-size">
                    <div class="box-content">
                        <div class="box-form_LNEC">
                            <?php if (isset($_SESSION["return"])) {
                                echo $_SESSION["return"];
                                unset($_SESSION["return"]);
                            } ?>
                        <span class="title-content">O LNEC disponibiliza o aluguer de 6 salas e de outras áreas do <a href="" class="link-congresso">Centro de Congressos</a> para eventos que se integrem no âmbito de atividades científicas e técnicas..</span>
                        <div class="box-form_LNEC">
                            <span class="obs-form">*Campos de preenchimento obrigatório</span>
                            <form class="form-LNEC" method="post">
                                <div class="input-item_form">
                                    <input type="text" placeholder="E-mail*" name="email"/>
                                    <p style="color: red"><?php echo (!empty($email_err)) ? $email_err : ''; ?> </p>
                                </div>
                                <div class="input-item_form">
                                    <input type="text" placeholder="Assunto*" name="assunto"/>
                                    <p style="color: red"><?php echo (!empty($assunto_err)) ? $assunto_err : ''; ?> </p>

                                </div>
                                <div class="input-item_form">
                                    <textarea placeholder="Observações" name="observacao"></textarea>
                                    <p style="color: red"><?php echo (!empty($observacao_err)) ? $observacao_err : ''; ?> </p>

                                </div>
                                <div class="d-flex double-input-inline">
                                    <div class="input-item_form">
                                        <input type="text" placeholder="Telefone (PT)*" name="tel"/>
                                        <p style="color: red"><?php echo (!empty($tel_err)) ? $tel_err : ''; ?> </p>
                                    </div>
                                    <div class="input-item_form">
                                        <input type="date" placeholder="Data*" name="data"/>
                                        <p style="color: red"><?php echo (!empty($data_err)) ? $data_err : ''; ?> </p>
                                    </div>
                                </div>
                                <div class="infos-user">
                                    <label  class="code-sec">Código de segurança*</label>
                                    <input type="text" name="t1"><br>
                                    <img src="captcha/captcha-image.php" id="capt"
                                         style=" margin-right: 5px; margin-left: 5px;border: 1px solid #ddd;">
                                    <input type=button onClick=reload(); value='Actualizar'
                                           style=" margin-right: 5px; margin-left: 5px;"><br>
                                    <p style="color: red"><?php echo (!empty($my_captcha_err)) ? $my_captcha_err : ''; ?> </p>

                                </div>
                                <div class="">
                                    <span>Por favor, copie os caracteres da imagem para o campo ao lado.</span>
                                </div>

                                <div class="input-item_form box-button_form">
                                    <button type="reset" value="Reset" class="button-reset_LNEC">LIMPAR</button>
                                    <button type="submit" value="Submit" class="button-submit_LNEC">SUBMETER</button>
                                </div>
                            </form>
                        </div>
                        <div class="gallery-images">
                            <div class="content-gallery-images">
                                <div class="item-gallery">
                                    <img src="assets/image/pequenoauditorio.png" class="img-item-gallery"/>
                                </div>
                                <div class="item-gallery">
                                    <img src="assets/image/sala2.png" class="img-item-gallery"/>
                                </div>
                                <div class="item-gallery">
                                    <img src="assets/image/auditorio.png" class="img-item-gallery"/>
                                </div>
                            </div>
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
    