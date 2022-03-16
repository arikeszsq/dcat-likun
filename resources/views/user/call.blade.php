<script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
<link rel="stylesheet" href="/static/call/call.css">
<script src="/static/bootstrap/js/bootstrap.min.js"></script>

<script src="/static/call/addintention.js"></script>

<div class="con_a_w">
    <div class="con_a">
        <div class="con_a_l">
            <div class="sj_nr">
                <div class="sj_nr_bt">待呼叫资源</div>
                <div class="sj_nr_nr">
                    <div class="sj_nr_nr_bt">
                        <ul>
                            <li><span>公司名称</span><span>用户名</span><span>手机号</span><span>数据来源</span></li>
                            @foreach ($users as $k => $val)
                                @if($val['call_no'])
                                    <li class="on_a user-info"
                                        data-key_id={{ $val['key_id'] }}
                                            data-id={{ $val['id'] }}
                                            data-user_id={{ $val['user_id'] }}
                                            data-user_name={{ $val['user_name'] }}
                                            data-mobile={{ $val['mobile'] }}
                                            data-call_no={{ $val['call_no'] }}
                                            data-company_name={{ $val['company_name'] }}
                                    >
                                @else
                                    <li class=" user-info"
                                        data-key_id={{ $val['key_id'] }}
                                            data-id={{ $val['id'] }}
                                            data-user_id={{ $val['user_id'] }}
                                            data-user_name={{ $val['user_name'] }}
                                            data-mobile={{ $val['mobile'] }}
                                            data-call_no={{ $val['call_no'] }}
                                            data-company_name={{ $val['company_name'] }}
                                    >
                                        @endif
                                        <input type="hidden" id="user-mobile-{{ $val['key_id'] }}"
                                               value="{{ $val['mobile'] }}">
                                        <input type="hidden" id="user-id-{{ $val['id'] }}" value="{{ $val['id'] }}">
                                        <span> {{ $val['company_name']}}</span>
                                        <span> {{ $val['user_name']}}</span>
                                        <span> {{ $val['mobile']}}</span>
                                        <span> {{ $val['source']}}</span>
                                    </li>
                                    @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="con_a_r">
            <div class="bddh_nr">
                <div class="sj_nr_bt">拨打电话</div>
                <div class="bddh_nr_nr">
                    <div class="container_zong">
                        <form class="container_sss">
                            <input type="hidden" id="excel-user_id">
                            <div class="form-item">
                                <span>企业名称:</span>
                                <input type="text" class="txt form-company-name" placeholder="企业名称"/>
                            </div>
                            <div class="form-item">
                                <span>联系人:</span>
                                <input type="text" class="txt form-user-name" placeholder="联系人"/>
                            </div>
                            <div class="form-item">
                                <span>手机号:</span><input type="text" class="txt form-mobile" placeholder="手机号"/>
                            </div>
                            <div class="form-item">
                                <span>数据来源:</span><input type="text" class="txt form-source"
                                                         placeholder="数据来源"/>
                            </div>
                            <div class="form-item">
                                <span class="form-item">客户类别</span>
                                <div class="khlb">
                                    <span class="nb_type khlb_user_type" data-id="A">A类客户</span>
                                    <span class="nb_type" data-id="B">B类客户</span>
                                    <span class="nb_type" data-id="C">C类客户</span>
                                    <span class="nb_type" data-id="D">D类客户</span>
                                </div>
                            </div>
                            <div class="form-item">
                                <span>客户信息登记:</span>
                                <textarea rows="3" class="gjkh_a form-bak" placeholder="请填写客户信息登记"></textarea>
                            </div>
                            <input type="hidden" id="stop_continue_call" value="0">
                            <input type="hidden" id="rolling_time" value="{{$rolling_time}}">
                            <input type="hidden" id="valid_time" value="{{$valid_time}}">
                            <input type="hidden" id="next_num" value="{{$next_num}}">

                        </form>

                        <div class="container_zong biaoqian_a">
                            <div class="container_sss">
                                <div class="form-item">
                                    <span class="form-item">标签：</span>
                                    <div class="khlb nb_tag_list">
                                        @foreach ($tags as $tag)
                                            <span class="nb_tag" data-select="2"
                                                  data-id="{{$tag['id']}}">{{$tag['name']}}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-list">
                            <button id="set_intention_user" class="btn btn-primary">转为意向客户</button>
                        </div>
                        <div class="container_zong biaoqian_a">
                            <div class="button-list">
                                <button id="batch_call" class="btn btn-success">开始自动拨号</button>
                                <button id="batch_hangup" class="btn btn-danger">停止自动拨号</button>
                                <button id="call" class="btn btn-info">拨号</button>
                                <button id="hangup" class="btn btn-danger">挂断</button>
                            </div>

                            <div class="notice_call">待机...</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="c"></div>
        </div>
    </div>
