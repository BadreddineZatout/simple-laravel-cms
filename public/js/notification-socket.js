let clientSocket = (config = {}) => {
    let route = config.route || "127.0.0.1";
    let port = config.port || 3280;
    window.Websocket = window.Websocket || window.MozWebSocket;
    return new WebSocket("ws://" + route + ":" + port);
};
let connection = clientSocket();

connection.onopen = () => {
    console.log("Connecion is open!");
};

//create notification
connection.onmessage = (message) => {
    let result = JSON.parse(message.data);

    $(".event-notification-box").html(`
        <h3>${result.eventName}</h3>
        <p>${result.eventMessage}</p>
    `);
    $(".event-notification-box").removeClass("opacity-0");
    $(".event-notification-box").addClass("opacity-100");

    setTimeout(() => {
        $(".event-notification-box").removeClass("opacity-100");
        $(".event-notification-box").addClass("opacity-0");
    }, 3000);
};

//page creation event listner
window.addEventListener("event-notification", (event) => {
    connection.send(
        JSON.stringify({
            eventName: event.detail.eventName,
            eventMessage: event.detail.eventMessage,
        })
    );
});
