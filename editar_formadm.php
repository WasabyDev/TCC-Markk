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
    <title>Agendar Corte - Markk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex items-center p-4 bg-yellow-400 text-white">
    <a href="logfunc.php" class="flex items-center mr-4">
        <svg class="w-8 h-8 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4l4 4"/>
        </svg>
    </a>
    <h1 class="text-3xl font-bold flex-grow text-center">Editar Serviço</h1>
    <div class="mr-5"></div> <!-- Garante que o H1 fique centralizado -->
</div>

<div class="container mx-auto py-10 px-4"> <!-- Adicionei px-4 para espaçamento lateral -->
    <form action="logfunc.php" method="post" class="bg-gray-800 shadow-md rounded-lg p-8 space-y-4"> 
        <div class="mb-6">
            <label for="data" class="block text-gray-200 font-bold mb-2">Selecione a Data:</label>
            <input type="date" id="data" name="data" onchange="updateDisplayDate(this.value); verificarHorariosOcupados(this.value);" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" class="border border-gray-300 rounded-lg w-full py-2 px-3 bg-white text-gray-700 focus:outline-none focus:ring focus:ring-yellow-400" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-200 font-bold mb-2">Selecione o Horário:</label>
            <div class="relative">
                <button type="button" id="dropdownButtonHorario" onclick="toggleDropdownHorario()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left bg-white text-gray-700">
                    Horários Disponíveis
                </button>
                <div class="absolute z-10 hidden bg-white border border-gray-300 mt-1 rounded-lg shadow-lg w-full max-h-60 overflow-y-auto" id="myDropdownHorario"></div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-200 font-bold mb-2">Selecione o Serviço:</label>
            <div class="relative">
                <button type="button" id="dropdownButtonCuts" onclick="toggleDropdownCuts()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left bg-white text-gray-700">
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
            <label class="block text-gray-200 font-bold mb-2">Selecione o Atendente:</label>
            <div class="relative">
                <button type="button" id="dropdownButtonEmployees" onclick="toggleDropdownEmployees()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left bg-white text-gray-700">
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
    <label class="block text-gray-200 font-bold mb-2">Selecione o Método de Pagamento:</label>
    <select id="paymentMethodSelect" name="selectMetods" class="border border-gray-300 rounded-lg w-full py-2 px-3 bg-white text-gray-700 focus:outline-none focus:ring focus:ring-yellow-400" onchange="updatePaymentMethod()">
        <option value="Dinheiro">Dinheiro</option>
        <option value="Cartão de Crédito">Cartão de Crédito</option>
        <option value="Pix">Pix</option>
    </select>
</div>

<input type="hidden" id="selectedEmployee" name="selectedEmployee" value="">
<br><br>

<div class="mb-6">
    <label class="text-gray-200 font-bold">Confirme as informações antes de agendar:</label>
    <p class="text-gray-300">Data: <span class="font-semibold" id="displayDate"></span></p>
    <p class="text-gray-300">Horário: <span class="font-semibold" id="selectedHorario"></span></p>
    <p class="text-gray-300">Atendente: <span class="font-semibold" id="selectedEmployeeDisplay"></span></p>
    <p class="text-gray-300">Forma de Pagamento: <span class="font-semibold" id="selectOptionEmployees"></span></p>

    <h2 class="text-2xl font-bold mt-4 text-gray-300">Total: <span class="font-semibold" id="selectedCut">**,**</span></h2>
</div>

<script>
// Função para atualizar a forma de pagamento exibida
function updatePaymentMethod() {
    var paymentMethod = document.getElementById("paymentMethodSelect").value;
    document.getElementById("selectOptionEmployees").textContent = paymentMethod;
}
</script>
        <br><br>
        <div class="flex justify-end space-x-4">
            <button type="submit" class="bg-yellow-400 text-gray-900 font-bold py-2 px-4 rounded-lg w-full hover:bg-yellow-500">Salvar Alterações</button>
            <a href="logfunc.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancelar</a>
        </div>
    </form>
</div>
<br>
<br>
<br>

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

<script>
    let horariosOcupados = [];
    let horarioSelecionado = null;

    async function verificarHorariosOcupados(data) {
        const response = await fetch('verificar_horarios.php?data=' + data);
        const dataOcupados = await response.json();
        horariosOcupados = dataOcupados.horarios;
        gerarHorarios(); // Regenerar os horários disponíveis após a verificação
    }

    function updateDisplayDate(date) {
        document.getElementById('displayDate').innerText = '' + date;
        document.getElementById('displayDateOutput').textContent = date;  // Atualiza a data na interface
    }

    function selectOptionCuts(price, service) {
        document.getElementById('selectedService').value = service;
        document.getElementById('vl_corte').value = price; 
        document.getElementById('dropdownButtonCuts').textContent = service; 
        document.getElementById('selectedCut').textContent = price;
        toggleDropdownCuts(); // Fecha o dropdown de cortes
    }

    function selectOptionEmployees(employee) {
        document.getElementById('dropdownButtonEmployees').textContent = employee;
        document.getElementById('selectedEmployeeDisplay').textContent = employee;
        document.getElementById('selectedEmployee').value = employee; // Armazenar o atendente
        toggleDropdownEmployees(); // Fecha o dropdown de atendentes
    }

    function selectOptionHorario(horario) {
        horarioSelecionado = horario; // Salvar o horário selecionado
        document.getElementById('dropdownButtonHorario').textContent = horario;
        document.getElementById('selectedHorario').textContent = horario;
        document.getElementById('hr_corte').value = horario; // Definir o valor do horário oculto
        toggleDropdownHorario(); // Fecha o dropdown de horários
    }

    function toggleDropdownCuts() {
        document.getElementById("myDropdownCuts").classList.toggle("hidden");
    }

    function toggleDropdownEmployees() {
        document.getElementById("myDropdownEmployees").classList.toggle("hidden");
    }

    function toggleDropdownHorario() {
        document.getElementById("myDropdownHorario").classList.toggle("hidden");
    }

    function toggleDropdownmetods() {
        document.getElementById("myDropdownmetods").classList.toggle("hidden");
    }

    function selectMetods(paymentMethod) {
        var dropdown = document.getElementById("myDropdownmetods");
        dropdown.classList.add("hidden"); // Fecha o dropdown
        document.getElementById("dropdownButtonmetods").textContent = paymentMethod;
        document.getElementById("displayPaymentMethod").innerHTML = paymentMethod; // Exibe o método de pagamento
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
