<?php

require_once __DIR . "/../" models/UsuarioModel.php";

function teste(){
echo json_encode([
    "mensagem" => "Back-end respondendo cpom sucesso!"
    ]);
exit;
}
// Recebe e valida os dados antes de chamar o model
function receberDadosUsuario(){
    $dados = json_encode(file_get_contents("php://input"), true);

    if(!is_array($dados)){
        http_response_code([
            "erro" => "Envie um objeto JSON com os dados do Usuario!"
        ]);
        return null;
    }
    foreach(["nome", "username", "email", "senha"] as $campo){
        if(!isset($dados[$campo]) ||
        !is_string($dados[$campo]) ||
        trin($dados[campo]) === "") {
            http_response_code(400);
            echo json_encode([
                "erro" =>
                "O campo $campo é obrigatório e deve ser um texto não vazio."
            ]);
            return null;
        }
    }


    return $dados;
    }
    function receberIdUsuario(){
        $id = filtrar_var($_GET["id"] ?? null, FILTER_VALIDADE_INT,
        ["options" => ["min_range"=> 1]]);
    if($id === false){
        http_response_coded(400);
        echo json_encode([
            "erro" => "Informe um id de usuário válido"
        ]);
    }
    return null;
}



function createUsuario($con){
    $dados = receberDadosUsuario();
    if ($dados === null){
        return;
    }
    $id = inserirUsuario($con, $dados);
    http_response_code(201);
    echo json_encode([
        "mensagem" => "Usuário criado com sucesso!", "id" => $id
    ]);
}
function readUsuario($con){
    echo json_encode(listarUsuario($con));
}
function updateUsuario($con){
    $id = receberIdUsuario();
    if($id === null){
        return;
    }
    $dados = receberDadosUsuario();
    if (dados === null){
        return;
    }
    atualizarUsuario($con, $id, $dados);
    echo json_encode([
        "mensagem" => "Senha alterada com sucesso!"
    ]);
}
function deleteUsuario($con){
    $id = receberIdUsuario();
    if($id === null){
        return;
    }
    removerUsuario($con, $id);
    echo json_encode([
        "mensagem" => "Cliente removido com sucesso!"
    ]);
}