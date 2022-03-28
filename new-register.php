<?php

// Include config file
session_start();
require("config.php");
// Check if the user is



// Define variables and initialize with empty values
$nome = $nif = $email = $password = $password_confirm = $tel = "";
$nome_err = $nif_err = $email_err = $password_err = $password_confirm_err = $tel_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nif
    if (empty(trim($_POST["nif"]))) {
        $nif_err = "Por favor introduza um NIF";
    } else {
        // Prepare a select statement
        $sql = "SELECT nif FROM users WHERE nif = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nif);

            // Set parameters
            $param_nif = trim($_POST["nif"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $nif_err = "Esse NIF já se encontra registrado.";
                } else {
                    $nif = trim($_POST["nif"]);
                }
            } else {
                echo "Oops! .";
            }
        }
    }


    // Validate nome
    if (empty(trim($_POST["nome"]))) {
        $nome_err = "Por favor introduza o seu nome.";
    } else {

        $nome = trim($_POST["nome"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor introduza um email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT email FROM users WHERE email = ?";

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
        // Close statement
        mysqli_stmt_close($stmt);
    }


    // Validate telefone
    if (empty(trim($_POST["tel"]))) {
        $tel_err = "Por favor introduza um numero de telemóvel.";
    } else {

        $tel = trim($_POST["tel"]);

    }


    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor introduza uma password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password deve ter mais de 7 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["password_confirm"]))) {
        $password_confirm_err = "Por favor confirma a password.";
    } else {
        $password_confirm = trim($_POST["password_confirm"]);
        if (empty($password_err) && ($password != $password_confirm)) {
            $password_confirm_err = "Password não são iguais.";
        }
    }

    // Check input errors before inserting in database
    if (empty($nif_err) && empty($password_err) && empty($password_confirm_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (nome, nif, email, password, telefone) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_nome, $param_nif, $param_email, $param_password, $param_tel);

            // Set parameters
            $param_nif = $nif;
            $param_nome = $nome;
            $param_email = $email;
            $param_tel = $tel;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $_SESSION["return"] = "<p style='color: chartreuse'>Conta registrada com sucesso.</p>";
                header("location: index.php");
            } else {
                printf("Error: %s.\n", mysqli_stmt_error($stmt));
                echo "4";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

?>
<?php include "header.php" ?>
<body>
	 <header>
	 	<div class="container d-flex container-header_LNEC">
			<div class="logo_LNEC">
				<img src="assets/image/logo.png" class="logo-img_LNEC"/>
			</div>
			<nav class="menu_LNEC">
				<ul class="box-menu_LNEC d-flex">
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">Sobre Nós</a></li>
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">LNEC</a></li>
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">Investigação</a></li>
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">Serviços</a></li>
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">Divulgação<br>e Formação</a></li>
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">Carreiras</a></li>
					<li class="item-menu_LNEC d-flex"><a href="" class="link-menu_LNEC">Notícias</a></li>
				</ul>
			</nav>
		</div>
	</header>
 
	<main class="main_LNEC">
	    <section class="page-login_LNEC d-flex">
			<div class="box-login_LNEC">
				<div class="header-login_LNEC">
					<div class="breadcrumb-login_LNEC">
						<span class="item-breadcrumb_login active">NOVO REGISTRO</span>
					</div>
				</div>
				<div class="box-form_LNEC">
					<p>Preencha a informação abaixo para proceder à criação da sua área pessoal online LNEC.</p>
					<form method="post">
						<div class="input-item_form">
							<label>Nome</label>
							<input type="text" name="nome" required/>
                            <p style="color: red"><?php echo (!empty($nome_err)) ? $nome_err : ''; ?> </p>
						</div>
						<div class="input-item_form">
							<label>Nº de Contribuinte</label>
							<input type="number" name="nif" required/>
                            <p style="color: red"><?php echo (!empty($nif_err)) ? $nif_err : ''; ?> </p>
						</div>
                        <div class="input-item_form">
							<label>Endereço de e-mail</label>
							<input type="email" name="email" required/>
                            <p style="color: red"><?php echo (!empty($email_err)) ? $email_err: ''; ?> </p>
						</div>
						<div class="input-item_form">
							<label>Palavra-passe</label>
							<input type="password" name="password" required/>
                            <p style="color: red"><?php echo (!empty($password_err)) ? $password_err: ''; ?> </p>
						</div>
                        <div class="input-item_form">
							<label>Confirmar Palavra-passe</label>
							<input type="password" name="password_confirm"/>
                            <p style="color: red"><?php echo (!empty($password_confirm_err)) ? $password_confirm_err: ''; ?></p>
						</div>
						<div class="input-item_form">
							<label>Telefone *(+351)</label>
							<input type="text" name="tel" required/>
                            <p style="color: red"><?php echo (!empty($tel_err)) ? $tel_err: ''; ?></p>
						</div>
                        <div class="input-item_form">
                            <input type="checkbox" required/> <span>Li e aceito a <a href="http://www.lnec.pt/pt/politica-de-privacidade/">Política de Privacidade.</a></span>
                        </div>
						<div class="input-item_form box-button_form">
							<button type="submit"  value="Submit" >REGISTAR</button>

						</div>

					</form>
                    <div class="new-recover_form">

                        <a href="index.php" class="link-new-recover_form">Já tem contar? Entrar</a>
                    </div>
				</div>
			</div>
		</section>

		<aside>
			<div class="box-sidebar_LNEC">
				<div class="top-sidebar_LNEC">
					<div class="search-sidebar_LNEC">
						<i class="fa fa-search"></i>
					</div>

					<div class="language-sidebar_LNEC">
						<a href="" class="select-language">PT</a> |
						<a href="" class="select-language">EN</a>
					</div>
				</div>


				<div class="bottom-sidebar_LNEC">
					<div class="socials-sidebar_LNEC">
						<div class="title-socials_LNEC">
							<span>Siga-nos nas Redes Sociais</span>
						</div>
						<div class="socials-icons_LNEC">
							<a href="" class="item-social_LNEC">
								<i class="fab fa-youtube"></i>
							</a>
							<a href="" class="item-social_LNEC">
								<i class="fab fa-twitter"></i>
							</a>
							<a href="" class="item-social_LNEC">
								<i class="fab fa-linkedin"></i>
							</a>
							<a href="" class="item-social_LNEC">
								<i class="fab fa-facebook-f"></i>
							</a>
							<a href="" class="item-social_LNEC">
								<i class="fab fa-instagram"></i>
							</a>
						</div>
					</div>
				</div>
				
			</div>
		</aside>
    </main>
 
 

</body>

</html>
