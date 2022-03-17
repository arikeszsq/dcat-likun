function useNextSim() {
    ws.send(JSON.stringify({action: 'SimNext', cb: new Date().getTime()}));
}


function addCookie(name, value) {
    localStorage.setItem(name, value);
}

function delCookie(name) {
    localStorage.removeItem(name);
}

function getCookie(name) {
    return localStorage.getItem(name);
}

function hangup() {
    $('.notice_call').html('已挂机');
    ws.send(JSON.stringify({action: 'Hangup', cb: new Date().getTime()}));
}
