<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_show_equip.php
 *  @descrição	Show an employee's equipment
 *  @package 	ShowEquipment
 */

  # inicializações
  require('ac_inic.inc.php');


  # BODY
  $empid = (int) $_GET['empid'];

  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Show Equipment");
  $page->printMenu($sess->username, $sess->isPrivilegedUser());

  ob_start();
  try {
	printcontent($sess, $empid);
  } catch (Exception $e) {
	ob_end_clean();
	echo "<div id='content'>\n";
	echo "Sorry, an error occurred";
	echo "</div>";
  }
  ob_end_flush();

  $page->printFooter();

  // Functions

  /**
   * Get an Employee Name
   *
   * @param Db $db
   * @param integer $empid
   * @return string An employee name
   */
  function getempname($db, $empid) {
	$sql = "SELECT first_name || ' ' || last_name AS emp_name ".
	       "FROM employees ".
	       "WHERE employee_id = :id";
	$res = $db->execFetchAll($sql, "Get EName", array(array(":id", $empid, -1)));
	$empname = $res[0]['EMP_NAME'];
	return($empname);
  }

  /**
   * Print the main body of the page
   *
   * @param Session $sess
   * @param integer $empid Employee identifier
   */
  function printcontent($sess, $empid) {
	echo "<div id='content'>\n";
	$db = new \Oracle\Db("Equipment", $sess->username);
	$empname = htmlspecialchars(getempname($db, $empid), ENT_NOQUOTES, 'UTF-8');
	echo "$empname has: ";

#throw new Exception;
#trigger_error('Whoops!', E_USER_ERROR);

	$sql = "BEGIN get_equip(:id, :rc); END;";
	$res = $db->refcurExecFetchAll($sql, "Get Equipment List", "rc", array(array(":id", $empid, -1)));
	if (empty($res['EQUIP_NAME'])) {
		echo "no equipment";
	} else {
		echo "<table border='1'>\n";
		foreach ($res['EQUIP_NAME'] as $item) {
			$item = htmlspecialchars($item, ENT_NOQUOTES, 'UTF-8');
			echo "<tr><td>$item</td></tr>\n";
		}
		echo "</table>\n";
	}
	echo "</div>";  // content
  }

?>
