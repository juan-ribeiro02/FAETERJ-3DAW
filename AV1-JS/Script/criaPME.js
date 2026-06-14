document.getElementById('formPME').addEventListener('submit', async function(event) {
    event.preventDefault();

    // Captura os valores digitados
    const pergunta = document.getElementById('pergunta').value;
    const alternativa_1 = document.getElementById('alt1').value;
    const alternativa_2 = document.getElementById('alt2').value;
    const alternativa_3 = document.getElementById('alt3').value;
    const alternativa_4 = document.getElementById('alt4').value;
    const resposta_select = document.getElementById('resposta').value;

    // salva a resposta na variavel dependendo do valor do resoita_select
    let resposta_texto = '';
    if (resposta_select === '1') resposta_texto = alternativa_1;
    if (resposta_select === '2') resposta_texto = alternativa_2;
    if (resposta_select === '3') resposta_texto = alternativa_3;
    if (resposta_select === '4') resposta_texto = alternativa_4;

    // vetor com as alternatias
    const dados = {
        pergunta: pergunta,
        alternativa_1: alternativa_1,
        alternativa_2: alternativa_2,
        alternativa_3: alternativa_3,
        alternativa_4: alternativa_4,
        resposta: resposta_texto
    };

    try {
        const response = await fetch('../Banco/createPME.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        });

        const resultado = await response.json();

        if (resultado.sucesso) {
            alert('Pergunta salva com sucesso no banco de dados!');
            this.reset(); // Limpa o formulário para a próxima pergunta
        } else {
            alert('Erro: ' + resultado.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de comunicação com o servidor.');
    }
});