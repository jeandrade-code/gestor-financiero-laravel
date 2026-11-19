const fs = require('fs');
const path = require('path');

const BASE = 'http://127.0.0.1:8123';
const OUT = process.argv[2] || path.join(__dirname, '..', 'docs', 'capturas');
const CDP = 'http://127.0.0.1:9222';
const CUENTA_PRUEBA = 'Cuenta de prueba';
const SALDO_INICIAL = 200000;

fs.mkdirSync(OUT, { recursive: true });

let ws;
let seq = 0;
const pending = new Map();

function send(method, params = {}, sessionId) {
    return new Promise((resolve, reject) => {
        const id = ++seq;
        pending.set(id, { resolve, reject });
        ws.send(JSON.stringify({ id, method, params, sessionId }));
    });
}

async function connect() {
    const res = await fetch(`${CDP}/json/list`);
    const targets = await res.json();
    const page = targets.find((t) => t.type === 'page');
    if (!page) {
        throw new Error('No hay pestaña disponible en Chrome');
    }
    ws = new WebSocket(page.webSocketDebuggerUrl);
    await new Promise((resolve, reject) => {
        ws.onopen = resolve;
        ws.onerror = reject;
    });
    ws.onmessage = (event) => {
        const msg = JSON.parse(event.data);
        if (msg.id && pending.has(msg.id)) {
            const { resolve, reject } = pending.get(msg.id);
            pending.delete(msg.id);
            if (msg.error) {
                reject(new Error(JSON.stringify(msg.error)));
            } else {
                resolve(msg.result);
            }
        }
    };
}

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function goto(url) {
    await send('Page.navigate', { url });
    await sleep(1500);
}

async function evaluate(expression) {
    const result = await send('Runtime.evaluate', { expression, awaitPromise: true, returnByValue: true });
    if (result.exceptionDetails) {
        throw new Error('JS: ' + JSON.stringify(result.exceptionDetails.text) + ' ' + (result.exceptionDetails.exception?.description || ''));
    }
    return result.result.value;
}

async function shot(name) {
    await sleep(600);
    const metrics = await send('Page.getLayoutMetrics');
    const width = Math.min(Math.ceil(metrics.cssContentSize.width), 1500);
    const height = Math.min(Math.ceil(metrics.cssContentSize.height), 2600);
    const { data } = await send('Page.captureScreenshot', {
        format: 'png',
        captureBeyondViewport: true,
        clip: { x: 0, y: 0, width, height, scale: 1 },
    });
    fs.writeFileSync(path.join(OUT, `${name}.png`), Buffer.from(data, 'base64'));
    console.log(`  [OK] ${name}.png (${width}x${height})`);
}

async function setSelect(selector, value) {
    return evaluate(`(() => {
        const el = document.querySelector(${JSON.stringify(selector)});
        if (!el) { throw new Error('select no encontrado: ' + ${JSON.stringify(selector)}); }
        el.value = ${JSON.stringify(value)};
        el.dispatchEvent(new Event('change', { bubbles: true }));
        el.dispatchEvent(new Event('input', { bubbles: true }));
        return el.value;
    })()`);
}

async function fill(selector, value) {
    return evaluate(`(() => {
        const el = document.querySelector(${JSON.stringify(selector)});
        if (!el) { throw new Error('campo no encontrado: ' + ${JSON.stringify(selector)}); }
        el.value = ${JSON.stringify(value)};
        el.dispatchEvent(new Event('input', { bubbles: true }));
        el.dispatchEvent(new Event('change', { bubbles: true }));
        return el.value;
    })()`);
}

/** Envía el formulario que contiene el campo indicado (evita el form de logout del layout). */
async function submitWith(fieldSelector) {
    await evaluate(`(() => {
        const campo = document.querySelector(${JSON.stringify(fieldSelector)});
        if (!campo) { throw new Error('campo no encontrado: ' + ${JSON.stringify(fieldSelector)}); }
        const f = campo.form;
        if (!f) { throw new Error('el campo no tiene formulario'); }
        f.submit();
        return true;
    })()`);
    await sleep(2000);
}

async function bodyText(limit = 1500) {
    return evaluate(`document.body.innerText.slice(0, ${limit})`);
}

async function login(email, password) {
    await goto(`${BASE}/login`);
    await fill('#email', email);
    await fill('#password', password);
    await submitWith('#email');
    await sleep(900);
}

/** Devuelve las celdas de la fila cuya primera columna coincide con el nombre. */
async function filaDe(tabla, nombre) {
    return evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length && celdas[0].innerText.trim() === ${JSON.stringify(nombre)}) {
                return [...celdas].map((c) => c.innerText.trim());
            }
        }
        return null;
    })()`);
}

async function idDeCuenta(nombre) {
    return evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length && celdas[0].innerText.trim() === ${JSON.stringify(nombre)}) {
                const enlace = fila.querySelector('a[href*="/cuentas/"][href$="/edit"]');
                if (!enlace) { return null; }
                const m = enlace.getAttribute('href').match(/\\/cuentas\\/(\\d+)\\/edit/);
                return m ? m[1] : null;
            }
        }
        return null;
    })()`);
}

