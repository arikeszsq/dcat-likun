function searchstatus() {
    ws.send(JSON.stringify({
        action: 'Query',
        type: 'Device',
        cb: 'cb_data'
    }));
}
