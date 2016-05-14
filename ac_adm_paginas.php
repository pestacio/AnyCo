<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_adm_paginas.php
 *  @descrição	manutenção de páginas aplicacionais
 *  @package 	Administration
 *
 *  Página de manutenção dos perfis aplicacionais
 *  */


  # inicializações
  require('ac_inic.inc.php');


  // Body
  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Páginas Aplicacionais");
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
	
        $db = new \Oracle\Db("Perfis Aplicacionais", $sess->username);
	$sql = "SELECT ID, DESIGNACAO, DESCRICAO, PARAMETROS, COMANDO ".
               "FROM WEB_ADM_PAGINAS ".
               "ORDER BY 1";
	$res = $db->execFetchPage($sql, "Páginas Aplicacionais Query", $startrow, NUMRECORDSPERPAGE);

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
        global $ui_code;
        global $ui_designation;
        global $ui_description;
        global $ui_parameters;
        global $ui_file;
        global $ui_save;
        global $ui_no_data;
        
        echo "<table>";

        # cabeçalho
        echo "<thead>";
        echo "<tr>";
        echo "<th>$ui_code</td><td>$ui_designation</th><th>$ui_description</th><th>$ui_parameters</th><th>$ui_file</th>";
        echo "</tr>";
        echo "</thead>";
        
        # utilizadores
        echo "<tbody>";
	if ($res) {
            foreach ($res as $row) {
                echo "<tr>";
                echo "<td>".$row['ID']."</td>";
                echo "<td>".$row['DESIGNACAO']."</td>";
                echo "<td>".$row['DESCRICAO']."</td>";
                echo "<td>".$row['PARAMETROS']."</td>";
                echo "<td>".$row['COMANDO']."</td>";
                echo "</tr>";
                
            }
        } else
            echo "<tr><td colspan='5' style='text-align:center'>$ui_no_data</td></tr>";
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
		echo "<form method='post' action='ac_adm_paginas.php'><div>";
	if (!$atfirstrow)
		echo "<input type='submit' value='< Previous' name='prevemps'>";
	if ($numrows == NUMRECORDSPERPAGE)
		echo "<input type='submit' value='Next >' name='nextemps'>";
	echo "</div></form>\n";
	}
  }
  
?>