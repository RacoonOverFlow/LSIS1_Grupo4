document.addEventListener("DOMContentLoaded", () => {
    // Vai buscar todas as divs com alertas atribuídos
    document.querySelectorAll('.alertas-atribuídos').forEach(div => {
        const idFuncionario = div.getAttribute('data-id');
        carregarAlertas(idFuncionario);
    });
});

// Função para buscar os alertas de um funcionário
function carregarAlertas(idFuncionario) {
    fetch(`../API/alertas_api.php?action=getAlertasFuncionario&idFuncionario=${idFuncionario}`)
        .then(response => response.json())
        .then(alertas => {
            const lista = document.getElementById(`lista-alertas-${idFuncionario}`);
            lista.innerHTML = ''; // limpar lista

            if (alertas.length === 0) {
                lista.innerHTML = '<li>Nenhum alerta atribuído.</li>';
            } else {
                alertas.forEach(alerta => {
                    const li = document.createElement('li');
                    li.textContent = alerta.mensagem + ' ';
                    
                    const btn = document.createElement('button');
                    btn.textContent = 'Remover';
                    btn.classList.add('btn-remover-alerta');
                    btn.onclick = () => removerAlerta(alerta.idAlertaFuncionario, idFuncionario);

                    // Adiciona o estado de visto/não visto
                    const spanVisto = document.createElement('span');
                    spanVisto.textContent = alerta.visualizado == 1 ? ' Visto ✅' : ' Não Visto ❌';
                    spanVisto.style.marginLeft = '10px';

                    li.appendChild(btn);
                    li.appendChild(spanVisto);
                    lista.appendChild(li);
                });
            }
        })
        .catch(error => {
            console.error('Erro ao carregar alertas:', error);
        });
}

// Função para remover alerta
function removerAlerta(idAlertaFuncionario, idFuncionario) {
    fetch(`../API/alertas_api.php?action=removerAlertaFuncionario&idAlertaFuncionario=${idAlertaFuncionario}`, {
        method: 'DELETE'
    })
    .then(response => response.ok ? carregarAlertas(idFuncionario) : console.error("Erro ao remover alerta"))
    .catch(error => console.error('Erro:', error));
}
