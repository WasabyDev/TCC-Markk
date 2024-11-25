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

// Variável para acumular o valor total dos cortes
$total_valor = 0;
while($cortes_cads = mysqli_fetch_assoc($result)) {
    $total_valor += $cortes_cads['vl_corte']; // Acumula o valor do corte
}

// Consulta para pegar os dados do usuário
$usuarios = $conn->query("SELECT nm_usuario, nm_sobrenome, nr_telefone FROM usuarios");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markk - Clientes Agendados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex items-center p-4 bg-yellow-500 text-white">
    <a href="logfunc.php" class="flex items-center mr-4">
        <svg class="w-8 h-8 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4l4 4"/>
        </svg>
    </a>
    <h1 class="text-3xl font-bold flex-grow text-center">Relatório Semanal</h1>
    <div class="mr-5"></div> <!-- Garante que o H1 fique centralizado -->
</div>

<!-- Exibe o total dos cortes acima dos agendamentos -->
<div class="container text-white mx-auto my-10 p-6 bg-gray-800 rounded-lg shadow-lg text-center max-w-md mx-4">
    <div class="text-center p-4 font-bold">
        <p>Total da Semana: R$ <?php echo number_format($total_valor, 2, ',', '.'); ?></p>
    </div>
</div>

<div class="space-y-6 mx-4">
    <?php
    // Exibe os agendamentos após o total
    $result->data_seek(0); // Reseta o ponteiro do resultado para o início
    while($cortes_cads = mysqli_fetch_assoc($result)) {
    ?>
        <div class="relative bg-gray-800 text-white p-6 rounded-lg shadow-lg agendamento" data-id="<?php echo $cortes_cads['id_horario']; ?>">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Data: <span class="font-normal"><?php echo $cortes_cads['dt_corte']; ?></span></h3>
                    <h3 class="text-lg font-semibold">Horário: <span class="font-normal"><?php echo $cortes_cads['hr_corte']; ?></span></h3>
                    <h3 class="text-lg font-semibold">Atendente: <span class="font-normal"><?php echo $cortes_cads['nm_funcionario']; ?></span></h3>
                </div>
            </div>
            <h3 class="font-semibold mt-4">Nome: 
                <?php
                // Consulta para obter o primeiro usuário
                $usuarios_result = $conn->query("SELECT nm_usuario, nm_sobrenome, nr_telefone FROM usuarios LIMIT 1");

                if ($usuario_row = mysqli_fetch_assoc($usuarios_result)) {
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
        </div>
    <?php } ?>
</div>

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
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-white sm:text-center dark:text-gray-400">© 2024 <a href="" class="hover:underline">MARKK</a>. All Rights Reserved.</span>
    </div>
</footer>
</body>
</html>
