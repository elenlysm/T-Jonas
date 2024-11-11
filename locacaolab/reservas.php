<?php
session_start(); 
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
$resultdisp = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['disp'])) {
    $qtdalunos = $conn->real_escape_string($_POST['qtdalunos']);
    $datareserva = $conn->real_escape_string($_POST['datareserva']);
    $horarioinicial = $conn->real_escape_string($_POST['horarioinicial']);
    $horariofinal = $conn->real_escape_string($_POST['horariofinal']);

    // Consulta para selecionar reservas
    $sql = "SELECT LAB.* FROM LAB WHERE LAB.num_computadores >= $qtdalunos AND 
    (SELECT COUNT(1) FROM reservas as r WHERE r.ID_LAB = LAB.ID_LAB AND r.datareserva = '$datareserva' AND 
    ('$horarioinicial' BETWEEN r.horarioinicial and r.horariofinal OR '$horariofinal' BETWEEN r.horarioinicial and r.horariofinal ) ) = 0;";
    $resultdisp = $conn->query($sql);

    $_SESSION["qtdalunos"] = $qtdalunos;
    $_SESSION["datareserva"] = $datareserva;
    $_SESSION["horarioinicial"] = $horarioinicial;
    $_SESSION["horariofinal"] = $horariofinal;
}

$email = $_SESSION["email"]; 

$sql="SELECT lab.numero as numero, DATE_FORMAT(re.datareserva, '%d/%m/%Y') as datareserva, 
CONCAT(DATE_FORMAT(re.horarioinicial, '%H:%i'), ' às ', DATE_FORMAT(re.horariofinal, '%H:%i')) as horario 
FROM lab 
JOIN reservas as re ON re.id_lab = lab.id_lab 
WHERE re.id_user = (SELECT u.id_user FROM user as u WHERE u.email = '$email');";

$resultreservas = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="reservas.css">
    <title>Reservas</title>
</head>

<body>
    <div class="container mt-4">
        <header>
            <img src="img/logo-web.png" alt="logo" class="navbar-brand">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <div class="icon-container me-2">
                </div>
            </div>
        </header>
        <main>
        <div class="icon-container me-2">
        <a href="login.php" style="margin-left: 40px;">
    <img src="img/sair.png" style="width: 24px; height: 24px;" alt="Botão de Sair">
</a>
                        <i class="bi bi-envelope"></i>
                    </div>
            <div class="card p-3 mb-4">
                <h5 class="text-center mb-3">Reserve um laboratório</h5>
                <form action="reservas.php" method="POST">
                    <div class="mb-3">
                        <label for="qtdalunos" class="form-label">Insira a quantidade de alunos:</label>
                        <input type="text" class="form-control" name="qtdalunos" required>
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
                    <button type="submit" class="btn btn-secondary w-100" name="disp">Verificar disponibilidade</button>
                </form>
            </div>
            <div class="card p-3 mb-4">
                <h5 class="text-center mb-3">Laboratórios disponíveis</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-warning">
                            <tr>
                                <th>Laboratório</th>
                                <th>Softwares</th>
                                <th>Nº de Computadores</th>
                                <th>Reservar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($resultdisp != null){?>
                            <?php  while ($row = $resultdisp->fetch_assoc()) {?>
                                <tr>
                                    <td><?= $row['numero'] ?></td>
                                    <td><?= $row['softwares'] ?></td>
                                    <td><?= $row['num_computadores'] ?></td>
                                    <td><a href="criarreserva.php?id_lab=<?= $row['id_lab'] ?>" name="Reservar">Reservar</a></td>
                                </tr>
                            <?php } } ?>        
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
                        <?php if($resultreservas != null){?>
                            <?php  while ($row = $resultreservas->fetch_assoc()) {?>
                                <tr>
                                    <td><?= $row['numero'] ?></td>
                                    <td><?= $row['datareserva'] ?></td>
                                    <td><?= $row['horario'] ?></td>
                                </tr>
                            <?php } } ?>   
                    </table>
                </div>
            </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </main>
    <footer>
        <div class="rodape bottom p-2 bg-black">
            <p class="rod01 mx-auto" style="width: fit-content;">FACULDADES INTEGRADAS EINSTEIN DE LIMEIRA - FIEL</p>
            <p class="rod02 mx-auto" style="width: fit-content;">DESENVOLVIDO POR BBEL®</p>
        </div>
    </footer>
</body>

</html>