<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_graph_page.php
 *  @descrição	Display a page containing the equipment graph
 *  @package 	Graph
 */

  # inicializações
  require('ac_inic.inc.php');


  # BODY
  $page = new \Equipment\Page;
  $page->printHeader("AnyCo Corp. Equipment Graph");
  $page->printMenu($sess->username, $sess->isPrivilegedUser());

  echo "<div id='content'> ".
       "  <img src='ac_graph_img.php' alt='Graph of office equipment'> ".
       "</div> ";

  $page->printFooter();

?>
