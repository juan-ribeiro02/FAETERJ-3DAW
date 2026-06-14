// Arquivo: Script/listarPerguntas.js

async function carregarTodasPerguntas() {
    try {
        const response = await fetch('../Banco/getAllPerguntas.php');
        const dados = await response.json();

        if (dados.sucesso) {
            renderizarPerguntasTexto(dados.texto);
            renderizarPerguntasMultipla(dados.multipla);
        } else {
            alert('Erro: ' + dados.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        document.getElementById('containerTexto').innerHTML = '<p class="lista-vazia">Erro ao carregar dados.</p>';
        document.getElementById('containerMultipla').innerHTML = '<p class="lista-vazia">Erro ao carregar dados.</p>';
    }
}

function renderizarPerguntasTexto(perguntas) {
    const container = document.getElementById('containerTexto');
    container.innerHTML = ''; // Limpa o "Carregando..."

    if (perguntas.length === 0) {
        container.innerHTML = '<p class="lista-vazia">Nenhuma pergunta de texto cadastrada.</p>';
        return;
    }

    perguntas.forEach(p => {
        const card = document.createElement('div');
        card.className = 'card-pergunta';
        
        card.innerHTML = `
            <h3>ID: ${p.id} - Enunciado:</h3>
            <p>${p.pergunta}</p>
            <div class="resposta-correta">Resposta Esperada: ${p.resposta}</div>
        `;
        
        container.appendChild(card);
    });
}

function renderizarPerguntasMultipla(perguntas) {
    const container = document.getElementById('containerMultipla');
    container.innerHTML = ''; // Limpa o "Carregando..."

    if (perguntas.length === 0) {
        container.innerHTML = '<p class="lista-vazia">Nenhuma pergunta de múltipla escolha cadastrada.</p>';
        return;
    }

    perguntas.forEach(p => {
        const card = document.createElement('div');
        card.className = 'card-pergunta';
        
        card.innerHTML = `
            <h3>ID: ${p.id} - Enunciado:</h3>
            <p>${p.pergunta}</p>
            <ul>
                <li><strong>1:</strong> ${p.alternativa_1}</li>
                <li><strong>2:</strong> ${p.alternativa_2}</li>
                <li><strong>3:</strong> ${p.alternativa_3}</li>
                <li><strong>4:</strong> ${p.alternativa_4}</li>
            </ul>
            <div class="resposta-correta">Alternativa Correta: ${p.resposta}</div>
        `;
        
        container.appendChild(card);
    });
}

// Inicia o processo de busca assim que o arquivo JS é lido
carregarTodasPerguntas();