function CallContinue(keyId) {
    var id_name = '#user-mobile-' + keyId;
    var number = $(id_name).val();
    console.log(id_name, number);

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/admin/verify-mobile",
        data: {'mobile': number},
        success: function (res) {
            var code = res.msg_code;
            if (code === 100000) {

                //到了换卡次数之后，开始延迟等待话机重启后拨号
                var next_num_set = $('#next_num').val();
                var next_num = getCookie('next_sim_num');
                if (!next_num) {
                    next_num = 1;
                } else if (parseInt(next_num) >= parseInt(next_num_set)) {
                    $('.notice_call').html('正在切换另一张卡，电话正在重启，请稍等60秒左右');
                    useNextSim();
                    addCookie('next_sim_num', 0);
                    setTimeout(function () {
                        CallContinue(keyId);//60000毫秒后,切换完卡，开始拨号
                    }, 60000);
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
                                $(id_name).parent().addClass('on_a');
                                record = param.time;
                                ajaxRecordSync(id, record, 'jf_user_excel');
                                uploadFile();
                            } else if (param.status == 'TalkingStart') {
                                console.log("开始通话语音");
                                addCookie('noanswer', 2);
                            } else if (param.status == 'TalkingEnd') {
                                console.log("语音结束");
                            } else if (param.status == 'CallEnd') {
                                console.log("通话结束");
                                var cdr = param.CDR;
                                $('.notice_call').html('');
                                // var id_val_name = '#user-id-' + keyId;
                                // var result = cdr.substring(1, 10);
                                // if (result == 'Succeeded') {
                                // }
                                ajaxSync(id, cdr); //通话之后，通知后端这个号码已经拨打过，是否拨通和通话时间，从cdr里面获取
                                setTimeout(function () {
                                    CallContinue((keyId + 1));//800毫秒后自动拨打下一个
                                }, 800);
                            }
                        } else if (message == 'update' && name == 'Device') {
                            var param_busy = data.param;
                            var CurrentSim = param_busy.CurrentSim;

                            console.log('话机状态正忙：', param_busy);
                            if (param_busy.DeviceBusy == 'busy') {

                                // //切卡之后，每四秒查询一次话机状态，十次之后，还是不对，直接报错
                                // var tel_search_num = getCookie('tel_search_num');
                                // if (!tel_search_num) {
                                //     tel_search_num = 1;
                                // }
                                //
                                // if (parseInt(tel_search_num) >= 10) {
                                //     $('.notice_call').html('卡槽【' + CurrentSim + '】话机换卡重启失败，请刷新重试');
                                // } else {
                                //     var next_tel_search_num = parseInt(tel_search_num) + 1;
                                //     addCookie('tel_search_num', next_tel_search_num);
                                //
                                //     $('.notice_call').html('话机正在重启，请稍等');
                                //     setTimeout(function () {
                                //         searchstatus();//3秒后查询话机状态
                                //     }, 3000);
                                // }


                            }
                            if (param_busy.DeviceBusy == 'idle') {

                                // $('.notice_call').html('卡槽【' + CurrentSim + '】设备状态空闲，可以拨号');
                                console.log('卡槽【' + CurrentSim + '】设备状态空闲，可以拨号');
                            }

                        }
                    };
                    //发生错误
                    ws.onerror = function () {
                        console.log("error");
                    }
                }
            }
            if (code === 200000) {
                $('.notice_call').html('号码' + number + '已设置了防骚扰，不可以拨打');
                CallContinue((keyId + 1));//800毫秒后自动拨打下一个
            }
        },
        error: function (res) {
            console.log(res);
        }
    });

}
