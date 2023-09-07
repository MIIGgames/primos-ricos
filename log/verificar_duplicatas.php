<?php
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

// Função para verificar duplicatas no banco de dados
function verificarDuplicata($campo, $valor) {
    global $conn;
    
    $sql = "SELECT * FROM usuarios WHERE $campo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return true; // Duplicata encontrada
    } else {
        return false; // Nenhuma duplicata encontrada
    }
}

// Verificar duplicatas com base no campo recebido via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campo = $_POST["campo"];
    $valor = $_POST["valor"];
    
    if (verificarDuplicata($campo, $valor)) {
        echo "Ja existe um registro com este $campo.";
    } else {
        echo ""; // Nenhum registro duplicado encontrado
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
