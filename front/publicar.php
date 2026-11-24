
<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $legenda = trim($_POST["legenda"] ?? "");
    $imagem = trim($_POST["imagem_url"] ?? "");

    if ($legenda === "") {
        header("Location: feed.php");
        exit;
    }

    if ($imagem !== "" && !filter_var($imagem, FILTER_VALIDATE_URL)) {
        header("Location: feed.php");
        exit;
    }

    $stmt = $con->prepare(
        "INSERT INTO publicacoes
        (id_usuario, legenda, imagem_url)
        VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $_SESSION["id_usuario"],
        $legenda,
        $imagem
    ]);
}

header("Location: feed.php");
exit;
?>
