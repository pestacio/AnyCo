<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.03.08
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_get_json.php
 *  @descrição	Service returning equipment counts in JSON
 *  @package 	WebService
 */

  # inicializações
  require('ac_inic.inc.php');

  # BODY
  $db = new \Oracle\Db("Equipment", $_POST['username']);

  $sql = "select equip_name, count(equip_name) as cn ".
         "from equipment ".
         "group by equip_name";
  $res = $db->execFetchAll($sql, "Get Equipment Counts");

  $mydata = array();
  foreach ($res as $row) {
	$mydata[$row['EQUIP_NAME']] = (int) $row['CN'];
  }

  echo json_encode($mydata);
?>
