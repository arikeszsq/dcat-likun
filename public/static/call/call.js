function Call(number) {
    if (!ws) {
        $('.notice_call').html('未安装驱动');
        return false;
    }

    addCookie('call_type', 'personal_call');
    addCookie('personal_call_number', number);

    //查询是否需要切卡
    var next_num_set = $('#next_num').val();
    var next_num = getCookie('next_sim_num');
    if (!next_num) {
        next_num = 1;
    }

    if (parseInt(next_num) >= parseInt(next_num_set)) {
        useNextSim();
        return false;
    } else {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/admin/verify-mobile",
            data: {'mobile': number},
            success: function (res) {
                var code = res.msg_code;
                if (code === 100000) {
                    //添加一次本卡槽的拨号次数
                    addCookie('next_sim_num', (parseInt(next_num) + 1));
                    $('.notice_call').html('开始拨号：' + number);
                    startCall(number);
                }
                if (code === 200000) {
                    $('.notice_call').html('防骚扰号：' + number);
                    return false;
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
    }
}
