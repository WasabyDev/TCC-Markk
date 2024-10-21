<?php
include_once('config.php'); // Inclua a configuração

// Verifica se foi enviado um nome para buscar
$nome_atendente = isset($_POST['nome_atendente']) ? $_POST['nome_atendente'] : '';

// Prepara a consulta com base no nome do atendente
$sql = "SELECT * FROM agendamentos";
if ($nome_atendente) {
    $sql .= " WHERE nm_funcionario LIKE '%" . $conn->real_escape_string($nome_atendente) . "%'";
}
$result = $conn->query($sql);

// Consulta para pegar os dados do usuário
$usuarios = $conn->query("SELECT nm_usuario, nr_telefone FROM usuarios");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markk - Clientes Agendados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex items-center p-4 bg-yellow-400 text-white">
    <h1 class="text-3xl font-bold flex-grow text-center">Clientes Agendados</h1>
</div>

<!-- Formulário de Pesquisa -->
<div class="flex justify-center mt-6">
    <div class="mb-6">
        <form method="POST" action="">
            <div class="flex items-center space-x-2">
                <input class="w-64 p-2 border rounded-lg" type="text" name="nome_atendente" placeholder="Pesquisar por atendente" value="<?php echo htmlspecialchars($nome_atendente); ?>">
                <button type="submit" class="bg-yellow-400 text-white p-2 rounded-lg hover:bg-yellow-500 transition">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="space-y-6 mx-4"> <!-- Adiciona margens laterais -->
    <?php while($cortes_cads = mysqli_fetch_assoc($result)) { ?>
        <div class="relative bg-gray-800 text-white p-6 rounded-lg shadow-lg agendamento">
            <button onclick="confirmDelete(event, this)" class="absolute top-4 right-4 inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Confirmar
            </button>
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Data: <span class="font-normal"><?php echo $cortes_cads['dt_corte']; ?></span></h3>
                    <h3 class="text-lg font-semibold">Horário: <span class="font-normal"><?php echo $cortes_cads['hr_corte']; ?></span></h3>
                    <h3 class="text-lg font-semibold">Atendente: <span class="font-normal"><?php echo $cortes_cads['nm_funcionario']; ?></span></h3>
                </div>
            </div>
            <h3 class="font-semibold mt-4">Nome: 
                <?php
                // Consulta para obter o primeiro usuário, ajuste se necessário
                $usuarios_result = $conn->query("SELECT nm_usuario, nr_telefone FROM usuarios LIMIT 1");
                if ($usuario_row = mysqli_fetch_assoc($usuarios_result)) {
                    echo htmlspecialchars($usuario_row['nm_usuario']);
                } else {
                    echo "Usuário não encontrado";
                }
                ?>
            </h3>
            <p>Número: 
                <?php
                if (isset($usuario_row)) {
                    echo htmlspecialchars($usuario_row['nr_telefone']);
                } else {
                    echo "Número não encontrado";
                }
                ?>
            </p>
            <p>Tipo de Corte: <span class="font-normal"><?php echo $cortes_cads['nm_corte']; ?></span></p>
            <p>Forma de Pagamento: </p>
            <p class="font-bold">Valor: <span class="font-normal"><?php echo $cortes_cads['vl_corte']; ?></span></p>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, button) {
        event.preventDefault(); // Previne o comportamento padrão do botão
        Swal.fire({
            title: "Tem certeza que deseja concluir o serviço?",
            text: "Para uma melhor segurança, confirme apenas após o efetuamento do pagamento",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, Concluir!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Atendimento Concluído!",
                    text: "Parabéns pelo serviço",
                    icon: "success"
                }).then(() => {
                    // Remove a div pai do botão
                    const agendamentoDiv = button.closest('.agendamento');
                    if (agendamentoDiv) {
                        agendamentoDiv.remove();
                    }
                });
            }
        });
    }
</script>

</body>
</html>
