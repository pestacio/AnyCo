<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.22
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_manut_web_adm_perfis.php
  *  @descrição	 Página de manutenção de Perfis
  *  @package 	 Administration
  */
  require("app_inic.php");

  #
  $page_title = "Perfis";

  $ui_add_record = "Adicionar Perfis";
  $ui_update_record = "Atualizar Perfis";
  $ui_delete_record = "Remover Perfis";
  
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
                
                <th data-field="id" data-visible="false" data-searchable="false">id</th>
                <th data-field="ds_perfil">ds_perfil</th>
                <th data-field="tp_perfil">tp_perfil</th>
                <th data-field="estado" data-visible="false" data-searchable="false">estado</th>
                <th data-field="descricao">descricao</th>
                <th data-field="nr_ordem">nr_ordem</th>
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
                       <input type="hidden" class="form-control" name="id" placeholder="id"> 
                    </div> 

                    <div class="form-group"> 
                       <label>ds_perfil</label> 
                       <input type="text" class="form-control" name="ds_perfil" placeholder="ds_perfil"> 
                    </div> 

                    <div class="form-group"> 
                       <label>tp_perfil</label> 
                       <select class="form-control" name="tp_perfil" placeholder="tp_perfil"> 
                          <option value=""></option> 
                          <?php echo $db->listDominio('TIPO_PERFIL','');?> 
                       </select> 
                    </div> 

                    <div class="form-group"> 
                       <input type="hidden" class="form-control" name="estado" placeholder="estado"> 
                    </div> 

                    <div class="form-group"> 
                       <label>descricao</label> 
                       <input type="text" class="form-control" name="descricao" placeholder="descricao"> 
                    </div> 

                    <div class="form-group"> 
                       <label>nr_ordem</label> 
                       <input type="text" class="form-control" name="nr_ordem" placeholder="nr_ordem"> 
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

</body>
</html>