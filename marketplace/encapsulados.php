<?php
// Inicie a sessão (se já não estiver iniciada)
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Se o usuário não estiver logado, redirecione para a página de login
    header("Location: ../log/login.php");
    exit();
}

// Verifique se o tempo de inatividade expirou (20 horas)
$inactivityTimeout = 20 * 3600; // 20 horas em segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivityTimeout)) {
    // Se o tempo de inatividade expirou, redirecione para o logout ou outra página
    header("Location: logout.php"); // Redireciona para uma página de logout, por exemplo
    exit();
}

// Atualize o horário da última atividade a cada requisição
$_SESSION['last_activity'] = time();

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

<?php
$host = "localhost";
$dbname = "usuarios_maond";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}


// Consultar os cursos na categoria "variados" no banco de dados
$stmt = $pdo->prepare("SELECT cursos.* FROM cursos JOIN categorias_cursos ON cursos.categoria_id = categorias_cursos.id WHERE categorias_cursos.nome_categoria = ?");
$stmt->execute(['encapsulados']);
$cursosVariados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TITULO -->
    <title>Dashboard - Maond</title>
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
    <link rel="stylesheet" href="../css/marketplace.css">

</head>

<body id="body-dashboard-index-php">
    <!--<p><?php echo $nomeUsuario; ?></p> -->

    <div class="flex-dashboard">
        <sidebar id="sidebar">

            <div class="logo-sidebar">
                <a href="#" class="logo-maond-sidebar">
                    <img src="../img/Logo-Maond.png" alt="">
                    <p><?php echo $nomeUsuario; ?></p>
                </a>
            </div>

            <div class="menu">
                <ul>
                    <li>
                        <a href="../dashboard/index.php">
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
                        <a href="variados.php">
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
                        <a href="../log/login.php">
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

            <div class="dashboard-main marketplace">
                <h2>Produtos mais vendidos da Maond</h2>

                <div class="marketplace-main-grid">
                    <div class="container-marketplace">

                        <!-- Menu de Categorias -->
                        <ul class="menu-categorias">
                            <li><a href="plr.php">PLR</a></li>
                            <li><a href="encapsulados.php">Encapsulados</a></li>
                            <li><a href="cosmeticos.php">Cosméticos</a></li>
                        </ul>

                        <!-- Exibição de Cursos da Categoria "Variados" -->
                        <br>
                        <div class="cards-container">
                            <?php foreach ($cursosVariados as $curso) { ?>
                                <div class="curso-card">
                                <img src="<?php echo $curso['imagem_curso']; ?>" alt="Imagem do Curso">
                                    <div class="desc-cursos-marketplace">
                                        <h3><?php echo $curso['titulo']; ?></h3>
                                        <p><?php echo $curso['descricao']; ?></p>
                                        <p><strong>Valor: R$ <?php echo number_format($curso['valor'], 2, ',', '.'); ?></strong></p>
                                        <p>Data do Curso: <?php echo $curso['data_curso']; ?></p>
                                        <a href="#" class="ver-mais-btn">Ver Mais</a>
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JAVASCRIPT -->
    <script src="../js/menu-dashboard.js"></script>
</body>

</html>