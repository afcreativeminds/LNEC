<?php

// Include config file
session_start();
require("config.php");

$id = $_SESSION["id"];


if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Validate nif
    if (empty(trim($_POST["nif"]))) {
        echo  "Por favor introduza um NIF";
    } else {
        $nif = trim($_POST["nif"]);
    }


    // Validate nome
    if (empty(trim($_POST["nome"]))) {
        echo  "Por favor introduza o seu nome.";
    } else {

        $nome = trim($_POST["nome"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        echo  "Por favor introduza um email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT email FROM users WHERE email = ? and iduser != $id";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "Esse email já se encontra associado a uma conta.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! .";
            }
        }

    }


    // Validate telefone
    if (empty(trim($_POST["tel"]))) {
        echo "Por favor introduza um numero de telemóvel.";
    } else {

        $tel = trim($_POST["tel"]);

    }

    // Validate morada
    if (empty($_POST["morada"])) {
        echo  "Por favor introduza uma morada valida!";
    } else {
        $morada = trim($_POST["morada"]);
    }

    // Validate morada outra
    if (empty(trim($_POST["morada_outra"]))) {
        echo  "Por favor introduza uma morada valida.";
    } else {
        $morada_outra = trim($_POST["morada_outra"]);
    }


    // Check input errors before inserting in database
    if (!empty($nif)) {

        $notificacao = trim($_POST["notificacao"]);
        $dir = "imagens/";
        // recebendo o arquivo multipart

            $file = $_FILES["img"];

            // Move o arquivo da pasta temporaria de upload para a pasta de destino
            if (move_uploaded_file($file["tmp_name"], "$dir/" . $file["name"])) {
                // Prepare an insert statement
                $sql = "UPDATE users SET nome = ?, nif = ?, email = ?, telefone = ?, img = ?, morada = ?, morada_outra = ?, notificacao = ? WHERE iduser = $id";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssssss", $param_nome, $param_nif, $param_email, $param_tel, $param_img, $param_morada, $param_morada_outra, $param_notificacao);

                    // Set parameters
                    $param_nif = $nif;
                    $param_nome = $nome;
                    $param_email = $email;
                    $param_tel = $tel;
                    $param_img = $file["name"];
                    $param_morada = $morada;
                    $param_morada_outra = $morada_outra;
                    $param_notificacao = $notificacao;

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        $_SESSION["return"] = "<p style='color: chartreuse'>Perfil atualizado com sucesso.</p>";
                    } else {
                        printf("Error: %s.\n", mysqli_stmt_error($stmt));
                        echo "4";
                    }
                }else{
                    printf("Error: %s.\n", mysqli_stmt_error($stmt));
                }


            }


        else {
            // Prepare an insert statement
            $sql = "UPDATE users SET nome = ?, nif = ?, email = ?, telefone = ?, morada = ?, morada_outra = ?, notificacao = ? WHERE iduser = $id";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssss", $param_nome, $param_nif, $param_email, $param_tel, $param_morada, $param_morada_outra, $param_notificacao);

                // Set parameters
                $param_nif = $nif;
                $param_nome = $nome;
                $param_email = $email;
                $param_tel = $tel;
                $param_morada = $morada;
                $param_morada_outra = $morada_outra;
                $param_notificacao = $notificacao;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    $_SESSION["return"] = "<p style='color: chartreuse'>Perfil atualizado com sucesso.</p>";
                } else {
                    printf("Error: %s.\n", mysqli_stmt_error($stmt));
                    echo "4";
                }
            }
            else{
                printf("Error: %s.\n", mysqli_stmt_error($stmt));
            }
        }
        // Close statement

    }

    // Close connection

}
// Informações do user
if ($id!=null) {
    // Prepare a select statement
    $sql = "SELECT nome, nif, email, telefone, img, morada, morada_outra, notificacao FROM users WHERE iduser = ?";

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
                mysqli_stmt_bind_result($stmt, $nome, $nif, $email, $telefone, $img, $morada, $morada_outra, $notificacao);
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
    <main class="main-int_LNEC main-int-particular">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int"><?php  if($_SESSION["tipo"]=="particular"){echo "PARTICULAR";}elseif ($_SESSION["tipo"]=="empresa"){echo "EMPRESA";} ?></h1>
                </div>
            </div>

            <div class="mid-content row-align">
                <div class="left_mid-content">
                    <div class="img-user">
                        <img src="imagens/<?php  if(!empty($img))echo $img; ?>"/>
                    </div>

                    <div class="profile-user">
                        <span class="name-user"><?php  if(!empty($nome))echo $nome; ?></span>

                    </div>

                    <div class="contact-user">
                        <span class="name-user"><strong>E-mail:</strong> <a href="mailto:loremipsumdolor@lnec.pt"><?php  if(!empty($email))echo $email; ?></a></span>
                        <span class="desc-user"><strong>Telefone:</strong> <a href="tel:+351<?php  if(!empty($telefone))echo $telefone; ?>"> +351 <?php  if(!empty($telefone))echo $telefone; ?></a> </span>
                    </div>

                    <div class="update-user">
                        <button action=""  onclick="editDataUser()">ACTUALIZAR DADOS</button>
                    </div>
                </div>

                <div class="right_mid-content">
                    <div class="box-infos-user" id="box-infos-user-particular">
                        <?php if(isset($_SESSION["return"])) { echo $_SESSION["return"]; unset($_SESSION["return"]); }?>
                        <div class="infos-user">
                            <div class="item-infos-user">
                                <span class="title-item-user">NOME</span>
                                <span class="object-item-user"><?php  if(!empty($nome))echo $nome; ?></span>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">NIF</span>
                                <span class="object-item-user"><?php  if(!empty($nif))echo $nif; ?></span>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">MORADA DE FATURAÇÃO*</span>
                                <span class="object-item-user"><?php  if(!empty($morada))echo $morada; ?></span>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">OUTRA MORADA</span>
                                <span class="object-item-user"><?php  if(!empty($morada_outra))echo $morada_outra; ?></span>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">TELEFONE</span>
                                <span class="object-item-user">+351 <?php  if(!empty($telefone))echo $telefone; ?></span>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">E-MAIL</span>
                                <span class="object-item-user"><?php  if(!empty($email))echo $email; ?></span>
                            </div>
                        </div>
                        <div class="accept-msg">
                            <div class="item-infos-accept">
                                <span class="title-item-user">QUER RECEBER NOTIFICAÇÕES POR EMAIL?</span>
                                <div>
                                    <input type="radio" id="sim" name="not"  <?php  if($notificacao==1) echo "checked"; ?>>
                                    <label for="sim">Sim</label>
                                    <input type="radio" id="nao"  name="not"  <?php  if($notificacao==0) echo "checked"; ?>>
                                    <label for="nao">Não</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-infos-user-edit" id="box-infos-user-edit">
                        <form method="post" enctype="multipart/form-data">
                        <div class="infos-user">
                            <div class="item-infos-user">
                                <span class="title-item-user">NOME</span>
                                <div class="input-item_form">
                                    <input type="text" name="nome" value="<?php  if(!empty($nome))echo $nome; ?>"/>
                                </div>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">NIF</span>
                                <div class="input-item_form">
                                    <input type="text" name="nif" value="<?php  if(!empty($nif))echo $nif; ?>" readonly/>
                                </div>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">MORADA DE FATURAÇÃO*</span>
                                <div class="input-item_form">
                                    <input type="text" name="morada" value="<?php  if(!empty($morada))echo $morada; ?>"/>
                                </div>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">OUTRA MORADA</span>
                                <div class="input-item_form">
                                    <input type="text" name="morada_outra" value="<?php  if(!empty($morada_outra))echo $morada_outra; ?>"/>
                                </div>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">TELEFONE</span>
                                <div class="input-item_form">
                                    <input type="tel" name="tel" value=" <?php  if(!empty($telefone))echo $telefone; ?>"/>
                                </div>
                            </div>
                            <div class="item-infos-user">
                                <span class="title-item-user">E-MAIL</span>
                                <div class="input-item_form">
                                    <input type="text" name="email" value="<?php  if(!empty($email))echo $email; ?>"/>
                                </div>
                            </div>
                            <div class="item-infos-user">
                                <div class="input-item_form">
                                    Selecione a foto de perfil: <input type="file" name="img" />
                                </div>
                            </div>
                        </div>
                        <div class="accept-msg d-flex">
                            <div class="item-infos-accept">
                                <span class="title-item-user">QUER RECEBER NOTIFICAÇÕES POR EMAIL?</span>
                                <div>
                                    <input type="radio" id="sim" name="notificacao" value="1" <?php  if($notificacao==1) echo "checked"; ?>>
                                    <label for="sim">Sim</label>
                                    <input type="radio" id="nao" name="notificacao" value="0" <?php  if($notificacao==0) echo "checked"; ?>>
                                    <label for="nao">Não</label>
                                </div>
                            </div>
                            <div class="item-infos-user">
                            <div class="update-user update-data-user">
                                <button  type="submit">GUARDAR</button>
                            </div>
                            </div>

                        </div>
                        </form>
                    </div>


                    <span class="adv-notification">* A morada deve ter os campos estruturados</span>
                </div>
            </div>

            <div class="bottom-content">
            </div>
        </section>

        <?php include "sidebar-int.php" ?>
    </main>



    <script>
        function editDataUser() {
            document.getElementById("box-infos-user-edit").style.display = "block";
            document.getElementById("box-infos-user-particular").style.display = "none";
        }

        function saveDataUser() {
            document.getElementById("box-infos-user-edit").style.display = "none";
            document.getElementById("box-infos-user-particular").style.display = "block";
        }
    </script>
</body>
    