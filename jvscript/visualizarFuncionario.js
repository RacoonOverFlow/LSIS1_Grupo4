document.addEventListener("DOMContentLoaded", function () {
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
                } else {
                    linha.style.display = 'none';
                }
            }
        });
    };

    window.sortFuncionarios = function(criterio) {
        const linhasContainer = document.querySelector('.linhas-container');
        const linhas = Array.from(linhasContainer.querySelectorAll('.linha-funcionario:not(.cabecalho)'));
        
        linhas.sort((a, b) => {
            let valorA, valorB;
            
            if (criterio === 'aniversario') {
                valorA = new Date(a.querySelector('.coluna.aniversario').dataset.aniversario);
                valorB = new Date(b.querySelector('.coluna.aniversario').dataset.aniversario);
            } else {
                valorA = a.querySelector(`.coluna.${criterio}`).textContent.toLowerCase();
                valorB = b.querySelector(`.coluna.${criterio}`).textContent.toLowerCase();
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