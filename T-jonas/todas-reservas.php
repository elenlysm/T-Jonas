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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Importa os ícones do Bootstrap para uso em botões e elementos visuais -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Script do Bootstrap para ativar funcionalidades como modais e dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Define o título da página que aparecerá na aba do navegador -->
    <title>Reúne Aqui Adimin</title>
</head>

<!-- Cabeçalho com o logotipo -->
<header class="container">
    <div class="logo">
        <!-- Exibe a imagem da logo do site -->
        <img src="img/logo.png" alt="Logotipo do Reúne Aqui" class="logo img-fluid">
    </div>
</header>
<!-- Corpo principal da página -->
<main class="corpo">
    <!-- Cria um container flexível que centraliza o conteúdo vertical e horizontalmente -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row container-fluid">

            <!-- Tabela demonstrando as informações de reservas -->
            <div class="col-12 col-md-7 p-0 d-flex flex-column justify-content-center align-items-center">

                <h5 class="text-center mb-3">Todas as reservas</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-warning">
                            <tr>
                                <th>Usuário</th>
                                <th>Sala</th>
                                <th>Data</th>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultAllReservas != null) { ?>
                            <?php while ($row = $resultAllReservas->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?= $row['nome'] ?>
                                </td>
                                <td>
                                    <?= $row['numero'] ?>
                                </td>
                                <td>
                                    <?= $row['datareserva'] ?>
                                </td>
                                <td>
                                    <?= $row['horario'] ?>
                                </td>
                            </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Botão que abre o modal de cadastro -->
                <button type="button" class="btn w-100" data-bs-toggle="modal" data-bs-target="#cadsModal">Cadastro de
                    Salas</button>

            </div>
        </div>
    </div>

    <!-- Modal para cadastro de novos usuários -->
    <div class="modal fade" id="cadsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Cabeçalho do modal -->
                <div class="modal-header">
                    <h4 class="modal-title">CADASTRO DE SALA</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Corpo do modal com o formulário de cadastro -->
                <div class="modal-body">
                    <form action="cadastro-salas.php" method="POST">
                        <div class="mb-2">
                            <label for="id" class="form-label">N° do laboratório:</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                        <div class="mb-2">
                            <label for="softwares" class="form-label">Softwares</label>

                        </div>

                        <!-- Botão para concluir o cadastro -->
                        <button type="submit" class="btn btn-primary w-100">Concluir</button>

                </div>
            </div>
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
        document.querySelector('form').addEventListener('submit', function (event) {
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