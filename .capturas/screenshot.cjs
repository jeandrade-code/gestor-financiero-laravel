const fs = require('fs');
const path = require('path');

const BASE = 'http://127.0.0.1:8123';
const OUT = process.argv[2] || path.join(__dirname, 'capturas');
const CDP = 'http://127.0.0.1:9222';

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
    await sleep(1400);
}

async function evaluate(expression) {
    const result = await send('Runtime.evaluate', {
        expression,
        awaitPromise: true,
        returnByValue: true,
    });

    if (result.exceptionDetails) {
        throw new Error('JS error: ' + JSON.stringify(result.exceptionDetails.text) + ' ' + JSON.stringify(result.exceptionDetails.exception?.description || ''));
    }

    return result.result.value;
}

async function shot(name) {
    await sleep(500);
    const metrics = await send('Page.getLayoutMetrics');
    const width = Math.min(Math.ceil(metrics.cssContentSize.width), 1500);
    const height = Math.min(Math.ceil(metrics.cssContentSize.height), 3000);

    const { data } = await send('Page.captureScreenshot', {
        format: 'png',
        captureBeyondViewport: true,
        clip: { x: 0, y: 0, width, height, scale: 1 },
    });

    const file = path.join(OUT, `${name}.png`);
    fs.writeFileSync(file, Buffer.from(data, 'base64'));
    console.log(`  saved ${name}.png (${width}x${height})`);
}

async function setSelect(selector, value) {
    await evaluate(`(() => {
        const el = document.querySelector(${JSON.stringify(selector)});
        if (!el) { throw new Error('no select ' + ${JSON.stringify(selector)}); }
        el.value = ${JSON.stringify(value)};
        el.dispatchEvent(new Event('change', { bubbles: true }));
        el.dispatchEvent(new Event('input', { bubbles: true }));
        return el.value;
    })()`);
}

async function fill(selector, value) {
    await evaluate(`(() => {
        const el = document.querySelector(${JSON.stringify(selector)});
        if (!el) { throw new Error('no input ' + ${JSON.stringify(selector)}); }
        el.value = ${JSON.stringify(value)};
        el.dispatchEvent(new Event('input', { bubbles: true }));
        el.dispatchEvent(new Event('change', { bubbles: true }));
        return el.value;
    })()`);
}

async function submit(formSelector) {
    await evaluate(`(() => {
        const f = document.querySelector(${JSON.stringify(formSelector)});
        if (!f) { throw new Error('no form ' + ${JSON.stringify(formSelector)}); }
        f.submit();
        return true;
    })()`);
    await sleep(1800);
}

async function login() {
    await goto(`${BASE}/login`);
    await fill('#email', 'admin@gestorfinanciero.test');
    await fill('#password', 'password');
    await submit('form');
    await sleep(600);
}

(async () => {
    await connect();
    await send('Page.enable');
    await send('Runtime.enable');

    console.log('Capturando pantallas...');

    await goto(`${BASE}/login`);
    await shot('01-login');

    await login();
    await shot('02-dashboard');

    await goto(`${BASE}/categorias`);
    await shot('03-categorias');

    await goto(`${BASE}/cuentas`);
    await shot('04-cuentas');

    await goto(`${BASE}/transacciones`);
    await shot('05-transacciones');

    console.log('Listo.');
    process.exit(0);
})().catch((err) => {
    console.error('ERROR:', err.message);
    process.exit(1);
});