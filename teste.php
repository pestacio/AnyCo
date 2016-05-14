<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 teste.php
  *  @descrição	 Página de teste da aplicação
  *  @package 	 Application
  */
  require("app_inic.php");

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
               data-dbtable="TESTE">
            <thead>
            <tr>
                <th data-field="name"><?php echo $ui_name;?></th>
                <th data-field="stargazers_count"><?php echo $ui_starts;?></th>
                <th data-field="forks_count"><?php echo $ui_forks;?></th>
                <th data-field="description"><?php echo $ui_description;?></th>
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
                        <label><?php echo $ui_name;?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?php echo $ui_name;?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo $ui_starts;?></label>
                        <input type="number" class="form-control" name="stargazers_count" placeholder="<?php echo $ui_starts;?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo $ui_forks;?></label>
                        <input type="number" class="form-control" name="forks_count" placeholder="<?php echo $ui_forks;?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo $ui_description;?></label>
                        <input type="text" class="form-control" name="description" placeholder="<?php echo $ui_description;?>">
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