<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_add_one.php
 *  @descrição	Add one piece of equipment to an employee
 *  @package 	Application
 */

  # inicializações
  require('ac_inic.inc.php');

  if ( !$sess->isPrivilegedUser()
      || (!isset($_GET['empid']) && !isset($_POST['empid']))) {
    \Generic\redirect('index.php');
    exit;
  }
  $empid = (int) (isset($_GET['empid']) ? $_GET['empid'] : $_POST['empid']);


  # BODY
  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Add Equipment");
  $page->printMenu($sess->username, $sess->isPrivilegedUser());
  printcontent($sess, $empid);
  $page->printFooter();

  // Functions

  /**
   * Print the main body of the page
   *
   * @param Session $sess
   * @param integer $empid Employee identifier
   */
  function printcontent($sess, $empid) {
	echo "<div id='content'>\n";
	$db = new \Oracle\Db("Equipment", $sess->username);
	if (!isset($_POST['equip']) || empty($_POST['equip'])) {
	    printform($sess, $db, $empid);
	} else {
	    if (!isset($_POST['csrftoken'])
	            || $_POST['csrftoken'] != $sess->csrftoken) {
	        // the CSRF token they submitted doesn't match the one we sent
               	\Generic\redirect('index.php');
	        exit;
	    }
	    $equip = getcleanequip();
	    if (empty($equip)) {
	        printform($sess, $db, $empid);
	    } else {
	        doinsert($db, $equip, $empid);
	        echo "<p>Added new equipment</p>";
	        echo '<a href="ac_show_equip.php?empid='
	             . $empid . '">Show Equipment</a>' . "\n";
	    }
	}
	echo "</div>";  // content
  }

  /**
   * Print the HTML form for entering new equipment
   *
   * @param Session $sess
   * @param Db $db
   * @param integer $empid Employee identifier
   */
  function printform($sess, $db, $empid) {
	$empname = htmlspecialchars(getempname($db, $empid), ENT_NOQUOTES, 'UTF-8');
	$empid = (int) $empid;
	$sess->setCsrfToken();
	echo "Add equipment for $empname ".
	     '<form method="post" action="'.$_SERVER["PHP_SELF"].'"> '.
	     '<div> '.
	     '  Equipment name <input type="text" name="equip"><br> '.
	     '    <input type="hidden" name="empid" value="'.$empid.'"> '.
	     '    <input type="hidden" name="csrftoken" value="'.$sess->csrftoken.'"> '.
	     '    <input type="submit" value="Submit"> '.
	     "</div>".
	     "</form>";
  }


  /**
   * Perform validation and data cleaning so empty strings are not inserted
   *
   * @return string The new data to enter
   */
  function getcleanequip() {
	if (!isset($_POST['equip'])) {
		return null;
	} else {
		$equip = $_POST['equip'];
		return(trim($equip));
	}
  }

  /**
   * Insert a piece of equipment for an employee
   *
   * @param Db $db
   * @param string $equip Name of equipment to insert
   * @param string $empid Employee identifier
   */
  function doinsert($db, $equip, $empid) {
	$sql = "INSERT INTO equipment (employee_id, equip_name) VALUES (:ei, :nm)";
	$db->execute($sql, "Insert Equipment", array(array("ei", $empid, -1),
	                                             array("nm", $equip, -1)));
  }

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
	$res = $db->execFetchAll($sql, "Get EName", array(array("id", $empid, -1)));
	$empname = $res[0]['EMP_NAME'];
	return($empname);
  }
?>
