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
        <p id="error-message" class="error-message"></p>
        
        <form id="loginForm" action="autenticar.php" method="POST">
            <div class="img-logo-cadastro">
                <img src="../img/Logo-Icon-Extenso.png" alt="">
            </div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            
            <button type="submit" id="loginButton">Login</button>
            <br><br>
            <a href="cadastro.html">Cadastre-se</a>
        </form>
        <p><a href="#">Esqueci minha senha</a></p>
    </div>
    
    <script src="../js/requisicao_log.js"></script>
</body>
</html>
