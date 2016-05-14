<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_bd_table_controller.php
  *  @descrição	 Controlador para acesso de dados de tabelas
  *  @package 	 DataTables
  */

  # classe base de dados Oracle
  require('app_class_db.php');
  require('app_bd_data.php');

  # tabela em manutenção
  $tabela = isset($_REQUEST['tabela']) ? $_REQUEST['tabela'] : '';

  # $accao : INSERT, UPDATE, DELETE
  $accao = @$_REQUEST['accao'];

  # chave da tabela
  $id = @$_REQUEST['id'];

  # dados em formato JSON
  $dados = @$_REQUEST['data'];

  
  # Ligação BD
  $db = new \Oracle\Db("JSON WevServ", "utilizador");

  
  if ($tabela == 'TESTE') {
      
        if ($accao == 'INSERT' && $dados != '') {

              # gera novo valor da chave
              $id = $db->getNextSeq("teste","id");

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # criar registo na tabela
              $sql = "INSERT INTO TESTE (ID, NAME, STARGAZERS_COUNT, FORKS_COUNT, DESCRIPTION)".
                     "VALUES(:v0,:v1,:v2,:v3,:v4)";
              $res = $db->execute($sql,"Insert teste", array(array("v0", $id, -1),
                                                             array("v1", $row['name'], -1),
                                                             array("v2", $row['stargazers_count'], -1),
                                                             array("v3", $row['forks_count'], -1),
                                                             array("v4", $row['description'], -1)
                                                       )
                            );


      } elseif ($accao == 'UPDATE' && $id != '' && $dados != '') {

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # atualizar registo na tabela
              $sql = "UPDATE TESTE ".
                     "SET NAME = :v1, STARGAZERS_COUNT = :v2, FORKS_COUNT = :v3, DESCRIPTION = :v4 ".
                     "WHERE ID = :v0";
              $res = $db->execute($sql,"Update teste", array(array("v0", $id, -1),
                                                             array("v1", $row['name'], 100),
                                                             array("v2", $row['stargazers_count'], -1),
                                                             array("v3", $row['forks_count'], -1),
                                                             array("v4", $row['description'], 1000)
                                                             )
                            );

      } elseif ($accao == 'DELETE' && $id != '') {

              $sql = "DELETE FROM TESTE WHERE ID = :v0";
              $res = $db->execute($sql,"Update teste", array(array("v0", $id, -1)));

      }

      $sql = 'SELECT ID "id", NAME "name", STARGAZERS_COUNT "stargazers_count", FORKS_COUNT "forks_count", DESCRIPTION "description" FROM TESTE ORDER BY ID ';
      $data = $db->execFetchAll($sql,"SelectAll teste");
      $jsonString = json_encode($data);

      echo $jsonString;
      
  } elseif ($tabela == 'WEB_ADM_UTILIZADORES') {
      
        if ($accao == 'INSERT' && $dados != '') {

              # gera novo valor da chave
              $id = $db->getNextSeq("web_adm_utilizadores","id");

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # criar registo na tabela
              $sql = "INSERT INTO WEB_ADM_UTILIZADORES (ID,UTILIZADOR,PASSWORD,ESTADO,EMAIL,TELEMOVEL,RHID,PEDE_PWD,ID_LANG) ".
                     "VALUES(:v0,:v1,:v2,:v3,:v4,:v5,:v6,:v7,:v8)";
              
              $password = "teste";
              $pede_pwd = "S";
              $rhid = "";
              $res = $db->execute($sql,"Insert $tabela", array(array("v0", $id, -1),
                                                               array("v1", $row['utilizador'], -1),
                                                               array("v2", $password, -1),
                                                               array("v3", $row['estado'], -1),
                                                               array("v4", $row['email'], -1),
                                                               array("v5", $row['telemovel'], -1),
                                                               array("v6", $rhid, -1),
                                                               array("v7", $pede_pwd, -1),
                                                               array("v8", $row['id_lang'], -1)
                                                         )
                            );


      } elseif ($accao == 'UPDATE' && $id != '' && $dados != '') {

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # atualizar registo na tabela
              $sql = "UPDATE WEB_ADM_UTILIZADORES ".
                     "SET UTILIZADOR = :v1, ESTADO = :v3, EMAIL = :v4 ".
                     "   ,TELEMOVEL = :v5, RHID = :v6, ID_LANG = :v8 ".
                     "WHERE ID = :v0";

              $res = $db->execute($sql,"Update $tabela", array(array("v0", $id, -1),
                                                               array("v1", $row['utilizador'], -1),
#                                                               array("v2", $row['password'], -1),
                                                               array("v3", $row['estado'], -1),
                                                               array("v4", $row['email'], -1),
                                                               array("v5", $row['telemovel'], -1),
                                                               array("v6", $row['rhid'], -1),
#                                                               array("v7", $row['pede_pwd'], -1),
                                                               array("v8", $row['id_lang'], -1)
                                                         )
                            );
              
      } elseif ($accao == 'UPT_ESTADO' && $id != '') {

              # transforma a linha no formato JSON para array
              $estado = @$_REQUEST['estado'];
              if ($estado == '')
                  $estado = 'I';

              # atualizar registo na tabela
              $sql = "UPDATE WEB_ADM_UTILIZADORES ".
                     "SET ESTADO = :v1 ".
                     "WHERE ID = :v0";

              $res = $db->execute($sql,"Update $tabela", array(array("v0", $id, -1),
                                                               array("v1", $estado, -1)
                                                         )
                            );

      } elseif ($accao == 'DELETE' && $id != '') {

              $sql = "DELETE FROM WEB_ADM_UTILIZADORES WHERE ID = :v0";
              $res = $db->execute($sql,"Delete $tabela", array(array("v0", $id, -1)));

      }

      $sql = 'SELECT A.ID "id", A.UTILIZADOR "utilizador", A.PASSWORD "password", A.ESTADO "estado", '.
             '       A.EMAIL "email", A.TELEMOVEL "telemovel", A.RHID "rhid", A.PEDE_PWD "pede_pwd", A.ID_LANG "id_lang", B.DSP_LANG "dsp_lang" '.
             'FROM WEB_ADM_UTILIZADORES A, WEB_ADM_LANGS B '.
             'WHERE B.ID_LANG (+) = A.ID_LANG '.
             'ORDER BY A.ID ';

      $data = $db->execFetchAll($sql,"SelectAll $tabela");
      $jsonString = json_encode($data);

      echo $jsonString;
      
  } elseif ($tabela == 'WEB_ADM_PERFIS') {
      
        if ($accao == 'INSERT' && $dados != '') {

              # gera novo valor da chave
              $id = $db->getNextSeq("web_adm_perfis","id");

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # criar registo na tabela
              $sql = "INSERT INTO WEB_ADM_PERFIS (ID, DS_PERFIL, TP_PERFIL, ESTADO, DESCRICAO, NR_ORDEM) ".
                     "VALUES(:v0, :v1, :v2, :v3, :v4, :v5)";
              
              $res = $db->execute($sql,"Insert $tabela", array(array("v0", $id, -1),
                                                               array("v1", $row['ds_perfil'], -1),
                                                               array("v2", $row['tp_perfil'], -1),
                                                               array("v3", $row['estado'], -1),
                                                               array("v4", $row['descricao'], -1),
                                                               array("v5", NULL, -1)
                                                         )
                            );


      } elseif ($accao == 'UPDATE' && $id != '' && $dados != '') {

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # atualizar registo na tabela
              $sql = "UPDATE WEB_ADM_PERFIS ".
                     "SET DS_PERFIL = :v1, TP_PERFIL = :v2, ESTADO = :v3 ".
                     "   ,DESCRICAO = :v4, NR_ORDEM = :v5 ".
                     "WHERE ID = :v0";

              $res = $db->execute($sql,"Update $tabela", array(array("v0", $id, -1),
                                                               array("v1", $row['ds_perfil'], -1),
                                                               array("v2", $row['tp_perfil'], -1),
                                                               array("v3", $row['estado'], -1),
                                                               array("v4", $row['descricao'], -1),
                                                               array("v5", NULL, -1)
                                                         )
                            );
              
      } elseif ($accao == 'UPT_ESTADO' && $id != '') {

              # transforma a linha no formato JSON para array
              $estado = @$_REQUEST['estado'];
              if ($estado == '')
                  $estado = 'I';

              # atualizar registo na tabela
              $sql = "UPDATE WEB_ADM_PERFIS ".
                     "SET ESTADO = :v1 ".
                     "WHERE ID = :v0";

              $res = $db->execute($sql,"Update $tabela", array(array("v0", $id, -1),
                                                               array("v1", $estado, -1)
                                                         )
                            );

      } elseif ($accao == 'DELETE' && $id != '') {

              $sql = "DELETE FROM WEB_ADM_PERFIS WHERE ID = :v0";
              $res = $db->execute($sql,"Delete $tabela", array(array("v0", $id, -1)));

      }

      $sql = 'SELECT A.ID "id", A.DS_PERFIL "ds_perfil", A.TP_PERFIL "tp_perfil", A.ESTADO "estado", '.
             '       A.DESCRICAO "descricao", A.NR_ORDEM "nr_ordem" '.
             'FROM WEB_ADM_PERFIS A '.
             'ORDER BY A.ID ';

      $data = $db->execFetchAll($sql,"SelectAll $tabela");
      # acrescentar a descodificação do tipo de perfil
      foreach ($data as $key => $row) {
          $data[$key]['ds_tp_perfil'] = \Oracle\dsp_perfis($row['tp_perfil']);
      }

      $jsonString = json_encode($data);

      echo $jsonString;
    
  } elseif ($tabela == 'WEB_ADM_PERFIS_UTILIZADORES') {
      
       if ($accao == 'INSERT') {

              # criar registo na tabela
              $sql = "INSERT INTO WEB_ADM_PERFIS_UTILIZADORES (ID_UTILIZADOR, ID_PERFIL, ESTADO )".
                     "SELECT A.ID ID_UTILIZADOR, B.ID ID_PERFIL, 'B' ESTADO ".
                     "FROM WEB_ADM_UTILIZADORES A, WEB_ADM_PERFIS B ".
                     "WHERE (A.ID,B.ID) NOT IN (SELECT X.ID_UTILIZADOR,X.ID_PERFIL FROM WEB_ADM_PERFIS_UTILIZADORES X)";
              
              $res = $db->execute($sql,"Insert $tabela0");


      } elseif ($accao == 'UPDATE') {

          
              $id_user = isset($_REQUEST['user']) ? $_REQUEST['user'] : '';
              $id_perfil = isset($_REQUEST['perfil']) ? $_REQUEST['perfil'] : '';
              $estado = isset($_REQUEST['estado']) ? $_REQUEST['estado'] : '';

              
              # atualizar registo na tabela
              $sql = "UPDATE WEB_ADM_PERFIS_UTILIZADORES ".
                     "SET ESTADO = '$estado' ".
                     "WHERE ID_UTILIZADOR = $id_user ";
                     "  AND ID_PERFIL = $id_perfil ";

              $res = $db->execute($sql,"Update $tabela");
                     
#              $res = $db->execute($sql,"Update $tabela", array(array("v0", $id_user, -1),
#                                                               array("v1", $id_perfil, -1),
#                                                               array("v2", $estado, -1)
#                                                         )
#                            );
              
      }

#      $sql = 'SELECT A.ID "id", A.DS_PERFIL "ds_perfil", A.TP_PERFIL "tp_perfil", A.ESTADO "estado", '.
#             '       A.DESCRICAO "descricao", A.NR_ORDEM "nr_ordem" '.
#             'FROM WEB_ADM_PERFIS A '.
#             'ORDER BY A.ID ';
#
#      $data = $db->execFetchAll($sql,"SelectAll $tabela");
#      # acrescentar a descodificação do tipo de perfil
#      foreach ($data as $key => $row) {
#          $data[$key]['ds_tp_perfil'] = \Oracle\dsp_perfis($row['tp_perfil']);
#      }
#
#      $jsonString = json_encode($data);
#
#      echo $jsonString;

      
  } elseif ($tabela == 'WEB_ADM_DOMINIOS') {
      
        if ($accao == 'INSERT' && $dados != '') {

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # criar registo na tabela
              $sql = "INSERT INTO WEB_ADM_DOMINIOS (DOMINIO,VALOR,DESIGNACAO,DESCRICAO) ".
                     "VALUES(:v0,:v1,:v2,:v3)";
              
              $password = "teste";
              $pede_pwd = "S";
              $rhid = "";
              $res = $db->execute($sql,"Insert $tabela", array(array("v0", $row['dominio'], -1),
                                                               array("v1", $row['valor'], -1),
                                                               array("v2", $row['designacao'], -1),
                                                               array("v3", $row['descricao'], -1)
                                                         )
                            );


      } elseif ($accao == 'UPDATE' && $id != '' && $dados != '') {

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              # atualizar registo na tabela
              $sql = "UPDATE WEB_ADM_DOMINIOS ".
                     "SET DESIGNACAO = :v2, DESCRICAO = :v3 ".
                     "WHERE DOMINIO = :v0 ".
                     "  AND VALOR = :v1 ";

              $res = $db->execute($sql,"Update $tabela", array(array("v0", $row['dominio'], -1),
                                                               array("v4", $row['valor'], -1),
                                                               array("v5", $row['designacao'], -1),
                                                               array("v6", $row['descricao'], -1)
                                                         )
                            );
              
      } elseif ($accao == 'DELETE' && $id != '') {

              # transforma a linha no formato JSON para array
              $row = json_decode($dados,TRUE);

              $sql = "DELETE FROM WEB_ADM_DOMINIO WHERE DOMINIO = :v0 AND VALOR = :v1";
              $res = $db->execute($sql,"Delete $tabela", array(array("v0", $row['dominio'], -1),
                                                               array("v1", $row['valor'], -1)));

      }

      $sql = 'SELECT A.DOMINIO "dominio", A.VALOR "valor", A.DESIGNACAO "designacao", A.DESCRICAO "descricao" '.
             'FROM WEB_ADM_DOMINIOS A '.
             'ORDER BY 1,2 ';

      $data = $db->execFetchAll($sql,"SelectAll $tabela");
      $jsonString = json_encode($data);

      echo $jsonString;
      
   }
?>