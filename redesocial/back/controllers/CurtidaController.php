
<?php
require_once __DIR__ . "/../models/CurtidaModel.php";
function receberCurtida() {

    $dados = json_decode(file_get_contents("php://input"), true);

    if (!is_array($dados)) {
        http_response_code(400);
        echo json_encode([
            "erro" => "Envie um objeto JSON válido!"
        ]);
        return null;
    }
    foreach (["id_usuario", "id_publicacao"] as $campo) {

        if (
            !isset($dados[$campo]) ||
            filter_var($dados[$campo], FILTER_VALIDATE_INT) === false ||
            $dados[$campo] < 1
        ) {
            http_response_code(400);
            echo json_encode([
                "erro" => "Informe um $campo válido."
            ]);
            return null;
        }
    }
    return $dados;
}
function createCurtida($con) {

    $dados = receberCurtida();

    if ($dados === null) {
        return;
    }

    $id = inserirCurtida($con, $dados);

    http_response_code(201);

    echo json_encode([
        "mensagem" => "Curtida registrada com sucesso!",
        "id" => $id
    ]);
}

function readCurtida($con) {

    echo json_encode(listarCurtidas($con));
}
function deleteCurtida($con) {

    $id_usuario = filter_var($_GET["id_usuario"] ?? null, FILTER_VALIDATE_INT);
    $id_publicacao = filter_var($_GET["id_publicacao"] ?? null, FILTER_VALIDATE_INT);

    if (
        $id_usuario === false || $id_usuario === null || $id_usuario < 1 ||
        $id_publicacao === false || $id_publicacao === null || $id_publicacao < 1
    ) {
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe IDs válidos."
        ]);
        return;
    }
    removerCurtida($con, $id_usuario, $id_publicacao);
    echo json_encode([
        "mensagem" => "Curtida removida com sucesso!"
    ]);
}
