<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_cred.inc.php:
 *  @descrição  Secret Connection Credentials for a database class
 *  @package 	Oracle
 */


  /**
   * DB user name
   */
  define('SCHEMA', 'pte');

  /**
   * DB Password.
   *
   * Note: In practice keep database credentials out of directories
   * accessible to the web server.
   */
  define('PASSWORD', 'pte');

  /**
   * DB connection identifier
   */
  define('DATABASE', 'prod.quad-systems.com/quadprod');
#  define('DATABASE', 'prod.quad-systems.com/quadprod:pooled');

  /**
   * DB character set for returned data
   */
  define('CHARSET', 'UTF8');

  /**
   * Client Information text for DB tracing
   */
  define('CLIENT_INFO', 'AnyCo Corp.');

?>
