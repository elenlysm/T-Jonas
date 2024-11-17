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

                <!-- Texto de cadastro -->
                <div class="mb-4 p-3 text-center welcome-text w-100">
                    <h3>CADASTRO</h3>

                    <!-- Formulário de login -->
                    <form action="cadastro-usuario.php" method="POST">
                        <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($row['id_user']); ?>">

                        <!-- Campo de input para nome (login) -->
                        <div class="mb-2">
                            <label for="nome" class="form-label">NOME</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <!-- Campo de input para email -->
                        <div class="mb-2">
                            <label for="email" class="form-label">E-MAIL</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <!-- Campo de input para senha -->
                        <div class="mb-2">
                            <label for="senha" class="form-label">SENHA</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>

                        <!-- Campo de input para senha -->
                        <div class="mb-2">
                            <label for="senha" class="form-label">CONFIRME SUA SENHA</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>

                        <!-- Botão de envio do formulário -->
                        <div class="mb-2">
                            <button type="submit" class="btn btn-secondary" name="salvar">Salvar</button>
                        </div>
                </div>
                </form>

            </div>

        </div>

    </main>

    <!-- Rodapé com a informação de desenvolvimento -->
    <footer class="rodape mt-5 py-3 text-black">
        <div class="container text-center">
            <!-- Texto do rodapé -->
            <p class="m-0">DESENVOLVIDO POR BBE®</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>