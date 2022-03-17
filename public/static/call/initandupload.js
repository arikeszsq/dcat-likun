function init() {
    getWebsocket();
}

function uploadFile() {
    ws.send(
        JSON.stringify({
            action: 'Settings',
            settings: {
                upload: {
                    api: 'http://tk.lianshuiweb.com/api/upload-file',//http://tk.lianshuiweb.com/api/upload-file
                    flag: 'token-1234-123',
                    file: '1',
                    qiniu: {
                        AccessKey: 'Bz7rahQAQVdmp-6wYw50zNKO2JPh52fIUrNCtwjq',
                        SecretKey: 'Pj_qaxfs9earPgwiiE_ys3OaFvB3xKunwgcYrieD',
                        Zone: 'Zone_z0',//华东
                        Bucket: '123456adsf'
                    }
                }
            },
            cb: new Date().getTime()
        })
    );
}

function getWebsocket() {
    ws = new WebSocket('ws://127.0.0.1:8090/APP_2AD85C71-BEF8-463C-9B4B-B672F603542A_fast');
    ws.onerror = function (event) {
        alert('初始化设备失败：' + event.data);
    };
    ws.onclose = function (event) {
    };
    ws.onopen = function () {
        console.log('初始化设备成功');
    }
}
