<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Markk</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body class="bg-gray-100 font-DM-Sans flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full">
    <h1 class="text-2xl font-bold text-center text-gray-800">
      <span class="text-yellow-400">Bem Vindo</span><br> Administrador!
    </h1>
    <h4 class="text-center text-gray-600 mt-2">Estávamos te esperando, vamos lá?</h4>

    <div class="mt-6">
      <label for="name" class="block text-gray-700">Informe seu Nome</label>
      <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200" name="nm_usuario" type="text" placeholder="Adicione seu Nome" id="name">

      <label for="codigo" class="block mt-4 text-gray-700">Insira o código de login</label>
      <div class="relative">
        <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200" id="codigo" name="codigo" type="password" placeholder="Adicione sua senha">
        <button class="absolute inset-y-0 right-0 flex items-center pr-3" id="btn-visualizar" type="button">
          <i class="material-icons">visibility_off</i>
        </button>
      </div>

      <span class="block mt-4 text-gray-800 font-bold cursor-pointer text-center" onclick="showAlert()">Esqueci o código</span>

      <div class="mt-6">
        <a href="logfunc.php">
          <button class="w-full bg-yellow-400 hover:bg-yellow-600 text-white font-bold py-2 rounded-md transition">Entrar</button>
        </a>
      </div>
    </div>
  </div>

  <script>
    const input = document.getElementById('codigo');

    input.addEventListener('input', (e) => {
      if (e.target.value.length > 4) {
        e.target.value = e.target.value.slice(0, 4);
      }
    });

    const senhaInput = document.getElementById('codigo');
    const btnVisualizar = document.getElementById('btn-visualizar');

    btnVisualizar.addEventListener('click', () => {
      if (senhaInput.type === 'password') {
        senhaInput.type = 'text';
        btnVisualizar.querySelector('i').textContent = 'visibility';
      } else {
        senhaInput.type = 'password';
        btnVisualizar.querySelector('i').textContent = 'visibility_off';
      }
    });

    function showAlert() {
      Swal.fire({
  title: "Código de Verificação enviado com sucesso!",
  text: "Verifique sua caixa de Email",
  icon: "info",
        

});}
  </script>
</body>
</html>
