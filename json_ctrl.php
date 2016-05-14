<?php

# $accao : INSERT, UPDATE, DELETE
$accao = @$_REQUEST['accao'];

# chave da tabela
$id = @$_REQUEST['id'];

# dados em formato JSON
$dados = @$_REQUEST['data'];


# le ficheiro json
$jsonString = file_get_contents('db.json');

# converte para matriz
$data = json_decode($jsonString,TRUE);      

if ($accao == 'INSERT' && $dados != '') {

    # gera novo valor da chave
    $id = count($data) + 1;
    
    # transforma a linha no formato JSON para array
    $row = json_decode($dados,TRUE);

    # adiciona a linha ao array de dados existente
    array_push($data,array("id"=>$id,
                           "name"=>$row['name'],
                           "stargazers_count"=>$row['stargazers_count'],
                           "forks_count"=>$row['forks_count'],
                           "description"=>$row['description']
                           )
     );

#    foreach ($data as $key => $row) {
#       echo "  id:".$row['id'];
#       echo "  name:".$row['name'];
#       echo "  stargazers_count:".$row['stargazers_count'];
#       echo "  forks_count:".$row['forks_count'];
#       echo "  description:".$row['description'];
#       echo "<br/>";
#    }

    # transforma em JSON os dados
    $newJsonString = json_encode($data);
    
    # grava ficheiro
    file_put_contents('db.json', $newJsonString);
    
    # le novamente o ficheiro
    $jsonString = file_get_contents('db.json');

} elseif ($accao == 'UPDATE' && $id != '' && $dados != '') {

    # transforma a linha no formato JSON para array
    $row = json_decode($dados,TRUE);

    foreach ($data as $key => $row1) {
        if ($row1['id'] == $id) {
            $data[$key]['name'] = $row['name'];
            $data[$key]['stargazers_count'] = $row['stargazers_count'];
            $data[$key]['forks_count'] = $row['forks_count'];
            $data[$key]['description'] = $row['description'];
            break;
        }
    }

    # transforma em JSON os dados
    $newJsonString = json_encode($data);
    
    # grava ficheiro
    file_put_contents('db.json', $newJsonString);
    
    # le novamente o ficheiro
    $jsonString = file_get_contents('db.json');
    
} elseif ($accao == 'DELETE' && $id != '') {

    # manipular dados do ficheiro -> remover a linha com id = $id
    foreach ($data as $key => $row) {
        if ($row['id'] == $id) {
            unset($data[$key]);
            break;
        }
    }

    $newJsonString = json_encode($data);
    file_put_contents('db.json', $newJsonString);
    $jsonString = file_get_contents('db.json');
    $jsonString = json_encode($data);
    
}

echo $jsonString;

?>

