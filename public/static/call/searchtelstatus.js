function searchstatus() {
    ws.send(JSON.stringify({
        action: 'Query',
        type: 'Device',
        cb: 'cb_data'
    }));
}


function searchDevice() {
    ws.send(JSON.stringify({
        action: 'Query',
        type: 'Connect',
        cb: 'cb_data'
    }));
}
