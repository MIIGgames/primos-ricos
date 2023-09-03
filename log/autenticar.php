<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Informações de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "usuarios_maond";

    // Criar uma conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consultar o banco de dados para verificar o login
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senha_hash);
        $stmt->fetch();

        if (password_verify($senha, $senha_hash)) {
            // Login bem-sucedido
            $_SESSION["user_id"] = $id;

            // Redirecionar para "index.php" após login bem-sucedido
            header("Location: ../cursos/index.php");
            exit;
        } else {
            // Login falhou
            $_SESSION["login_attempts"] = isset($_SESSION["login_attempts"]) ? $_SESSION["login_attempts"] + 1 : 1;

            if ($_SESSION["login_attempts"] >= 10) {
                // Bloquear o usuário por 5 minutos
                $_SESSION["login_blocked"] = time() + 300; // 300 segundos (5 minutos)
            }

            // Redirecionar de volta para a página de login com mensagem de erro
            header("Location: login.php?error=true");
            exit;
        }
    } else {
        // Usuário não encontrado
        // Redirecionar de volta para a página de login com mensagem de erro
        header("Location: login.php?error=true");
        exit;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>
