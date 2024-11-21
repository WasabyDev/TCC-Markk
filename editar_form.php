<?php
include_once('config.php'); // Inclua a configuração

// Verificar se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id_horario = $_GET['id'];  // Usando id_horario em vez de id_agendamento

    // Consultar o agendamento com base no id_horario
    $sql = "SELECT * FROM agendamentos WHERE id_horario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_horario);  // "i" para inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se a consulta retornou algum agendamento
    if ($result->num_rows > 0) {
        // Buscar os dados do agendamento
        $agendamento = $result->fetch_assoc();
    } else {
        echo "Agendamento não encontrado.";
        exit;
    }
} else {
    echo "ID do horário não fornecido.";
    exit;
}

// Consultar os dados do usuário (caso precise preencher o formulário)
$usuarios_result = $conn->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 font-sans">
<div class="flex items-center p-4 bg-yellow-400 text-white">
    <h1 class="text-3xl font-bold text-center w-full">Editar Agendamento</h1>
</div>

<div class="container mx-auto p-6">
    <form method="POST" action="salvar_edicao.php">
        <input type="hidden" name="id_horario" value="<?php echo $agendamento['id_horario']; ?>">

        <div class="mb-4">
            <label for="data_corte" class="block text-sm font-semibold">Data do Corte</label>
            <input type="date" id="data_corte" name="data_corte" value="<?php echo $agendamento['dt_corte']; ?>" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="hora_corte" class="block text-sm font-semibold">Horário do Corte</label>
            <input type="time" id="hora_corte" name="hora_corte" value="<?php echo $agendamento['hr_corte']; ?>" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="nm_corte" class="block text-sm font-semibold">Nome do Corte</label>
            <input type="text" id="nm_corte" name="nm_corte" value="<?php echo $agendamento['nm_corte']; ?>" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="valor_corte" class="block text-sm font-semibold">Valor do Corte</label>
            <input type="number" id="valor_corte" name="valor_corte" value="<?php echo $agendamento['vl_corte']; ?>" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="atendente" class="block text-sm font-semibold">Atendente</label>
            <input type="text" id="atendente" name="atendente" value="<?php echo $agendamento['nm_funcionario']; ?>" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="forma_pagamento" class="block text-sm font-semibold">Forma de Pagamento</label>
            <input type="text" id="forma_pagamento" name="forma_pagamento" value="<?php echo $agendamento['nm_forma_pagamento']; ?>" class="w-full p-2 border rounded-lg">
        </div>

        <!-- Caso você queira associar um usuário via ID -->
        <div class="mb-4">
            <label for="usuario" class="block text-sm font-semibold">Usuário</label>
            <select id="usuario" name="usuario" class="w-full p-2 border rounded-lg">
                <?php while ($usuario = mysqli_fetch_assoc($usuarios_result)) { ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>" <?php echo ($usuario['id_usuario'] == $agendamento['fg_id_funcionario']) ? 'selected' : ''; ?>>
                        <?php echo $usuario['nm_usuario']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="flex justify-end space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Salvar Alterações</button>
            <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