async function idDeTransaccion(descripcion) {
    return evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            if (fila.innerText.includes(${JSON.stringify(descripcion)})) {
                const enlace = fila.querySelector('a[href*="/transacciones/"][href$="/edit"]');
                if (!enlace) { return null; }
                const m = enlace.getAttribute('href').match(/\\/transacciones\\/(\\d+)\\/edit/);
                return m ? m[1] : null;
            }
        }
        return null;
    })()`);
}

/** Elimina todas las transacciones de una cuenta y después la cuenta (limpieza idempotente). */
async function eliminarCuentaConMovimientos(idCuenta) {
    for (let intento = 0; intento < 20; intento++) {
        await goto(`${BASE}/transacciones?cuenta_id=${idCuenta}`);
        const eliminado = await evaluate(`(() => {
            const filas = [...document.querySelectorAll('table tbody tr')];
            for (const fila of filas) {
                const f = fila.querySelector('form[action*="/transacciones/"]');
                if (f) { f.submit(); return true; }
            }
            return false;
        })()`);
        if (!eliminado) {
            break;
        }
        await sleep(1600);
    }
    await goto(`${BASE}/cuentas`);
    await evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length && celdas[0].innerText.trim() === ${JSON.stringify(CUENTA_PRUEBA)}) {
                const f = fila.querySelector('form[action*="/cuentas/"]');
                if (f) { f.submit(); return true; }
            }
        }
        return false;
    })()`);
    await sleep(1600);
}

/** Envía un DELETE real (sin confirm) para comprobar el bloqueo en el servidor. */
async function intentarBorrarPorPost(url, campoId) {
    await evaluate(`(() => {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const f = document.createElement('form');
        f.method = 'POST';
        f.action = ${JSON.stringify(url)};
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = token;
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        f.appendChild(csrf);
        f.appendChild(method);
        document.body.appendChild(f);
        window.__flashForm = f;
        return true;
    })()`);
    await evaluate(`(() => { window.__flashForm.submit(); return true; })()`);
    await sleep(2000);
}

async function mensajeFlash() {
    return evaluate(`(() => {
        const el = document.querySelector('[role="alert"], [role="status"]');
        return el ? el.innerText.trim() : '(sin mensaje)';
    })()`);
}

async function crearCuentaPrueba() {
    await goto(`${BASE}/cuentas/create`);
    await fill('#nombre', CUENTA_PRUEBA);
    await fill('#descripcion', 'Cuenta creada para demostrar el efecto de los movimientos en el saldo.');
    await fill('#saldo', String(SALDO_INICIAL));
    await fill('#moneda', 'COP');
    await submitWith('#nombre');
}

async function crearTransaccion({ cuentaId, tipo, monto, descripcion, fecha }) {
    await goto(`${BASE}/transacciones/create`);
    await setSelect('#cuenta_id', cuentaId);
    await setSelect('#tipo', tipo);
    await evaluate(`(() => {
        const sel = document.querySelector('#categoria_id');
        const opt = [...sel.options].find((o) => o.dataset.tipo === ${JSON.stringify(tipo)});
        if (!opt) { throw new Error('no hay categoria de tipo ' + ${JSON.stringify(tipo)}); }
        sel.value = opt.value;
        sel.dispatchEvent(new Event('change', { bubbles: true }));
        return sel.value;
    })()`);
    await fill('#monto', String(monto));
    await fill('#fecha', fecha);
    await fill('#descripcion', descripcion);
    await submitWith('#monto');
}

