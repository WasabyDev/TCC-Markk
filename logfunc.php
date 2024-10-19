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

    <script>
        function showDelet() {
            Swal.fire({
                title: 'Código Enviado',
                text: 'Um código foi enviado para o número de origem!',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <br>

    <div class="bg-yellow-400 text-white p-4 rounded-lg shadow-md text-center mb-6">
        <h1 class="text-2xl font-bold">Clientes Agendados</h1>
    </div>

    <div class="mb-6">
        <form method="POST" action="">
            <div class="flex items-center space-x-2">
                <input class="flex-grow p-2 border rounded-lg" type="text" name="nome_atendente" placeholder="Pesquisar por atendente" value="<?php echo htmlspecialchars($nome_atendente); ?>">
                <button type="submit" class="bg-yellow-400 text-white p-2 rounded-lg hover:bg-yellow-500 transition">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </div>
        </form>
    </div>

   

    <div class="space-y-6">
        <?php while($cortes_cads = mysqli_fetch_assoc($result)) { ?>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">Data: <span class="font-normal"><?php echo $cortes_cads['dt_corte']; ?></span></h3>
                        <h3 class="text-lg font-semibold">Horário: <span class="font-normal"><?php echo $cortes_cads['hr_corte']; ?></span></h3>
                        <h3 class="text-lg font-semibold">Atendente: <span class="font-normal"><?php echo $cortes_cads['nm_funcionario']; ?></span></h3>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-green-500 text-white p-2 rounded hover:bg-green-400 transition" onclick="confirmCorte(event)">
                            <span class="material-symbols-outlined">check</span>
                        </button>
                        <button class="bg-red-500 text-white p-2 rounded hover:bg-red-400 transition" onclick="confirmDelete(event)">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>
                <h3 class="font-semibold mt-4">Nome: </h3>
                <p>Número: </p>
                <p>Tipo de Corte: <span class="font-normal"><?php echo $cortes_cads['nm_corte']; ?></span></p>
                <p>Forma de Pagamento: </p>
                <p class="font-bold">Valor: <span class="font-normal"><?php echo $cortes_cads['vl_corte']; ?></span></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
