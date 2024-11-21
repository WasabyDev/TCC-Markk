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
    <h1 class="text-3xl font-bold flex-grow text-center">Meus Clientes</h1>
</div>

<!-- Formulário de Pesquisa -->
<div class="flex justify-center mt-6">
    <div class="mb-6">
        <form method="POST" action="">
            <div class="flex items-center space-x-2">
                <input class="w-64 p-2 border rounded-lg" type="text" name="nome_atendente" placeholder="Pesquisar por atendente" value="<?php echo htmlspecialchars($nome_atendente); ?>">
                
            </div>
        </form>
    </div>
</div>

<div class="space-y-6 mx-4"> <!-- Adiciona margens laterais -->
    <?php while($cortes_cads = mysqli_fetch_assoc($result)) { ?>
        <div class="relative bg-gray-800 text-white p-6 rounded-lg shadow-lg agendamento">
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

            <!-- Botões de Editar e Excluir -->
            <div class="mt-4 flex justify-end space-x-4">
<!-- Botão Editar -->
<button  
    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
    onclick="window.location.href='editar_form.php?id=<?php echo $cortes_cads['id_horario']; ?>'">
    Editar 
</button>


                <!-- Botão Excluir -->
                <button 
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
                    onclick="cancelService(event, this)">
                    Cancelar
                </button>
            </div>
        </div>
    <?php } ?>
</div>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="bg-green-500 text-white p-4 mb-4 rounded-lg">
        Agendamento atualizado com sucesso!
    </div>
<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     function cancelService(event, button) {
    event.preventDefault(); // Previne o comportamento padrão do botão

    // Solicitar motivo para o cancelamento
    Swal.fire({
        title: "Informe ao cliente o motivo do cancelamento",
        input: 'textarea',
        inputPlaceholder: 'Descreva o motivo aqui...',
        showCancelButton: true,
        confirmButtonColor: "#00FF00", // Cor mais escura para o botão de confirmação
        cancelButtonColor: "#FF3019", // Cor mais escura para o botão de cancelamento
        confirmButtonText: 'Confirmar Cancelamento',
        cancelButtonText: 'Voltar',
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
                confirmButtonColor: "#00FF00", // Cor mais escura para o botão de confirmação
                cancelButtonColor: "#FF3019", // Cor mais escura para o botão de cancelamento
                confirmButtonText: "Sim, cancelar serviço!",
                cancelButtonText: "Não, voltar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Cancelado!",
                        confirmButtonColor: "#00FF00", // Cor mais escura para o botão de confirmação
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
