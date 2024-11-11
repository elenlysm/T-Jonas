<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body>
    <section>
        <form method="post">
            <label for="login" class="label p-2">LOGIN</label>
            <input type="email" class="input" id="user" placeholder="@einsteinlimeira.com.br" name="email">
            <br>
            <label for="pwd" class="label p-2">SENHA</label>
            <input type="password" class="input" id="senha" name="senha">
            <i class="bi bi-eye-slash" id="mostrar-senha"></i>
            <br><br>
            <button type="submit" id="btn">ENTRAR</button>
        </form>

    <?php
    session_start(); // Inicia a sessão para armazenar os dados do usuário logado

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "labs";

    // Estabelece a conexão com o banco de dados
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Processa o formulário quando enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);

        // Consulta o banco de dados para verificar se o usuário e senha estão corretos
        $sql = "SELECT * FROM user WHERE email = '$email' AND senha = '$senha'";
        $result = mysqli_query($conn, $sql);

        // Verifica se a consulta foi bem-sucedida
        if ($result) {
            // Verifica se a consulta retornou algum resultado
            if (mysqli_num_rows($result) == 1) {
                // O usuário foi autenticado com sucesso
                $_SESSION['email'] = $email; // Armazena o nome de usuário na sessão

                // Redireciona conforme o email
                if ($email == 'tilabs@einsteinlimeira.com.br') {
                    header("Location: cadastro-usuario.php");
                } else {
                    header("Location: reservas.php");
                }
                exit; // Certifica-se de que o script para aqui
            } else {
                echo '<script>alert("Login ou senha incorretos!");</script>';
            }
        } else {
            // Exibe uma mensagem de erro se a consulta falhar
            echo '<script>alert("Erro na consulta: ' . mysqli_error($conn) . '");</script>';
        }
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
    ?>


    </section>
    <footer>
        <div class="rodape fixed-bottom bg-black">
            <p class="rod01 mx-auto" style="width: fit-content;">FACULDADES INTEGRADAS EINSTEIN DE LIMEIRA - FIEL
            </p>
            <br>
            <p class="rod02 mx-auto" style="width: fit-content;">DESENVOLVIDO POR BBEL®</p>
        </div>
    </footer>
</body>

</html>
