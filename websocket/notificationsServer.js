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
        console.log(message);
    });

    connection.on("close", (connection) => {
        clients.splice(index, 1);
        console.log("Client", index, "was disconnected");
    });
});
