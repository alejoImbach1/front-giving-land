const cliqueables = document.querySelectorAll('.cliqueable');
const inhabilitables = document.querySelectorAll('.inhabilitable');

inhabilitables.forEach(input => {
    input.disabled = true;
});

cliqueables.forEach(lable => {
    lable.addEventListener('click', mostrarAlertaAuth);
});

function mostrarAlertaAuth() {
    window.alert('¡Se debe iniciar sesión para usar esta opción!')
}