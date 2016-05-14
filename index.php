<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.10.31
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	index.php
  *  @descrição	Start page for the AnyCo Equipment application
  *  @package 	Application
  */
  # inicializações
  require('ac_inic.inc.php');

  # variáveis de entrada
  $usr = isset($_REQUEST['usr']) ? $_REQUEST['usr'] : '';
  $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
  $lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : '';

  $sess = new \Equipment\Session;
  $sess->clearSession();
  
  if ($lang != '')
        $sess->setLang($lang);
  else
        $lang = $lang_App;
  
  $msg = '';
  
  if ($usr != '') {
    if ($sess->authenticateUser($usr,$pwd,$msg)) {
            $sess->setSession();
            $sess->setLang($lang);
            \Generic\redirect('ac_emp_list.php');
  #	} else {
  #                \Generic\redirect('index.php');
    }
  }

  $list = new \Equipment\Lists;

  $page = new \Equipment\Page;
  $page->printHeader("Welcome to AnyCo Corp.");

  if ($msg !='') 
           echo '<div><span style="color:red">'.$msg.'</div>';
               
  echo '<div id="content">'.
       '<h3>'.ucwords($ui_select_user).'</h3>'.
       '<form method="post" action="index.php">'.
       '<div>'.
       '<table>'.
       '<tr><td>'.$ui_username.':</td><td><input type="text" name="usr" value='.$usr.'></td></tr>'.
       '<tr><td>'.$ui_password.':</td><td><input type="password" name="pwd"></td></tr>'.
       '<tr><td>'.$ui_language.':</td><td><select name="lang">'.$list->Show_Langs($lang).'</select></td></tr>'.
       '<tr><td colspan="2"><input type="submit" value="'.$ui_login.'"></td></tr>'.
       '</table>'.
       '</div>'.
       '</form>'.
       '</div>';
  
  $page->printFooter();
  
?>