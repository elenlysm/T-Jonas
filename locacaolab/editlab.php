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
    <title>Edição de laboratórios cadastrados</title>
</head>
<body>
<div class='container'>
    <h2>Edição de laboratórios cadastrados</h2>
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

    if (isset($_GET['id_lab'])) {
        $id = $_GET['id_lab'];

        $sql = "SELECT * FROM lab WHERE id_lab = $id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <form method="post" action="">
                <input type="hidden" name="id_lab" value="<?php echo $row['id_lab']; ?>">

                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($row['numero']); ?>" required>

                <label for="softwares">Softwares:</label>
                <input type="text" id="softwares" name="softwares" value="<?php echo htmlspecialchars($row['softwares']); ?>" required>

                <label for="num_computadores">Nº de computadores:</label>
                <input type="text" id="num_computadores" name="num_computadores" value="<?php echo htmlspecialchars($row['num_computadores']); ?>" required>

                <input type="submit" name="action" value="Salvar">
            </form>
            <?php
        } else {
            echo "Laboratório não encontrado.";
        }
    } else {
        echo "ID do laboratório não fornecido.";
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

    $id_lab = $_POST['id_lab'];
    $numero = $_POST['numero'];
    $softwares = $_POST['softwares'];
    $num_computadores = $_POST['num_computadores'];

    // Atualiza os dados na tabela
    $sql = "UPDATE lab SET numero='$numero', softwares='$softwares', num_computadores='$num_computadores' WHERE id_lab=$id_lab";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Laboratório editado com sucesso!"); window.location.href = "cadastro-lab.php";</script>';
    } else {
        echo '<script>alert("Erro ao editar laboratório. Tente novamente. ' . $sql . '\n' . mysqli_error($conn) . '");</script>';
    }

    // Fecha a conexão
    mysqli_close($conn);
}
?>

<div style="display: flex; justify-content: center;">
    <button class="btn-sair" type="button" onclick="redirecionarParaLogin()">Sair</button>

    <script>
        function redirecionarParaLogin() {
            window.location.href = "cadastro-lab.php";
        }
    </script>
</div>
</body>
</html>