<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilo da navegação */
        nav ul {
            list-style-type: none;
        }

        nav ul li a:hover {
            color: #ff4500; /* Cor do texto ao passar o mouse */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #ffc107;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #ffca28;
        }

        .btn-sair {
            background-color: #ff4500;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-sair:hover {
            background-color: #cc3700;
        }
    </style>
    <title>Edição de usuários cadastrados</title>
</head>
<body>
<div class='container'>
    <h2>Edição de usuários cadastrados</h2>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "labs";

    // Cria a conexão
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verifica a conexão
    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }

    if (isset($_GET['id_user'])) {
        $id = $_GET['id_user'];

        $sql = "SELECT * FROM user WHERE id_user = $id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <form method="post" action="">
            <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($row['id_user']); ?>">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

                <label for="curso">Curso:</label>
                <input type="text" id="curso" name="curso" value="<?php echo htmlspecialchars($row['curso']); ?>" required>

                <label for="materia">Matérias:</label>
                <input type="text" id="materia" name="materia" value="<?php echo htmlspecialchars($row['materia']); ?>" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" value="<?php echo htmlspecialchars($row['senha']); ?>" required>

                <input type="submit" name="action" value="Salvar">
            </form>
            <?php
        } else {
            echo "Usuário não encontrado.";
        }
    } else {
        echo "ID do usuário não fornecido.";
    }

    mysqli_close($conn);
    ?>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "labs";

    // Cria a conexão
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verifica a conexão
    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }

    $id_user = $_POST['id_user'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $materia = $_POST['materia'];
    $senha = $_POST['senha'];

    // Atualiza os dados na tabela
    $sql = "UPDATE user SET nome='$nome', email='$email', curso='$curso', materia='$materia', senha='$senha' WHERE id_user=$id_user";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Usuário editado com sucesso!"); window.location.href = "cadastro-usuario.php";</script>';
    } else {
        echo '<script>alert("Erro ao editar usuário. Tente novamente. ' . $sql . '\n' . mysqli_error($conn) . '");</script>';
    }

    // Fecha a conexão
    mysqli_close($conn);
}
?>

<div style="display: flex; justify-content: center;">
    <button class="btn-sair" type="button" onclick="redirecionarParaLogin()">Sair</button>

    <script>
        function redirecionarParaLogin() {
            window.location.href = "cadastro-usuario.php";
        }
    </script>
</div>
</body>
</html>