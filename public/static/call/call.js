function Call(number) {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/admin/verify-mobile",
        data: {'mobile': number},
        success: function (res) {
            var code = res.msg_code;
            if (code === 100000) {

                if ($('#tell_no_line').val() == 1 || $('#tell_no_line').val() == 3) {
                    console.log('查询设备是否在线');
                    searchDevice();
                    if ($('#tell_no_line').val() == 3) {
                        return false;
                    }
                }

                //查询是否需要切卡
                var rolling_time_set = $('#rolling_time').val();
                var next_num_set = $('#next_num').val();
                var next_num = getCookie('next_sim_num');
                if (!next_num) {
                    next_num = 1;
                }
                if (parseInt(next_num) >= parseInt(next_num_set)) {
                    useNextSimAndCall();
                } else {
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
                        console.log('calljs', event.data);
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
                                $(id_name).parent().addClass('on_a');
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

                        //接收到话机信息查询的回调，注意message 和name，代表不同类型的查询
                        if (message == 'query' && name == 'Device') {
                            var param_busy = data.param;
                            var CurrentSim = param_busy.CurrentSim;
                            console.log('正在使用卡槽：', CurrentSim);
                            if (param_busy.DeviceBusy == 'busy') {
                                //切卡之后，每四秒查询一次话机状态，十次之后，还是不对，直接报错
                                var tel_search_num = getCookie('tel_search_num');
                                if (!tel_search_num) {
                                    tel_search_num = 1;
                                }
                                if (parseInt(tel_search_num) >= 20) {
                                    $('.notice_call').html('卡槽【' + CurrentSim + '】话机换卡重启失败，请刷新重试');
                                    addCookie('tel_search_num', 1);
                                } else {
                                    var next_tel_search_num = parseInt(tel_search_num) + 1;
                                    addCookie('tel_search_num', next_tel_search_num);

                                    $('.notice_call').html('话机正在重启，请稍等');
                                    setTimeout(function () {
                                        console.log('3s后再次开始查询话机状态接口');
                                        searchstatus();//3秒后查询话机状态
                                    }, 3000);
                                }
                            }
                            if (param_busy.DeviceBusy == 'idle') {
                                $('.notice_call').html('卡槽【' + CurrentSim + '】设备状态空闲，开始拨号');
                                console.log('卡槽【' + CurrentSim + '】设备状态空闲，可以拨号');
                                console.log('换卡完成，开始拨号');
                                addCookie('next_sim_num', 0);
                                Call(number);
                            }
                        }

                        if (message == 'query' && name == 'Connect') {
                            var param_connect = data.param;
                            if (!param_connect) {
                                console.log('话机不在线');
                                $('.notice_call').html('话机不在线');
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
                }
            }
            if (code === 200000) {
                $('.notice_call').html('号码' + number + '已设置了防骚扰，不可以拨打');
                return false;
            }
        },
        error: function (res) {
            console.log(res);
        }
    });

}


function useNextSimAndCall() {
    //需要设备空闲的时候，才可以换卡
    console.log('正在切换另一张卡，电话正在重启');
    $('.notice_call').html('正在切换另一张卡，电话正在重启，请稍等');
    useNextSim();
    setTimeout(function () {
        searchDevice();
    }, 1000);
    setTimeout(function () {
        console.log('开始查询话机状态接口');
        searchstatus();
    }, 20000);
}
