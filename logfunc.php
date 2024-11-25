<?php
include_once('config.php'); // Inclua a configuração

// Verifica se foi enviado um nome para buscar
$nome_atendente = isset($_POST['nome_atendente']) ? $_POST['nome_atendente'] : '';

// Prepara a consulta com base no nome do atendente
$sql = "SELECT * FROM agendamentos ORDER BY id_horario DESC";  // Ordena do último para o primeiro
if ($nome_atendente) {
    $sql .= " WHERE nm_funcionario LIKE '%" . $conn->real_escape_string($nome_atendente) . "%'";
}
$result = $conn->query($sql);

// Consulta para pegar os dados do usuário
$usuarios = $conn->query("SELECT nm_usuario, nm_sobrenome, nr_telefone FROM usuarios");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
<div class="flex items-center p-4 bg-yellow-400 text-white">
    <h1 class="text-3xl font-bold flex-grow text-center">Meus Clientes</h1>
</div>
<br>
<!-- Formulário de Pesquisa -->
<div class="flex justify-center mt-6">
    <div class="mb-6 w-full max-w-md">
        <form method="POST" action="">
            <div class="flex items-center space-x-2 justify-center">
                <!-- Campo de pesquisa com tamanho ajustado e centralizado -->
                <input class="w-2/3 p-3 border rounded-lg text-gray-800" type="text" name="nome_atendente" placeholder="Pesquisar por atendente" value="<?php echo htmlspecialchars($nome_atendente); ?>">
                <button type="submit" class="bg-yellow-400 text-white p-3 rounded-lg hover:bg-yellow-500 transition">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>


<div class="button-container flex justify-center space-x-4 p-4">

<a href="agendtdadm.php">
            <button class="bg-gray-800 text-white font-bold py-2 px-4 w-28 h-32 rounded transition duration-300 shadow-md hover:shadow-lg flex flex-col items-center justify-center">
              <i class="fa-solid fa-calendar-plus text-3xl mb-2"></i> <!-- Tamanho do ícone -->
                Agendar <span class="text-yellow-600">Serviço</span> 
            </button>
        </a>

<!-- Botão Relatório -->
    <a href="concluidosadm.php">
        <button class="bg-gray-800 text-white font-bold py-4 px-6 w-28 h-32 rounded transition duration-300 shadow-md hover:shadow-lg flex flex-col items-center justify-center">
            <svg class="w-10 h-10 text-white mb-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2a1 1 0 0 0-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.707 8.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
            </svg>
            <span class="text-yellow-600">Relatório</span>
        </button>
    </a>

</div>

<br>

