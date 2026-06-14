document.getElementById('formCadastro').addEventListener('submit', async function(event) {
    event.preventDefault();

    const nome = document.querySelector('input[name="nome"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const senha = document.querySelector('input[name="senha"]').value;

    try {
        const response = await fetch('Banco/createUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nome, email, senha })
        });

        const resultado = await response.json();

        if (resultado.sucesso) {
            alert('Usuário cadastrado com sucesso!');
            window.location.href = 'Pages/menu.html';
        } else {
            alert('Erro: ' + resultado.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de comunicação com o servidor.');
    }
});