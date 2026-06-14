// Arquivo: Script/alterarPT.js

let listaPerguntas = [];

// 1. Carregar as perguntas de texto
async function carregarPerguntas() {
    try {
        const response = await fetch('../Banco/getPerguntasTexto.php');
        listaPerguntas = await response.json();

        const seletor = document.getElementById('seletorPergunta');
        seletor.innerHTML = '<option value="">-- Selecione uma pergunta --</option>';

        listaPerguntas.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            // Limita o texto para não estourar a tela
            option.textContent = item.id + ' - ' + item.pergunta.substring(0, 60) + '...';
            seletor.appendChild(option);
        });
    } catch (error) {
        console.error("Erro ao carregar perguntas:", error);
    }
}

// 2. Preencher o formulário ao selecionar uma pergunta
document.getElementById('seletorPergunta').addEventListener('change', function() {
    const idSelecionado = this.value;
    const form = document.getElementById('formPT');

    if (!idSelecionado) {
        form.style.display = 'none';
        return;
    }

    const perguntaEditada = listaPerguntas.find(p => p.id == idSelecionado);

    if (perguntaEditada) {
        document.getElementById('idPergunta').value = perguntaEditada.id;
        document.getElementById('pergunta').value = perguntaEditada.pergunta;
        document.getElementById('resposta').value = perguntaEditada.resposta;

        form.style.display = 'block';
    }
});

// 3. Enviar a atualização (UPDATE)
document.getElementById('formPT').addEventListener('submit', async function(event) {
    event.preventDefault();

    const dados = {
        id: document.getElementById('idPergunta').value,
        pergunta: document.getElementById('pergunta').value,
        resposta: document.getElementById('resposta').value
    };

    try {
        const response = await fetch('../Banco/updatePT.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });

        const resultado = await response.json();

        if (resultado.sucesso) {
            alert('Pergunta de texto atualizada com sucesso!');
            carregarPerguntas(); // Atualiza a lista no select
            
            // Reseta a tela
            document.getElementById('formPT').style.display = 'none';
            document.getElementById('seletorPergunta').value = '';
        } else {
            alert('Erro: ' + resultado.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de comunicação com o servidor.');
    }
});

// Inicia carregando as perguntas
carregarPerguntas();