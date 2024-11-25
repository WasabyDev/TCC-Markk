<?php
include_once('config.php'); // Inclua a configuração do banco

// Verifica se os parâmetros foram enviados via POST
if (isset($_POST['id_horario']) && isset($_POST['motivo'])) {
    $id_horario = $_POST['id_horario'];
    $motivo = $_POST['motivo'];

    // Escapar as variáveis para evitar SQL Injection
    $id_horario = $conn->real_escape_string($id_horario);
    $motivo = $conn->real_escape_string($motivo);

    // Registrar o motivo do cancelamento (opcional, caso queira armazenar)
    $query_motivo = "INSERT INTO cancelamentos (id_horario, motivo) VALUES ('$id_horario', '$motivo')";
    $conn->query($query_motivo);

    // Realiza o DELETE no banco
    $sql = "DELETE FROM agendamentos WHERE id_horario = '$id_horario'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao cancelar o agendamento']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
}

$conn->close();
?>
