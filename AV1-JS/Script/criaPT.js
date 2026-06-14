document.getElementById('formPT').addEventListener('submit', async function(event) {
    event.preventDefault();

    const pergunta = document.getElementById('pergunta').value;
    const resposta = document.getElementById('resposta').value;

    const dados = {
        pergunta: pergunta,
        resposta: resposta
    };

    try {
        const response = await fetch('../Banco/createPT.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        });

        const resultado = await response.json();

        if (resultado.sucesso) {
            alert('Pergunta de texto salva com sucesso!');
            this.reset(); // Limpa os textareas
        } else {
            alert('Erro: ' + resultado.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de comunicação com o servidor.');
    }
});