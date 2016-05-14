<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_adm_utilizadores.php
  *  @descrição	 Página de geração de páginas para tabelas de manutenção
  *  @package 	 Administration
  */
  require("app_inic.php");

  $table_name = @$_REQUEST['table_name'];
  $table_desig =  @$_REQUEST['table_desig'];
  $column_name =  @$_REQUEST['column_name'];
  $display_type =  @$_REQUEST['display_type'];
  $file_template =  @$_REQUEST['file_template'];

  
  #
  $page_title = "Geração de tabelas";

  $msg_state_file_generate_sucess = "Ficheiro gerado com sucesso";
  $msg_state_file_generate_error = "Ficheiro gerado com erro";

  # PAGE
  $page = new \Application\Page;
    
  # HEADER
  $page->printHeader("Y");

?>

<body>

    <?php
        # NAVBAR
        # $page->printNavBar();
        include("app_navbar.php");
    ?>
    <!-- Begin page content -->
    <div class="container">
        <h1><?php echo $page_title?></h1>

        <form class="form-horizontal">
        <p class="toolbar">
            <span class="alert"></span>
        </p>
        <div class="row">       
            <div class="col-md-6">
                <div class="form-group">
                    <label for="table_name" class="control-label">Tabelas</label>
                    <div>
                        <select id="table_name" name="table_name" class="form-control">
                            <?php
                                $db = new \Oracle\Db("tables", $sess->username);
                                $sql = "SELECT TABLE_NAME FROM USER_TABLES ORDER BY 1";
                            	$res = $db->execFetchAll($sql, "Table Query");
                                foreach ($res as $row) {
                                    if ($table_name == '')
                                        $table_name == $row['TABLE_NAME'];
                                    
                                    if ($table_name == $row['TABLE_NAME'])
                                        echo "<option value='".$row['TABLE_NAME']."' selected>".$row['TABLE_NAME']."</option>";
                                    else
                                        echo "<option value='".$row['TABLE_NAME']."'>".$row['TABLE_NAME']."</option>";
                                }
                            ?>
                            
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="file_template" class="control-label">Designação</label>
                    <div>
                        <input type="text" id="table_desig" name="table_desig" class="form-control" value="<?php echo $table_desig;?>" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="colunas" class="control-label">Colunas</label>
                    <div> 
                        <table class="table" id="table_cols"></table>
                    </div>
                </div>

            </div>
            <div class="col-md-1"></div>
            
            <div class="col-md-5">
                <div class="form-group">
                    <label for="file_template" class="control-label">Ficheiro Template</label>
                    <div>
                        <input type="text" id="file_template" name="file_template" class="form-control" value="app_manut_table_template.php">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10 text-right">
                        <button type="button" id="gera" class="btn btn-primary">Gerar Ficheiro</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <?php
        # FOOTER
        $page->printFooter();
        
        # JAVASCRIPT
        $page->printJavaScript('Y');
    ?>

    <script>
        $(function () {
            
            function get_cols() {
                    
                    $("#table_desig").val("");
                    
                    $.ajax({
                            url: "app_gera_tab_det.php",
                            data: "accao=TABLE_COLS"+
                                  "&table_name="+$("#table_name").val(),
                            type: "POST",
                            success: function (result) {
                                    $("#table_cols").html(result);
                            },
                            error: function () {
                                    showAlert("<?php echo $msg_state_update_error;?>!", "danger");
                            }
                    })                 
            }
            
            $("#gera").click(function() {
            
                    colunas_ = [];
                    $("[name=column_name]").each(function(){
                        colunas_.push($(this).val());
                    });

                    display_type_ = [];
                    $("[name=display_type]").each(function(){
                        display_type_.push($(this).val());
                    });
            
                    $.ajax({
                            url: "app_gera_tab_det.php",
                            data: "accao=GERA_FX"+
                                  "&table_name="+$("#table_name").val()+
                                  "&table_desig="+$("#table_desig").val()+
                                  "&column_name="+colunas_+
                                  "&display_type="+display_type_+
                                  "&file_template="+$("#file_template").val(),
                            type: "POST",
                            async: false,
                            success: function () {
                                    showAlert("<?php echo $msg_state_file_generate_sucess;?>!", "success");
                            },
                            error: function () {
                                    showAlert("<?php echo $msg_state_file_generate_error;?>!", "danger");
                            }
                    })                 
             });
             
            $("#table_name").change(function(){
                 get_cols();
            });
            
            get_cols();

        });    
    </script>
</body>
</html>