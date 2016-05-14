<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    %DATE%
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 %FILENAME%
  *  @descrição	 Página de manutenção de %TABLE_DESIG%
  *  @package 	 Administration
  */
  require("app_inic.php");

  #
  $page_title = "%TABLE_DESIG%";

  $ui_add_record = "Adicionar %TABLE_DESIG%";
  $ui_update_record = "Atualizar %TABLE_DESIG%";
  $ui_delete_record = "Remover %TABLE_DESIG%";
  
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
               data-dbtable="%TABLENAME%">
            <thead>
            <tr>
                %COLS_HEADER%
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
                    %COLS_DIALOG%
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