(async () => {
    await connect();
    await send('Page.enable');
    await send('Runtime.enable');
    await send('Network.enable');
    await send('Network.clearBrowserCookies');

    const resumen = {};

    console.log('\n== 1. Autenticación ==');
    await goto(`${BASE}/login`);
    await shot('01-login');
    resumen.login = await bodyText(260);

    await login('admin@gestorfinanciero.test', 'password');
    resumen.dashboard = await bodyText(700);
    await shot('02-dashboard');

    console.log('\n== 2. Módulo de categorías ==');
    await goto(`${BASE}/categorias`);
    resumen.categorias = await evaluate(`
        [...document.querySelectorAll('table tbody tr')].map((f) => {
            const c = f.querySelectorAll('td');
            return { nombre: c[0].innerText.trim(), tipo: c[1].innerText.trim(), movimientos: c[3].innerText.trim() };
        })`);
    await shot('03-categorias');

    await goto(`${BASE}/categorias/create`);
    await shot('06-categorias-crear');

    await goto(`${BASE}/categorias/1/edit`);
    await shot('07-categorias-editar');

    console.log('\n== 3. Módulo de cuentas ==');
    await goto(`${BASE}/cuentas`);
    await shot('04-cuentas');

    await goto(`${BASE}/cuentas/create`);
    await shot('08-cuentas-crear');

    await goto(`${BASE}/cuentas/1/edit`);
    resumen.cuentaConMovimientos = await bodyText(700);
    await shot('09-cuentas-editar');

    console.log('\n== 4. Módulo de transacciones ==');
    await goto(`${BASE}/transacciones`);
    resumen.transacciones = await evaluate(`
        [...document.querySelectorAll('table tbody tr')].map((f) => {
            const c = f.querySelectorAll('td');
            return { fecha: c[0].innerText.trim(), cuenta: c[1].innerText.trim(), categoria: c[2].innerText.trim(), tipo: c[3].innerText.trim(), monto: c[4].innerText.trim(), registradoPor: c[6].innerText.trim() };
        })`);
    await shot('05-transacciones');

    await goto(`${BASE}/transacciones/create`);
    await shot('10-transacciones-crear');

    await goto(`${BASE}/transacciones/1/edit`);
    await shot('11-transacciones-editar');

    console.log('\n== 5. Validación con retención de datos ==');
    await goto(`${BASE}/transacciones/create`);
    const idCaja = await evaluate(`(() => {
        const opt = [...document.querySelectorAll('#cuenta_id option')].find((o) => o.textContent.includes('Caja'));
        return opt ? opt.value : '';
    })()`);
    await setSelect('#cuenta_id', idCaja);
    await setSelect('#tipo', 'gasto');
    await evaluate(`(() => {
        const sel = document.querySelector('#categoria_id');
        const opt = [...sel.options].find((o) => o.dataset.tipo === 'gasto');
        sel.value = opt.value;
        sel.dispatchEvent(new Event('change', { bubbles: true }));
        return sel.value;
    })()`);
    await fill('#fecha', '2026-11-19');
    await fill('#monto', '-5');
    await fill('#descripcion', 'Intento con monto negativo');
    await submitWith('#monto');
    resumen.validacionMontoNegativo = await bodyText(1000);
    await shot('12-validacion-monto-negativo');

    console.log('\n== 5b. Validación: gasto mayor que el saldo disponible ==');
    await goto(`${BASE}/transacciones/create`);
    await setSelect('#cuenta_id', idCaja);
    await setSelect('#tipo', 'gasto');
    await evaluate(`(() => {
        const sel = document.querySelector('#categoria_id');
        const opt = [...sel.options].find((o) => o.dataset.tipo === 'gasto');
        sel.value = opt.value;
        sel.dispatchEvent(new Event('change', { bubbles: true }));
        return sel.value;
    })()`);
    await fill('#fecha', '2026-11-19');
    await fill('#monto', '99999999');
    await fill('#descripcion', 'Gasto mayor al saldo disponible');
    await submitWith('#monto');
    resumen.validacionSaldoInsuficiente = await bodyText(1000);
    await shot('12b-validacion-saldo-insuficiente');

    console.log('\n== 6. Bloqueo de eliminación (servidor) ==');
    await goto(`${BASE}/cuentas`);
    const idBancolombia = await idDeCuenta('Bancolombia');
    await intentarBorrarPorPost(`${BASE}/cuentas/${idBancolombia}`, 'nombre');
    resumen.bloqueoCuentaServidor = await mensajeFlash();
    await shot('21-bloqueo-eliminar-cuenta');

    await goto(`${BASE}/categorias`);
    const idCategoriaUsada = await evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            const c = fila.querySelectorAll('td');
            if (c.length && c[3] && c[3].innerText.trim() !== '0') {
                const enlace = fila.querySelector('a[href*="/categorias/"][href$="/edit"]');
                if (enlace) {
                    const m = enlace.getAttribute('href').match(/\\/categorias\\/(\\d+)\\/edit/);
                    if (m) { return m[1]; }
                }
            }
        }
        return null;
    })()`);
    await intentarBorrarPorPost(`${BASE}/categorias/${idCategoriaUsada}`, 'nombre');
    resumen.bloqueoCategoriaServidor = await mensajeFlash();
    await shot('22-bloqueo-eliminar-categoria');

    console.log('\n== 7. Prueba de cambio de saldo ==');
    // Limpieza previa por si el script ya se ejecutó antes.
    await goto(`${BASE}/cuentas`);
    const idPrevio = await idDeCuenta(CUENTA_PRUEBA);
    if (idPrevio) {
        console.log(`  limpiando "${CUENTA_PRUEBA}" existente (id ${idPrevio})`);
        await eliminarCuentaConMovimientos(idPrevio);
        resumen.limpiezaPrevia = true;
    }

    await crearCuentaPrueba();
    await goto(`${BASE}/cuentas`);
    const idCuenta = await idDeCuenta(CUENTA_PRUEBA);
    if (!idCuenta) {
        throw new Error('No se pudo crear la cuenta de prueba');
    }
    resumen.pruebaSaldo = { idCuenta, inicial: await filaDe('cuentas', CUENTA_PRUEBA) };
    await shot('13-prueba-saldo-inicial-200000');

    const fecha = '2026-11-19';

    await crearTransaccion({
        cuentaId: idCuenta,
        tipo: 'ingreso',
        monto: 150000,
        descripcion: 'Ingreso de prueba para la defensa',
        fecha,
    });
    await goto(`${BASE}/cuentas`);
    resumen.pruebaSaldo.trasIngreso150000 = await filaDe('cuentas', CUENTA_PRUEBA);
    await shot('14-prueba-saldo-tras-ingreso-350000');

    await crearTransaccion({
        cuentaId: idCuenta,
        tipo: 'gasto',
        monto: 20000,
        descripcion: 'Gasto de prueba para la defensa',
        fecha,
    });
    await goto(`${BASE}/cuentas`);
    resumen.pruebaSaldo.trasGasto20000 = await filaDe('cuentas', CUENTA_PRUEBA);
    await shot('15-prueba-saldo-final-330000');

    console.log('\n== 8. Edición y eliminación sobre el saldo ==');
    await goto(`${BASE}/transacciones?cuenta_id=${idCuenta}`);
    await shot('16-movimientos-cuenta-prueba');

    const idIngreso = await idDeTransaccion('Ingreso de prueba para la defensa');
    if (!idIngreso) {
        throw new Error('No se encontró el ingreso de prueba');
    }
    await goto(`${BASE}/transacciones/${idIngreso}/edit`);
    await shot('17-prueba-editar-ingreso');
    await fill('#monto', '100000');
    await submitWith('#monto');

    await goto(`${BASE}/cuentas`);
    resumen.pruebaSaldo.trasEditarIngresoA100000 = await filaDe('cuentas', CUENTA_PRUEBA);
    await shot('18-prueba-saldo-tras-editar-280000');

    const idGastoReal = await evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            if (fila.innerText.includes('Gasto de prueba para la defensa')) {
                const enlace = fila.querySelector('a[href*="/transacciones/"][href$="/edit"]');
                if (!enlace) { return null; }
                const m = enlace.getAttribute('href').match(/\\/transacciones\\/(\\d+)\\/edit/);
                return m ? m[1] : null;
            }
        }
        return null;
    })()`);
    resumen.idGasto = idGastoReal;
    await goto(`${BASE}/transacciones`);
    await evaluate(`(() => {
        const filas = [...document.querySelectorAll('table tbody tr')];
        for (const fila of filas) {
            if (fila.innerText.includes('Gasto de prueba para la defensa')) {
                const f = fila.querySelector('form[action*="/transacciones/"]');
                if (f) { f.submit(); return true; }
            }
        }
        return false;
    })()`);
    await sleep(2000);

    await goto(`${BASE}/cuentas`);
    resumen.pruebaSaldo.trasEliminarGasto = await filaDe('cuentas', CUENTA_PRUEBA);
    await shot('19-prueba-saldo-tras-eliminar-300000');

    console.log('\n== 9. Limpieza de los datos de prueba ==');
    await eliminarCuentaConMovimientos(idCuenta);
    await goto(`${BASE}/cuentas`);
    resumen.pruebaSaldo.limpiezaFinal = (await idDeCuenta(CUENTA_PRUEBA)) === null ? 'cuenta eliminada' : 'aún existe';
    await shot('20-cuentas-final');

    await goto(`${BASE}/dashboard`);
    resumen.dashboardFinal = await bodyText(700);
    await shot('23-dashboard-final');

    console.log('\n== 10. Cierre de sesión ==');
    await evaluate(`(() => {
        const f = document.querySelector('form[action*="logout"]');
        if (f) { f.submit(); return true; }
        return false;
    })()`);
    await sleep(1800);
    resumen.trasLogout = await evaluate(`window.location.pathname`);
    await shot('24-tras-logout');

    fs.writeFileSync(path.join(OUT, 'resumen.json'), JSON.stringify(resumen, null, 2), 'utf8');

    console.log('\n--- Prueba de saldo ---');
    console.log(JSON.stringify(resumen.pruebaSaldo, null, 2));
    console.log('\n--- Bloqueos ---');
    console.log('Cuenta:', resumen.bloqueoCuentaServidor);
    console.log('Categoría:', resumen.bloqueoCategoriaServidor);
    console.log('Logout ->', resumen.trasLogout);
    process.exit(0);
})().catch((err) => {
    console.error('ERROR:', err.message);
    process.exit(1);
});