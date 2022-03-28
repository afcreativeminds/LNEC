<?Php
session_start();

require("config.php");

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}


if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = array();
} //adiciona produto


if($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST"){
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


            <div class="bottom-content">
                <div class="search-result-show_LNEC">
                    <div class="content-result">
                        <table class="table table-strip">
                            <caption><h2 class="card-title" style="border-bottom: 2px solid #e20613;">Carrinho</h2></caption>
                            <thead>
                            <tr>
                                <td width="300" ></td>
                                <td width="300"><b>Produto</b></td>
                                <td width="300"><b>Pre&ccedil;o</b></td>
                                <td width="100"><b>Quantidade</b></th>
                                <td width="200"><b>SubTotal</b></td>

                            </tr>
                            </thead>
                            <form action="?acao=up" method="post">
                                <tfoot>
                                <tr>
                                    <td colspan="1"><input type="submit" value="Atualizar Carrinho" /></td>
                                </tr>

                                </tfoot>
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
                            foreach($_SESSION['carrinho'] as $id => $qtd) {

                                $sql = "SELECT *  FROM servico WHERE idservico = $id";

                                $result = $link->query($sql);
                                $ln = $result->fetch_assoc();
                                $sub   = number_format($ln['preco'] * $qtd, 2, ',', '.');
                                $nome = $ln['servico'];
                                $preco = number_format($ln['preco'], 2, ',', '.');
                                $total += $ln['preco'] * $qtd;
                                echo'
              <tr>      
				<td ><img src="logo.png" alt="" width="100px" height="50px"></td>	
                <td>' . $nome . '</td>
				<td>' . $preco . ' Euros</td>
                <td><input type="text" size="3" name="prod['.$id.']" value="'.$qtd.'" /></td>
                
                <td>' . $sub . ' Euros</td>
                <td ><a href="?acao=del&id=' . $id . '"><img src="imagens/delete.png" alt=""></a></td>
                            </tr>';
                                }
                                $total = number_format($total, 2, ',', '.');
                                echo '<br><tr>                         
                                    <td colspan="4"><b>Total</b></td>
                                    <td>'.$total. ' Euros</td>
                    </tr>';

                            }  ?>
                              </tbody>

                        </table>
                        </form>
                        <div class="bt-search-result_submit input-item_form button box-button_form">
                            <a href="<?php echo $_SESSION["continue_shoping"]; ?>" ><button  class="button-reset_LNEC">CONTINUAR COMPRANDO</button></a>&nbsp;
                            <a href="./checkout.php"><button  type="submit" class="button-submit_LNEC">PRÉ-ENCOMENDAR</button></a>
                        </div>



                    </div>
                </div>
            </div>
        </section>

        <?php include "sidebar-int.php" ?>
    </main>

<script>
    function voltar() {
    alert(window.history.back());
    }
</script>



</body>