import Alpine from 'alpinejs';
import './charts';

window.Alpine = Alpine;

Alpine.start();

/**
 * Show / hide a password field. Used by the auth and profile forms.
 */
window.togglePassword = function (inputId, button) {
    const input = document.getElementById(inputId);

    if (! input || ! button) {
        return;
    }

    const eyeOpen = button.querySelector('[data-eye-open]');
    const eyeClosed = button.querySelector('[data-eye-closed]');
    const show = input.type === 'password';

    input.type = show ? 'text' : 'password';

    if (eyeOpen) {
        eyeOpen.classList.toggle('hidden', show);
    }

    if (eyeClosed) {
        eyeClosed.classList.toggle('hidden', ! show);
    }

    button.setAttribute('aria-label', show ? 'Ocultar contraseña' : 'Mostrar contraseña');
};

/**
 * Prevent duplicate submissions and give immediate feedback.
 * Add data-loading to a form to opt in.
 */
document.addEventListener('submit', function (event) {
    const form = event.target;

    if (! (form instanceof HTMLFormElement) || ! form.matches('[data-loading]')) {
        return;
    }

    const button = form.querySelector('button[type="submit"]');

    if (! button) {
        return;
    }

    const loadingText = button.dataset.loadingText;

    window.setTimeout(function () {
        button.disabled = true;
        button.classList.add('opacity-70');

        if (loadingText) {
            button.textContent = loadingText;
        }
    }, 0);
});

/**
 * Convierte el texto de un campo con máscara monetaria a número.
 * Se usa para validaciones en vivo sin depender del orden de los eventos.
 */
window.moneyValue = function (input) {
    if (! input) {
        return 0;
    }

    const texto = String(input.value || '').trim();
    const normalizado = texto.includes(',')
        ? texto.replace(/\./g, '').replace(',', '.')
        : texto;
    const numero = parseFloat(normalizado.replace(/[^\d.]/g, ''));

    return Number.isFinite(numero) ? numero : 0;
};

/**
 * Máscara monetaria en es-CO para los campos [data-money-input].
 * El campo visible muestra los puntos de miles y la coma decimal; el campo
 * oculto indicado por data-money-target conserva el valor numérico del formulario.
 */
const inicializarMascaraMoneda = function (input) {
    const oculto = document.getElementById(input.dataset.moneyTarget);

    if (! oculto) {
        return;
    }

    const normalizar = function (valor) {
        let texto = String(valor ?? '').replace(/[^\d.,]/g, '');

        if (texto.includes(',')) {
            return texto.replace(/\./g, '');
        }

        const partes = texto.split('.');

        if (partes.length === 1) {
            return texto;
        }

        const ultima = partes[partes.length - 1];

        // Tres cifras después del punto son miles en es-CO; el resto es decimal.
        return ultima.length === 3
            ? partes.join('')
            : partes.slice(0, -1).join('') + ',' + ultima;
    };

    const descomponer = function (valor) {
        const partes = normalizar(valor).split(',');

        return {
            entero: (partes.shift() || '').replace(/\D/g, '').slice(0, 16),
            decimal: partes.join('').replace(/\D/g, '').slice(0, 2),
        };
    };

    const agrupar = function (entero) {
        return entero.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };

    const sincronizar = function (opciones = {}) {
        const forzar = opciones.forzar === true;
        const preservar = opciones.preservar === true;
        const cursor = input.selectionStart ?? input.value.length;
        const digitosAntes = (input.value.slice(0, cursor).match(/\d/g) || []).length;
        const partes = descomponer(input.value);
        const entero = agrupar(partes.entero);
        const texto = partes.decimal ? entero + ',' + partes.decimal : (forzar ? (entero || '0') + ',00' : entero);

        input.value = texto;
        oculto.value = (partes.entero || '0') + (partes.decimal ? '.' + partes.decimal.padEnd(2, '0') : '');
        input.dataset.valor = oculto.value;

        if (! preservar) {
            return;
        }

        let vistos = 0;
        let posicion = texto.length;

        if (digitosAntes === 0) {
            posicion = 0;
        } else {
            for (let i = 0; i < texto.length; i += 1) {
                if (/\d/.test(texto[i])) {
                    vistos += 1;

                    if (vistos === digitosAntes) {
                        posicion = i + 1;
                        break;
                    }
                }
            }
        }

        input.setSelectionRange(posicion, posicion);
    };

    input.addEventListener('input', function () {
        sincronizar({ preservar: true });
    });

    input.addEventListener('blur', function () {
        sincronizar({ forzar: true });
    });

    sincronizar();
};

const iniciarMascarasMoneda = function () {
    document.querySelectorAll('[data-money-input]').forEach(inicializarMascaraMoneda);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', iniciarMascarasMoneda);
} else {
    iniciarMascarasMoneda();
}