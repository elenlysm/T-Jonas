<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta charset="UTF-8">

    <!-- Garante que a página será responsiva em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link para o arquivo CSS local que personaliza o estilo da página -->
    <link rel="stylesheet" href="home.css">

    <!-- Importa o Bootstrap 5 (framework CSS para design responsivo e moderno) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Importa os ícones do Bootstrap para uso em botões e elementos visuais -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Script do Bootstrap para ativar funcionalidades como modais e dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Define o título da página que aparecerá na aba do navegador -->
    <title>Reúne Aqui</title>
</head>

<!-- Cabeçalho com o logotipo -->
<header class="container">
    <div class="logo">
        <!-- Exibe a imagem da logo do site -->
        <img src="img/logo.png" alt="Logotipo do Reúne Aqui" class="logo img-fluid">
    </div>
</header>

<!-- Corpo principal da página -->

<body>


    <main class="corpo">
        <!-- Cria um container flexível que centraliza o conteúdo vertical e horizontalmente -->
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row container-fluid">
                <!-- Coluna para exibir uma imagem descritiva -->
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
                        <!-- Botão que abre o modal de cadastro -->
                        <button type="button" class="btn btn-link w-100" data-bs-toggle="modal" data-bs-target="#caduModal">Cadastre-se</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para cadastro de novos usuários -->
        <div class="modal fade" id="caduModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">CADASTRE-SE</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Corpo do modal com o formulário de cadastro -->
                    <div class="modal-body">
                        <form action="cadastro-usuario.php" method="POST">
                            <div class="mb-2">
                                <label for="nome" class="form-label">NOME</label>
                                <input type="text" class="form-control" id="cad-nome" name="nome" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">E-MAIL</label>
                                <input type="email" class="form-control" id="cad-email" name="email" required>
                            </div>
                            <div class="mb-2">
                                <label for="senha" class="form-label">SENHA</label>
                                <input type="password" class="form-control" id="cad-senha" name="senha" required>
                            </div>
                            <div class="mb-2">
                                <label for="confirma-senha" class="form-label">CONFIRME SUA SENHA</label>
                                <input type="password" class="form-control" id="confirma-senha" name="senha" required>
                            </div>
                            <!-- Botão para concluir o cadastro -->
                            <button type="submit" class="btn btn-primary w-100" name="salvar">Concluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "salas";

        // Conexão com o banco
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Conexão falhou: " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $senha = mysqli_real_escape_string($conn, $_POST['senha']);

            $sql = "SELECT * FROM user WHERE TRIM(email) = '$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);

                if ($senha === $user['senha']) { // Substitua por password_verify() se usar hash
                    $_SESSION['email'] = $email;

                    if ($email == 'admReunaAqui@gmail.com') {
                        header("Location: todas-reservas.php");
                    } else {
                        header("Location: reservas.php");
                    }
                    exit;
                } else {
                    echo '<script>alert("Login ou senha incorretos!");</script>';
                }
            } else {
                echo '<script>alert("Login ou senha incorretos!");</script>';
            }
        }

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

    <!-- Script para alternar a exibição da senha e validar os campos -->
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
            document.querySelector('form').addEventListener('submit', function(event) {
                const senha = document.getElementById('cad-senha').value;
                const confirmaSenha = document.getElementById('confirma-senha').value;
                if (senha !== confirmaSenha) {
                    event.preventDefault();
                    alert("As senhas não coincidem!");
                }
            });
        }
    </script>

</body>

</html>