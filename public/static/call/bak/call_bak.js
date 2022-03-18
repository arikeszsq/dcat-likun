function Call(number) {
    verifyMobile(number);
    setTimeout(function () {
        console.log('验证是否是防骚扰了');//700毫秒延迟，因为上面验证ajax大约需要570ms
    }, 700);
    var can_call_mobile = $('#verify_mobile_can_call').val();
    console.log('can_call_mobile', can_call_mobile);
    if (can_call_mobile == 2) {
        $('.notice_call').html('号码' + number + '已设置了防骚扰，不可以拨打');
        return false;
    }
    return false;
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
        }, 60000);
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
    };
    //发生错误
    ws.onerror = function () {
        console.log("error");
    }
}