</div>
<script>
    $('.nb_type').click(function () {
        $(this).addClass('khlb_user_type').siblings().removeClass('khlb_user_type');
    });
    $('.nb_tag').click(function () {
        var nb_val = $(this).data('select');
        if (nb_val == 1) {
            $(this).data('select', 2);
            $(this).removeClass('khlb_01');
        } else {
            $(this).data('select', 1);
            $(this).addClass('khlb_01');
        }
    });
    //转为意向客户
    $('#set_intention_user').click(function () {
        addTention();
    });


    //初始化设备
    var callout_cb;
    init();

    function init() {
        getWebsocket();
    }

    //点击右侧列表，把信息传到表单
    $('.user-info').click(function () {
        var company_name = $(this).data('company_name');
        var user_name = $(this).data('user_name');
        var mobile = $(this).data('mobile');
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
        var id_name = '#user-mobile-' + keyId;
        var number = $(id_name).val();
        console.log(id_name, number);
        var can_call = verifyMobile(number);
        if (!can_call) {
            $('.notice_call').html('该号码' + number + '已设置了防骚扰，不可以拨打');
            CallContinue((keyId + 1));
        }

        //到了换卡次数之后，开始延迟等待话机重启后拨号
        var next_num_set = $('#next_num').val();
        var next_num = getCookie('next_sim_num');
        if (!next_num) {
            next_num = 1;
        } else if (parseInt(next_num) >= parseInt(next_num_set)) {
            var notice = '正在切换另一张卡，电话正在重启，请稍等60秒左右';
            $('.notice_call').html(notice);
            useNextSim();
            addCookie('next_sim_num', 0);
            setTimeout(function () {
                CallContinue(keyId);//6000毫秒后,切换完卡，开始拨号
            }, 60000)
        }
        var next_num_incr = parseInt(next_num) + 1;
        addCookie('next_sim_num', next_num_incr);


        if (!ws) {
            alert("控件未初始化");
            return false;
        }
        var rolling_time_set = $('#rolling_time').val();
        $('.notice_call').html('开始连续拨号');
        var stop = $('#stop_continue_call').val();
        console.log(stop);
        if (stop) {
            $('.notice_call').html('停止连续拨号');
            console.log('停止连续拨号');
            return false;
        }
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


                        console.log("开始拨号，开始通话");
                        //开始计时，到时间未接通直接挂断
                        addCookie('noanswer', 1);
                        setTimeout(function () {
                            var noanswer = parseInt(getCookie('noanswer'));
                            if (noanswer == 1) {
                                hangup();
                            }
                        }, (rolling_time_set * 1000));


                        $('.notice_call').html('拨号中：' + number);
                        //拨号之后把手机号码置空
                        $(id_name).val('');
                        $(id_name).parent().addClass('already_called');
                        record = param.time;
                        ajaxRecordSync(id, record, 'jf_user_excel');
                        uploadFile();
                    } else if (param.status == 'TalkingStart') {
                        console.log("开始通话语音");
                        addCookie('noanswer', 2);
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

    function verifyMobile(mobile) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/admin/verify-mobile",
            data: {'mobile': mobile},
            success(res) {
                var code = res.msg_code;
                if (code == 100000) {
                    return true;
                } else {
                    return false;
                }
            }
        });
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

    function Call(number) {


        var can_call = verifyMobile(number);
        if (!can_call) {
            $('.notice_call').html('该号码已设置了防骚扰，不可以拨打');
            return false;
        }

        var rolling_time_set = $('#rolling_time').val();

        var next_num_set = $('#next_num').val();
        var next_num = getCookie('next_sim_num');
        if (!next_num) {
            next_num = 1;
        } else if (parseInt(next_num) >= parseInt(next_num_set)) {
            var notice = '正在切换另一张卡，电话正在重启，请稍等60秒左右';
            $('.notice_call').html(notice);
            useNextSim();
            addCookie('next_sim_num', 0);
            setTimeout(function () {
                Call(number);//6000毫秒后,切换完卡，开始拨号
            }, 60000)
        }
        var next_num_incr = parseInt(next_num) + 1;
        addCookie('next_sim_num', next_num_incr);


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

                    console.log("开始拨号，开始通话");
                    //开始计时，到时间未接通直接挂断
                    addCookie('noanswer', 1);
                    setTimeout(function () {
                        var noanswer = parseInt(getCookie('noanswer'));
                        if (noanswer == 1) {
                            hangup();
                        }
                    }, (rolling_time_set * 1000));

                    record = param.time;
                    ajaxRecordSync(id, record, 'jf_user_excel');
                    uploadFile();
                    $('.notice_call').html('拨号中：' + number);
                    var id_name = '#user-mobile-' + id;
                    $(id_name).val('');
                    $(id_name).parent().addClass('already_called');
                } else if (param.status == 'TalkingStart') {
                    console.log("开始通话语音");
                    addCookie('noanswer', 2);
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

