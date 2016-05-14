<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.03.08
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	app_nav_bar.php
 *  @descrição  menu de navegação da aplicação
 *
 */

?>

      <!-- Static navbar -->
      <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $app_title;?></a>
          </div>
          <div class="navbar-collapse collapse">

            <!-- Left nav -->
            <ul class="nav navbar-nav">


<?php

  $usr_id = 2;
  $perfil_id = 7;

  $db = new \Oracle\Db("", "");
  $sql = "select A.* ".
	 "      ,B.COMANDO ".
	 "      ,C.CNT_PAGES ".
	 "from WEB_ADM_MENUS_UTILIZADORES A ".
	 "   , WEB_ADM_PAGINAS B ".
	 "   , (select Z.ID_UTILIZADOR,Z.ID_PERFIL,Z.ID_MENU_PAI, COUNT(*) CNT_PAGES ".
	 "      from WEB_ADM_MENUS_UTILIZADORES Z ".
	 "      where Z.ID_MENU_PAI IS NOT NULL ".
	 "      group by Z.ID_UTILIZADOR,Z.ID_PERFIL,Z.ID_MENU_PAI) C ".
	 "where A.ID_UTILIZADOR = :usr_id ".
	 "  and A.ID_PERFIL = :perf_id ".
	 "  and B.ID (+) = A.ID_PAGINA ".
	 "  and C.ID_UTILIZADOR (+) = A.ID_UTILIZADOR ".
	 "  and C.ID_PERFIL (+) = A.ID_PERFIL ".
	 "  and C.ID_MENU_PAI (+) = A.ID_MENU ".
	 "start with A.NIVEL = 0 ".
	 "connect by prior A.ID_MENU = A.ID_MENU_PAI ";

   $res = $db->execFetchAll($sql, "Query Example",array(array(":usr_id", $usr_id, -1),
                                               	        array(":perf_id", $perfil_id, -1)));

   $first = true;
   $niv_ant = '';
   foreach ($res as $row) {

   	if ($first) {
	   $class_active = 'class="active"';
           $first = false;
        } else
	   $class_active = "";

	if ($niv_ant == '' || $niv_ant <= $row['NIVEL'])
        	$niv_ant = $row['NIVEL'];
        elseif ($niv_ant > $row['NIVEL'])  {
                for ($i=0; $i<($niv_ant - $row['NIVEL']); $i++) {
		      	echo '  </ul>';
			echo '</li>';
                };
        	$niv_ant = $row['NIVEL'];
	}

#        echo '<li class="active"><a href="#">Home</a></li>';
	if ($row['PARAMETROS'] == 'separador') {
		echo '<li role="separator" class="divider"></li>';
	} elseif ($row['COMANDO'] != '') {
		echo '<li '.$class_active.'><a href="'.$row['COMANDO'].'">'.$row['DESIGNACAO'].'</a></li>';
	} elseif ($row['CNT_PAGES'] != "" && $row['CNT_PAGES'] > 0 ) {
		$cnt = $row['CNT_PAGES'];
		echo '<li><a href="#">'.$row['DESIGNACAO'].' <span class="caret"></span></a>';
		echo '  <ul class="dropdown-menu">';

        } else {
		echo '<li '.$class_active.'><a href="'.$row['COMANDO'].'">'.$row['DESIGNACAO'].'</a></li>';
	}

   }

   for ($i=0; $i<($niv_ant); $i++) {
	echo '  </ul>';
	echo '</li>';
   };
?>
            </ul>


            <!-- Right nav -->
            <ul class="nav navbar-nav navbar-right">
              <li><a href="bootstrap-navbar.html">Default</a></li>
              <li><a href="#">PT <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">PT <img src="_images/blank.jpg" class="flag flag-pt"/></a></li>
                  <li><a href="#">ES</a></li>
                  <li><a href="#">EN</a></li>
                </ul>
	      </li>
              <li><a href="#">Logout</a></li>
            </ul>

          </div><!--/.nav-collapse -->
        </div><!--/.container -->
      </div>

  <!--    <div class="navbar">
        <div class="container">
		<ol class="breadcrumb">
		  <li><a href="#">Administração</a></li>
		  <li><a href="#">Configurações</a></li>
		  <li class="active">Gerais</li>
		</ol>
      	</div>
      </div>-->