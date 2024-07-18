const divCodigo = document.querySelector('.div-codigo');
const inputs = divCodigo.querySelectorAll('input');
const submit = document.querySelector("button[type='submit']");
inputs[0].addEventListener('paste', function (event) {
    let data = event.clipboardData.getData('text');
    if (/^[a-zA-Z1-9]{6}$/.test(data)) {
        let arrayData = data.split('');
        inputs[inputs.length-1].focus();
        for (let index = 0; index < arrayData.length; index++) {
            inputs[index].value = arrayData[index];
        }
    } else {
        event.preventDefault();
    }
});
for (let index = 1; index < inputs.length; index++) {
    inputs[index].addEventListener('paste',event=>{
        event.preventDefault();
    });
}
inputs.forEach(input => {
    input.addEventListener('keydown', function (event) {
        let key = event.key;
        console.log(key);
        (!/\b(Tab|Backspace|Enter|Shift|CapsLock)\b/.test(key) && !event.ctrlKey) ? (event.target.value = (/^[a-zA-Z1-9]{1}$/.test(key)) ? key : " ") : '';
    });
});

for (let index = 0; index < inputs.length; index++) {
    inputs[index].addEventListener('keyup', function (event) {
        let key = event.key;
        (index != inputs.length - 1 && !/\b(Tab|Backspace|Enter|Shift|CapsLock)\b/.test(key) && !event.ctrlKey) ? ((/^[a-zA-Z1-9]{1}$/.test(key)) ? inputs[index + 1].focus() : '') : '';
    });
}