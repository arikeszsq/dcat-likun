function hangup() {
    $('.notice_call').html('挂机');
    ws.send(JSON.stringify({action: 'Hangup', cb: new Date().getTime()}));
}

function useNextSim() {
    $('.notice_call').html('正在切卡,请稍等');
    ws.send(JSON.stringify({action: 'SimNext', cb: new Date().getTime()}));
    setTimeout(function () {
        searchstatus();
    }, 1000);
}

function startCall(number) {
    callout_cb = 'CallOut_cb_' + new Date().getTime();
    var action = {
        action: 'CallOut',
        number: number,
        cb: callout_cb
    };
    ws.send(JSON.stringify(action));
}

//查询话机的状态，idle：设备空闲；busy：设备忙。
function searchstatus() {
    ws.send(JSON.stringify({
        action: 'Query',
        type: 'Device',
        cb: 'cb_data'
    }));
}
