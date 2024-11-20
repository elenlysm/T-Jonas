<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sala";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Tratamento de inserção de dados
$resultdisp = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['disp'])) {
    $qtdalunos = $conn->real_escape_string($_POST['qtdlugares']);
    $datareserva = $conn->real_escape_string($_POST['datareserva']);
    $horarioinicial = $conn->real_escape_string($_POST['horarioinicial']);
    $horariofinal = $conn->real_escape_string($_POST['horariofinal']);

    // Consulta para selecionar reservas
    $sql = "SELECT SALA.* FROM SALA WHERE SALA.num_act >= $qtdlugares AND 
    (SELECT COUNT(1) FROM reservas as r WHERE r.ID_SALA = SALA.ID_SALA AND r.datareserva = '$datareserva' AND 
    ('$horarioinicial' BETWEEN r.horarioinicial and r.horariofinal OR '$horariofinal' BETWEEN r.horarioinicial and r.horariofinal ) ) = 0;";
    $resultdisp = $conn->query($sql);

    $_SESSION["qtdlugares"] = $qtdlugares;
    $_SESSION["datareserva"] = $datareserva;
    $_SESSION["horarioinicial"] = $horarioinicial;
    $_SESSION["horariofinal"] = $horariofinal;
}

$email = $_SESSION["email"];

$sql = "SELECT sala.numero as numero, DATE_FORMAT(re.datareserva, '%d/%m/%Y') as datareserva, 
CONCAT(DATE_FORMAT(re.horarioinicial, '%H:%i'), ' às ', DATE_FORMAT(re.horariofinal, '%H:%i')) as horario 
FROM sala 
JOIN reservas as re ON re.id_lab = lab.id_lab 
WHERE re.id_user = (SELECT u.id_user FROM user as u WHERE u.email = '$email');";

$resultreservas = $conn->query($sql);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Importa os ícones do Bootstrap para uso em botões e elementos visuais -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Script do Bootstrap para ativar funcionalidades como modais e dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Define o título da página que aparecerá na aba do navegador -->
    <title>Reservas</title>
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

                <div class="card p-3 mb-4">
                    <h5 class="text-center mb-3">Reserve um laboratório</h5>
                    <form action="reservas.php" method="POST">
                        <div class="mb-3">
                            <label for="qtdlugares" class="form-label">Insira a quantidade de acentos necessários:</label>
                            <input type="text" class="form-control" name="qtdlugares" required>
                        </div>
                        <div class="mb-3">
                            <label for="datareserva" class="form-label">Data:</label>
                            <input type="date" class="form-control" name="datareserva" placeholder="DD/MM/YY" required>
                        </div>
                        <div class="mb-3">
                            <label for="horarioinicial" class="form-label">Horário inicial:</label>
                            <input type="time" class="form-control" name="horarioinicial" required>
                        </div>
                        <div class="mb-3">
                            <label for="horariofinal" class="form-label">Horário final:</label>
                            <input type="time" class="form-control" name="horariofinal" required>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100" name="disp">Verificar
                            disponibilidade</button>
                    </form>
                </div>
                <div class="card p-3 mb-4">
                    <h5 class="text-center mb-3">Salas disponíveis</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th>Sala</th>
                                    <th>Softwares</th>
                                    <th>Nº de acentos/th>
                                    <th>Reservar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultdisp != null) { ?>
                                    <?php while ($row = $resultdisp->fetch_assoc()) { ?>
                                        <tr>
                                            <td>
                                                <?= $row['numero'] ?>
                                            </td>
                                            <td>
                                                <?= $row['softwares'] ?>
                                            </td>
                                            <td>
                                                <?= $row['num_act'] ?>
                                            </td>
                                            <td><a href="criarreserva.php?id_sala=<?= $row['id_sala'] ?>"
                                                    name="Reservar">Reservar</a></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card p-3">
                    <h5 class="text-center mb-3">Últimas reservas</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th>Laboratório</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                </tr>
                            </thead>
                            <?php if ($resultreservas != null) { ?>
                                <?php while ($row = $resultreservas->fetch_assoc()) { ?>
                                    <tr>
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
                        </table>
                    </div>
                </div>
            </div>
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
                            <label for="id" class="form-label">numero da Sala reservada:</label>
                            <input type="text" class="form-control" id="numero" name="numsala" required>
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

</body>

</html>