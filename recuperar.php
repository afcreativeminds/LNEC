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
						<span class="item-breadcrumb_login active">RECUPERAR PASSWORD</span>
					</div>
				</div>
                <div class="box-form_LNEC">
<?php
if( empty($_GET['utilizador']) || empty($_GET['confirmacao']) ){
    echo"<p style='color: red'>Não é possível alterar a password: dados em falta</p><br><br>";
}
else {


    include "config.php";

    $user = $_GET['utilizador'];
    $hash = $_GET['confirmacao'];

    $q = $link->query("SELECT COUNT(*) FROM recuperacao WHERE utilizador = '$user' AND confirmacao = '$hash'");
    $row = $q->fetch_assoc();
    if ($row['COUNT(*)'] == "1") {
        // os dados estão corretos: eliminar o pedido e permitir alterar a password
        $link->query("DELETE FROM recuperacao WHERE utilizador = '$user' AND confirmacao = '$hash'");

        ?>

            <p>Insira uma password nova.</p>
            <form method="post" action="mudar_password.php"  onsubmit="return validar()">
                <?php if(isset($_SESSION["return"])) { echo $_SESSION["return"]; unset($_SESSION["return"]); }?>
                <div class="input-item_form">
                    <label>Palavra-passe <img id="olho" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="
                                             width="12px"/></label>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
                    <input type="password" name="password" id="password" required/>
                </div>
                <div class="input-item_form">
                    <label>Confirmar Palavra-passe</label>
                    <input type="password" name="password_confirm" id="password_confirm" required/>
                </div>
                <input type="email" name="email" value="<?php echo $user;?>" hidden/>
                <div class="input-item_form box-button_form">
                    <button  type="submit" value="Submit" >REGISTAR</button>

                </div>

            </form>

        <?php

    } else {
        echo "<p style='color: red'>Não é possível alterar a password: dados incorretos</p><br><br>";

    }
}
?>        <div class="new-recover_form">

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
<script src="js/js.js"></script>


</html>

