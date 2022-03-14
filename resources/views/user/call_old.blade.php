<script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
<link rel="stylesheet" href="/static/call/call.css">
<script src="/static/bootstrap/js/bootstrap.min.js"></script>

<div class="container-01 clearfix">
    <div class="right list_item user-info-list">
        <li class="li_title"><span>公司名称</span><span>用户名</span><span>手机号</span></li>
        <ul>
            @foreach ($users as $k => $val)
                <li class="user-info"
                    data-key_id={{ $val['key_id'] }}
                        data-id={{ $val['id'] }}
                        data-user_id={{ $val['user_id'] }}
                        data-user_name={{ $val['user_name'] }}
                        data-mobile={{ $val['mobile'] }}
                        data-call_no={{ $val['call_no'] }}
                        data-company_name={{ $val['company_name'] }}
                >
                    <input type="hidden" id="user-mobile-{{ $val['key_id'] }}" value="{{ $val['mobile'] }}">
                    <input type="hidden" id="user-id-{{ $val['id'] }}" value="{{ $val['id'] }}">
                    <span> {{ $val['company_name']}}</span>
                    <span> {{ $val['user_name']}}</span>
                    <span> {{ $val['mobile']}}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="container_zong left">
        <form class="container_sss">
            <input type="hidden" id="excel-user_id">
            <div class="form-item">
                <input type="text" class="txt form-company-name" placeholder="企业名称"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-user-name" placeholder="联系人"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-mobile" placeholder="手机号"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-wechat" placeholder="请输入微信号"/>
            </div>
            <div class="form-item">
                <input type="text" class="txt form-qq" placeholder="请输入QQ号"/>
            </div>
            <div class="form-item clearfix">
                <div class="left title">客户类别</div>
                <div class="left">
                    <input type="radio" name="type" value="A" checked/><span>A</span>
                    <input type="radio" name="type" value="B"/><span>B</span>
                    <input type="radio" name="type" value="C"/><span>C</span>
                    <input type="radio" name="type" value="D"/><span>D</span>
                </div>
            </div>
            <div class="form-item"><input type="text" class="txt form-bak" placeholder="请填写备注"></div>
            <input type="hidden" id="stop_continue_call" value="0">
        </form>
        <div class="button-list">
            <button id="batch_call" class="btn btn-success">开始自动拨号</button>
            <button id="batch_hangup" class="btn btn-danger">停止自动拨号</button>
            <button id="call" class="btn btn-info">拨号</button>
            <button id="hangup" class="btn btn-danger">挂断</button>
            <button id="set_intention_user" class="btn btn-primary">转为意向客户</button>
            <div id="add_intention_notice_html" style="color: red;"></div>
        </div>

        <div class="notice_call">待机...</div>
    </div>
</div>

<style>
    .notice_call {
        margin-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
        border-radius: 20px;
        width: 330px;
        height: 60px;
        line-height: 60px;
        background-color: lightblue;
        font-size: 18px;
        color: whitesmoke;
    }

    .already_called {
        background-color: #f9f9f9;
    }

    .already_called span  {
        color: #ccc;
    }

</style>

