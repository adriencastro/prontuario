document.getElementById('prontuario-form').addEventListener('submit', function(e) {
    e.preventDefault();

    
    const nome = document.getElementById('nome').value;
    const data = document.getElementById('data').value;
    const observacao = document.getElementById('observacao').value;

    
    const registroItem = document.createElement('div');
    registroItem.classList.add('registro-item');
    registroItem.innerHTML = `
        <p><strong>Nome:</strong> ${nome}</p>
        <p><strong>Data:</strong> ${data}</p>
        <p><strong>Observação:</strong> ${observacao}</p>
    `;

    // Adicionar um novo registro à lista de registros
    document.querySelector('.registro-lista').appendChild(registroItem);

    document.getElementById('prontuario-form').reset();
});
