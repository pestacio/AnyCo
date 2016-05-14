<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_adm_perfis_utilizadores.php
 *  @descrição	users maintenance
 *  @package 	Administration
 *
 *  Página de manutenção dos perfis aplicacionais dos utilizadores
 *  */


  # inicializações
  require('ac_inic.inc.php');


  // Body
  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Perfis Aplicationais de utilizadores");
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
	
        $db = new \Oracle\Db("Perfis Aplicacionais de utilizadores", $sess->username);

        $sql = "SELECT ID, DS_PERFIL, ESTADO, TP_PERFIL, DESCRICAO ".
               "FROM WEB_ADM_PERFIS ".
               "WHERE ESTADO = 'A' ".
               "ORDER BY 1";
	$perfis = $db->execFetchAll($sql, "Perfis Aplicacionais Query");

        $sql = "SELECT ID, UTILIZADOR ".
               "FROM WEB_ADM_UTILIZADORES ".
               "WHERE ESTADO = 'A' ".
               "ORDER BY 1";
	$utilizadores = $db->execFetchPage($sql, "Utilizadores Query", $startrow, NUMRECORDSPERPAGE);

        echo "<div id='content'>";
	printrecords($sess, $perfis, $utilizadores, ($startrow === 1));
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
  function printrecords($sess, $perfis, $utilizadores, $atfirstrow) {

        global $db;
        global $ui_designation;
        global $ui_state;
        global $ui_type;
        global $ui_description;
        global $ui_active;
        global $ui_inactive;
        global $ui_no_data;
        global $ui_save;
        
        $db = new \Oracle\Db("Perfis Aplicacionais de utilizadores", $sess->username);

        echo "<table>";

        # cabeçalho
        echo "<thead>";
        echo "<tr>";
        foreach ($perfis as $row) {
            echo "<th>".$row['DS_PERFIL']."</th>";
        }
        echo "</tr>";
        echo "</thead>";
        
        # utilizadores
        echo "<tbody>";
	if ($utilizadores) {
            foreach ($utilizadores as $row) {
                echo "<tr>";
                echo "<td>".$row['UTILIZADOR']."</td>";
                for ($i=0;$i < count($perfis)-1;$i++) {

                    $sql = "SELECT 1 ".
                           "FROM WEB_ADM_PERFIS_UTILIZADORES ".
                           "WHERE ESTADO = 'A' ".
                           "  AND ID_UTILIZADOR = ".$row['ID']." ".
                           "  AND ID_PERFIL = ".$perfis[$i]['ID']." ";
                    $per_utilz = $db->execFetchAll($sql, "Utilizadores/Perfis Query");
                    
                    if (count($per_utilz) > 0)
                        echo "<td style='text-align:center'><input type='checkbox' checked></td>";
                    else
                        echo "<td style='text-align:center'><input type='checkbox'></td>";
                }
                echo "</tr>";
                
            }
        } else
            echo "<tr><td colspan=''>$ui_no_data</td></tr>";
        echo "</tbody>";
        echo "</table>";

        printnextprev($atfirstrow, count($utilizadores));

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
		echo "<form method='post' action='ac_adm_perfis_utilizadores.php'><div>";
	if (!$atfirstrow)
		echo "<input type='submit' value='< Previous' name='prevemps'>";
	if ($numrows == NUMRECORDSPERPAGE)
		echo "<input type='submit' value='Next >' name='nextemps'>";
	echo "</div></form>\n";
	}
  }
  
?>