<?Php
session_start();

require("config.php");

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}

$_SESSION["continue_shoping"] = $_SERVER["REQUEST_URI"];
if($_SERVER["REQUEST_URI"] == "http://localhost/LNEC/ensaios-calibracoes.php"){
    unset($_SESSION["continue_shoping"]);
}
if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = array();
} //adiciona produto
if($_SERVER["REQUEST_METHOD"] == "GET"){
if(isset($_GET['acao'])){
    //ADICIONAR CARRINHO
    if($_GET['acao'] == 'add'){
        $id = intval($_GET['id']);
        if(!isset($_SESSION['carrinho'][$id])){
            $_SESSION['carrinho'][$id] = 1;
        }
    } //REMOVER CARRINHO

    if($_GET['acao'] == 'del'){
        $id = intval($_GET['id']);
        if(isset($_SESSION['carrinho'][$id])){
            unset($_SESSION['carrinho'][$id]);

        }
    } //ALTERAR QUANTIDADE
    if($_GET['acao'] == 'up' && count($_SESSION['carrinho']) != 0){
        if(is_array($_POST['prod'])){
            foreach($_POST['prod'] as $id => $qtd){
                $id  = intval($id);
                $qtd = intval($qtd);
                if(!empty($qtd) || $qtd <> 0){
                    $_SESSION['carrinho'][$id] = $qtd;
                }else{
                    unset($_SESSION['carrinho'][$id]);
                }
            }
        }
        $consultaq = "UPDATE pedido SET quantidade='$qtd'where produto_id='$id' ";
    }

    }
}


?>

<?php include "header.php" ?>

