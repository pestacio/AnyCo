<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_adm_perfis.php
  *  @descrição	 Página de manutenção de perfis
  *  @package 	 Administration
  */
  require("app_inic.php");

  #
  $page_title = "Perfis";

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
        <p class="toolbar">
            <a class="create btn btn-default" href="javascript:" title="<?php echo $ui_add_record;?>"><?php echo $ui_add;?></a>
            <span class="alert"></span>
        </p>
        <table id="table"
               data-show-refresh="true"
               data-show-columns="true"
               data-search="true"
               data-pagination="true"
               data-only-info-pagination="false"
               data-query-params="queryParams"
               data-toolbar=".toolbar"
               data-undefined-text=""
               data-dbtable="WEB_ADM_PERFIS">
            <thead>
            <tr>
                <th data-field="ds_perfil"><?php echo $ui_designation;?></th>
                <th data-field="ds_tp_perfil"><?php echo $ui_type;?></th>
                <th data-field="estado" data-align="center" data-formatter="checkboxEstado" data-searchable="false"><?php echo $ui_state;?></th>
                <th data-field="descricao"><?php echo $ui_description;?></th>
                <th data-field="nr_ordem" data-visible="false" data-searchable="false"></th>
                <th data-field="tp_perfil" data-visible="false" data-searchable="false"><?php echo $ui_type;?></th>
                <th data-field="action"
                    data-align="center"
                    data-formatter="actionFormatter"
                    data-events="actionEvents"><?php echo $ui_action;?></th>
            </tr>
            </thead>
        </table>
    </div>

    <div id="modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo $ui_designation;?></label>
                        <input type="text" class="form-control" name="ds_perfil" placeholder="<?php echo $ui_designation;?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo $ui_type;?></label>
                        <select class="form-control" name="tp_perfil" placeholder="<?php echo $ui_type;?>">
<?php
                            echo Oracle\list_perfis();
?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?php echo $ui_state;?></label>
                        <input type="checkbox" name="estado" check_val="A" uncheck_val="I" placeholder="<?php echo $ui_state;?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo $ui_description;?></label>
                        <input type="text" class="form-control" name="descricao" placeholder="<?php echo $ui_description;?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $ui_cancel;?></button>
                    <button type="button" class="btn btn-primary submit"><?php echo $ui_save;?></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php
        # FOOTER
        $page->printFooter();
        
        # JAVASCRIPT
        $page->printJavaScript('Y');
    ?>

    <script>
        function checkboxEstado(value,row,index) {
            return '<input class="estado" rowid="'+row.id+'" type="checkbox"' + (value == 'A' ? " checked=\"checked\" " : "")  + '>';
        }        
        
        function listLang(value,row,index) {
            select_ = '<select>'+
<?php
            echo "'<option value=\"0\"'+(value=='0' ? \"selected\":\"\")+'>Português</option>'+";
            echo "'<option value=\"1\"'+(value=='1' ? \"selected\":\"\")+'>English</option>'+";
            echo "'<option value=\"2\"'+(value=='2' ? \"selected\":\"\")+'>Deutch</option>'";
?>
                   + '</select>';
            
            return select_;
        }        

        $(function () {
             $("#table").on('click','.estado', function () {
                    id_ = $(this).attr("rowid");
                    estado_ = 'I';
                    if ($(this).is(":checked"))
                        estado_ = 'A';

                    $.ajax({
                            url: API_URL+"?tabela="+$table_name,
                            data: "accao=UPT_ESTADO"+
                                  "&tabela="+$table_name+
                                  "&id="+id_+
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