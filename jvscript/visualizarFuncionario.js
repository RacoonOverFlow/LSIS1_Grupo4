document.addEventListener("DOMContentLoaded", function () {
    const sortButton = document.createElement("button");
    sortButton.textContent = "Ordenar por Aniversário";
    sortButton.className = "button-export";
    sortButton.type = "button"; // evita submit do form

    const container = document.querySelector(".tabela-funcionarios");
    if (container) {
        container.prepend(sortButton);

        // Aqui só mexemos no container que tem as linhas:
        const linhasContainer = container.querySelector(".linhas-container");

        if (sortButton && linhasContainer) {
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
        }
    }
    
    // Handler para botões de reativar
    document.querySelectorAll('.btn-reativar').forEach(button => {
        button.addEventListener('click', function() {
            const numero = this.getAttribute('data-numero');
            if (confirm('Tem certeza que deseja reativar este funcionário?')) {
                // Chamada AJAX para reativar
                fetch(`/LSIS1_Grupo4/BLL/export_importData_bll.php?action=reativar&numero=${numero}`)
                    .then(response => {
                        if (response.ok) {
                            alert('Funcionário reativado com sucesso!');
                            location.reload();
                        } else {
                            alert('Erro ao reativar funcionário.');
                        }
                    });
            }
        });
    });
});