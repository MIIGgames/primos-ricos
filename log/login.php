<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <p id="error-message" class="error-message"></p>
        <form id="loginForm" action="autenticar.php" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            
            <button type="submit" id="loginButton">Login</button>
        </form>
        <p><a href="#">Esqueci minha senha</a></p>
    </div>
    
    <script src="../js/requisicao_log.js"></script>
</body>
</html>
