<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_base_classes.php
  *  @descrição	 Classes estruturais da Aplicação
  *  @package 	 Application
  */

  namespace Application;


 /**
   * @package Application
   * @subpackage Page
   */
  class Page {
      
        /**
         * Print the top section of each HTML page
         * @param string $BootTable - Y/N uses bootstrap table
         */
        public function printHeader($BootTable = 'N') {
            
            global $app_favicon;
            global $app_title;
            global $app_description;
            global $app_author;
                
            echo '
                <!DOCTYPE html>
                <html lang="en">
                  <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
                    <meta name="description" content="'.$app_description.'">
                    <meta name="author" content="'.$app_author.'">
                    <link rel="icon" href="'.$app_favicon.'" rel="icon" type="image/x-icon">

                    <title>'.$app_title.'</title>

                    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- SmartMenus jQuery Bootstrap Addon CSS -->
<link href="_css/jquery.smartmenus.bootstrap.css" rel="stylesheet">

                    <style>
                        /* Sticky footer styles
                        -------------------------------------------------- */
                        html {
                          position: relative;
                          min-height: 100%;
                        }
                        body {
                          /* Margin bottom by footer height */
                          margin-bottom: 60px;
                        }
                        .footer {
                          position: absolute;
                          bottom: 0;
                          width: 100%;
                          /* Set the fixed height of the footer here */
                          height: 60px;
                          background-color: #f5f5f5;
                        }


                        /* Custom page CSS
                        -------------------------------------------------- */
                        /* Not required for template or sticky footer method. */

                        body > .container {
                          padding: 60px 15px 0;
                        }
                        .container .text-muted {
                          margin: 20px 0;
                        }

                        .footer > .container {
                          padding-right: 15px;
                          padding-left: 15px;
                        }

                        code {
                          font-size: 80%;
                        }
                    </style>';

            if ($BootTable == 'Y') {
                echo '  <!-- SO ATIVO COM TABELAS -->
                        <!-- Latest compiled and minified CSS -->
                        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/bootstrap-table.min.css">
                        <style>
                            .update {
                                color: #333;
                                margin-right: 5px;
                            }
                            .remove {
                                color: red;
                                margin-left: 5px;
                            }
                            .alert {
                                padding: 0 14px;
                                margin-bottom: 0;
                                display: inline-block;
                            }
                        </style>
                        <!------------------------------------->';
                echo '<link rel="stylesheet" href="//rawgit.com/wenzhixin/bootstrap-table-fixed-columns/master/bootstrap-table-fixed-columns.css">';
            }
            
            echo '  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                    <!--[if lt IE 9]>
                      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                    <![endif]-->';

            echo '</head>';
            
        }


	/**
	 * Print the bottom of each HTML page
	 */
	public function printNavBar() {
            
            global $app_title;
            
            echo ' <!-- Fixed navbar -->
                   <nav class="navbar navbar-default navbar-fixed-top">
                     <div class="container">
                       <div class="navbar-header">
                         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                           <span class="sr-only">Toggle navigation</span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                         </button>
                         <a class="navbar-brand" href="#">'.$app_title.'</a>
                       </div>
                       <div id="navbar" class="collapse navbar-collapse">
                         <ul class="nav navbar-nav">
                           <li class="active"><a href="#">Home</a></li>
                           <li><a href="#about">About</a></li>
                           <li><a href="#contact">Contact</a></li>
                           <li class="dropdown">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administração <span class="caret"></span></a>
                             <ul class="dropdown-menu">
                               <li><a href="app_adm_utilizadores.php">Utilizadores</a></li>
                               <li><a href="app_adm_perfis.php">Perfis</a></li>
                               <li><a href="app_adm_perfis_utilizadores.php">Perfis Utilizadores</a></li>
                               <li role="separator" class="divider"></li>
                               <li class="dropdown-header">Nav header</li>
                               <li><a href="#">Separated link</a></li>
                               <li><a href="#">One more separated link</a></li>
                             </ul>
                           </li>
                         </ul>
                       </div><!--/.nav-collapse -->
                     </div>
                   </nav>';

            
        } 
       
	/**
	 * Print the bottom of each HTML page
	 */
	public function printFooter() {

            echo '  <footer class="footer">
                      <div class="container">
                        <p class="text-muted">Place sticky footer content here.</p>
                      </div>
                    </footer>';
            
        }        
        
        
        public function printJavaScript($BootTable = 'N') {

            
            echo '  <!-- Bootstrap core JavaScript
                    ================================================== -->
                    <!-- Placed at the end of the document so the pages load faster -->
                    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
                    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>';
            
            if ($BootTable == 'Y') {

                global $ui_update_record;
                global $ui_delete_record;
                global $msg_record_insert_sucess;
                global $msg_record_insert_error;
                global $msg_record_update_sucess;
                global $msg_record_update_error;
                global $msg_record_delete_sucess;
                global $msg_record_delete_error;
                global $msg_confirm_delete_record;
                
                        
                echo '  <!-- SO ATIVO COM BOOTSTRAP TABLES -->
                        <!-- Latest compiled and minified JavaScript -->
                        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/bootstrap-table.min.js"></script>

                        <!-- Latest compiled and minified Locales -->
                        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/locale/bootstrap-table-pt-PT.min.js"></script>
                        <!-------------------------->';
                
                echo '  <script src="//rawgit.com/wenzhixin/bootstrap-table-fixed-columns/master/bootstrap-table-fixed-columns.js"></script>';

                echo '	<script>
                            var API_URL = "'.APP_URL_DB_CONTROLER.'";
                            var $table_name = $("#table").attr("data-dbtable");
                            var $table = $("#table").bootstrapTable({url: API_URL+"?tabela="+$table_name}),
                                    $modal = $("#modal").modal({show: false}),
                                    $alert = $(".alert").hide();

                            $(function () {
                                    //
                                    // create event
                                    $(".create").click(function () {
                                            $modal.data("id","");
                                            showModal($(this).attr("title"));
                                    });
                                    $modal.find(".submit").click(function () {
                                            var row = {};
                                            $modal.find("input[name]").each(function () {
                                                    row[$(this).attr("name")] = $(this).val();
                                            });
                                            
                                            // leitura dos valores para gravar na bd
                                            $modal.find(":input").not(":button").each(function(){
                                                name = $(this).attr("name");
                                                if ($(this).attr("type") == "text") {
                                                    row[name] = $(this).val();
                                                } else if ($(this).attr("type") == "checkbox") {
                                                    if ($(this).is(":checked"))
                                                        row[name] = $(this).attr("check_val");
                                                    else
                                                        row[name] = $(this).attr("uncheck_val");
                                                } else if ($(this).is("select")) {
                                                    row[name] = $(this).val();
                                                }
                                            });

                                            if (typeof $modal.data("id") != "undefined")
                                                    id_ = $modal.data("id");
                                            else
                                                    id_ = "";

                                            accao_ = "INSERT";
                                            if (id_ != "")
                                                    accao_ = "UPDATE";

                                            $.ajax({
                                                    url: API_URL,
                                                    type: "POST",
                                                    //contentType: "application/json",
                                                    data: "accao="+accao_+
                                                          "&tabela="+$table_name+
                                                          "&id="+id_+
                                                          "&data="+JSON.stringify(row),
                                                    success: function () {
                                                            $modal.modal("hide");
                                                            $table.bootstrapTable("refresh");
                                                            showAlert(($modal.data("id") ? "'.$msg_record_update_sucess.'!" : "'.$msg_record_insert_sucess.'!"), "success");
                                                    },
                                                    error: function () {
                                                            $modal.modal("hide");
                                                            showAlert(($modal.data("id") ? "'.$msg_record_update_error.'!" : "'.$msg_record_insert_error.'!"), "danger");
                                                    }
                                            });
                                    });
                            });
                            function queryParams(params) {
                                    return {};
                            }
                            function actionFormatter(value) {
                                    return [
                                            \'<a class="update" href="javascript:" title="'.$ui_update_record.'"><i class="glyphicon glyphicon-edit"></i></a>\',
                                            \'<a class="remove" href="javascript:" title="'.$ui_delete_record.'"><i class="glyphicon glyphicon-remove-circle"></i></a>\',
                                    ].join("");
                            }
                            // update and delete events
                            window.actionEvents = {
                                    "click .update": function (e, value, row) {
                                                    showModal($(this).attr("title"), row);
                                    },
                                    "click .remove": function (e, value, row) {
                                            if (confirm("'.$msg_confirm_delete_record.'")) {
                                                    $.ajax({
                                                            url: API_URL+"?tabela="+$table_name,
                                                            data: "accao=DELETE"+
                                                                  "&tabela="+$table_name+
                                                                  "&id="+row.id,
                                                            type: "POST",
                                                            success: function () {
                                                                    $table.bootstrapTable("refresh");
                                                                    showAlert("'.$msg_record_delete_sucess.'!", "success");
                                                            },
                                                            error: function () {
                                                                    showAlert("'.$msg_record_delete_error.'!", "danger");
                                                            }
                                                    })
                                            }
                                    }
                            };
                            function showModal(title, row) {
                                    row = row || {};
                                    $modal.data("id", row.id);
                                    $modal.find(".modal-title").text(title);

                                    // carregamento da janela de edição
                                    if (row.id) {
                                        $modal.find(":input").not(":button").each(function(){
                                            name = $(this).attr("name");
                                            if ($(this).attr("type") == "text") {
                                                    $(this).val(row[name]);
                                            } else if ($(this).attr("type") == "checkbox") {
                                                    $(this).prop("checked",false);
                                                    if (row[name] == $(this).attr("check_val")) { 
                                                        $(this).prop("checked",true);
                                                    }
                                            } else if ($(this).is("select")) {
                                                    $(this).val(row[name]);
                                            }
                                        });
                                    // carregamento da janela de inserção
                                    } else {
                                        $modal.find("input").each(function(){
                                                $(this).val("");
                                        });
                                    }
                                    $modal.modal("show");
                            }
                            function showAlert(title, type) {
                                    $alert.attr("class", "alert alert-" + type || "success")
                                              .html("<i class=\'glyphicon glyphicon-check\'></i> " + title).show();
                                    setTimeout(function () {
                                            $alert.hide();
                                    }, 3000);
                            }
                    </script>';
                
echo '<!-- SmartMenus jQuery plugin -->';
echo '<script type="text/javascript" src="_js/jquery.smartmenus.js"></script>';
echo '<!-- SmartMenus jQuery Bootstrap Addon -->';
echo '<script type="text/javascript" src="_js/jquery.smartmenus.bootstrap.js"></script>';
            }
        }
        
  }

?>