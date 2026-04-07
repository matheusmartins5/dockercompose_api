<?php
header("Content-Type: application/json");

$host = 'mysql';
$user = 'meu_usuario';
$pass = 'minha_senha';
$db = 'meu_banco';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Falha na ligação: " . $conn->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? explode('/', trim($_GET['path'], '/')) : [];

if ($method == 'GET' && count($path) == 1 && $path[0] == 'produtos') {
    $result = $conn->query("SELECT * FROM produtos");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));

} elseif ($method == 'POST' && count($path) == 1 && $path[0] == 'produtos') {
    $input = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO produtos (nome, preco, quantidade) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $input['nome'], $input['preco'], $input['quantidade']);
    $stmt->execute();
    echo json_encode(["message" => "Produto criado", "id" => $conn->insert_id]);

} elseif ($method == 'GET' && count($path) == 2 && $path[0] == 'produtos') {
    $id = intval($path[1]);
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dado = $stmt->get_result()->fetch_assoc();
    echo $dado ? json_encode($dado) : json_encode(["error" => "Produto não encontrado"]);

} elseif ($method == 'PUT' && count($path) == 2 && $path[0] == 'produtos') {
    $id = intval($path[1]);
    $input = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, preco = ?, quantidade = ? WHERE id = ?");
    $stmt->bind_param("sdii", $input['nome'], $input['preco'], $input['quantidade'], $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(["message" => "Produto atualizado"]);
    } else {
        echo json_encode(["error" => "Produto não encontrado ou sem alterações"]);
    }

} elseif ($method == 'DELETE' && count($path) == 2 && $path[0] == 'produtos') {
    $id = intval($path[1]);
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(["message" => "Produto deletado"]);
    } else {
        echo json_encode(["error" => "Produto não encontrado"]);
    }

} else {
    echo json_encode(["error" => "Rota não encontrada"]);
}

$conn->close();