<?php

// Include config file
session_start();
require("config.php");


if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)){
    header("location: logout.php");
}


$id = $_SESSION["id"];
// Atualizar dados
?>
<?php include "header.php" ?>
<body>
    <main class="main-int_LNEC main-documentacao">
        <?php include "side-menu.php" ?> 

        <section class="content-int_LNEC">
            <div class="top-content">
                <div class="breadcrumb-int">
                    <a href="" class="item-breadcrumb-int">ÁREA DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">INFORMAÇÕES DO CLIENTE</a> > <a href="" class="item-breadcrumb-int">PARTICULAR</a>
                </div>

                <div class="title-int">
                    <h1 class="h1-int">DOCUMENTAÇÃO</h1>
                    <h2 class="h2-int">DOCUMENTOS DISPONÍVEIS</h2>
                </div>
            </div>

            <div class="mid-content">
                <div class="all_mid-content" style="width: 70%;">
                <div class="search-result-show_LNEC">
                        <div class="content-result">
                            <table class="search-result-table_LNEC">
                                <tr class="rowhd-item_table">
                                    <th>LISTAGEM DE DOCUMENTOS</th>
                                </tr>
                                <?php
                                $limite = $_GET["pag"] * 10;
                                $inicio = $limite-10;
                                $sql = "SELECT documentos FROM documentos INNER JOIN evento_particular ON documentos.id_operacao_evento = evento_particular.idevento_particular where user_iduser = $id and diretorio = 'upload/' LIMIT 10 OFFSET $inicio";



                                if ($stmt = mysqli_prepare($link, $sql)) {

                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                mysqli_stmt_store_result($stmt);

                                // Check if username exists, if yes then verify password
                                if (mysqli_stmt_num_rows($stmt) >= 1) {
                                // Bind resultado variables
                                mysqli_stmt_bind_result($stmt, $doc);
                                while (mysqli_stmt_fetch($stmt)){


                                ?>
                                <tr class="row-item_table">
                                    <td>
                                        <div class="title-item_table">
                                            <span class="Txttitle-item_table"><?php echo $doc; ?> | Ótica e radiação</span>
                                        </div>
                                        <div class="desc-item_table">
                                            <span class="Txtdesc-item_table">Luxímetros</span>
                                        </div>
                                        <div class="desc-item_table">
                                            <span class="Txtdesc-item_table item_area-doc">Unidade de Fotometria e Colorimetria | <a href="mailto:ubd-aeq@lnec.pt">ubd-aeq@lnec.pt</a></span>
                                        </div>
                                    </td>
                                    <td class="btn-options">
                                        <div class="expand-item_table">
                                            <a href="" onclick="javascript:window.open('upload/<?php echo $doc; ?>')" class="expand-icon_table" target="_blank">
                                                    <i class="fas fa-eye"></i> 
                                            </a>

                                        </div>
                                        <div class="expand-item_table">
                                            <a href="download.php?file=<?php echo $doc; ?>" class="expand-icon_table" >
                                                    <i class="fas fa-download"></i> 
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                    <?php
                                        }
                                    }
                                 }
                                }
                                ?>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $resultado = $link->query("SELECT * FROM documentos");
            $final =$resultado->num_rows;
            $pagina = ($final/10) % 10;
            if($final<=10){
                $pagina=1;
            }
            $i=1;
            while ($i <= $pagina) {
                echo'<a href="documentacao.php?pag='.$i.'" style="  padding: 5px;background-color: red;color: white;border-radius: 50%;text-decoration: none;
">'.$i.'</a>&nbsp;&nbsp;';
                $i++;
            }
            ?>
        </section>

        <?php include "sidebar-int.php" ?>
    </main>


</body>
    