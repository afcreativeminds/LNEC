<?php
// Initialize the session
session_start();
require "validarNif.php";
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
    header("location: particular.php");
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nif  = $password = "";
$nif_err = $password_err = "";










// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if (empty(trim($_POST["nif"])) ) {
        $nif_err = "Por favor introduza um NIF";
    } else {
        if(validarNif::validateNIF($_POST["nif"])) {
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
                        $nif = trim($_POST["nif"]);
                    } else {
                        $nif_err = "Esse NIF não se encontra registrado.";

                    }
                } else {
                    echo "Oops! .";
                }
            }
        }else{   $nif_err = "Por favor introduza um NIF valido"; }
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, insira sua senha.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($nif_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT iduser, password FROM users WHERE nif = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nif);

            // Set parameters
            $param_nif = $nif;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store resultado
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind resultado variables
                    mysqli_stmt_bind_result($stmt, $id,$hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session

                            // Store data in session variables

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            if(validarNif::isEmpresa($nif)) $_SESSION["tipo"] = "empresa";
                            if(validarNif::isParticular($nif)) $_SESSION["tipo"] = "particular";
                            header("location: particular.php");
                        }

                        else{
                            // Display an error message if password is not valid
                            $password_err = "A senha que você digitou é válida.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $nif_err = "Nenhuma conta encontrada com esse nome de utilizador.";
                }
            } else{
                echo "Opa! Algo deu errado. Por favor, tente novamente mais tarde.";
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
						<span class="item-breadcrumb_login active">LOGIN</span>
						<span class="item-breadcrumb_login">AUTENTICAÇÃO GOV</span>
					</div>
				</div>
				<div class="box-form_LNEC">
					<p>Por favor indique-nos o seu Nº de Contribuinte e Palavra-passe para aceder à sua conta</p>
					<form  method="POST">
                        <?php if(isset($_SESSION["return"])) { echo $_SESSION["return"]; unset($_SESSION["return"]); }?>
						<div class="input-item_form">
							<label>Nº de Contribuinte</label>
							<input type="text" name="nif"/>
                            <p style="color: red"><?php echo (!empty($nif_err)) ? $nif_err : ''; ?> </p>
						</div>
						<div class="input-item_form">
							<label>Palavra-passe</label>
							<input type="password" name="password"/>
                            <p style="color: red"><?php echo (!empty($password_err)) ? $password_err : ''; ?> </p>
						</div>
						<div class="input-item_form box-button_form">
							<button type="submit" value="Submit" >ENTRAR</button>
						</div>
					</form>
					<div class="new-recover_form">
                        <a href="new-register.php" class="link-new-recover_form">Novo registo </a> |
                        <a href="perdipassword.php" class="link-new-recover_form">Recuperar Password</a>
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
