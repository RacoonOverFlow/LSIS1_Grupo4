document.addEventListener("DOMContentLoaded", function () {
    const sortButton = document.createElement("button");
    sortButton.textContent = "Ordenar por Aniversário";
    sortButton.className = "button-export";
    sortButton.type = "button"; // evita submit do form

    const container = document.querySelector(".tabela-funcionarios");
    container.prepend(sortButton);

    // Aqui só mexemos no container que tem as linhas:
    const linhasContainer = container.querySelector(".linhas-container");

    sortButton.addEventListener("click", function () {
        const linhas = Array.from(linhasContainer.querySelectorAll(".linha-link"));

        linhas.sort((a, b) => {
            const dataA = new Date(a.querySelector(".coluna.aniversario").dataset.aniversario);
            const dataB = new Date(b.querySelector(".coluna.aniversario").dataset.aniversario);
            return dataA - dataB;
        });

        // Remove todas as linhas para inserir na ordem certa
        linhas.forEach(linha => linhasContainer.appendChild(linha));
    });
});
