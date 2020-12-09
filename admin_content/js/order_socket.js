// Websocket
console.log("Sockets script");
const WebsocketServer = new WebSocket("wss://" + domain + ':55556');
WebsocketServer.onopen = function(e) {
    console.log("Connection established");
    WebsocketServer.send(
        JSON.stringify({
            'type': 'socket',
            'user_id': userid,
            'chat_msg': 'hello world'
        })
    );
};
WebsocketServer.onerror = function(e) {
    // Errorhandling
}
WebsocketServer.onmessage = function(e) {
    const json = JSON.parse(e.data);
    switch (json.type) {
        case 'socket':
            console.log(json.msg);
            break;
    }
}