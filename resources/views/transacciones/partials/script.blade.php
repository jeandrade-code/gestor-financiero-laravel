<script>
    (function () {
        const form = document.getElementById('transaccion-form');

        if (! form) {
            return;
        }

        const categoria = form.querySelector('#categoria_id');
        const cuenta = form.querySelector('#cuenta_id');
        const monto = form.querySelector('#monto');
        const moneda = document.getElementById('monto-moneda');
        const disponible = document.getElementById('cuenta-disponible');
        const alerta = document.getElementById('alerta-saldo');

        const tipoActual = function () {
            const seleccionado = form.querySelector('input[name="tipo"]:checked');

            return seleccionado ? seleccionado.value : '';
        };

        const formatear = function (valor, codigo) {
            return new Intl.NumberFormat('es-CO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(valor) + ' ' + codigo;
        };

        const opcionCuenta = function () {
            const opcion = cuenta.options[cuenta.selectedIndex];

            return opcion && opcion.value ? opcion : null;
        };

        const filtrarCategorias = function (preservar) {
            if (! categoria) {
                return;
            }

            const tipo = tipoActual();
            const actual = categoria.value;
            let primera = null;

            Array.from(categoria.options).forEach(function (opcion) {
                if (! opcion.dataset.tipo) {
                    return;
                }

                const visible = ! tipo || opcion.dataset.tipo === tipo;
                opcion.hidden = ! visible;
                opcion.disabled = ! visible;

                if (visible && primera === null) {
                    primera = opcion;
                }
            });

            if (actual) {
                const seleccionada = Array.from(categoria.options).find(function (opcion) {
                    return opcion.value === actual && ! opcion.disabled;
                });

                categoria.value = seleccionada ? actual : '';
            } else if (! preservar && primera) {
                categoria.value = '';
            }
        };

        const validarSaldo = function () {
            if (! alerta) {
                return;
            }

            const opcion = opcionCuenta();
            const saldo = opcion ? parseFloat(opcion.dataset.saldo || '0') : null;
            const valor = parseFloat(monto.value || '0');

            alerta.classList.add('hidden');

            if (tipoActual() === 'gasto' && opcion && valor > saldo) {
                alerta.textContent = 'El gasto supera el saldo disponible (' + formatear(saldo, opcion.dataset.moneda || 'COP') + ').';
                alerta.classList.remove('hidden');
            }
        };

        const actualizarSaldo = function () {
            const opcion = opcionCuenta();
            const saldo = opcion ? parseFloat(opcion.dataset.saldo || '0') : null;
            const codigo = opcion ? (opcion.dataset.moneda || 'COP') : 'COP';

            if (moneda) {
                moneda.textContent = codigo;
            }

            if (disponible) {
                disponible.innerHTML = saldo === null
                    ? 'Selecciona una cuenta para ver su saldo disponible.'
                    : 'Saldo disponible: <span class="font-mono tabular-nums">' + formatear(saldo, codigo) + '</span>';
            }

            validarSaldo();
        };

        form.querySelectorAll('input[name="tipo"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                filtrarCategorias(false);
                validarSaldo();
            });
        });

        if (cuenta) {
            cuenta.addEventListener('change', actualizarSaldo);
        }

        if (monto) {
            monto.addEventListener('input', validarSaldo);
        }

        filtrarCategorias(true);
        actualizarSaldo();
    })();
</script>