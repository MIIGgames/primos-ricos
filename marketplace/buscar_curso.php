<?php
// Conecte-se ao seu banco de dados (substitua com suas credenciais)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuarios_maond";

// Crie uma conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtenha o ID do curso da solicitação Ajax
if (isset($_GET['id'])) {
    $cursoId = $_GET['id'];

    // Consulta SQL para buscar as informações detalhadas do curso com base no ID
    $sql = "SELECT * FROM cursos WHERE id = $cursoId";

    // Execute a consulta
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exiba os detalhes do curso
        $row = $result->fetch_assoc();
        echo "<h3>{$row['titulo']}</h3>";
        echo "<p>{$row['descricao']}</p>";
        echo "<p><strong>Valor: R$ " . number_format($row['valor'], 2, ',', '.') . "</strong></p>";

        // Adicione o link de vendas
        echo "<p><strong>Link de Venda:</strong> <a href=\"{$row['link_venda']}\" target=\"_blank\">Copiar link de venda</a></p>";

        // Adicione o botão de solicitação de afiliação
        echo "<button class=\"solicitar-afiliacao-btn\" data-curso-id=\"{$row['id']}\">Solicitar Afiliação</button>";
    } else {
        echo "Curso não encontrado.";
    }
} else {
    echo "ID do curso não especificado.";
}

// Feche a conexão com o banco de dados
$conn->close();
?>
