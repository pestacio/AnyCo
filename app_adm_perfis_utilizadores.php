<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_adm_perfis_utilizadores.php
  *  @descrição	 Página de manutenção de perfis
  *  @package 	 Administration
  */
  require("app_inic.php");

  #
  $page_title = "Perfis Utilizadores";

  $ui_add_record = "Adicionar perfil";
  $ui_update_record = "Atualizar perfil";
  $ui_delete_record = "Remover perfil";
  
  # PAGE
  $page = new \Application\Page;
    
  # HEADER
  $page->printHeader("Y");

?>

<body>

    <?php
        # NAVBAR
        $page->printNavBar();
    ?>

    <!-- Begin page content -->
    <div class="container">
        <h1><?php echo $page_title?></h1>
        <div class="toolbar form-inline">
            <span class="alert"></span>
        </div>
        <table id="table" data-height="400" data-show-columns="true" data-dbtable="WEB_ADM_PERFIS_UTILIZADORES"></table>
    </div>


    <?php
        # FOOTER
        $page->printFooter();
        
        # JAVASCRIPT
        $page->printJavaScript('Y');
    ?>
    
    <script>

        var $table = $('#table');

        $(function () {
            buildTable($table, 20, 20);
        });

        function buildTable($el, cells, rows) {
            var i, j, row,
                    columns = [],
                    data = [];
<?php

        $db = new \Oracle\Db("JSON WevServ", "utilizador");
        $sql = "SELECT A.ID, A.DS_PERFIL ".
               "FROM WEB_ADM_PERFIS A ".
               "WHERE A.ESTADO = 'A' ".
               "ORDER BY A.ID ";

        $perfis = $db->execFetchAll($sql,"Ger Perfis");

        $sql = "SELECT A.ID, A.UTILIZADOR ".
               "FROM WEB_ADM_UTILIZADORES A ".
               "WHERE A.ESTADO = 'A' ".
               "ORDER BY A.ID ";

        $utilizadores = $db->execFetchAll($sql,"Ger Utilizadores");
        
        # CABEÇALHO
        echo "columns.push({ ".
             "  field: 'users', ".
             "  title: 'Utilizadores', ".
             "  sortable: false ".
             "});";
        
        foreach ($perfis as $key => $row) {
            echo "columns.push({ ".
                 "  field: 'p".$row['ID']."', ".
                 "  title: '".$row['DS_PERFIL']."', ".
                 "  sortable: true ,".
                 "  align: 'center' ".
                 "});";
    
        }

        
        foreach ($utilizadores as $key => $row) {
            echo "row = {};";
            echo "row['users'] = '".$row['UTILIZADOR']."';";
            foreach ($perfis as $key1 => $row1) {
                $sql = "SELECT A.ESTADO ".
                       "FROM WEB_ADM_PERFIS_UTILIZADORES A ".
                       "WHERE A.ID_UTILIZADOR = '".$row['ID']."' ".
                       "  AND A.ID_PERFIL = '".$row1['ID']."' ";
                $res = $db->execute($sql, "");
                $estado = $db->fetchRow();
                
                if ($estado['ESTADO'] == 'A')
                    echo "row['p".$row1['ID']."'] = '<input class=\"estado\" type=\"checkbox\" user=\"".$row['ID']."\" per=\"".$row1['ID']."\" checked=\"checked\">';";
                else
                    echo "row['p".$row1['ID']."'] = '<input class=\"estado\" type=\"checkbox\" user=\"".$row['ID']."\" per=\"".$row1['ID']."\">';";
            }
            echo "data.push(row);";
        }
        
?>
            $("#table").bootstrapTable('destroy').bootstrapTable({
                columns: columns,
                data: data,
                search: true,
                toolbar: '.toolbar',
                fixedColumns: true,
                fixedNumber: 1
            });
        }


        $(function () {
             $("#table").on('click','.estado', function () {
                    user_ = $(this).attr("user");
                    perfil_ = $(this).attr("per");
                    estado_ = 'I';
                    if ($(this).is(":checked"))
                        estado_ = 'A';
                    $.ajax({
                            url: API_URL+"?tabela="+$table_name,
                            data: "accao=UPDATE"+
                                  "&tabela="+$table_name+
                                  "&user="+user_+
                                  "&perfil="+perfil_+
                                  "&estado="+estado_,
                            type: "POST",
                            success: function () {
                                    $table.bootstrapTable("refresh");
                                    showAlert("<?php echo $msg_state_update_sucess;?>!", "success");
                            },
                            error: function () {
                                    showAlert("<?php echo $msg_state_update_error;?>!", "danger");
                            }
                    })                 
             })        
        });    
    </script>
</body>
</html>