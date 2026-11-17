
<?php

require_once __DIR__ . "/../controllers/usuarios.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

if ($rota === "usuario") {

    switch ($metodo) {

        case "POST":
            $dados = receberUsuario();

            if ($dados !== null) {
                inserirUsuario($con, $dados);
            }
            break;

        case "GET":
            $id = receberIdUsuario();

            if ($id !== null) {
                readUsuario($id);
            }
            break;

        case "PUT":
            $id = receberIdUsuario();
            $dados = receberUsuario();

            if ($id !== null && $dados !== null) {
                updateUsuario($id, $dados);
            }
            break;

        case "DELETE":
            $id = receberIdUsuario();

            if ($id !== null) {
                deleteUsuario($id);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode([
                "erro" => "Método não permitido"
            ]);
            break;
    }

} else {
    http_response_code(404);
    echo json_encode([
        "erro" => "Rota não encontrada"
    ]);
}
