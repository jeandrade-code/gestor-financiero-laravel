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

async function connect() {
    const targets = await (await fetch(`${CDP}/json/list`)).json();
    const page = targets.find((t) => t.type === 'page');
    ws = new WebSocket(page.webSocketDebuggerUrl);
    await new Promise((res, rej) => { ws.onopen = res; ws.onerror = rej; });
    ws.onmessage = (ev) => {
        const msg = JSON.parse(ev.data);
        if (msg.id && pending.has(msg.id)) {
            const { resolve, reject } = pending.get(msg.id);
            pending.delete(msg.id);
            msg.error ? reject(new Error(JSON.stringify(msg.error))) : resolve(msg.result);
        }
    };
}

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function goto(url) {
    await send('Page.navigate', { url });
    await sleep(1500);
}

async function evaluate(expression) {
    const r = await send('Runtime.evaluate', { expression, awaitPromise: true, returnByValue: true });
    if (r.exceptionDetails) { throw new Error(JSON.stringify(r.exceptionDetails)); }
    return r.result.value;
}

async function text() {
    return evaluate(`document.body.innerText.replace(/\\n{2,}/g, '\\n').trim()`);
}

async function fill(sel, value) {
    await evaluate(`(() => { const e = document.querySelector(${JSON.stringify(sel)}); e.value = ${JSON.stringify(value)}; e.dispatchEvent(new Event('input',{bubbles:true})); return e.value; })()`);
}

async function submit(sel) {
    await evaluate(`document.querySelector(${JSON.stringify(sel)}).submit(); true`);
    await sleep(2000);
}

(async () => {
    await connect();
    await send('Page.enable');
    await send('Runtime.enable');

    await goto(`${BASE}/login`);
    console.log('===== LOGIN =====');
    console.log(await text());

    await fill('#email', 'admin@gestorfinanciero.test');
    await fill('#password', 'password');
    await submit('form');

    await goto(`${BASE}/dashboard`);
    console.log('\n===== DASHBOARD =====');
    console.log(await text());

    await goto(`${BASE}/categorias`);
    console.log('\n===== CATEGORIAS =====');
    console.log(await text());

    await goto(`${BASE}/cuentas`);
    console.log('\n===== CUENTAS =====');
    console.log(await text());

    await goto(`${BASE}/transacciones`);
    console.log('\n===== TRANSACCIONES =====');
    console.log(await text());

    process.exit(0);
})().catch((e) => { console.error('ERROR:', e.message); process.exit(1); });