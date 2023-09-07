<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver logado, redirecione para a página de login
    header("Location: ../log/login.php");
    exit;
}

// Verificar o tempo de expiração (24 horas)
if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > 86400)) {
    // Se passaram mais de 24 horas, destrua a sessão e redirecione para a página de login
    session_unset();
    session_destroy();
    header("Location: ../log/login.php");
    exit;
}

// Atualizar o tempo de atividade
$_SESSION["last_activity"] = time();
?>
