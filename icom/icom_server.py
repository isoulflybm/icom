#!/usr/bin/python

import asyncio
import hashlib
import ssl
import websockets
import certifi
import time
import logging

# 

app_code = '123456789'

# сохраняет всех клиентов, подключенных к серверу
client_list = []

async def handler(websocket):
    if(websocket.path == (
        '/app/' + hashlib.md5(str.encode(str(int(time.time())) + ':' + app_code)).hexdigest())
    ):
        client_list.append(websocket)
        while True:
            try:
                message = await websocket.recv()
                print('Message received from client: ', message)
                await broadcast(message)
            except Exception as e:
                print(e)
                client_list.remove(websocket)
                break

async def broadcast(message):
    for client in client_list:
        # транслирует сообщение другому клиенту
        await client.send(message)

async def main():
    logging.basicConfig(filename = "client.log", level = logging.DEBUG)
    ssl_context = ssl.SSLContext(ssl.PROTOCOL_TLS_SERVER)
    ssl_context.load_cert_chain("certificate.crt", "private.key")
    async with websockets.serve(handler, "", 6030, max_size = 4000000000, ssl = ssl_context):
        await asyncio.Future()  # работает бесконечно

if __name__ == "__main__":
    asyncio.run(main())
