<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Definindo o conjunto de caracteres para UTF-8, adequado para português -->
    <meta charset="UTF-8">

    <!-- Tornando o site responsivo em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link para o arquivo de estilos (CSS) local -->
    <link rel="stylesheet" href="home.css">
    <!-- Link para o Bootstrap 5 (framework CSS) que oferece uma estrutura de layout responsiva e estilizada -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Link para os ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Título da página exibido na aba do navegador -->
    <title>Reúne Aqui</title>
</head>

<body>
    <!-- Cabeçalho com a logo do site -->
    <header class="container">
        <div class="logo">
            <!-- Imagem da logo com responsividade -->
            <img src="img/logo.png" alt="Logotipo do Reúne Aqui" class="logo img-fluid">
        </div>
    </header>

    <main class="corpo">
        <!-- Container principal centralizado -->
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <!-- Layout com duas colunas (imagem e formulário de login) -->
            <div class="row container-fluid">
                <!-- Coluna com a imagem da sala -->
                <div class="col-12 col-md-5 p-0 d-flex justify-content-center align-items-stretch">
                    <!-- Imagem representando a sala -->
                    <img src="img/sla-reune.jpg" alt="Imagem da sala do Reúne Aqui" class="sala img-thumbnail img-fluid">
                </div>
                <!-- Coluna com o formulário de login -->
                <div class="col-12 col-md-7 p-0 d-flex flex-column justify-content-center align-items-center">
                    <!-- Texto de boas-vindas e explicação sobre o sistema -->
                    <div class="mb-4 p-3 text-center welcome-text w-100">
                        <h3>Seu Portal que Reserva Salas de Reunião!</h3>
                        <h5>Organize suas reuniões de forma rápida e prática.</h5>
                        <p>Faça o login e garanta o espaço ideal para sua equipe!</p>
                    </div>
                    <!-- Formulário de login -->
                    <form method="post" class="form w-80">
                        <!-- Campo de input para e-mail (login) -->
                        <div class="mb-2">
                            <label for="login" class="label p-2">LOGIN</label>
                            <input type="email" class="input form-control" id="user" placeholder="@gmail.com" name="email">
                        </div>
                        <!-- Campo de input para senha -->
                        <div class="mb-2">
                            <label for="pwd" class="label p-2">SENHA</label>
                            <div class="input-group">
                                <input type="password" class="input form-control" id="senha" name="senha">
                                <!-- Botão para mostrar/ocultar a senha -->
                                <button type="button" class="btn btn-outline-secondary" aria-label="Mostrar senha" id="mostrar-senha" onclick="toggleSenha(event)">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Botão de envio do formulário -->
                        <div class="mb-2">
                            <button type="submit" id="btn" class="btn btn-light w-100">ENTRAR</button>
                        </div>
                        <!-- Link para a página de cadastro (necessário adicionar funcionalidade) -->
                        <button type="button" class="btn btn-link w-100"><a href="cad-user.php">Cadastre-se</a></button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        session_start(); // Inicia a sessão para armazenar os dados do usuário logado

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "*";

        // Estabelece a conexão com o banco de dados
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Verifica se o formulário foi enviado
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
                    if ($email == '*tilabs@einsteinlimeira.com.br*') {
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

    </main>

    <!-- Rodapé com a informação de desenvolvimento -->
    <footer class="rodape mt-5 py-3 text-black">
        <div class="container text-center">
            <!-- Texto do rodapé -->
            <p class="m-0">DESENVOLVIDO POR BBE®</p>
        </div>
    </footer>

    <script>
        function toggleSenha(event) {
            // Impede que o botão provoque o envio do formulário
            event.preventDefault(); 
            const senhaInput = document.getElementById('senha');
            const senhaIcon = document.getElementById('senha-icon');
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                senhaIcon.classList.remove('bi-eye-slash');
                senhaIcon.classList.add('bi-eye');
            } else {
                senhaInput.type = 'password';
                senhaIcon.classList.remove('bi-eye');
                senhaIcon.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>

</html>