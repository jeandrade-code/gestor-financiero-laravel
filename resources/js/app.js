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