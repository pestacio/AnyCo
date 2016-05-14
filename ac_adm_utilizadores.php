<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_adm_utilizadores.php
 *  @descrição	users maintenance
 *  @package 	Administration
 *
 *  Página de manutenção dos utilizadores aplicacionais
 *  */


  # inicializações
  require('ac_inic.inc.php');


  // Body
  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Configurações gerais");
  $page->printMenu($sess->username, $sess->isPrivilegedUser());
  printcontent($sess, calcstartrow($sess));
  $page->printFooter();

  
  // Functions

  /**
   * Print the main body of the page
   *
   * @param Session $sess
   */
  function printcontent($sess, $startrow) {
	
        $db = new \Oracle\Db("Utilizadores", $sess->username);
	$sql = "SELECT ID, UTILIZADOR, PASSWORD, ESTADO, EMAIL, TELEMOVEL, RHID, PEDE_PWD, ID_LANG ".
               "FROM WEB_ADM_UTILIZADORES ".
               "ORDER BY 1";
	$res = $db->execFetchPage($sql, "Utilizadores Query", $startrow, NUMRECORDSPERPAGE);

        echo "<div id='content'>";
	printrecords($sess, ($startrow === 1), $res);
	echo "</div>";  // content

        // Save the session, including the current data row number
	$sess->empstartrow = $startrow;
	$sess->setSession();

  }
  /**
   * Print the Employee records
   *
   * @param Session $sess
   * @param boolean $atfirstrow True if the first array entry is the first table row
   * @param array $res Array of rows to print
   */
  function printrecords($sess, $atfirstrow, $res) {

        global $db;
        global $ui_username;
        global $ui_state;
        global $ui_email;
        global $ui_mobile;
        global $ui_active;
        global $ui_inactive;
        global $ui_language;
        global $ui_save;
        $list = new \Equipment\Lists; 

        echo "<table>";

        # cabeçalho
        echo "<thead>";
        echo "<tr>";
        echo "<th>$ui_username</th><th>$ui_state</th><th>$ui_email</th><th>$ui_mobile</th><th>$ui_language</th>";
        echo "</tr>";
        echo "</thead>";
        
        # utilizadores
        echo "<tbody>";
	if ($res) {
            foreach ($res as $row) {
                echo "<tr>";
                echo "<td>".$row['UTILIZADOR']."</td>";
                
                echo "<td>";
                echo "<select name='estado'>";
                if ($row['ESTADO'] == 'A')
                    echo "<option value='A' selected>$ui_active</option>".
                         "<option value='B'>$ui_inactive</option>";
                else
                    echo "<option value='A'>$ui_active</option>".
                         "<option value='B' selected>$ui_inactive</option>";
                echo "</select>";
                echo "</td>";
                
                echo "<td>".$row['EMAIL']."</td>";
                echo "<td>".$row['TELEMOVEL']."</td>";

                echo "<td>";
                echo "<select name='id_lang'>".$list->Show_Langs($row['ID_LANG'])."</select>";
                echo "</td>";
                
                echo "</tr>";
                
            }
        } else
            echo "<tr><td colspan=''>$ui_no_data</td></tr>";
        echo "</tbody>";
        echo "</table>";

        printnextprev($atfirstrow, count($res));
  }
  
  /**
   * Return the row number of the first record to display.
   *
   * The calculation is based on the current position
   * and whether the Next or Previous buttons were clicked
   *
   * @param Session $sess
   * @return integer The row number that the page should start at
   */
  function calcstartrow($sess) {
	if (empty($sess->empstartrow)) {
	    $startrow = 1;
	} else {
	    $startrow = $sess->empstartrow;
	    if (isset($_POST['prevemps'])) {
	        $startrow -= NUMRECORDSPERPAGE;
	        if ($startrow < 1) {
	            $startrow = 1;
	        }
	    } else if (isset($_POST['nextemps'])) {
	        $startrow += NUMRECORDSPERPAGE;
	    }
	}
	return($startrow);
  }

  /**
   * Print Next/Previous buttons as needed to page through the records
   *
   * @param boolean $atfirstrow True if the first array entry is the first table row
   * @param integer $numrows Number of rows the current query retrieved
   */
  function printnextprev($atfirstrow, $numrows) {
	if (!$atfirstrow || $numrows == NUMRECORDSPERPAGE) {
		echo "<form method='post' action='ac_adm_utilizadores.php'><div>";
	if (!$atfirstrow)
		echo "<input type='submit' value='< Previous' name='prevemps'>";
	if ($numrows == NUMRECORDSPERPAGE)
		echo "<input type='submit' value='Next >' name='nextemps'>";
	echo "</div></form>\n";
	}
  }
  
?>