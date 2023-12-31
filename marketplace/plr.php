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
    header("Location: ../log/login.php"); // Redireciona para uma página de logout, por exemplo
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
$stmt->execute(['plr']);
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
                        <a href="../afiliacoes/minhas_afiliacoes.php">
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
                                        <p>
                                            <?php
                                            $descricao = $curso['descricao'];
                                            $descricaoResumida = substr($descricao, 0, 90);
                                            echo $descricaoResumida;
                                            if (strlen($descricao) > 90) {
                                                echo '...';
                                            }
                                            ?>
                                        </p>
                                        <p><strong>Comissão: R$ <?php echo number_format($curso['valor'], 2, ',', '.'); ?></strong></p>
                                        <br>
                                        <button class="ver-mais-btn" data-curso-id="<?php echo $curso['id']; ?>">Ver Mais</button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="curso-detalhes"></div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="../js/menu-dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".ver-mais-btn").click(function(e) {
                e.preventDefault();
                var cursoId = $(this).data("curso-id");
                var detalhesDiv = $("#curso-detalhes");

                // Use Ajax para buscar as informações detalhadas do curso com o ID correspondente
                $.ajax({
                    url: "buscar_curso.php",
                    method: "GET",
                    data: {
                        id: cursoId
                    },
                    success: function(response) {
                        // Exiba as informações detalhadas do curso e mostre a div de detalhes adicionais
                        detalhesDiv.html(response).fadeIn(300);
                        $("#info-adicionais-curso-" + cursoId).show();

                        // Adicione um evento para solicitar afiliação
                        $(".solicitar-afiliacao-btn").click(function() {
                            var cursoId = $(this).data("curso-id");

                            // Envie uma solicitação de afiliação para o servidor
                            $.ajax({
                                url: "solicitar_afiliacao.php",
                                method: "POST",
                                data: {
                                    cursoId: cursoId
                                },
                                success: function() {
                                    // Exiba uma mensagem de sucesso
                                    alert("Solicitação de afiliação enviada com sucesso!");
                                },
                                error: function() {
                                    alert("Erro ao enviar a solicitação de afiliação.");
                                }
                            });
                        });
                    },
                    error: function() {
                        alert("Erro ao buscar detalhes do curso.");
                    }
                });
            });

        // Adicione um evento para fechar as informações detalhadas ao clicar no botão de fechar
        $(document).on('click', '.fechar-btn', function() {
            var detalhesDiv = $("#curso-detalhes");

            // Ocultar a div de detalhes
            detalhesDiv.fadeOut(300, function() {
                detalhesDiv.empty(); // Limpar o conteúdo após fechar
            });
        });

        // Impedir que o clique dentro da div de informações propague para o documento
        $("#curso-detalhes").on('click', function(event) {
            event.stopPropagation();
        });

        // Adicione um evento para fechar as informações ao clicar fora da caixa
        $(document).on('click', function(event) {
        var detalhesDiv = $("#curso-detalhes");
        if (!$(event.target).closest("#curso-detalhes").length && !$(event.target).hasClass("ver-mais-btn")) {
            detalhesDiv.fadeOut(300, function() {
                detalhesDiv.empty(); // Limpar o conteúdo após fechar
            });
        }
        });
        });
    </script>

</body>

</html>