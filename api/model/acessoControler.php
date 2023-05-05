<?php

include('../conection/conn.php');

$requestData = $_REQUEST;

if($requestData['operação'] == 'create'){
    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "INSERT INTO ACESSO (NOME) VALUES (?)";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $requestData['NOME']
        ]);
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro salvo com sucesso!'
        );
    } catch (PDOException $e) {
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao salvar o registro: '.$e
        );
    }

    echo json_encode($dados);
}

if($requestData['operação'] == 'read'){

    // obter o numero de colunas da nossa tabela
    $colulas =$requestData['columns'];

    //
    $sql = "SELECT * FROM ACESSO WHERE 1=1";

    //Obter total de registro encontrados
    $resultado = $pdo->query($sql);
    $qtdeLinhas = $resultado->rowCount();

    // vereificar se exixtem algum filtro determinado
    $filtro - $requestData['search']['value'];
    if(!empty($filtro)){
        $sql .= " AND (ID LIKE '.$filtro%'";
        $SQL .= " OR nome LIKE '.$filtro%')";
    }

    //oBTER REQUISI=TOS ENCONTRADOS COM FILTROS
    $resultado = $pdo->query($sql);
    $totalFiltrados = $resultado->rowCount();
    
    //Obter os valores para a cordenação de registros
    $colunaOrdem, $requestData['order'][0]['colum'];
    $ordem = $colunas[$colunaOrdem]['data'];
    $direção = $requestData['order'][0]['dir'];

    // Obter os limites para paginação dos dados
    $inicio = $requestData['start']; // obtendo inicio do limite
    $tamanho = $requestData['length']; // obtendo tamanho do limite

    // Realizar a nossa ordenação e os limites 
    $sql .= " ORDER BY $ordem $direcao LIMIT $inicio $tamanho";
    $resultado = $pdo->query($sql);
    $dados = array();
    while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
        $dados[ = array_map (null,$row);
    }

    //montar o objeto jason no padrao datatables
    $json data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal"  =>intval($qtdeLinhas),
        "recordsFiltered" =>intval($totalFiltrados),
        "data" => $dados
    );

    echo json_encode($json_data);
}

if($requestData['operação'] == 'update'){

    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "UPDATE ACESSO SET NOME = ?";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $requestData['NOME']
        ]);
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro atualizado com sucesso!'
        );
    } catch (PDOException $e) {
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao atualizar o registro: '.$e
        );
    }

    echo json_encode($dados);
    
}

if($requestData['operação'] == 'delete'){

    try {
        // Gerar a querie de inserção de dados no B.D.
        $sql = "DELETE FROM ACESSO WHERE ID = ?";
        // Iremos preparar a nossa querie para gerar o objeto de inserção ao B.D.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $requestData['ID']
        ]);
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro excluído com sucesso!'
        );
    } catch (PDOException $e) {
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao excluir o registro: '.$e
        );
    }

    echo json_encode($dados);
    
}