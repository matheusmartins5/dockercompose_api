<?php
$host = 'mysql';
$user = 'root';
$pass = 'root';
$db = 'dockercompose';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
echo "Conectado ao MySQL com sucesso!";
?>