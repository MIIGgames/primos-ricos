<?php include('check_auth.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    // Se o usuário não estiver logado, redirecione para a página de login
    header("Location: login.html");
    exit();
}

// Recupere o ID do usuário armazenado na sessão
$user_id = $_SESSION['user_id'];

// Conecte-se ao banco de dados (substitua com suas próprias configurações)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuarios_maond";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para obter o nome do usuário com base no ID de usuário
$sql = "SELECT nome FROM usuarios WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Encontrou o usuário, recupere o nome
    $row = $result->fetch_assoc();
    $nomeUsuario = $row['nome'];
} else {
    // Caso o usuário não seja encontrado, você pode tratar o erro aqui
    $nomeUsuario = "Usuário Desconhecido";
}

// Feche a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TITULO -->
    <title>Cursos - Maond</title>
    <!-- FAICON -->
    <link rel="shortcut icon" href="../img/Logo-Maond.png" type="image/x-icon">
    <!-- ====================== FONT ROBOTO ======================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri&family=Mukta:wght@300;800&family=Roboto+Mono:ital,wght@0,200;0,400;0,600;1,300&family=Roboto:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- ICONS -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- ESTILO CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <!--<p><?php echo $nomeUsuario;?></p> -->

    <div class="flex-dashboard">
        <sidebar id="sidebar">

            <div class="logo-sidebar">
                <a href="#" class="logo-maond-sidebar">
                    <img src="../img/Logo-Maond.png" alt="">
                    <p><?php echo $nomeUsuario;?></p>
                </a>
            </div>

            <div class="menu">
                <ul>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-house"></i>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-tag"></i>
                            <h3>Produtos</h3>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-shopping-cart"></i>
                            <h3>Marketplace</h3>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-user"></i>
                            <h3>Meus Afiliados</h3>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-credit-card"></i>
                            <h3>Financeiro</h3>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-question"></i>
                            <h3>Ajuda</h3>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ph-bold ph-sign-out"></i>
                            <h3>Sair</h3>
                        </a>
                    </li>
                </ul>
            </div>

        </sidebar>

        <main id="mainContent">
            <header>
            <i id="iconMenu" onclick="responsiveSidebar()" class="ph-bold ph-list"></i>

            <div class="perfil-dashboard">
                <a href="#">
                    <img src="#" alt="">
                    <p>Perfil</p>
                </a>
            </div>
            </header>

            <div class="dashboard-main">
                <h2>Dashboard</h2>
            </div>
        </main>
    </div>

    <!-- JAVASCRIPT -->
    <script src="../js/menu-dashboard.js"></script>
</body>
</html>