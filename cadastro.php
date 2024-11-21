<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    $nm_usuario = mysqli_real_escape_string($conn, $_POST['nm_usuario']);
    $nm_sobrenome_usuario = mysqli_real_escape_string($conn, $_POST['nm_sobrenome_usuario']);
    $nr_usuario = mysqli_real_escape_string($conn, $_POST['nr_usuario']);
    $nm_senha = mysqli_real_escape_string($conn, $_POST['nm_senha']);

    // Consulta para inserir dados
    $cadastrar = mysqli_query($conn, "INSERT INTO usuarios (nm_usuario, nr_telefone, nm_senha) VALUES ('$nm_usuario', '$nr_usuario', '$nm_senha')");

    // Se o cadastro for bem-sucedido, redireciona para inicio.html
    if ($cadastrar) {
        header("Location: inicio.html");
        exit();
    } else {
        echo "Erro ao cadastrar. Tente novamente.";
        echo "Erro: " . mysqli_error($conn); // Adiciona essa linha para ver o erro específico
    }

    // Fecha a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Markk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Carrossel -->
    <div id="default-carousel" class="relative w-full mb-4" data-carousel="slide">
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
    </div>

    <!-- Container de Formulário -->
    <div class="flex items-center justify-center min-h-screen relative -mt-20">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8 relative">
            <!-- Botão de Cadastro Flutuante -->
            <a href="loginfunc.php" class="absolute top-7 right-1">
                <button class="bg-gray-800 text-white font-bold py-2 px-2 rounded transition duration-300">
                    Administrador
                </button>
            </a>

            <!-- Texto de Boas-vindas -->
            <div class="p-8">
                <h1 class="text-4xl font-bold text-yellow-400 mb-4">Bem Vindo!!!</h1>
                <h4 class="font-bold text-left text-yellow-400 mb-4">Estamos dedicados a oferecer o melhor serviço para você!</h4>
            </div>

            <!-- Formulário de Cadastro -->
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg mt-4">
                <h3 class="text-2xl text-center font-bold text-gray-100 mb-4">Cadastre-se</h3>
                <form action="cadastro.php" method="POST">
                <div class="mb-4">
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="nm_usuario">Nome</label>
    <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-yellow-300" 
           name="nm_usuario" type="text" placeholder="Adicione seu Nome" required 
           oninput="validarEntrada(this)" />
</div>

<div class="mb-4">
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="nm_sobrenome_usuario">Sobrenome</label>
    <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-yellow-300" 
           name="nm_sobrenome_usuario" type="text" placeholder="Adicione seu Sobrenome" required 
           oninput="validarEntrada(this)" />
</div>

<div class="mb-4">
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="nr_usuario">Telefone</label>
    <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-yellow-300" 
           name="nr_usuario" type="text" placeholder="Adicione seu telefone" required 
           oninput="validarTelefone(this)" />
</div>

<div class="mb-4">
    <label class="block text-gray-300 text-sm font-semibold mb-2" for="nm_senha">Senha</label>
    <div class="relative">
        <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-yellow-300" 
               id="senha" name="nm_senha" type="password" placeholder="Crie uma senha" required />
        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 focus:outline-none" id="btn-visualizar" type="button">
            <span class="material-icons" id="icon-visibility">visibility_off</span>
        </button>
    </div>
</div>

<script>
  // Função para validar entrada de texto (letras e espaços) para nome e sobrenome
  function validarEntrada(input) {
    // Remove qualquer caractere que não seja letra ou espaço
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
  }

  // Função para validar telefone (aceitando apenas números)
  function validarTelefone(input) {
    // Remove qualquer caractere que não seja número (aceita apenas números)
    input.value = input.value.replace(/[^0-9]/g, '');
  }

  // Exemplo para visualizar a senha (não modifica a validação da senha)
  const btnVisualizar = document.getElementById("btn-visualizar");
  const senhaInput = document.getElementById("senha");
  const iconVisibility = document.getElementById("icon-visibility");

  btnVisualizar.addEventListener("click", () => {
    if (senhaInput.type === "password") {
      senhaInput.type = "text";
      iconVisibility.textContent = "visibility";
    } else {
      senhaInput.type = "password";
      iconVisibility.textContent = "visibility_off";
    }
  });
</script>


                    <div class="mb-6 flex items-center">
                        <input type="checkbox" id="myCheckbox" class="mr-2">
                        <label for="myCheckbox" class="text-white text-sm">Salvar suas informações</label>
                    </div>

                    <div class="flex items-center justify-center">
                        <button class="w-full bg-yellow-400 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400" type="submit" id="submit" name="submit">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
