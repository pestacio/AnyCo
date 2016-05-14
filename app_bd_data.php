<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_bd_data.php
  *  @descrição	 Procedimentos de descodificação de dados
  *  @package 	 Oracle
  */

  namespace Oracle;
  
  
  # Ligação BD
  $db = new \Oracle\Db("Descodificações Dados", "utilizador");

  
  function dsp_perfis($tp) {
      
      if ($tp == 'A')
          $dsp = 'Utilizador';
      elseif ($tp == 'B') 
          $dsp = 'Gestor Admin.';
      elseif ($tp == 'C') 
          $dsp = 'Supervisor';
      elseif ($tp == 'D') 
          $dsp = 'Diretor';
      elseif ($tp == 'E') 
          $dsp = 'Gertor';
      elseif ($tp == 'F') 
          $dsp = 'Dept.RH';
      elseif ($tp == 'G') 
          $dsp = 'Contabilidade';
      elseif ($tp == 'Z') 
          $dsp = 'Administrador';

      return $dsp;
  }

  function list_perfis($tp) {
      
      $result = '';
      if ($tp == 'A')
          $result .= '<option value="A" selected>Utilizador</option>';
      else
          $result .= '<option value="A">Utilizador</option>';

      
      if ($tp == 'B') 
          $result .= '<option value="B" selected>Gestor Admin.</option>';
      else
          $result .= '<option value="B">Gestor Admin.</option>';

      
      if ($tp == 'C') 
          $result .= '<option value="B" selected>Supervisor</option>';
      else
          $result .= '<option value="B">Supervisor</option>';

      
      if ($tp == 'D') 
          $result .= '<option value="D" selected>Diretor</option>';
      else
          $result .= '<option value="D">Diretor</option>';

      
      if ($tp == 'E') 
          $result .= '<option value="E" selected>Gestor</option>';
      else
          $result .= '<option value="E">Gestor</option>';

      
      if ($tp == 'F') 
          $result .= '<option value="F" selected>Dept.RH</option>';
      else
          $result .= '<option value="F">Dept.RH</option>';


      if ($tp == 'G') 
          $result .= '<option value="G" selected>Contabilidade.</option>';
      else
          $result .= '<option value="G">Contabilidade</option>';


      if ($tp == 'Z') 
          $result .= '<option value="Z" selected>Administrador.</option>';
      else
          $result .= '<option value="Z">Administrador</option>';

      
      return $result;
  }
  
?>