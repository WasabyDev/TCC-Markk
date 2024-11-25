<?php
include_once('config.php'); // Inclua a configuração

// Verificar se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $id_horario = $_POST['id_horario'];
    $data_corte = $_POST['data_corte'];
    $hora_corte = $_POST['hora_corte'];
    $nm_corte = $_POST['nm_corte'];
    $valor_corte = $_POST['valor_corte'];
    $atendente = $_POST['atendente'];
    $nm_forma_pagamento = $_POST['nm_forma_pagamento'];
    $id_usuario = $_POST['usuario']; // ID do usuário (funcionário)

    // Consulta SQL para atualizar o agendamento
    $sql = "UPDATE agendamentos SET
            dt_corte = ?,
            hr_corte = ?,
            nm_corte = ?,
            vl_corte = ?,
            nm_funcionario = ?,
            nm_forma_pagamento = ?,
            fg_id_funcionario = ?
            WHERE id_horario = ?";

    // Preparar a consulta
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Vincular os parâmetros
    $stmt->bind_param("sssssssi", $data_corte, $hora_corte, $nm_corte, $valor_corte, $atendente, $nm_forma_pagamento, $id_usuario, $id_horario);

    // Executar a consulta
    if ($stmt->execute()) {
        // Redirecionar para a página de edição com uma mensagem de sucesso
        header("Location: editar_agendamento.php?id=" . $id_horario . "&success=1");
        exit;
    } else {
        // Caso falhe a execução
        die('Erro ao atualizar agendamento: ' . $stmt->error);
    }
}
?>
