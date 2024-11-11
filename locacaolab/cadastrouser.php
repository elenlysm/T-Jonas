<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labs";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Tratamento de inserção de dados

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['salvar'])) {
    // Atribuir valores das variáveis
    $nome = $_POST['nome'];
    $curso = $_POST['curso'];
    $email = $_POST['email'];
    $materia = $_POST['materia'];
    $senha = $_POST['senha'];

    // Verificar se o usuário já existe
    $check_query = "SELECT id_user FROM user WHERE email = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Usuário já existe
        echo '<script>alert("Este usuário já está cadastrado.");</script>';
    } else {
        // Prepare a declaração SQL para inserção
        $insert_stmt = $conn->prepare("INSERT INTO user (nome, curso, email, materia, senha) VALUES (?, ?, ?, ?, ?)");

        // Vincular parâmetros e executar a declaração
        $insert_stmt->bind_param("sssss", $nome, $curso, $email, $materia, $senha);

        // Executar a inserção
        if ($insert_stmt->execute()) {
            echo '<script>alert("Usuário cadastrado com sucesso!");</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar usuário: ' . $insert_stmt->error . '");</script>';
        }
    }
}

// Tratamento de exclusão de dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Delete'])) {
    $id_user = $conn->real_escape_string($_POST['id_user']);
    $sql = "DELETE FROM user WHERE id_user=$id_user";
    if ($conn->query($sql)) {
        echo '<script>alert("Usuário deletado com sucesso!");</script>';
        
    } else {
        echo '<script>alert("Erro ao deletar usuário. Tente novamente. ' . $conn->error . '");</script>';
    }
}

// Consulta para selecionar usuários
$sql  = "SELECT * FROM user";
$result = $conn->query($sql);

// Exibição dos usuários na tela
$tableRows = ""; // Variável para armazenar as linhas da tabela

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>";
        $tableRows .= "<td>" . htmlspecialchars($row['nome']) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row['email']) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row['curso']) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row['materia']) . "</td>";
        $tableRows .= "<td><a href='edituser.php?id_user=" . $row['id_user'] . "' class='btn btn-primary'>Editar</a></td>";
        $tableRows .= "<td>
                         <form action='' method='POST'>
                           <input type='hidden' value='". $row['id_user']."' name='id_user' />
                           <input type='submit' name='Delete' value='Deletar' class='btn btn-danger'>
                         </form>
                       </td>";
        $tableRows .= "</tr>";
    }
} else {
    $tableRows .= "<tr><td colspan='6'>Nenhum usuário cadastrado.</td></tr>";
}

// Imprime as linhas da tabela
echo $tableRows;

// Fecha a conexão
$conn->close();
?>