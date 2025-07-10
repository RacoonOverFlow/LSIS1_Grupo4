document.addEventListener("DOMContentLoaded", function() {
    // Funções de filtragem e ordenação
    window.filterFuncionarios = function(searchField) {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const linhas = document.querySelectorAll('.linha-funcionario:not(.cabecalho)');
        
        linhas.forEach(linha => {
            const coluna = linha.querySelector(`.coluna.${searchField}`);
            if (coluna) {
                const textoColuna = coluna.textContent.toLowerCase();
                if (textoColuna.includes(input)) {
                    linha.style.display = 'flex';
                    linha.parentElement.style.display = 'flex';
                } else {
                    linha.style.display = 'none';
                    linha.parentElement.style.display = 'none';
                }
            }
        });
    };

    window.sortFuncionarios = function(criterio) {
        const linhasContainer = document.querySelector('.linhas-container');
        const linhas = Array.from(linhasContainer.querySelectorAll('.linha-container:has(.linha-funcionario:not(.cabecalho))'));
        
        linhas.sort((a, b) => {
            let valorA, valorB;
            const linhaA = a.querySelector('.linha-funcionario');
            const linhaB = b.querySelector('.linha-funcionario');
            
            if (criterio === 'aniversario') {
                valorA = new Date(linhaA.querySelector('.coluna.aniversario').dataset.aniversario);
                valorB = new Date(linhaB.querySelector('.coluna.aniversario').dataset.aniversario);
            } else {
                valorA = linhaA.querySelector(`.coluna.${criterio}`).textContent.toLowerCase();
                valorB = linhaB.querySelector(`.coluna.${criterio}`).textContent.toLowerCase();
            }
            
            if (criterio === 'aniversario') {
                return valorA - valorB;
            } else {
                return valorA.localeCompare(valorB);
            }
        });
        
        // Reinserir linhas ordenadas
        linhas.forEach(linha => linhasContainer.appendChild(linha));
    };

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