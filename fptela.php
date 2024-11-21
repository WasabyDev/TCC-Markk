<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Concluído</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <style>
        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="bg-gray-100">


    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
             <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="img/barbearia-fotos1.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="img/barbearia-fotos2.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="img/barbearia-fotos3.png" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
         
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    </section>
    <div class="bg-yellow-400 text-white p-4 text-center">
        <h1 class="text-2xl font-bold">Barbearia da Garagem</h1>
    </div>

    <div class="container mx-auto my-10 p-6 bg-gray-800 text-white rounded-lg shadow-lg text-center max-w-md mx-4">
        <h2 class="text-2xl font-semibold mb-4">Selecione uma forma de pagamento:</h2>
        <br>
        <div class="mb-6">
        <div class="relative">
    <button type="button" id="dropdownButtonCuts" onclick="toggleDropdownmetods()" class="border border-gray-300 rounded-lg w-full py-2 px-3 text-left bg-white text-gray-700">
        Serviços Disponíveis
    </button>
    <div class="absolute z-10 hidden bg-white border border-gray-300 mt-1 rounded-lg shadow-lg w-full" id="myDropdownCuts">
        <a href="#" onclick="selectMetods('Dinheiro')" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 text-left">Dinheiro</a>
        <a href="#" onclick="selectMetods('Pix')" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 text-left">Pix</a>
        <a href="#" onclick="selectMetods('Cartão Débito/Crédito')" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 text-left">Cartão Débito/Crédito</a>
    </div>
</div>

<!-- Exibição da seleção do usuário -->
<p class="text-gray-300">Método de pagamento: 
    <span class="font-semibold" id="displayPaymentMethod"></span>
</p>


<!-- Div que irá exibir a opção selecionada abaixo do dropdown -->
<div id="selectedMethod" class="mt-4 text-gray-700"></div>

        <br><br><br>

        <a href="confirmar.html">
            <button class="bg-yellow-400 hover:bg-yellow-300 text-white font-bold py-2 px-4 rounded transition duration-200">Agendar Serviço</button>
        </a>
    </div>
    </div>
    </div>


    <script>
// Função para alternar a visibilidade do dropdown
function toggleDropdownmetods() {
    var dropdown = document.getElementById("myDropdownCuts");
    dropdown.classList.toggle("hidden");
}

// Função para selecionar o método de pagamento e exibir abaixo do dropdown
function selectMetods(paymentMethod) {
    // Fecha o dropdown
    var dropdown = document.getElementById("myDropdownCuts");
    dropdown.classList.add("hidden");

    // Exibe o método selecionado abaixo do dropdown no formato desejado
    var displayElement = document.getElementById("displayPaymentMethod");
    displayElement.innerHTML = paymentMethod; // Atualiza o conteúdo do <span> com o método selecionado
}

    </script>
    <br><br><br><br><br><br>
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
