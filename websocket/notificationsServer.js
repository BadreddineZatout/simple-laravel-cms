const webSocketServer = require("websocket").server;
const http = require("http");
const htmlEntity = require("html-entities");

const PORT = 3280;
const clients = [];

const server = http.createServer();
server.listen(PORT, () => {
    console.log("Server listening on PORT:", PORT);
});

const wsServer = new webSocketServer({
    httpServer: server,
});
wsServer.on("request", (req) => {
    let connection = req.accept(null, req.origin);
    let index = clients.push(connection) - 1;
    console.log("Client", index, "connected");

    connection.on("message", (message) => {
        let utf8Data = JSON.parse(message.utf8Data);
        if (message.type == "utf8") {
            let obj = JSON.stringify({
                eventName: htmlEntity.encode(utf8Data.eventName),
                eventMessage: htmlEntity.encode(utf8Data.eventMessage),
            });
            clients.forEach((client) => {
                client.sendUTF(obj);
            });
        }
    });

    connection.on("close", (connection) => {
        clients.splice(index, 1);
        console.log("Client", index, "was disconnected");
    });
});
