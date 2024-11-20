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

// Armazena o email de usuário na sessão
$email = $_SESSION["email"]; 
$id_sala = $_GET["id_sala"]; 
$qtdlugares = $_SESSION["qtdlugares"];
$datareserva = $_SESSION["datareserva"];
$horarioinicial = $_SESSION["horarioinicial"];
$horariofinal = $_SESSION["horariofinal"];

// Prepare a declaração SQL para inserção
$stmt = $conn->prepare("INSERT INTO reservas 
(id_user, id_sala, qtdlugares , datareserva, horarioinicial, horariofinal) 
VALUES ((select u.id_user from user as u where u.email = ?), ?, ?, ?, ?, ?)");

// Vincular parâmetros e executar a declaração
$stmt->bind_param("siisss", $email, $id_sala, $qtdlugares, $datareserva, $horarioinicial, $horariofinal);

// Executar a inserção
if ($stmt->execute()) {
    echo '<script>alert("Reserva realizada com sucesso!");</script>';
} else {
    echo '<script>alert("Erro ao realizar reserva: ' . $stmt->error . '");</script>';
}

echo "<script type='text/javascript'>window.location='reservas.php';</script>";

?>