<body>
    <main class="main-int_LNEC main-int-ensaios-calibracoes">
        <?php include "side-menu.php" ?>

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">PEDIDO DE SERVIÇOS</h1>
                    <h2 class="h2-int">ENSAIOS OU CALIBRAÇÕES</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content">
                    <div class="tabs_LNEC">
                        <div class="tab">
                            <button class="tablinks active" onclick="openTab(event, 'tab1')">PESQUISA ORIENTADA</button>
                            <button class="tablinks" onclick="openTab(event, 'tab2')">LISTAR</button>
                            <button class="tablinks" onclick="openTab(event, 'tab3')">PESQUISA LIVRE</button>
                        </div>



                        <div id="tab1" class="tabcontent" style="display: block;">
                            <form method="get">
                                <div class="input-item_form fontawesome">
                                    <select class="form-select" aria-label="Default select example" name="ambito">
                                        <option value="0">Âmbito</option>
                                        <?php
                                        $sql = "SELECT * FROM servico_ambito";
                                        $result = $link->query($sql);
                                        $result->num_rows;
                                        if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['servico_ambito']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>

                                    <select class="form-select" aria-label="Default select example" name="area">
                                        <option value="0">Área de Intervenção</option>
                                        <?php
                                        $sql = "SELECT * FROM servico_area_intervencao";
                                        $result = $link->query($sql);
                                        $result->num_rows;
                                        if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['servico_area_intervencao']; ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                    <select class="form-select" aria-label="Default select example" name="material">
                                        <option value="0"> Material/Produto/Ensaio</option>
                                        <?php
                                        $sql = "SELECT * FROM servico_material_produto";
                                        $result = $link->query($sql);
                                        $result->num_rows;
                                        if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['servico_material_produto']; ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                    <div class="input-item_form box-button_form">
                                        <button type="reset" value="Reset" class="button-reset_LNEC">LIMPAR</button>
                                        <button type="submit" value="Submit" class="button-submit_LNEC">PESQUISAR</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="tab2" class="tabcontent">
                            <form method="get" >
                                <div class="input-item_form">
                                    <select class="select" name="ambito">
                                        <option value="0">Âmbito</option>
                                        <?php
                                        $sql = "SELECT * FROM servico_ambito";
                                        $result = $link->query($sql);
                                        $result->num_rows;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {

                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['servico_ambito']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </select>

                                    <select class="select" name="area">
                                        <option value="0">Área de Intervenção</option>
                                        <?php
                                        $sql = "SELECT * FROM servico_area_intervencao";
                                        $result = $link->query($sql);
                                        $result->num_rows;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {

                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['servico_area_intervencao']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                    <select class="select" name="material">
                                        <option value="0"> Material/Produto/Ensaio</option>
                                        <?php
                                        $sql = "SELECT * FROM servico_material_produto";
                                        $result = $link->query($sql);
                                        $result->num_rows;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {

                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['servico_material_produto']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-item_form box-button_form">
                                    <button type="reset"  value="Reset" class="button-reset_LNEC">LIMPAR</button>
                                    <button type="submit"  value="Submit" class="button-submit_LNEC">PESQUISAR</button>
                                </div>
                            </form>
                        </div>

                        <div id="tab3" class="tabcontent">
                            <form method="get">
                                <div class="input-item_form">
                                    <input class="select-form_LNEC" name="pesquisar" placeholder="Pesquisar aqui!">
                                </div>
                                <div class="input-item_form box-button_form">
                                    <button type="reset"  value="Reset" class="button-reset_LNEC">LIMPAR</button>
                                    <button type="submit" value="Submit" class="button-submit_LNEC">PESQUISAR</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
                <?php if (isset($_SESSION["return"])) {
                    echo $_SESSION["return"];
                    unset($_SESSION["return"]);
                } ?>
            </div>

            <div class="bottom-content">
                <div class="search-result-show_LNEC">
                    <div class="content-result">
                        <?php if (isset($_SESSION["return"])) {
                            echo $_SESSION["return"];
                            unset($_SESSION["return"]);
                        } ?>
                        <table class="search-result-table_LNEC" >
                            <tr class="rowhd-item_table">
                                <th>LISTAGEM DE ENSAIOS E CALIBRAÇÕES:</th>

                            </tr >

                            <?php

                            if ($_SERVER["REQUEST_METHOD"] == "GET") {

                                if(
                                    (isset($_GET['ambito'])and $_GET['ambito'] !="" &&
                                        isset($_GET['area'])and $_GET['area'] !="" &&
                                        isset($_GET['material'])and $_GET['material'] !="") ||
                                    (isset($_GET['pesquisar'])and $_GET['pesquisar'] !="")


                                ){

                                // Prepare an insert statement
                                 if(isset($_GET['pesquisar'])){
                                     $sql = "SELECT idservico, servico, preco, descricao, descricao_2, unidade FROM servico WHERE servico like ?";

                                 }
                                 if(isset($_GET['ambito']) && isset($_GET['area']) && isset($_GET['material'])){
                                     $sql = "SELECT idservico, servico, preco, descricao, descricao_2, unidade FROM servico WHERE servico_ambito_id = ? and servico_area_intervencao_id = ? and servico_material_produto_id = ?";

                                 }

                                if ($stmt = mysqli_prepare($link, $sql)) {
                                    // Bind variables to the prepared statement as parameters
                                    if(isset($_GET['pesquisar'])){
                                        mysqli_stmt_bind_param($stmt, "s", $param_1);
                                            $param_1 = "{$_GET['pesquisar']}%";

                                        }


                                    if(isset($_GET['ambito']) && isset($_GET['area']) && isset($_GET['material'])){
                                        mysqli_stmt_bind_param($stmt, "sss", $param_1, $param_2, $param_3);

                                        // Set parameters
                                            $param_1 = $_GET['ambito'];
                                            $param_2 = $_GET['area'];
                                            $param_3 = $_GET['material'];

                                    }

                                    // Attempt to execute the prepared statement
                                    if (mysqli_stmt_execute($stmt)) {
                                        // Redirect to login page
                                        mysqli_stmt_store_result($stmt);

                                        // Check if username exists, if yes then verify password
                                        if (mysqli_stmt_num_rows($stmt) >= 1) {
                                            // Bind resultado variables
                                            mysqli_stmt_bind_result($stmt, $id_v,$nome, $preco, $descricao, $descricao_2, $unidade);
                                            while (mysqli_stmt_fetch($stmt)){


                                            ?>
                                            <tr class="row-item_table justify-content-between" id="tabela">
                                                <td>
                                                    <div class="title-item_table" style="margin-right: 290px;">
                                                        <span class="Txttitle-item_table"><?php echo $nome; ?></span>
                                                    </div>
                                                    <div class="desc-item_table">
                                                        <span class="Txtdesc-item_table"><?php echo $descricao; ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="expand-item_table">
                                                        <a  onclick="showHide<?php echo $id_v; ?>()" id="<?php echo "show".$id_v; ?>"   class="expand-icon_table">
                                                            <i class="fas fa-plus"></i>

                                                        </a>
                                                    </div>

                                                </td>

                                                <td class="hide-data" id="container_show<?php echo $id_v; ?>">
                                                    <div class="main-data">
                                                        <div class="infos-hide">
                                                            <span class="Txtdesc-item_table">Instrumentos de medição e outros   </span>
                                                            <p class="Txtdesc-item_table"><?php echo $descricao_2; ?></p>
                                                            <p class="Txtdesc-item_table"><?php echo $unidade; ?> | <span style="color:red;">ubc-aeq@lnec.pt</span></p>
                                                        </div>

                                                        <div class="Txtdesc-item_table">
                                                            <i class="fas fa-eye"></i>
                                                        </div>

                                                        <div class="Txtdesc-item_table">
                                                            <i class="fas fa-download"></i>
                                                        </div>

                                                        <div class="Txtdesc-item_table">
                                                            <p><?php echo $preco; ?>€</p>
                                                        </div>

                                                        <div class="Txtdesc-item_table">
                                                            <i class="far fa-window-close" ></i>
                                                        </div>
                                                    </div>

                                                </td>
                                                    <td class="input-item_form button box-button_form" style=" margin-top: 0px;">

                                                                    <a href="carrinho.php?id=<?php echo $id_v; ?>&acao=add"><button  class="button-submit_LNEC">Pre-encomendar</button></a>

                                                    </td>

                                            </tr>
                                                <script>

                                                    function showHide<?php echo $id_v; ?>(){
                                                        var link = document.getElementById('<?php echo 'show'.$id_v;?>');
                                                        var container = document.getElementById('container_<?php echo 'show'.$id_v;?>');

                                                        link.addEventListener('click', function(){
                                                            if(container.style.display === 'none'){
                                                                container.style.display = 'flex';
                                                            } else {
                                                                container.style.display = 'none';
                                                            }
                                                        });
                                                    }


                                                </script>
                            <?php
                                            }
                                        }else{ echo '<tr><th style="color: red">Não foram encontrados ensaios disponíveis para a sua pesquisa. Por favor tente novamente.</th></tr >';}
                                    } else {
                                        printf("Error: %s.\n", mysqli_stmt_error($stmt));
                                        echo "4";
                                    }
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }else{ echo '<tr><th style="color: red">Nenhuma categoria selecionada.</th></tr >';}
                            // Close connection
                            //mysqli_close($link);
                            }else{ echo '<tr><th style="color: red">Sem Pesquisa!</th></tr >';}
                            ?>
                        </table>
                        <div class="bt-search-result_submit input-item_form button box-button_form">
                            <a href="carrinho.php"><button  type="submit" class="button-submit_LNEC">IR PARA CARRINHO</button></a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <?php include "sidebar-int.php" ?>
    </main>






</body>