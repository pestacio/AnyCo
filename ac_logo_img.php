<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome       ac_logo_img.php
 *  @descrição  Create a JPEG image of the company logo
 *  @package 	Logo
 */

  # inicializações
  require('ac_inic.inc.php');

  # BODY
  $sess = new \Equipment\Session;
  $sess->getSession();
  if (isset($sess->username) && !empty($sess->username)) {
	$username = $sess->username;
  } else { // index.php during normal execution, or other external caller
	$username = "unknown-logo";
  }

  $db = new \Oracle\Db("Equipment", $username);
  $sql = 'SELECT pic FROM pictures WHERE id = (SELECT MAX(id) FROM pictures)';
  $img = $db->fetchOneLob($sql, "Get Logo", "pic");

  header("Content-type: image/jpg");
  echo $img;
?>
