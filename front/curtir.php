
<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idPublicacao = filter_input(
        INPUT_POST,
        "id_publicacao",
        FILTER_VALIDATE_INT
    );

    if ($idPublicacao) {

        $verificar = $con->prepare(
            "SELECT id_publicacao
             FROM publicacoes
             WHERE id_publicacao = ?"
        );

        $verificar->execute([$idPublicacao]);

        if ($verificar->fetch()) {

            $stmt = $con->prepare(
                "SELECT id_curtida
                 FROM curtidas
                 WHERE id_usuario = ?
                 AND id_publicacao = ?"
            );

            $stmt->execute([
                $_SESSION["id_usuario"],
                $idPublicacao
            ]);

            $curtida = $stmt->fetch();

            if ($curtida) {

                $remover = $con->prepare(
                    "DELETE FROM curtidas
                     WHERE id_usuario = ?
                     AND id_publicacao = ?"
                );

                $remover->execute([
                    $_SESSION["id_usuario"],
                    $idPublicacao
                ]);

            } else {

                $inserir = $con->prepare(
                    "INSERT INTO curtidas
                    (id_usuario, id_publicacao)
                    VALUES (?, ?)"
                );

                $inserir->execute([
                    $_SESSION["id_usuario"],
                    $idPublicacao
                ]);
            }
        }
    }
}

header("Location: feed.php");
exit;
?>
