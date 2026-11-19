const CDP = 'http://127.0.0.1:9222';
let ws, seq = 0; const pending = new Map();
function send(m, p = {}) { return new Promise((res, rej) => { const id = ++seq; pending.set(id, { res, rej }); ws.send(JSON.stringify({ id, method: m, params: p })); }); }
async function connect() { const t = await (await fetch(`${CDP}/json/list`)).json(); const page = t.find(x => x.type === 'page'); ws = new WebSocket(page.webSocketDebuggerUrl); await new Promise((r, j) => { ws.onopen = r; ws.onerror = j; }); ws.onmessage = ev => { const m = JSON.parse(ev.data); if (m.id && pending.has(m.id)) { const { res, rej } = pending.get(m.id); pending.delete(m.id); m.error ? rej(new Error(JSON.stringify(m.error))) : res(m.result); } }; }
const sleep = ms => new Promise(r => setTimeout(r, ms));
async function evaluate(e) { const r = await send('Runtime.evaluate', { expression: e, awaitPromise: true, returnByValue: true }); if (r.exceptionDetails) throw new Error(JSON.stringify(r.exceptionDetails)); return r.result.value; }
(async () => {
  await connect(); await send('Page.enable'); await send('Runtime.enable'); await send('Network.enable');
  await send('Network.clearBrowserCookies');
  await send('Page.navigate', { url: 'http://127.0.0.1:8123/login' }); await sleep(1600);
  console.log('URL:', await evaluate('location.pathname'));
  console.log('---');
  console.log(await evaluate("document.body.innerText.replace(/\\n{2,}/g,'\\n').trim()"));
  process.exit(0);
})().catch(e => { console.error('ERR', e.message); process.exit(1); });
