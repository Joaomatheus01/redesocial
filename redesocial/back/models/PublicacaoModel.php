
<?php
function inserirPublicacao($con, $dados) {

    $stmt = $con->prepare(
        "INSERT INTO publicacoes (id_usuario, legenda, imagem_url)
         VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $dados["id_usuario"],
        $dados["legenda"],
        $dados["imagem_url"] ?? null
    ]);

    return $con->lastInsertId();
}
function listarPublicacoes($con) {

    $stmt = $con->query(
        "SELECT * FROM publicacoes ORDER BY id_publicacao DESC"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removerPublicacao($con, $id) {

    $stmt = $con->prepare(
        "DELETE FROM publicacoes WHERE id_publicacao = ?"
    );

    $stmt->execute([$id]);

    return $stmt->rowCount();
}
