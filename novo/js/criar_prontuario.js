document.addEventListener('DOMContentLoaded', () => {
    console.log('Página de criação de prontuário carregada.');
    const form = document.querySelector('form');
    form.addEventListener('submit', (event) => {
        if (!confirm('Deseja realmente criar este prontuário?')) {
            event.preventDefault();
        }
    });
});