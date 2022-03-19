function CallContinue(keyId) {
    if (!ws) {
        $('.notice_call').html('未安装驱动');
        return false;
    }

    addCookie('call_type', 'continue_call');
    addCookie('continue_call_keyId', keyId);

    var stop = $('#stop_continue_call').val();
    if (stop) {
        $('.notice_call').html('停止连续拨号');
        return false;
    }

    var id_name = '#user-mobile-' + keyId;
    var number = $(id_name).val();
    if (number) {
        console.log(number, keyId);
        //查询是否需要切卡
        var next_num_set = $('#next_num').val();
        var next_num = getCookie('next_sim_num');
        if (!next_num) {
            next_num = 1;
        }

        if (parseInt(next_num) >= parseInt(next_num_set)) {
            useNextSim();
        } else {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/admin/verify-mobile",
                data: {'mobile': number},
                success: function (res) {
                    var code = res.msg_code;
                    if (code === 100000) {

                        var company_name = $(id_name).parent().data('company_name');
                        var user_name = $(id_name).parent().data('user_name');
                        var mobile = $(id_name).parent().data('mobile');
                        var source = $(id_name).parent().data('source');
                        $('.form-company-name').val(company_name);
                        $('.form-user-name').val(user_name);
                        $('.form-mobile').val(mobile);
                        $('.form-source').val(source);
                        var excel_user_id = $(id_name).parent().data('id');
                        $('#excel-user_id').val(excel_user_id);

                        addCookie('next_sim_num', (parseInt(next_num) + 1));
                        $('.notice_call').html('连续拨号:' + number);
                        startCall(number);

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
    } else {
        if (keyId <= 200) {
            var keyAddId = (parseInt(keyId) + 1);
            CallContinue(keyAddId);
        } else {
            $('.notice_call').html('全部号码已经拨打完成');
            console.log('全部号码已经拨打完成');
            return false;
        }
        console.log(keyId);
    }

}
