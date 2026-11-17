
<?php
//CREATE
function inserirUsuario($con, $dados) {
    $stmt = $con->prepare(
        "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
    );

    $stmt->execute([
      $dados['nome'],
      $dados['email'],
      $dados['senha']
    ]);

    return $con->lastInsertId();
}

//READ
function listarUsuarios($con) {
    $stmt = $con->query("SELECT * FROM usuarios");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//UPDATE
function atualizarUsuario($con, $id, $dados) {
    $stmt = $con->prepare(
        "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?"
    );

   $stmt ->execute([$dados["senha"], $id]);


    return $stmt->rowCount();
} 