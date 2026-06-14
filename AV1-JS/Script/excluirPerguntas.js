// Arquivo: Script/excluirPerguntas.js

// Variável para guardar todas as perguntas em memória
let todasAsPerguntas = { texto: [], multipla: [] };

// 1. Carrega todas as perguntas do banco (reutilizando a API existente!)
async function carregarDados() {
    try {
        const response = await fetch('../Banco/getAllPerguntas.php');
        const dados = await response.json();

        if (dados.sucesso) {
            todasAsPerguntas.texto = dados.texto;
            todasAsPerguntas.multipla = dados.multipla;
        }
    } catch (error) {
        console.error('Erro ao carregar dados:', error);
    }
}

// 2. Evento para quando o usuário trocar o tipo de pergunta (Radio Buttons)
const radios = document.querySelectorAll('input[name="tipoPergunta"]');
radios.forEach(radio => {
    radio.addEventListener('change', function() {
        preencherSelect(this.value);
    });
});

// 3. Função para preencher o dropdown
function preencherSelect(tipo) {
    const seletor = document.getElementById('seletorPergunta');
    seletor.innerHTML = '<option value="">-- Selecione a pergunta --</option>';
    
    // Libera o select para uso
    seletor.disabled = false;

    // Pega a lista correta baseada no tipo escolhido (texto ou multipla)
    const lista = todasAsPerguntas[tipo];

    if (lista.length === 0) {
        seletor.innerHTML = '<option value="">Nenhuma pergunta cadastrada neste tipo.</option>';
        seletor.disabled = true;
        return;
    }

    lista.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = `ID: ${item.id} - ${item.pergunta.substring(0, 50)}...`;
        seletor.appendChild(option);
    });
}

// 4. Envio do formulário para DELETAR
document.getElementById('formExcluir').addEventListener('submit', async function(event) {
    event.preventDefault();

    const idSelecionado = document.getElementById('seletorPergunta').value;
    const tipoSelecionado = document.querySelector('input[name="tipoPergunta"]:checked').value;

    if (!idSelecionado) {
        alert("Por favor, selecione uma pergunta válida.");
        return;
    }

    // Confirmação de segurança (boa prática antes de usar DELETE)
    const confirmar = confirm("Tem certeza que deseja apagar esta pergunta? Esta ação não pode ser desfeita.");
    if (!confirmar) return;

    try {
        const response = await fetch('../Banco/deletePergunta.php', {
            method: 'DELETE', // Método HTTP semântico para exclusão
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id: idSelecionado,
                tipo: tipoSelecionado
            })
        });

        const resultado = await response.json();

        if (resultado.sucesso) {
            alert('Pergunta excluída com sucesso!');
            
            // Limpa a tela
            document.getElementById('seletorPergunta').innerHTML = '<option value="">Escolha um tipo acima primeiro...</option>';
            document.getElementById('seletorPergunta').disabled = true;
            document.getElementById('formExcluir').reset();
            
            // Recarrega os dados do banco para atualizar a memória
            carregarDados();
        } else {
            alert('Erro: ' + resultado.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de comunicação com o servidor.');
    }
});

// Busca os dados assim que a tela abre
carregarDados();