<script>
    $('#set_intention_user').click(function () {
        addIntentionUser();
    });

    function addIntentionUser() {
        var company_name = $('.form-company-name').val();
        var user_name = $('.form-user-name').val();
        var mobile = $('.form-mobile').val();
        var wechat = $('.form-wechat').val();
        var qq = $('.form-qq').val();
        var type = $('input[name="type"]:checked').val();
        var bak = $('.form-bak').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/admin/add-intention",
            data: {
                'company_name': company_name,
                'user_name': user_name,
                'mobile': mobile,
                'wechat': wechat,
                'qq': qq,
                'type': type,
                'bak': bak
            },
            success: function (res) {
                if (res.msg_code == 100000) {
                    $('#add_intention_notice_html').html('成功添加意向客户');
                    setTimeout(function () {
                        $('#add_intention_notice_html').html('');
                    }, 3000)
                } else {
                    $('#add_intention_notice_html').html('意向客户添加失败');
                    setTimeout(function () {
                        $('#add_intention_notice_html').html('');
                    }, 3000)
                }
            }
        });
    }


    //初始化设备
    var callout_cb;
    init();

    function init() {
        getWebsocket();
    }

    //点击右侧列表，把信息传到表单
    $('.user-info').click(function () {
        var id = $(this).data('id');
        var user_id = $(this).data('user_id');
        var company_name = $(this).data('company_name');
        var user_name = $(this).data('user_name');
        var mobile = $(this).data('mobile');
        var call_no = $(this).data('call_no');
        $('.form-company-name').val(company_name);
        $('.form-user-name').val(user_name);
        $('.form-mobile').val(mobile);

        var excel_user_id = $(this).data('id');
        $('#excel-user_id').val(excel_user_id);
    });

    //单独拨号
    $('#call').click(function () {
        var mobile = $('.form-mobile').val();
        if (!mobile) {
            alert('请先选择需要拨打的用户号码');
        } else {
            Call(mobile);
        }
    });

    //单独挂机
    $('#hangup').click(function () {
        hangup()
    });

    //连续拨号
    $('#batch_call').click(function () {
        $('#stop_continue_call').val('');
        CallContinue(1);
    });

    //停止连续拨号
    $('#batch_hangup').click(function () {
        hangup();
        $('#stop_continue_call').val(1);
    });

    function CallContinue(keyId) {
        if (!ws) {
            alert("控件未初始化");
            return false;
        }
        $('.notice_call').html('开始连续拨号');
        var stop = $('#stop_continue_call').val();
        console.log(stop);
        if (stop) {
            $('.notice_call').html('停止连续拨号');
            console.log('停止连续拨号');
            return false;
        }

        var id_name = '#user-mobile-' + keyId;

        var number = $(id_name).val();
        console.log(id_name, number);
        if (number) {
            var company_name = $(id_name).parent().data('company_name');
            var user_name = $(id_name).parent().data('user_name');
            var mobile = $(id_name).parent().data('mobile');
            $('.form-company-name').val(company_name);
            $('.form-user-name').val(user_name);
            $('.form-mobile').val(mobile);
            var excel_user_id = $(id_name).parent().data('id');
            $('#excel-user_id').val(excel_user_id);

            callout_cb = 'CallOut_cb_' + new Date().getTime();
            var action = {
                action: 'CallOut',
                number: number,
                cb: callout_cb
            };
            ws.send(JSON.stringify(action));
            //收到服务端消息
            ws.onmessage = function (event) {
                console.log(event.data);
                var data = JSON.parse(event.data);
                var message = data.message;
                var name = data.name;
                var id = $('#excel-user_id').val();
                var record = '';
                if (message == 'update' && name == 'Call') {
                    var param = data.param;
                    console.log(param);
                    if (param.status == 'CallStart') {
                        $('.notice_call').html('拨号中：' + number);
                        //拨号之后把手机号码置空
                        $(id_name).val('');
                        $(id_name).parent().addClass('already_called');
                        record = param.time;
                        ajaxRecordSync(id, record, 'jf_user_excel');
                        uploadFile();
                    } else if (param.status == 'TalkingEnd') {
                        console.log("语音结束");
                    } else if (param.status == 'CallEnd') {
                        console.log("通话结束：");
                        $('.notice_call').html('');
                        var id_val_name = '#user-id-' + keyId;
                        var cdr = param.CDR;
                        // var result = cdr.substring(1, 10);
                        // if (result == 'Succeeded') {
                        // }
                        ajaxSync(id, cdr); //通话之后，通知后端这个号码已经拨打过，是否拨通和通话时间，从cdr里面获取
                        setTimeout(function () {
                            CallContinue((keyId + 1));//800毫秒后自动拨打下一个
                        }, 800)
                    }
                }
            };
            //发生错误
            ws.onerror = function () {
                console.log("error");
            }
        }
    }

    function ajaxSync(id, cdr) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/admin/call-back",
            data: {'id': id, 'cdr': cdr}
        });
    }

    function ajaxRecordSync(id, record, table_name) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/admin/add-call-record",
            data: {'id': id, 'record': record, 'table_name': table_name}
        });
    }


    //主动切换下一张卡拨号
    $('#next').click(function () {
        ws.send(JSON.stringify({action: 'SimNext', cb: new Date().getTime()}));
        ws.onmessage = function (event) {
            console.log("message", event.data);
        };
        ws.onerror = function () {
            console.log("error");
        }
    });

    function Call(number) {
        if (!ws) {
            alert("控件未初始化");
            return false;
        }
        $('.notice_call').html('开始拨号');
        callout_cb = 'CallOut_cb_' + new Date().getTime();
        var action = {
            action: 'CallOut',
            number: number,
            cb: callout_cb
        };
        ws.send(JSON.stringify(action));
        //收到服务端消息
        ws.onmessage = function (event) {
            console.log(event.data);
            var data = JSON.parse(event.data);
            var message = data.message;
            var name = data.name;
            var id = $('#excel-user_id').val();
            var record = '';
            if (message == 'update' && name == 'Call') {
                var param = data.param;
                console.log(param);
                if (param.status == 'CallStart') {
                    record = param.time;
                    ajaxRecordSync(id, record, 'jf_user_excel');
                    uploadFile();
                    $('.notice_call').html('拨号中：' + number);


                    var id_name = '#user-mobile-' + id;
                    $(id_name).val('');
                    $(id_name).parent().addClass('already_called');
                } else if (param.status == 'TalkingEnd') {
                    console.log("语音结束");
                } else if (param.status == 'CallEnd') {
                    console.log("通话结束/或者挂断事件");
                    $('.notice_call').html('');
                    var cdr = param.CDR;
                    //通话之后，通知后端这个号码已经拨打过，是否拨通和通话时间，从cdr里面获取
                    ajaxSync(id, cdr);
                }
            }
        };
        //发生错误
        ws.onerror = function () {
            console.log("error");
        }
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

    function hangup() {
        ws.send(JSON.stringify({action: 'Hangup', cb: new Date().getTime()}));
        ws.onmessage = function (event) {
            console.log("message", event.data);
        };
        ws.onerror = function () {
            console.log("error");
        }
    }
</script>

