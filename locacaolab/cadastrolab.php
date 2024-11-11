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
    $numero = $_POST['numero'];
    $softwares = $_POST['softwares'];
    $num_computadores = $_POST['num_computadores'];

    // Verificar se o laboratório já existe
    $check_query = "SELECT id_lab FROM lab WHERE numero = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $numero);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Laboratório já existe
        echo '<script>alert("Este laboratório já está cadastrado.");</script>';
    } else {
        // Prepare a declaração SQL para inserção
        $insert_stmt = $conn->prepare("INSERT INTO lab (numero , softwares, num_computadores) VALUES (?, ?, ?)");

        // Vincular parâmetros e executar a declaração
        $insert_stmt->bind_param("sss", $numero, $softwares, $num_computadores);

        // Executar a inserção
        if ($insert_stmt->execute()) {
            echo '<script>alert("Laboratório cadastrado com sucesso!");</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar laboratório: ' . $insert_stmt->error . '");</script>';
        }
    }
}

// Tratamento de exclusão de dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Delete'])) {
    $id_lab = $conn->real_escape_string($_POST['id_lab']);
    $sql = "DELETE FROM lab WHERE id_lab=$id_lab";
    if ($conn->query($sql)) {
        echo '<script>alert("Laboratório deletado com sucesso!");</script>';
    } else {
        echo '<script>alert("Erro ao deletar laboratório. Tente novamente. ' . $conn->error . '");</script>';
    }
}

// Consulta para selecionar laboratório
$sql  = "SELECT * FROM lab";
$result = $conn->query($sql);

// Exibição dos laboratórios na tela
$tableRows = ""; // Variável para armazenar as linhas da tabela

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>";
        $tableRows .= "<td>" . htmlspecialchars($row['numero']) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row['softwares']) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row['num_computadores']) . "</td>";
        $tableRows .= "<td><a href='editlab.php?id_lab=" . $row['id_lab'] . "' class='btn btn-primary'>Editar</a></td>";
        $tableRows .= "<td>
                         <form action='' method='POST'>
                           <input type='hidden' value='". $row['id_lab']."' name='id_lab' />
                           <input type='submit' name='Delete' value='Deletar' class='btn btn-danger'>
                         </form>
                       </td>";
        $tableRows .= "</tr>";
    }
} else {
    $tableRows .= "<tr><td colspan='5'>Nenhum laboratório cadastrado.</td></tr>";
}

// Imprime as linhas da tabela
echo $tableRows;

// Fecha a conexão
$conn->close();
?>