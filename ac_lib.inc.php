<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_lib.inc.php
 *  @descrição	livraria de utilitários
 *  @package 	Generic
 */
   namespace Generic;

  /**
   * Error Handler
   *
   * @param integer $errno Error level raised
   * @param string $errstr Error text
   * @param string $errfile File name that the error occurred in
   * @param integer $errline File line where the error occurred
   */
  function ac_error_handler($errno, $errstr, $errfile, $errline) {
#	error_log(sprintf("PHP AnyCo Corp.: %d:  %s in %s on line %d",
#		  $errno, $errstr, $errfile, $errline));
echo sprintf("PHP AnyCo Corp.: %d:  %s in %s on line %d",
            $errno, $errstr, $errfile, $errline);
      #\Generic\redirect('ac_error.html');
	exit;
  }

  # redirecciona a página para o URL indicado
  #
  function redirect($url) {
	echo "<script language=\"javascript\">location.href=\"$url\"</script>";
  }

?>