<div class="space-y-6 mx-4"> <!-- Adiciona margens laterais -->
    <?php while($cortes_cads = mysqli_fetch_assoc($result)) { ?>
        <div class="relative bg-gray-800 text-white p-6 rounded-lg shadow-lg agendamento" data-id="<?php echo $cortes_cads['id_horario']; ?>">
            
            <!-- Botão Concluir no canto superior direito -->
            <div class="absolute top-4 right-4">
    <button 
        class="bg-green-400 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition"
        onclick="concluirServico(<?php echo $cortes_cads['id_horario']; ?>)">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
            </svg>
            <span>Concluir</span>
        </div>
    </button>
</div>


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
            $usuarios_result = $conn->query("SELECT nm_usuario, nm_sobrenome, nr_telefone FROM usuarios LIMIT 1");

            if ($usuario_row = mysqli_fetch_assoc($usuarios_result)) {
                // Exibe o nome e o sobrenome com um espaço entre eles
                echo htmlspecialchars($usuario_row['nm_usuario']) . ' ' . htmlspecialchars($usuario_row['nm_sobrenome']);
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
            <p>Forma de Pagamento: <span class="font-normal"><?php echo $cortes_cads['nm_forma_pagamento']; ?></span></p>
            <p class="font-bold">Valor: <span class="font-normal"><?php echo $cortes_cads['vl_corte']; ?></span></p>

            <!-- Botões de Editar e Excluir -->
            <div class="mt-4 flex justify-end space-x-4">
    <!-- Botão Editar -->
    <button  
        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
        onclick="window.location.href='editar_formadm.php?id=<?php echo $cortes_cads['id_horario']; ?>'">
        <!-- Ícone à esquerda do texto -->
        <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
            </svg>
            <span>Editar</span>
        </div>
    </button>

    <!-- Botão Excluir -->
    <button 
        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
        onclick="cancelService(event, this)">
        <!-- Ícone à esquerda do texto -->
        <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
            </svg>
            <span>Cancelar</span>
        </div>
    </button>
</div>

        </div>
    <?php } ?>
</div>
<script>

function cancelService(event, button) {
    event.preventDefault(); // Previne o comportamento padrão do botão

    const agendamentoId = button.closest('.agendamento').getAttribute('data-id'); // Recupera o ID do agendamento

    // Solicitar motivo para o cancelamento
    Swal.fire({
        title: "Informe o motivo do cancelamento abaixo",
        input: 'textarea',
        inputPlaceholder: 'Descreva o motivo aqui...',
        showCancelButton: true,
        confirmButtonColor: "#00FF00", // Cor mais escura para o botão de confirmação
        cancelButtonColor: "#FF3019", // Cor mais escura para o botão de cancelamento
        confirmButtonText: 'Confirmar Cancelamento',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            if (!value) {
                return 'Você precisa informar um motivo!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
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
                    // Envia a requisição para excluir o agendamento
                    fetch('cancelar_agendamento.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_horario=${agendamentoId}&motivo=${encodeURIComponent(result.value)}`
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Cancelado!",
                                text: "O serviço foi cancelado com sucesso",
                                icon: "success"
                            }).then(() => {
                                // Remover o agendamento da tela
                                const agendamentoDiv = button.closest('.agendamento');
                                if (agendamentoDiv) {
                                    agendamentoDiv.remove();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Erro!",
                                text: data.message || "Ocorreu um erro ao cancelar o serviço.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    });
}



function concluirServico(idHorario) {
    // Exibe o alerta de confirmação
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, conclude it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Se o usuário confirmar, envia a requisição para concluir o serviço
            fetch('concluir_servico.php', {
                method: 'POST',
                body: JSON.stringify({ id_horario: idHorario }),
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Exibe a mensagem de sucesso
                    Swal.fire({
                        title: "Concluded!",
                        text: "The service has been concluded.",
                        icon: "success"
                    });

                    // Atualiza o status visual do serviço para "concluído"
                    const serviceElement = document.querySelector(`[data-id="${idHorario}"]`);
                    if (serviceElement) {
                        serviceElement.classList.add('bg-green-500'); // Alterando a cor de fundo para indicar que foi concluído
                        serviceElement.querySelector('button').style.display = 'none'; // Escondendo o botão "Concluir"
                    }
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "There was an error concluding the service.",
                        icon: "error"
                    });
                }
            });
        }
    });
}

</script>
<br><br>
<footer class="bg-gray-800 py-10 bottom-0 w-full text-center">
  <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
      <div class="sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center mb-4 sm:mb-0 rtl:space-x-reverse">
          <img src="img/logo_markk.png" class="h-20" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark text-white">
              Equipe MAR<span class="text-blue-700">KK</span>
          </span>
          <div class="ml-auto text-white">
              <a href="https://www.instagram.com/markk.tcc/" class="hover:underline me-4 md:me-6">
                <i class="fab fa-instagram fa-1x mr-1"></i>
                Instagram da Equipe
              </a>
          </div>
      </div>
      <div class="text-white text-left">
          <p>Transforme sua experiência com a MARKK!</p>
      </div>
      
          <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-white sm:mb-0 dark:text-gray-400">
            <li>
              
          </li>
          
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <span class="block text-sm text-white sm:text-center dark:text-gray-400">© 2024 <a href="" class="hover:underline">MARKK</a>. All Rights Reserved.</span>
  </div>
</footer>

</body>
</html>
