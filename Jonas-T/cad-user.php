<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Definindo o conjunto de caracteres para UTF-8, adequado para português -->
    <meta charset="UTF-8">

    <!-- Tornando o site responsivo em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link para o arquivo de estilos (CSS) local -->
    <link rel="stylesheet" href="cad-user.css">

    <!-- Link para o Bootstrap 5 (framework CSS) que oferece uma estrutura de layout responsiva e estilizada -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Link para os ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Título da página exibido na aba do navegador -->
    <title>Cadastre-se</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">CADASTRO</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">NOME</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-MAIL</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="action" class="btn btn-warning">Registrar</button>
            </div>
        </form>
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

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Insere os dados na tabela
        $sql = "INSERT INTO user (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Usuário registrado com sucesso!"); window.location.href = "cadastro-usuario.php";</script>';
        } else {
            echo '<script>alert("Erro ao registrar usuário. Tente novamente. ' . mysqli_error($conn) . '");</script>';
        }

        // Fecha a conexão
        mysqli_close($conn);
    }
    ?>

    <script>
        function redirecionarParaLogin() {
            window.location.href = "cadastro-usuario.php";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>