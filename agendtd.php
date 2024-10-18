<?php
include_once('config.php'); // Inclua a configuração
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura dos dados do formulário
    $data = $_POST['data'] ?? '';
    $horario = $_POST['hr_corte'] ?? '';
    $servico = $_POST['selectedService'] ?? '';
    $valor = $_POST['vl_corte'] ?? '';
    $atendente = $_POST['selectedEmployee'] ?? '';

    // Substitui vírgula por ponto no valor do corte
    $valor = str_replace(',', '.', $valor);

    // Preparar e vincular
    $stmt = $conn->prepare("INSERT INTO agendamentos (dt_corte, hr_corte, nm_corte, vl_corte, nm_forma_pagamento) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data, $horario, $servico, $valor, $atendente);

    // Executar a consulta
    if ($stmt->execute()) {
        // Redirecionar para uma página de sucesso ou exibir mensagem de sucesso
        header("Location: confirmar.html"); // Alterar para o seu arquivo de redirecionamento
        exit(); // Certifique-se de chamar exit após o redirecionamento
    } else {
        echo "Erro ao agendar: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Corte - Markk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="flex items-center justify-between p-4 bg-yellow-400 text-white shadow-lg">
        <a href="inicio.html" class="text-white flex items-center">
            <span class="ml-2">Voltar</span>
        </a>
        <h1 class="text-xl font-bold">Agendar Corte</h1>
        <div></div>
    </div>

    <div class="container mx-auto py-10">
        <form action="agendtd.php" method="post" class="bg-white shadow-md rounded-lg p-8">
            <div class="mb-6">
                <label for="data" class="block text-gray-700 font-bold mb-2">Selecione a data:</label>
                <input type="date" id="data" name="data" onchange="updateDisplayDate(this.value); verificarHorariosOcupados(this.value);" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" class="border border-gray-300 rounded-lg w-full py-2 px-3 focus:outline-none focus:ring focus:ring-yellow-400" required>
                <p id="displayDate" class="mt-2 text-gray-600"></p>
            </div> 

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Selecione o horário:</label>
                <div class="relative">
                    <button type="button" id="dropdownButtonHorario" onclick="toggleDropdownHorario()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left">
                        Horários Disponíveis
                    </button>
                    <div class="absolute z-10 hidden bg-white border border-gray-300 mt-1 rounded-lg shadow-lg w-full max-h-60 overflow-y-auto" id="myDropdownHorario"></div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Selecione o corte:</label>
                <div class="relative">
                    <button type="button" id="dropdownButtonCuts" onclick="toggleDropdownCuts()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left">
                        Serviços Disponíveis
                    </button>
                    <div class="absolute z-10 hidden bg-white border border-gray-300 mt-1 rounded-lg shadow-lg" id="myDropdownCuts">
                        <a href="#" onclick="selectOptionCuts('35,00', 'Corte Clássico')" class="block px-4 py-2 hover:bg-gray-200">Corte Clássico</a>
                        <a href="#" onclick="selectOptionCuts('45,00', 'Clássico com Sombrancelha')" class="block px-4 py-2 hover:bg-gray-200">Clássico com Sombrancelha</a>
                        <a href="#" onclick="selectOptionCuts('50,00', 'Completão')" class="block px-4 py-2 hover:bg-gray-200">Completão</a>
                        <a href="#" onclick="selectOptionCuts('25,00', 'Barba')" class="block px-4 py-2 hover:bg-gray-200">Barba</a>
                    </div>
                </div>
            </div>

            <input type="hidden" id="selectedService" name="selectedService" value="">
            <input type="hidden" id="vl_corte" name="vl_corte" value="">
            <input type="hidden" id="hr_corte" name="hr_corte" value="">

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Selecione o Atendente:</label>
                <div class="relative">
                    <button type="button" id="dropdownButtonEmployees" onclick="toggleDropdownEmployees()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left">
                        Atendentes
                    </button>
                    <div class="absolute z-10 hidden bg-white border border-gray-300 mt-1 rounded-lg shadow-lg" id="myDropdownEmployees">
                        <a href="#" onclick="selectOptionEmployees('Ricardo')" class="block px-4 py-2 hover:bg-gray-200">Ricardo</a>
                        <a href="#" onclick="selectOptionEmployees('Rubens')" class="block px-4 py-2 hover:bg-gray-200">Rubens</a>
                        <a href="#" onclick="selectOptionEmployees('Matheus')" class="block px-4 py-2 hover:bg-gray-200">Matheus</a>
                        <a href="#" onclick="selectOptionEmployees('Sem Preferencia')" class="block px-4 py-2 hover:bg-gray-200">Sem Preferencia</a>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="text-gray-700 font-bold">Confirme as informações antes de agendar:</label>
                <p class="text-gray-600">Data: <span class="font-semibold" id="displayDateOutput"></span></p>
                <p class="text-gray-600">Horário: <span class="font-semibold" id="selectedHorario"></span></p>
                <p class="text-gray-600">Atendente: <span class="font-semibold" id="selectedEmployee"></span></p>
                <h2 class="text-2xl font-bold mt-4">Total: <span class="font-semibold" id="selectedCut">**,**</span></h2>

            </div>

            <div class="flex justify-center mb-6">
    <button type="submit" id="submit" name="agendar" class="bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-5 px-20 rounded focus:outline-none">Agendar</button>
</div>

        </form>
    </div>
    <br><br>
    <footer class="bg-gray-800 text-white py-10 bottom-0 w-full text-center">
            <div class="container mx-auto">
                <p>&copy; 2024 Barbearia da Garagem. Todos os direitos reservados.</p>
            </div>
        </footer>

    <script>
        let horariosOcupados = [];
        let horarioSelecionado = null;

        async function verificarHorariosOcupados(data) {
            const response = await fetch('verificar_horarios.php?data=' + data);
            const dataOcupados = await response.json();
            horariosOcupados = dataOcupados.horarios;
            gerarHorarios(); // Regenerar os horários disponíveis após a verificação
        }

        function updateDisplayDate(data) {
            document.getElementById('displayDateOutput').textContent = data;
        }

        function selectOptionCuts(price, service) {
            document.getElementById('selectedService').value = service;
            document.getElementById('vl_corte').value = price; 
            document.getElementById('dropdownButtonCuts').textContent = service; 
            document.getElementById('selectedCut').textContent = price;
            toggleDropdownCuts(); 
        }

        function selectOptionEmployees(employee) {
            document.getElementById('dropdownButtonEmployees').textContent = employee;
            document.getElementById('selectedEmployee').textContent = employee;
            toggleDropdownEmployees();
        }

        function selectOptionHorario(horario) {
            horarioSelecionado = horario; // Salvar o horário selecionado
            document.getElementById('dropdownButtonHorario').textContent = horario;
            document.getElementById('selectedHorario').textContent = horario;
            document.getElementById('hr_corte').value = horario; // Definir o valor do horário oculto
            toggleDropdownHorario(); 
        }

        function toggleDropdownCuts() {
            const dropdown = document.getElementById('myDropdownCuts');
            dropdown.classList.toggle("hidden");
        }

        function toggleDropdownEmployees() {
            const dropdown = document.getElementById('myDropdownEmployees');
            dropdown.classList.toggle("hidden");
        }

        function toggleDropdownHorario() {
            const dropdown = document.getElementById('myDropdownHorario');
            dropdown.classList.toggle("hidden");
        }

        function gerarHorarios() {
            const dropdownHorario = document.getElementById("myDropdownHorario");
            dropdownHorario.innerHTML = '';

            for (let hora = 9; hora < 19; hora++) {
                for (let minuto = 0; minuto < 60; minuto += 20) {
                    const horario = `${String(hora).padStart(2, '0')}:${String(minuto).padStart(2, '0')}`;
                    if (!horariosOcupados.includes(horario) && horario !== horarioSelecionado) {
                        const link = document.createElement("a");
                        link.href = "#";
                        link.className = "block px-4 py-2 text-gray-700 hover:bg-yellow-100";
                        link.onclick = () => selectOptionHorario(horario);
                        link.textContent = horario;
                        dropdownHorario.appendChild(link);
                    }
                }
            }

            const horarioFinal = '19:00';
            if (!horariosOcupados.includes(horarioFinal) && horarioFinal !== horarioSelecionado) {
                const linkFinal = document.createElement("a");
                linkFinal.href = "#";
                linkFinal.className = "block px-4 py-2 text-gray-700 hover:bg-yellow-100";
                linkFinal.onclick = () => selectOptionHorario(horarioFinal);
                linkFinal.textContent = horarioFinal;
                dropdownHorario.appendChild(linkFinal);
            }
        }

        window.onload = () => {
            gerarHorarios();
            verificarHorariosOcupados(document.getElementById('data').value);
        };
    </script>
</body>
</html>
