let passoAtual = 0;

function exibirPergunta(passo) {
    const perguntas = document.querySelectorAll('.pergunta');
    const feedbackDiv = document.querySelector('.feedback');
    
    // Exibir a pergunta correspondente ao passo atual e esconder as outras
    perguntas.forEach((pergunta, index) => {
        pergunta.style.display = (index === passo) ? 'block' : 'none';
    });

    // Se chegarmos ao final das perguntas, exibir o feedback
    if (passo === perguntas.length) {
        perguntas.forEach(pergunta => pergunta.style.display = 'none');
        feedbackDiv.style.display = 'block';

        // Alterar o texto do botão para "Finalizar"
        const botao = document.querySelector('button');
        botao.textContent = 'Finalizar';
        botao.setAttribute('onclick', 'finalizarFormulario()');
    }
}

function proximaPergunta() {
    const perguntas = document.querySelectorAll('.pergunta');
    
    // Se ainda houver perguntas, avança para a próxima
    if (passoAtual < perguntas.length) {
        passoAtual++;
        exibirPergunta(passoAtual);
    }
}

function finalizarFormulario() {
    document.getElementById('formulario').submit();
}

// Exibir a primeira pergunta quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    exibirPergunta(passoAtual);
});