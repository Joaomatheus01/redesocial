
<?php

require_once __DIR__ . "/../models/PublicacaoModel.php";

function receberPublicacao() {

    $dados = json_decode(file_get_contents("php://input"), true);

    if (!is_array($dados)) {
        http_response_code(400);
        echo json_encode([
            "erro" => "Envie um objeto JSON válido!"
        ]);
        return null;
    }

    if (
        !isset($dados["id_usuario"]) ||
        filter_var($dados["id_usuario"], FILTER_VALIDATE_INT) === false ||
        $dados["id_usuario"] < 1 ||
        !isset($dados["legenda"]) ||
        !is_string($dados["legenda"]) ||
        trim($dados["legenda"]) === ""
    ) {
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe um usuário e uma legenda válida."
        ]);
        return null;
    }

    if (isset($dados["imagem_url"]) && !is_string($dados["imagem_url"])) {
        http_response_code(400);
        echo json_encode([
            "erro" => "A URL da imagem deve ser um texto."
        ]);
        return null;
    }

    return $dados;
}
function createPublicacao($con) {

    $dados = receberPublicacao();

    if ($dados === null) {
        return;
    }

    $id = inserirPublicacao($con, $dados);

    http_response_code(201);

    echo json_encode([
        "mensagem" => "Publicação criada com sucesso!",
        "id" => $id
    ]);
}

function readPublicacao($con) {

    echo json_encode(listarPublicacoes($con));
}
function deletePublicacao($con) {

    $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id < 1) {
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe um ID válido."
        ]);
        return;
    }

    removerPublicacao($con, $id);

    echo json_encode([
        "mensagem" => "Publicação removida com sucesso!"
    ]);
}
