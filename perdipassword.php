<?php
session_start();

  if(!empty($_POST) ){

    include "config.php";

    $user = $_POST['email'];
    $q = $link->query("SELECT * FROM users WHERE email = '$user'");

    if($link->affected_rows == 1 ){
      // o utilizador existe, vamos gerar um link único e enviá-lo para o e-mail

      // gerar a chave
      // exemplo adaptado de http://snipplr.com/view/20236/
      $chave = sha1(uniqid( mt_rand(), true));

      // guardar este par de valores na tabela para confirmar mais tarde
      $conf = $link->query("INSERT INTO recuperacao VALUES ('$user', '$chave')");

      if($link->affected_rows == 1 ){

        $link = "http://localhost/LNEC/recuperar.php?utilizador=$user&confirmacao=$chave";
          include("./phpmailer/src/PHPMailer.php");
          include("./phpmailer/src/SMTP.php");
          include("./phpmailer/src/OAuth.php");
          include("./phpmailer/src/Exception.php");

          $mailDestino = $_POST["email"];
          $nome = 'Suporte LNEC';
          $assunto = "Recuperação de password";
          $mensagem = "Olá '.$user.', visite este link '.$link";

        if(include("envio.php")){
            $_SESSION["return"] = "<p style='color: green'>Foi enviado um e-mail para o seu endereço.</p>";

        } else {

          $_SESSION["return"] = "<p style='color: red'>Houve um erro ao enviar o email!</p>";

        }

      } else {
          $_SESSION["return"] = "<p style='color: red'>Não foi possível.</p>";



      }
    } else {
        $_SESSION["return"] = "<p style='color: red'>Esse email não esta associado a nenhuma conta.</p>";

	}
  }
    // mostrar formulário de recuperação
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
                    <span class="item-breadcrumb_login">RECUPERAR PASSWORD</span>
                </div>
            </div>
            <div class="box-form_LNEC">
                <p>Por favor insira o seu email.</p>
                <form  method="POST">
                    <?php if(isset($_SESSION["return"])) { echo $_SESSION["return"]; unset($_SESSION["return"]); }?>
                    <div class="input-item_form">
                        <label>Email</label>
                        <input type="email" name="email" required/>
                    </div>
                    <div class="input-item_form box-button_form">
                        <button type="submit" value="Submit" >Recuperar</button>
                    </div>
                </form>
                <div class="new-recover_form">
                    <a href="new-register.php" class="link-new-recover_form">Novo registo </a> |
                    <a href="index.php" class="link-new-recover_form">Login</a>
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
