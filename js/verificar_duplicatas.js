document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("cadastroForm");
    const campos = ["cpf", "nome", "email"];

    campos.forEach(campo => {
        const inputCampo = document.getElementById(campo);
        inputCampo.addEventListener("blur", function () {
            const valorCampo = inputCampo.value.trim();
            if (valorCampo !== "") {
                verificarDuplicata(campo, valorCampo);
            }
        });
    });

    function verificarDuplicata(campo, valor) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const mensagem = xhr.responseText;
                const mensagemElement = document.getElementById(`${campo}-mensagem`);
                mensagemElement.textContent = mensagem;
            }
        };

        xhr.open("POST", "verificar_duplicatas.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`campo=${campo}&valor=${valor}`);
    }
});
