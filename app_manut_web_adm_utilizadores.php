<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.21
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_manut_web_adm_utilizadores.php
  *  @descrição	 Página de manutenção de Utilizadores
  *  @package 	 Administration
  */
  require("app_inic.php");

  #
  $page_title = "WEB_ADM_UTILIZADORES";

  $ui_add_record = "Adicionar Utilizadores";
  $ui_update_record = "Atualizar Utilizadores";
  $ui_delete_record = "Remover Utilizadores";
  
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
               data-dbtable="WEB_ADM_UTILIZADORES">
            <thead>
            <tr>
                
                <th data-field="id" data-visible="false" data-searchable="false">id</th>
                <th data-field="utilizador">utilizador</th>
                <th data-field="password">password</th>
                <th data-field="estado">estado</th>
                <th data-field="email">email</th>
                <th data-field="telemovel">telemovel</th>
                <th data-field="rhid">rhid</th>
                <th data-field="pede_pwd">pede_pwd</th>
                <th data-field="id_lang">id_lang</th>
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
                       <label>ID</label> 
                       <input type="hidden" class="form-control" name="ID" placeholder="ID"> 
                    </div> 

                    <div class="form-group"> 
                       <label>UTILIZADOR</label> 
                       <input type="text" class="form-control" name="UTILIZADOR" placeholder="UTILIZADOR"> 
                    </div> 

                    <div class="form-group"> 
                       <label>PASSWORD</label> 
                       <input type="text" class="form-control" name="PASSWORD" placeholder="PASSWORD"> 
                    </div> 
                    <div class="form-group"> 
                        <label>ESTADO</label>
                        <input type="checkbox" name="ESTADO" check_val="" uncheck_val="" placeholder="ESTADO">
                    </div>

                    <div class="form-group"> 
                       <label>EMAIL</label> 
                       <input type="text" class="form-control" name="EMAIL" placeholder="EMAIL"> 
                    </div> 

                    <div class="form-group"> 
                       <label>TELEMOVEL</label> 
                       <input type="text" class="form-control" name="TELEMOVEL" placeholder="TELEMOVEL"> 
                    </div> 

                    <div class="form-group"> 
                       <label>RHID</label> 
                       <select class="form-control" name="RHID" placeholder="RHID"> 
                          <option value=""></option> 
                       </select> 
                    </div> 
                    <div class="form-group"> 
                        <label>PEDE_PWD</label>
                        <input type="checkbox" name="PEDE_PWD" check_val="" uncheck_val="" placeholder="PEDE_PWD">
                    </div>

                    <div class="form-group"> 
                       <label>ID_LANG</label> 
                       <select class="form-control" name="ID_LANG" placeholder="ID_LANG"> 
                          <option value=""></option> 
                       </select> 
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