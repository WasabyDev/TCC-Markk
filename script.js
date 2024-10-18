const box = document.querySelector(".cont-carrossel");
const imagens = document.querySelectorAll(".cont-carrossel .img-carrossel");

let contador = 0;

function slide() {
    contador++;

    if (contador > imagens.length - 1) {
        contador = 0;
    }

    box.style.transform = `translateX(${-contador * 450}px)`;
}

setInterval(slide, 2000);
/////

//DOWNDROPER

function toggleDropdownDays() {
    document.getElementById("myDropdownDays").classList.toggle("show");
}

function selectOptionDays(optionText) {
    document.getElementById("dropdownButtonDays").textContent = optionText;
    document.getElementById("selectedOption").textContent = `Seu serviço será agendado para: ${optionText}`;
    toggleDropdownDays();
}

function toggleDropdownCuts() {
    document.getElementById("myDropdownCuts").classList.toggle("show");
}

function selectOptionCuts(optionPrice, optionText) {
    document.getElementById("dropdownButtonCuts").textContent = optionText;
    document.getElementById("selectedCut").textContent = `R$ ${optionPrice}`;
    toggleDropdownCuts();
}

function toggleDropdownEmployees() {
    document.getElementById("myDropdownEmployees").classList.toggle("show");
}

function selectOptionEmployees(employeeName) {
    document.getElementById("dropdownButtonEmployees").textContent = employeeName;
    document.getElementById("selectedEmployee").textContent = `Com o atendente ${employeeName}`;
    toggleDropdownEmployees();
}

function toggleDropdownHorario() {
    document.getElementById("myDropdownHorario").classList.toggle("show");
}

function selectOptionHorario(horario) {
    document.getElementById("dropdownButtonHorario").textContent = horario;
    document.getElementById("selectedHorario").textContent = `Às: ${horario}`;
    toggleDropdownHorario();
}

// Chamar a função para gerar os horários quando a página carregar
window.onload = gerarHorarios;



// Fecha o dropdown se o usuário clicar fora dele
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
                setTimeout(() => {
                    openDropdown.style.maxHeight = "0"; // Reseta max-height para animação de fechamento
                }, 300); // Deve coincidir com a duração da animação
            }
        }
    }
}

// Fecha o modal quando o usuário clica no botão de fechar
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Fecha o modal se o usuário clicar fora do conteúdo do modal
window.onclick = function(event) {
    if (event.target == document.getElementById("myModal")) {
        closeModal();
    }
}
//Confirmação do código de segurança
const inputSenha = document.querySelector('.inpt');

inputSenha.addEventListener('input', () => {
    const valor = inputSenha.value;
    if (valor.length > 8) {
        inputSenha.value = valor.slice(0, 8);
    }
});

function confirmDelete() {
    if (confirm("Você tem certeza que deseja excluir?")) {
      // código para excluir o item aqui
      alert('Item excluído com sucesso!');
    }
  }


  function confirmDelete(event) {
    var div = event.target.closest('.container-cli-agnd');
    if (confirm("Você tem certeza que deseja excluir?")) {
      // código para excluir o item aqui
      div.remove();
      alert('Item excluído com sucesso!');
    }
  }

  function confirmCorte() {
    if (confirm("Você tem certeza que o serviço foi concluído?")) {
      // código para excluir o item aqui
      alert('Serviço concluído com sucesso!');
    }
  }


  function confirmCorte(event) {
    var div = event.target.closest('.container-cli-agnd');
    if (confirm("Você tem certeza que o serviço foi concluído?")) {
      // código para excluir o item aqui
      div.remove();
      alert('Serviço concluído com sucesso!');
    }
  }




