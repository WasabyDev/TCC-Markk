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
    <a href="inicio.html" class="flex items-center mr-4">
        <svg class="w-8 h-8 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4l4 4"/>
        </svg>
    </a>
    <h1 class="text-3xl font-bold flex-grow text-center">Serviços Agendados Anteriormente</h1>
    <div class="mr-5"></div> <!-- Garante que o H1 fique centralizado -->
</div>

<!-- Formulário de Pesquisa -->
<div class="flex justify-center mt-6">
    <div class="mb-6">
        <form method="POST" action="">
            <div class="flex items-center space-x-2">
                <!-- Seu formulário pode continuar aqui -->
            </div>
        </form>
    </div>
</div>

<div class="space-y-6 mx-4"> <!-- Adiciona margens laterais -->
    <?php while($cortes_cads = mysqli_fetch_assoc($result)) { ?>
        <div class="relative bg-gray-800 text-white p-6 rounded-lg shadow-lg agendamento">
            <button onclick="cancelService(event, this)" class="absolute top-4 right-4 inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancelar Serviço
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
    function cancelService(event, button) {
        event.preventDefault(); // Previne o comportamento padrão do botão

        // Solicitar motivo para o cancelamento
        Swal.fire({
            title: "Informe o motivo do cancelamento",
            input: 'textarea',
            inputLabel: 'Motivo do cancelamento',
            inputPlaceholder: 'Descreva o motivo aqui...',
            showCancelButton: true,
            confirmButtonText: 'Confirmar Cancelamento',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Você precisa informar um motivo!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Agora que temos o motivo, mostramos um alerta de confirmação
                Swal.fire({
                    title: "Você tem certeza?",
                    text: "Você não poderá reverter isso!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, cancelar serviço!",
                    cancelButtonText: "Não, voltar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Cancelado!",
                            text: "O serviço foi cancelado com sucesso.",
                            icon: "success"
                        }).then(() => {
                            // Remover o agendamento da tela
                            const agendamentoDiv = button.closest('.agendamento');
                            if (agendamentoDiv) {
                                agendamentoDiv.remove();
                            }
                        });
                    }
                });
            }
        });
    }
</script>

</body>
</html>
