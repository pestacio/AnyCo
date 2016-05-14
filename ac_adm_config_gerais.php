<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_adm_config_gerais.php
 *  @descrição	general configurations maintenance
 *  @package 	Administration
 */

  # inicializações
  require('ac_inic.inc.php');

  $db = new \Oracle\Db("Config.Gerais", $sess->username);
  if (isset($_FILES['lob_upload']) && $_FILES['lob_upload']['name'] != '') {
	    $blobdata = file_get_contents($_FILES['lob_upload']['tmp_name']);
	    if (!$blobdata) {
	        // N.b. this test could be enhanced to confirm the image is a JPEG
	   #     printform();
	    } else {
	        $sql = "INSERT INTO pictures (pic) ".
	               "VALUES(EMPTY_BLOB()) RETURNING pic INTO :blobbind ";
	        $db->insertBlob($sql, 'Insert Logo BLOB', 'blobbind', $blobdata);
                \Generic\redirect("ac_adm_config_gerais.php");
	    }
  } elseif (isset($_POST['gravar'])) {
       
        $id = $_POST['id'];
        $title = $_POST['title'];
        $empresa = $_POST['empresa'];
        $manut = 'N';
        if (isset($_POST['manutencao']))
            $manut = 'S';
        $lang = $_POST['id_lang'];
       
	$sql = "UPDATE WEB_ADM_CONFIGURACOES ".
               "SET TITULO = :titulo_ ".
               "   ,EMPRESA = :empresa_ ".
               "   ,MANUTENCAO = :manut_ ".
               "   ,ID_LANG = :lang_ ".
               "WHERE ID = :id_ ";
       
	$res = $db->execute($sql, "gravar configurações gerais", 
                                array(
                                    array("titulo_",$title,100),
                                    array("empresa_",$empresa,100),
                                    array("manut_",$manut,1),
                                    array("lang_",$lang,-1),
                                    array("id_",$id,-1)
                            ));
        
        \Generic\redirect("ac_adm_config_gerais.php");
   
        
  }



  // Body
  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Configurações gerais");
  $page->printMenu($sess->username, $sess->isPrivilegedUser());
  printcontent($sess);
  $page->printFooter();

  
  // Functions

  /**
   * Print the main body of the page
   *
   * @param Session $sess
   */
  function printcontent($sess) {

        global $db;
        global $ui_title;
        global $ui_company;
        global $ui_maintenance;
        global $ui_language;
        global $ui_save;
        global $ui_logo;
        global $ui_file;

        $cnt = 0;
        $list = new \Equipment\Lists; 
	$sql = "SELECT ID, TITULO, EMPRESA, MANUTENCAO, ID_LANG FROM WEB_ADM_CONFIGURACOES ";
	$res = $db->execFetchAll($sql, "Configurações gerais");
	if ($res) {
            foreach ($res as $row) {
                 $cnt += 1;
            }
	}

        echo "<div id='content'>";
        echo "<form method='post' action='".$_SERVER["PHP_SELF"]."' enctype='multipart/form-data'> ";

        echo "<input name='id' type='hidden' value='".$row['ID']."'>";
        echo "<table class='table'>";

        # titulo
        echo "<tr>";
        echo "<td style='text-align:right'>$ui_title :</td>";
        echo "<td>";
        echo "<input name='title' type='text' value='".$row['TITULO']."' style='width:99%'>";
        echo "</td>";
        echo "</tr>";
        
        # empresa
        echo "<tr>";
        echo "<td style='text-align:right'>$ui_company :</td>";
        echo "<td>";
        echo "<input name='empresa' type='text' value='".$row['EMPRESA']."' style='width:99%'>";
        echo "</td>";
        echo "</tr>";
        
        # manutenção ?
        echo "<tr>";
        echo "<td style='text-align:right'>$ui_maintenance :</td>";
        echo "<td>";
        if ($row['MANUTENCAO'] == 'S')
            echo "<input name='manutencao' type='checkbox' checked>";
        else
            echo "<input name='manutencao' type='checkbox'>";
        echo "</td>";
        echo "</tr>";
        
        # língua por defeito
        echo "<tr>";
        echo "<td style='text-align:right'>$ui_language :</td>";
        echo "<td>";
        echo "<select name='id_lang'>".$list->Show_Langs($row['ID_LANG'])."</select>";
        echo "</td>";
        echo "</tr>";

        # língua por defeito
        echo "<tr>";
        echo "<td style='text-align:right'>$ui_logo :</td>";
        echo "<td>";
        if (defined('LOGO_URL')) {
                echo '<div><img src="' . LOGO_URL . '" alt="Company Icon"></div>';
        }

        echo '<div style="border:1px solid red">'.
             "   $ui_file: <input type='file' name='lob_upload'>".
             "   <input type='submit' value='Upload'".
             '</div>';
        
        echo "</td>";
        echo "</tr>";
        

        # gravar
        echo "<tr>";
        echo "<td>&nbsp;</td>";
        echo "<td style='text-align:right'><input type='submit' name='gravar' value = '$ui_save'></td>";
        echo "</tr>";
        
        
        echo "</table>";
        echo "</form>";

        echo "</div>";  // content

  }
  
  
?>