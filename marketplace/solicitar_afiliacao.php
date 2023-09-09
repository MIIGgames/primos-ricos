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

// Receba o ID do curso da solicitação Ajax
if (isset($_POST['cursoId'])) {
    $cursoId = $_POST['cursoId'];

    // Verifique se o usuário já está afiliado a este curso (você pode personalizar essa verificação)
    $userId = 1; // Substitua pelo ID do usuário logado (essa lógica depende do seu sistema de autenticação)
    $verificarAfiliação = "SELECT * FROM afiliacoes WHERE usuario_id = $userId AND curso_id = $cursoId";

    $result = $conn->query($verificarAfiliação);

    if ($result->num_rows > 0) {
        // O usuário já está afiliado a este curso
        echo "Você já está afiliado a este curso.";
    } else {
        // Caso contrário, insira a afiliação na tabela 'afiliacoes'
        $inserirAfiliação = "INSERT INTO afiliacoes (usuario_id, curso_id) VALUES ($userId, $cursoId)";

        if ($conn->query($inserirAfiliação) === TRUE) {
            // A afiliação foi inserida com sucesso
            echo "Solicitação de afiliação enviada com sucesso!";
        } else {
            echo "Erro ao enviar a solicitação de afiliação: " . $conn->error;
        }
    }
} else {
    echo "ID do curso não especificado.";
}

// Feche a conexão com o banco de dados
$conn->close();
?>
