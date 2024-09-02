# icom
#
# icom protocol
#
# connect to:
#
# wss://[url]:[port]/app/[app-id-hash]
#
# app-id-hash = [gmt_time_seconds]:[app-id]
#
# json:
#
# when client connected:
# ping:[client_app-id]
#
# all online clients resopnded:
# pong:[client_app-id]
#
# when client sended to app:
# send:[to_client_app-id]
# recv:[from_client_app-id]
# type:[mime_type_of_data]
# data:[base64_encoded_data]
# offset:[offset_from_file_begin]
#
# who is client:
# send:[to_client_app-id]
# recv:[from_client_app-id]
#
# send to all apps:
# recv:[from_client_app-id]
# type:[mime_type_of_data]
# data:[base64_encoded_data]
# offset:[offset_from_file_begin]
#
