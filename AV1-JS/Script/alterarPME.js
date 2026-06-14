// Arquivo: Script/alterarPME.js

let listaPerguntas = []; // Vai guardar as perguntas carregadas do banco

// 1. Função para carregar as perguntas assim que a página abrir
async function carregarPerguntas() {
    try {
        const response = await fetch('../Banco/getPerguntasME.php');
        listaPerguntas = await response.json();

        const seletor = document.getElementById('seletorPergunta');
        seletor.innerHTML = '<option value="">-- Selecione uma pergunta --</option>';

        listaPerguntas.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            // Mostra apenas os primeiros 50 caracteres para não quebrar o layout
            option.textContent = item.id + ' - ' + item.pergunta.substring(0, 50) + '...';
            seletor.appendChild(option);
        });
    } catch (error) {
        console.error("Erro ao carregar perguntas:", error);
    }
}

// 2. Evento para quando o usuário escolher uma pergunta na lista
document.getElementById('seletorPergunta').addEventListener('change', function() {
    const idSelecionado = this.value;
    const form = document.getElementById('formPME');

    if (!idSelecionado) {
        form.style.display = 'none'; // Esconde o form se nada for selecionado
        return;
    }

    // Acha a pergunta completa dentro da nossa lista
    const perguntaEditada = listaPerguntas.find(p => p.id == idSelecionado);

    if (perguntaEditada) {
        // Preenche os campos do formulário
        document.getElementById('idPergunta').value = perguntaEditada.id;
        document.getElementById('pergunta').value = perguntaEditada.pergunta;
        document.getElementById('alt1').value = perguntaEditada.alternativa_1;
        document.getElementById('alt2').value = perguntaEditada.alternativa_2;
        document.getElementById('alt3').value = perguntaEditada.alternativa_3;
        document.getElementById('alt4').value = perguntaEditada.alternativa_4;

        // Lógica para descobrir qual alternative estava certa no Select
        let indexResposta = "";
        if (perguntaEditada.resposta === perguntaEditada.alternativa_1) indexResposta = "1";
        else if (perguntaEditada.resposta === perguntaEditada.alternativa_2) indexResposta = "2";
        else if (perguntaEditada.resposta === perguntaEditada.alternativa_3) indexResposta = "3";
        else if (perguntaEditada.resposta === perguntaEditada.alternativa_4) indexResposta = "4";
        
        document.getElementById('resposta').value = indexResposta;

        // Mostra o formulário
        form.style.display = 'block';
    }
});

// 3. Evento para salvar as alterações (UPDATE)
document.getElementById('formPME').addEventListener('submit', async function(event) {
    event.preventDefault();

    const id = document.getElementById('idPergunta').value;
    const pergunta = document.getElementById('pergunta').value;
    const alternativa_1 = document.getElementById('alt1').value;
    const alternativa_2 = document.getElementById('alt2').value;
    const alternativa_3 = document.getElementById('alt3').value;
    const alternativa_4 = document.getElementById('alt4').value;
    const resposta_select = document.getElementById('resposta').value;

    let resposta_texto = '';
    if (resposta_select === '1') resposta_texto = alternativa_1;
    if (resposta_select === '2') resposta_texto = alternativa_2;
    if (resposta_select === '3') resposta_texto = alternativa_3;
    if (resposta_select === '4') resposta_texto = alternativa_4;

    const dados = {
        id: id,
        pergunta: pergunta,
        alternativa_1: alternativa_1,
        alternativa_2: alternativa_2,
        alternativa_3: alternativa_3,
        alternativa_4: alternativa_4,
        resposta: resposta_texto
    };

    try {
        const response = await fetch('../Banco/updatePME.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });

        const resultado = await response.json();

        if (resultado.sucesso) {
            alert('Pergunta atualizada com sucesso!');
            // Recarrega a lista para pegar a versão nova
            carregarPerguntas(); 
            // Esconde o formulário e reseta o select
            document.getElementById('formPME').style.display = 'none';
            document.getElementById('seletorPergunta').value = '';
        } else {
            alert('Erro: ' + resultado.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de comunicação com o servidor.');
    }
});

// Executa a função para carregar a lista ao abrir a página
carregarPerguntas();