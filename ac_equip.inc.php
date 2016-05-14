<?php
/*
 *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
 *  @versão     1.0
 *  @revisão    2015.10.31
 *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
 *  @nome	ac_equip.inc.php
 *  @descrição  PHP classes for the employee equipment example
 *  @package 	Equipment
 */

  namespace Equipment;

  /**
   * @package Equipment
   * @subpackage Session
   */
  class Session {

	    /**
	     *
	     * @var string Web user's name
	     */
	    public $username = null;
	    public $id = null;
	    public $lang = null;
	    public $pede_pwd = null;
            
	    /**
	     *
	     * @var integer  current record number for paged employee results
	     */
	    public $empstartrow = 1;
	    /**
	     *
	     * @var string CSRF token for HTML forms
	     */
	    public $csrftoken = null;

	   /**
	     * Simple authentication of the web end-user
	     *
	     * @param string $username
	     * @return boolean True if the user is allowed to use the application
	     */
	    public function authenticateUser($username, $passw, &$msg) {

                global $msg_usr_pwd_invalid;
                global $msg_usr_required;
                global $msg_pwd_required;
                
        	$db = new \Oracle\Db("Auth", $username);
                $msg = '';

                $user = \filter_var($username, \FILTER_SANITIZE_STRING);
		$pwd = \filter_var($passw, \FILTER_SANITIZE_STRING);

                if ($user != '' && $pwd != '') {

    #		$sql =  "SELECT w.id, w.utilizador, w.password, r.rhid, r.nome, r.sexo, w.estado, w.pede_pwd ".
                    $sql =  "SELECT w.ID, w.UTILIZADOR, w.PASSWORD, w.PEDE_PWD ".
                            "FROM WEB_ADM_UTILIZADORES w ".
                            #"LEFT JOIN rh_identificacoes r ".
                            #"ON w.rhid = r.rhid ".
                            "WHERE w.UTILIZADOR = :u ".
                            "  AND w.PASSWORD = :p ";

                    $res = $db->execFetchAll($sql, "Auth User", array(array("u", $user, 30),
                                                                      array("p", $pwd, 30)));

                    if (count($res) > 0 ){
                        foreach ($res as $row) {
                            $this->username = $row['UTILIZADOR'];
                            return (true);
                        }
                    } else {
                        $msg = $msg_usr_pwd_invalid;
                    }
                    
                } else {

                    if ($username == '')
                        $msg = $msg_usr_required;
                    elseif ($passw == '')
                        $msg = $msg_pwd_required;
                    
                }
                return (false);
	    }

	    /**
	     * Check if the current user is allowed to do administrator tasks
	     *
	     * @return boolean
	     */
	    public function isPrivilegedUser() {
	        if ($this->username === 'admin')
	            return(true);
	        else
	            return(false);
	    }


	  /**
	     * Store the session data to provide a stateful web experience
	     */
	    public function setSession() {
	        $_SESSION['username']    = $this->username;
	        $_SESSION['empstartrow'] = (int)$this->empstartrow;
	        $_SESSION['csrftoken']   = $this->csrftoken;


	        $_SESSION['id'] = $this->id;
	        $_SESSION['utilizador'] = $this->username;
	        $_SESSION['pede_pwd'] = $this->pede_pwd;

                $_SESSION['manutencao'] = $this->username;
	        $_SESSION['perfil'] = $this->username;
	        $_SESSION['lang'] = $this->lang;

	    }

	    /**
	     * Get the session data to provide a stateful web experience
	     */
	    public function getSession() {
	        $this->username = isset($_SESSION['username']) ?
	             $_SESSION['username'] : null;
	        $this->empstartrow = isset($_SESSION['empstartrow']) ?
	             (int)$_SESSION['empstartrow'] : 1;
	        $this->csrftoken = isset($_SESSION['csrftoken']) ?
	             $_SESSION['csrftoken'] : null;
	        $this->id = isset($_SESSION['id']) ?
	             $_SESSION['id'] : null;
	        $this->pede_pwd = isset($_SESSION['pede_pwd']) ?
	             $_SESSION['pede_pwd'] : null;
	        $this->lang = isset($_SESSION['lang']) ?
	             $_SESSION['lang'] : 0;
	    }

	    /**
	     * Logout the current user
	     */
	    public function clearSession() {
	        $_SESSION = array();
	        $this->username = null;
	        $this->empstartrow = 1;
	        $this->csrftoken = null;
	        $this->id = null;
	        $this->pede_pwd = null;
	        $this->lang = null;             
	    }

	 /**
	     * Records a token to check that any submitted form was generated
	     * by the application.
	     *
	     * For real systems the CSRF token should be securely,
	     * randomly generated so it can't be guessed by a hacker
	     * mt_rand() is not sufficient for production systems.
	     */
	    public function setCsrfToken() {
	        $this->csrftoken = mt_rand();
	        $this->setSession();
	    }
            
            
            public function getLang() {
	        $this->lang = isset($_SESSION['lang']) ?
	             $_SESSION['lang'] : 0;
            }
            
            public function setLang($lang = 0) {
                $this->lang = $lang;
                $_SESSION['lang']  = (int) $this->lang;
            }
            
	}

        
  /**
   * @package Equipment
   * @subpackage Configuracao
   */
  class Configuracao {
      
      public $titulo;
      public $empresa;
      public $logo;
      public $logo_w;
      public $logo_h;
      public $manutencao;
      public $id_lang;
      public $lang;
      
      public function getInfoConfiguracao(){
          
            $db = new \Oracle\Db("InfoConfiguracao", '');
            $sql = "SELECT A.*, B.CODE_LANG ".
                   "FROM WEB_ADM_CONFIGURACOES A ".
                   "    ,WEB_ADM_LANGS B ".
                   "WHERE A.ID_LANG = B.ID_LANG ";
            
            $res = $db->execFetchAll($sql, "Config.Gerais");

            if (count($res) > 0 ){
                foreach ($res as $row) {
                    $this->titulo = $row['TITULO'];
                    $this->empresa = $row['EMPRESA'];
                    $this->logo = $row['LOGO'];
                    $this->logo_w = $row['LOGO_WIDTH'];
                    $this->logo_h = $row['LOGO_HEIGHT'];
                    $this->manutencao = $row['MANUTENCAO'];
                    $this->id_lang = $row['ID_LANG'];
                    $this->lang = $row['CODE_LANG'];
                    return (true);    
                }
            }
      }
      
  }
        
        
        

  /**
   * @package Equipment
   * @subpackage Page
   */
  class Page {
	/**
	 * Print the top section of each HTML page
	 * @param string $title The page title
	 */
	public function printHeader($title) {
                
                global $ui_in_maintenance;
                global $title_App;
                global $manutencao_App;
                global $empresa_App;
                
 		$title = htmlspecialchars($title, ENT_NOQUOTES, 'UTF-8');
                $list = new \Equipment\Lists();

		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'.
		     '"http://www.w3.org/TR/html4/strict.dtd">'.
		     '<html>'.
		     '<head>'.
		     '  <meta http-equiv="Content-Type"'.
		     '        content="text/html; charset=utf-8">'.
		     '  <link rel="stylesheet" type="text/css" href="style.css">'.
		     "  <title>$title_App</title>".
		     '</head>'.
		     '<body>'.
		     '<div id="header">';

                echo '<div style="float:left;font-size:15px">'.$empresa_App;
                if (defined('LOGO_URL')) {
			echo '<div style="float:left"><img src="' . LOGO_URL . '" alt="Company Icon"></div>';
		}
                echo '</div>';
                
                if (isset($_SESSION['lang']))
                    echo '<div style="float:right;font-size:15px"><select name="lang">'.$list->Show_Langs($_SESSION['lang']).'</select></div>';

                echo "$title";
		echo "</div>";

                if ($manutencao_App == 'S')
                    echo '<div style="float-right;color:red;font-weight:bold">'.mb_strtoupper($ui_in_maintenance,'UTF8').'</div>';
	}

	/**
	 * Print the bottom of each HTML page
	 */
	public function printFooter() {
		echo "</body></html>\n";
	}


	/**
	* Print the navigation menu for each HTML page
	*
	* @param string $username The current web user
	* @param type $isprivilegeduser True if the web user is privileged
	*/
	public function printMenu($username, $isprivilegeduser) {
            
                $username = htmlspecialchars($username, ENT_NOQUOTES, 'UTF-8');
		echo "<div id='menu'>".
		     "<div id='user'>Logged in as: $username</div>".
		     "<ul>".
		     "<li><a href='ac_emp_list.php'>Employee List</a></li>";

		if ($isprivilegeduser) {
			echo "<li><a href='ac_report.php'>Equipment Report</a></li>".
			     "<li><a href='ac_graph_page.php'>Equipment Graph</a></li>";
                        
                        echo "<hr/>";
                        echo "ADMINISTRAÇÃO".
			     "<li><a href='ac_adm_config_gerais.php'>Configurações Gerais</a></li>".
			     #"<li><a href='ac_logo_upload.php'>Upload Logo</a></li>".
			     "<li><a href='ac_adm_perfis.php'>Perfis</a></li>".
			     "<li><a href='ac_adm_utilizadores.php'>Utilizadores</a></li>".
			     "<li><a href='ac_adm_perfis_utilizadores.php'>Perfis Utilizadores</a></li>".
			     "<li><a href='ac_adm_paginas.php'>Páginas</a></li>";
                        echo "<hr/>";
		}
		echo '<li><a href="index.php">Logout</a></li>'.
		     '</ul>'.
		     '</div>';
	}
  }
  /**
   * @package Equipment
   * @subpackage Lists
   */
  class Lists {
      
      public function Show_Langs($id) {
          
        $db = new \Oracle\Db("Línguas",'');
        $result = '';
        
        $sql = "SELECT ID_LANG, DSP_LANG FROM WEB_ADM_LANGS ORDER BY 1 ";
        $res = $db->execFetchAll($sql, 'List Languages');
        foreach ($res as $row) {
            if ($id == $row['ID_LANG'])
                $result .= '<option value="'.$row['ID_LANG'].'" selected>'.$row['DSP_LANG'].'</option>';
            else
                $result .= '<option value="'.$row['ID_LANG'].'">'.$row['DSP_LANG'].'</option>';
        }

        return $result;
      }
      
  }
?>
