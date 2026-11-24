
<?php
function inserirCurtida($con, $dados) {

    $stmt = $con->prepare(
        "INSERT INTO curtidas (id_usuario, id_publicacao)
         VALUES (?, ?)"
    );

    $stmt->execute([
        $dados["id_usuario"],
        $dados["id_publicacao"]
    ]);

    return $con->lastInsertId();
}

function listarCurtidas($con) {

    $stmt = $con->query(
        "SELECT * FROM curtidas ORDER BY id_curtida DESC"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function removerCurtida($con, $id_usuario, $id_publicacao) {

    $stmt = $con->prepare(
        "DELETE FROM curtidas
         WHERE id_usuario = ? AND id_publicacao = ?"
    );

    $stmt->execute([
        $id_usuario,
        $id_publicacao
    ]);

    return $stmt->rowCount();
}
