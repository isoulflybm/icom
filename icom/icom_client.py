#!/usr/bin/python

import hashlib
import ssl
import websocket
import time
import _thread
import json

app_code = '123456789'
app_id = str(int(time.time()))

ws = websocket.WebSocket(sslopt = { "cert_reqs": ssl.CERT_NONE })
ws.connect(
    'wss://localhost:6030/app/'
    + hashlib.md5(str.encode(str(int(time.time())) + ':' + app_code)).hexdigest()
)

def receive_messages(websock):
    while True:
        try:
            message = websock.recv()
            print(">", message)
            message = json.loads(message)
            if(message['ping'] and message['ping'] != app_id):
                websock.send(json.dumps({'pong': app_id}))
            elif(message['recv']):
                if(message['send']):
                    if(message['type'] and message['data']):
                        print(message['data'])
                    elif(message['send'] == app_id):
                            websock.send(json.dumps({
                                'send': message['recv'], 'recv': app_id,
                                'type': 'text/plain',
                                'data': {'id': 0, 'name': 'user'}
                            }))
        except Exception as exception:
                print(exception)
                #break

_thread.start_new_thread(receive_messages, (ws, ))  # прослушивание с сервера
ws.send(json.dumps({'ping': app_id}))
while True:
    to_send = input()
    ws.send(to_send)
