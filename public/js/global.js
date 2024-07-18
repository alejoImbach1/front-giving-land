//definiciones para dropdowns
var dropdowns;

window.addEventListener('load', () => {
    //DROPDOWNS
    dropdowns = document.querySelectorAll(".dropdown");
    if (dropdowns.length) {
        dropdowns.forEach(dropdown => {
            let button = dropdown.querySelector('.dropdown-button');
            button.addEventListener('click', () => {
                let dropdownMenu = dropdown.querySelector('.dropdown-menu');
                dropdownMenu.classList.toggle('hidden');
                const buttonRect = button.getBoundingClientRect();
                const dropdownHeight = dropdownMenu.offsetHeight;
                if (window.innerHeight - buttonRect.bottom >= dropdownHeight) {
                    dropdownMenu.classList.remove('-top-14');
                    dropdownMenu.classList.add('top-4');
                } else {
                    // If not, position the dropdown above the button
                    dropdownMenu.classList.remove('top-4');
                    dropdownMenu.classList.add('-top-14');
                }
            });
        });
    }

    //Cerrar dropdown cuando se hace fuera de él o en el mismo botón
    window.addEventListener('click', (event) => {
        let openDropdown = getOpenDropdown();
        if (openDropdown != null && event.target != openDropdown.querySelector('.dropdown-menu') && event.target != openDropdown.querySelector('.dropdown-button')) {
            openDropdown.querySelector('.dropdown-menu').classList.add('hidden');
        }
    });

    //POPUPS
    let popups = document.querySelectorAll('.popup');

    popups.forEach(popup => {
        let closers = popup.querySelectorAll('.popup-closer');
        closers.forEach(closer => {
            closer.addEventListener('click',() => {
                popup.classList.add('hidden');
            });
        });
    });

    if (popups.length) {
        let popupShowers = document.querySelectorAll('[data-show-popup]');
        // let popupClosers = document.querySelectorAll('[data-close-popup]');

        popupShowers.forEach(element => {
            element.addEventListener('click', mostrarPopup);
        });

        // popupClosers.forEach(element => {
        //     element.addEventListener('click', cerrarPopup);
        // });

        //Cerrar popup cuando se hace click fuera de él
        popups.forEach(element => {
            element.addEventListener('click', (event) => {
                if (event.target.classList.contains('popup')) {
                    event.target.classList.add('hidden');
                }
            });
        });
    }

    //MENSAJES DE ERROR
    //quitar después de 3.5 s
    setTimeout(() => {
        document.querySelectorAll(".input-error").forEach(p => {
            p.remove();
        });
    }, 3500);
});

//Se llama el dropdown que actualmente está abierto
function getOpenDropdown() {
    let dropdownReturn = null;
    dropdowns.forEach(dropdown => {
        if (!dropdown.querySelector('.dropdown-menu').classList.contains('hidden')) {
            dropdownReturn = dropdown;
        }
    });
    return dropdownReturn;
}

//para evento click de un botón y luego abrir su respectivo pupup
function mostrarPopup(event) {
    document.querySelector(event.target.getAttribute('data-show-popup')).classList.remove('hidden');
}

//para evento click de un botón y luego cerrar su respectivo pupup
function cerrarPopup(event) {
    document.querySelector(event.target.getAttribute('data-close-popup')).classList.add('hidden');
}

function toggleFill(element) {
    let path = element.querySelector('path');
    if (path.getAttribute('fill') === 'none') {
        path.setAttribute('fill', 'red');
    } else {
        path.setAttribute('fill', 'none');
    }
}