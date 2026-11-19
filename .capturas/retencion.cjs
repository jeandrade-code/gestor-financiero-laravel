const fs = require('fs');
const path = require('path');

const BASE = 'http://127.0.0.1:8123';
const CDP = 'http://127.0.0.1:9222';

let ws;
let seq = 0;
const pending = new Map();

function send(method, params = {}) {
    return new Promise((resolve, reject) => {
        const id = ++seq;
        pending.set(id, { resolve, reject });
        ws.send(JSON.stringify({ id, method, params }));
    });
}

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function evaluate(expression) {
    const result = await send('Runtime.evaluate', { expression, awaitPromise: true, returnByValue: true });
    if (result.exceptionDetails) {
        throw new Error(JSON.stringify(result.exceptionDetails));
    }
    return result.result.value;
}

(async () => {
    const res = await fetch(`${CDP}/json/list`);
    const targets = await res.json();
    const page = targets.find((t) => t.type === 'page');
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
            if (msg.error) { reject(new Error(JSON.stringify(msg.error))); } else { resolve(msg.result); }
        }
    };

    await send('Page.enable');
    await send('Runtime.enable');
    await send('Network.enable');
    await send('Network.clearBrowserCookies');

    const fill = (sel, val) => evaluate(`(() => {
        const el = document.querySelector(${JSON.stringify(sel)});
        el.value = ${JSON.stringify(val)};
        el.dispatchEvent(new Event('input', { bubbles: true }));
        el.dispatchEvent(new Event('change', { bubbles: true }));
        return el.value;
    })()`);

    await send('Page.navigate', { url: `${BASE}/login` });
    await sleep(1400);
    await fill('#email', 'admin@gestorfinanciero.test');
    await fill('#password', 'password');
    await evaluate(`document.querySelector('#email').form.submit()`);
    await sleep(1800);

    await send('Page.navigate', { url: `${BASE}/transacciones/create` });
    await sleep(1400);
    await fill('#descripcion', 'Descripcion que debe conservarse');
    await fill('#fecha', '2026-11-19');
    await fill('#monto', '-5');

    const opciones = await evaluate(`(() => {
        const cuenta = [...document.querySelectorAll('#cuenta_id option')].find((o) => o.textContent.includes('Ahorros'));
        const categoria = [...document.querySelectorAll('#categoria_id option')].find((o) => o.dataset.tipo === 'gasto');
        return { cuenta: cuenta.value, categoria: categoria.value, categoriaTexto: categoria.textContent.trim() };
    })()`);

    await evaluate(`(() => {
        const c = document.querySelector('#cuenta_id');
        c.value = ${JSON.stringify(opciones.cuenta)};
        c.dispatchEvent(new Event('change', { bubbles: true }));
        const t = document.querySelector('#tipo');
        t.value = 'gasto';
        t.dispatchEvent(new Event('change', { bubbles: true }));
        const cat = document.querySelector('#categoria_id');
        cat.value = ${JSON.stringify(opciones.categoria)};
        cat.dispatchEvent(new Event('change', { bubbles: true }));
        return true;
    })()`);

    await evaluate(`document.querySelector('#monto').form.submit()`);
    await sleep(2000);

    const retenido = await evaluate(`(() => {
        return {
            cuenta: document.querySelector('#cuenta_id').value,
            tipo: document.querySelector('#tipo').value,
            categoria: document.querySelector('#categoria_id').value,
            monto: document.querySelector('#monto').value,
            fecha: document.querySelector('#fecha').value,
            descripcion: document.querySelector('#descripcion').value,
            errores: [...document.querySelectorAll('[role="alert"]')].map((e) => e.innerText.trim()),
        };
    })()`);

    console.log(JSON.stringify({ esperado: opciones, retenido }, null, 2));
    process.exit(0);
})().catch((err) => {
    console.error('ERROR:', err.message);
    process.exit(1);
});