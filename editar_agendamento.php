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
    <h1 class="text-3xl font-bold flex-grow text-center">Serviços Agendados</h1>
    <div class="mr-5"></div> <!-- Garante que o H1 fique centralizado -->
</div>
<br><br><br>

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

<br><br><br>

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
