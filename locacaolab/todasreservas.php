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

// Nova consulta para obter todas as reservas
$sqlAllReservas = "SELECT u.nome, lab.numero as numero, 
                   DATE_FORMAT(re.datareserva, '%d/%m/%Y') as datareserva, 
                   CONCAT(DATE_FORMAT(re.horarioinicial, '%H:%i'), ' às ', DATE_FORMAT(re.horariofinal, '%H:%i')) as horario 
                   FROM reservas as re
                   JOIN lab ON re.id_lab = lab.id_lab
                   JOIN user as u ON re.id_user = u.id_user
                   ORDER BY re.datareserva DESC";

$resultAllReservas = $conn->query($sqlAllReservas);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="cadastro-lab.css">
    <title>Todas as reservas</title>
</head>

<body>
<header>
        <nav class="navbar navbar-light bg-transparent ">
            <div class="container-fluid">
                <img src="img/logo-web.png" alt="logo" class="navbar-brand">
                <div class="menu">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">MENU</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page"
                                        href="cadastro-usuario.php">USUÁRIO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cadastro-lab.php">LABORATÓRIO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="todasreservas.php">TODAS AS RESERVAS</a>
                                </li>
                            </ul>
                            <div class="icon-container me-2">
                        <a href="login.php">
                        <img src="img/sair.png" style="width: 24px; height: 24px;" alt="Botão de Sair">
                        </a>
                        <i class="bi bi-envelope"></i>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
        <main>
            <div class="card p-3 mb-4">
                <h5 class="text-center mb-3">Todas as reservas</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-warning">
                            <tr>
                                <th>Usuário</th>
                                <th>Laboratório</th>
                                <th>Data</th>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($resultAllReservas != null){?>
                            <?php while ($row = $resultAllReservas->fetch_assoc()) {?>
                                <tr>
                                    <td><?= $row['nome'] ?></td>
                                    <td><?= $row['numero'] ?></td>
                                    <td><?= $row['datareserva'] ?></td>
                                    <td><?= $row['horario'] ?></td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </main>
    <footer>
        <div class="rodape bottom bg-black bg-black">
            <p class="rod01 mx-auto" style="width: fit-content;">FACULDADES INTEGRADAS EINSTEIN DE LIMEIRA - FIEL</p>
            <p class="rod02 mx-auto" style="width: fit-content;">DESENVOLVIDO POR BBEL®</p>
        </div>
    </footer>
</body>

</html>