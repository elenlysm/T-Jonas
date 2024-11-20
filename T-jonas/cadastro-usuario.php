<?php
// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Configurações do banco de dados
    $servername = "localhost";
    $username = "root"; // Usuário do banco de dados
    $password = ""; // Senha do banco de dados
    $dbname = "salas"; // Nome do banco de dados

    // Conecta ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Conexão com o banco de dados falhou: " . $conn->connect_error);
    }

    // Captura os dados enviados pelo formulário
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    // Verifica se o e-mail já está cadastrado
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<script>alert("E-mail já cadastrado! Por favor, use outro.");</script>';
        echo '<script>window.location.href = "home.php";</script>'; // Redireciona de volta para a página inicial
    } else {
        // Insere o novo usuário na tabela 'user'
        $sql = "INSERT INTO user (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Cadastro realizado com sucesso! Faça login para continuar.");</script>';
            echo '<script>window.location.href = "home.php";</script>'; // Redireciona para a página inicial
        } else {
            echo '<script>alert("Erro ao cadastrar: ' . $conn->error . '");</script>';
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
