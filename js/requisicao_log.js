// Validação de CPF simples
function validarCPF(cpf) {
    if (!/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/.test(cpf)) {
        return false;
    }
    return true;
}

document.getElementById("cadastroForm").addEventListener("submit", function (e) {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const cpf = document.getElementById("cpf").value;
    const dataNascimento = document.getElementById("data_nascimento").value;

    if (nome.split(" ").length < 2) {
        alert("O campo Nome deve conter nome completo.");
        e.preventDefault();
    } else if (!validarCPF(cpf)) {
        alert("CPF inválido. O formato correto é XXX.XXX.XXX-XX.");
        e.preventDefault();
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const senhaInput = document.getElementById("senha");
    const errorMessageBox = document.getElementById("error-message");

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        // Verificar se o usuário está bloqueado
        const blockedUntil = localStorage.getItem("loginBlockedUntil");

        if (blockedUntil && Date.now() < blockedUntil) {
            errorMessageBox.textContent = "Tentativas de login bloqueadas. Tente novamente em 5 minutos.";
            return;
        }

        const email = emailInput.value;
        const senha = senhaInput.value;

        // Enviar solicitação AJAX para autenticação
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "autenticar.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Redirecionar para "index.html" após login bem-sucedido
                    window.location.href = "../cursos/index.php";
                } else {
                    // Exibir mensagem de erro
                    errorMessageBox.textContent = "Usuário ou senha incorretos.";
                    
                    // Contabilizar a tentativa de login falha
                    const loginAttempts = parseInt(localStorage.getItem("loginAttempts")) || 0;
                    localStorage.setItem("loginAttempts", loginAttempts + 1);

                    // Bloquear o usuário se exceder 10 tentativas
                    if (loginAttempts + 1 >= 10) {
                        const blockedUntil = Date.now() + 300000; // 5 minutos em milissegundos
                        localStorage.setItem("loginBlockedUntil", blockedUntil);
                    }
                }
            } else {
                // Tratamento de erro para solicitação AJAX
                console.error("Erro na solicitação AJAX");
            }
        };

        // Enviar os dados do formulário
        const data = `email=${encodeURIComponent(email)}&senha=${encodeURIComponent(senha)}`;
        xhr.send(data);
    });
});


