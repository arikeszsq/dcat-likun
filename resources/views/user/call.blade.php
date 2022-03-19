<script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
<link rel="stylesheet" href="/static/call/call.css">
<script src="/static/bootstrap/js/bootstrap.min.js"></script>

<script src="/static/call/api.js"></script>
<script src="/static/call/call.js"></script>
<script src="/static/call/callcontinue.js"></script>
<script src="/static/call/caller.js"></script>
<script src="/static/call/click.js"></script>

<style>
    .div_list_body {
        height: 700px;
        overflow: scroll;
        overflow-x: auto;
    }
</style>
<div class="con_a_w">
    <div class="con_a">
        <div class="con_a_l">
            <div class="sj_nr">
                <div class="sj_nr_bt">待呼叫资源</div>
                <div class="sj_nr_nr div_list_body">
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
                                            data-source={{ $val['source'] }}
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
                                            data-source={{ $val['source'] }}
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
                            <div class="form-item" style="padding-bottom:8px;border-bottom: #0a6aa1 2px solid;">
                                <span>切换批次数据:</span>
                                <select class="form-control excel_batch_no_list">
                                    <option value=""></option>
                                    @foreach ($batch_array as $batch_no)
                                        <option value="/admin/user-call?batch_no={{$batch_no}}">{{$batch_no}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                            <input type="hidden" id="tell_no_line" value="1">
                            <input type="hidden" id="hid_key_id" value="0">

                            <input type="hidden" id="verify_mobile_can_call" value="1">

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
    var callout_cb;
    init();

    function init() {
        $('.content-header').remove();
        //初始化驱动，查询电话机是否连接
        getWebsocket();
    }

    ws.onmessage = function (event) {
        console.log('服务器消息：', event.data);
        var data = JSON.parse(event.data);
        var message = data.message;
        var name = data.name;

        var tabel_user_excel_id = $('#excel-user_id').val();
        var record = '';
        var call_type = getCookie('call_type');
        var keyId = 0;

        if (message == 'update' && name == 'Call') {
            var param = data.param;
            if (param.status == 'CallStart') {

                addCookie('callstatus', 'iscalling');

                //开始计时，到时间未接通直接挂断
                addCookie('noanswer', 1);
                var rolling_time_set = $('#rolling_time').val();
                setTimeout(function () {
                    var noanswer = parseInt(getCookie('noanswer'));
                    if (noanswer == 1) {
                        hangup();
                    }
                }, (rolling_time_set * 1000));

                //拨号之后把手机号码置空
                if (call_type === 'continue_call') {
                    keyId = getCookie('continue_call_keyId');
                    var id_name = '#user-mobile-' + keyId;
                    $(id_name).val('');
                    $(id_name).parent().addClass('on_a');
                } else {
                    //这里p_keyId重命名，是怕keyId被p_keyId单独拨号覆盖了
                    var p_keyId = $('#hid_key_id').val();
                    var p_id_name = '#user-mobile-' + p_keyId;
                    $(p_id_name).val('');
                    $(p_id_name).parent().addClass('on_a');
                }

                record = param.time;
                ajaxRecordSync(tabel_user_excel_id, record, 'jf_user_excel');
                uploadFile();
            } else if (param.status == 'TalkingStart') {
                console.log("开始通话语音");
                addCookie('noanswer', 2);
            } else if (param.status == 'TalkingEnd') {
                console.log("语音结束");
            } else if (param.status == 'CallEnd') {
                console.log("通话结束");
                var cdr = param.CDR;
                addCookie('callstatus', 'callend');
                $('.notice_call').html('通话已结束');
                // var result = cdr.substring(1, 10);
                // if (result == 'Succeeded') {
                // }
                ajaxSync(tabel_user_excel_id, cdr); //通话之后，通知后端这个号码已经拨打过，是否拨通和通话时间，从cdr里面获取
                if (call_type === 'continue_call') {
                    keyId = getCookie('continue_call_keyId');
                    yFlow(keyId);
                    setTimeout(function () {
                        CallContinue((parseInt(keyId) + 1));//800毫秒后自动拨打下一个
                    }, 800);
                }
            }
        }

        //接收到话机信息查询的回调，注意message 和name，代表不同类型的查询
        if (message == 'query' && name == 'Device') {
            var param_busy = data.param;
            var CurrentSim = param_busy.CurrentSim;
            if (param_busy.DeviceBusy == 'busy') {
                //切卡之后，每3秒查询一次话机状态，二十次之后，还是不对，直接报错
                var tel_search_num = getCookie('tel_search_num');
                if (!tel_search_num) {
                    tel_search_num = 1;
                }
                if (parseInt(tel_search_num) >= 20) {
                    $('.notice_call').html('卡槽【' + CurrentSim + '】，话机换卡重启失败，请刷新重试');
                    addCookie('tel_search_num', 1);
                } else {
                    addCookie('tel_search_num', (parseInt(tel_search_num) + 1));
                    $('.notice_call').html('换卡中');
                    setTimeout(function () {
                        searchstatus();//3秒后查询话机状态
                    }, 3000);
                }
            }
            if (param_busy.DeviceBusy == 'idle') {
                $('.notice_call').html('卡槽【' + CurrentSim + '】空闲，开始拨号');
                console.log('换卡完成，开始拨号');
                addCookie('next_sim_num', 0);
                if (call_type === 'continue_call') {
                    keyId = getCookie('continue_call_keyId');
                    CallContinue(keyId);
                } else {
                    var mobile = getCookie('personal_call_number');
                    Call(mobile);
                }
            }
        }

        if (message == 'query' && name == 'Connect') {
            var param_connect = data.param;
            if (!param_connect) {
                console.log('话机不在线');
                $('.notice_call').html('话机不在线');
                alert('未查询到电话机');
                $('#tell_no_line').val(3);
            } else {
                $('#tell_no_line').val(2);
                console.log('话机在线');
            }
        }
    };

    //发生错误
    ws.onerror = function () {
        console.log("error");
    };


    function uploadFile() {
        ws.send(
            JSON.stringify({
                action: 'Settings',
                settings: {
                    upload: {
                        api: '',//http://tk.lianshuiweb.com/api/upload-file
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
            alert('驱动初始化失败：' + event.data);
        };
        ws.onclose = function (event) {
        };
        ws.onopen = function () {
            console.log('驱动初始化成功');
            //设置设备8张卡
            ws.send(
                JSON.stringify({
                    action: 'Settings',
                    settings: {
                        SimTotal: 8
                    },
                    cb: new Date().getTime()
                })
            );

            setTimeout(function () {
                queryConnect();
            }, 500);

        };
    }

    function queryConnect() {
        //查询设备是否连接
        ws.send(JSON.stringify({
            action: 'Query',
            type: 'Connect',
            cb: 'cb_data'
        }));
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

</script>

