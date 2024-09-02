import path from 'path';
import { fileURLToPath } from 'url';
import WebSocket from 'ws';
import crypto from 'crypto';
import readline from 'node:readline';
import { stdin, stdout } from 'node:process';

const app_code = '123456789';
let app_id = new String(Math.floor(new Date().getTime() / 1000));

let app_hash = crypto.createHash('md5').update(
    new String(Math.floor(new Date().getTime() / 1000)) + ':' + app_code
).digest('hex');
const ws = new WebSocket(`wss://127.0.0.1:6030/app/${app_hash}` , {
    rejectUnauthorized: false
});

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

console.log(`App ID: ${app_id}`);

ws.on('error', console.error);

ws.on('message', function message(data) {
    console.log(`Data: ${data}`);
    let json = JSON.parse(data);
    if(json.ping) {
        ws.send(`{"pong": "${app_id}"}`);
    }
    else if(json.type && json.data) {
        if(json.send && json.recv && json.send == app_id) {
            console.log("Match");
        }
        else if(json.recv) {
        }
    }
    else if(!json.type && !json.data) {
        if(json.send && json.recv && json.send == app_id) {
            ws.send(JSON.stringify({
                "send": app_id, "recv": json.send,
                "type": "text/html", "data": "<div>Test</div>"
            }));
        }
    }
});

ws.on('open', function open() {
    ws.send(`{"ping": "${app_id}"}`);
});

const read = readline.createInterface({ input: stdin, output: stdout });

console.log('>');
read.on('line', (input) => {
    ws.send(input);
    console.log('>');
});
