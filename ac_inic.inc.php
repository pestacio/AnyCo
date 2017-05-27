<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_inic.inc.php
 *  @descrição  Inicialização de toda a infraestrutura da aplicação
 *  @package 	Generic
 */
  ini_set("display_errors","0");
  ini_set("display_startup_errors","0");
# set_magic_quotes_runtime(0);
  date_default_timezone_set('Europe/Lisbon');

  session_start();

  # variáveis aplicacionais

  # número de registos por página
  define('NUMRECORDSPERPAGE', 15);

  # URL do webservice associado à obtenção das estatísticas dos equipamentos
  define('WEB_SERVICE_URL', "https://www.wips.com.pt/AnyCo/ac_get_json.php");

  # URL do logotipo da companhia
  define('LOGO_URL', 'https://www.wips.com.pt/AnyCo/ac_logo_img.php');

  # ficheiro de língua 
  require('ac_lang_pt.php');
  
  # classe base de dados Oracle
  require('ac_db.inc.php');

  # classes aplicativas
  require('ac_equip.inc.php');

  # classes de utilitários
  require('ac_lib.inc.php');

  # tratamento de erros
  set_error_handler("\Generic\ac_error_handler");

  # configurações gerais do Portal
  $config = new Equipment\Configuracao;
  $config->getInfoConfiguracao();
  $title_App = "AnyCo";
  $empresa_App = $config->empresa;
  $manutencao_App = $config->manutencao;
  $lang_App = $config->id_lang;
  
  # verifica se está conetado, se não estiver, redireciona para a página inicial
  $file = $_SERVER["SCRIPT_NAME"];
  if ($file == '')
  	$file = $argv[0];
  $break = Explode('/', $file);
  $pfile = strtolower($break[count($break) - 1]);

  if ($pfile != 'index.php' &&
      $pfile != 'ac_get_json.php' &&
      $pfile != 'ac_logo_img.php') {
	  $sess = new \Equipment\Session;
	  $sess->getSession();
	  if (!isset($sess->username) ||
	       empty($sess->username)) {
		\Generic\redirect('index.php');
		exit;
	  }
  }

?>
