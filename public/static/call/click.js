$('document').ready(function () {
    //客户类型
    $('.nb_type').click(function () {
        $(this).addClass('khlb_user_type').siblings().removeClass('khlb_user_type');
    });

    //标签
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

    //添加意向客户意向客户
    $('#set_intention_user').click(function () {
        addTention();
    });
    //点击右侧列表，把信息传到表单
    $('.user-info').click(function () {
        var keyId = $(this).data('key_id');
        var company_name = $(this).data('company_name');
        var user_name = $(this).data('user_name');
        var mobile = $(this).data('mobile');
        var source = $(this).data('source');
        $('.form-company-name').val(company_name);
        $('.form-user-name').val(user_name);
        $('.form-mobile').val(mobile);
        $('.form-source').val(source);
        var excel_user_id = $(this).data('id');
        $('#excel-user_id').val(excel_user_id);
        $('#hid_key_id').val(keyId);
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
        hangup();
    });

    //连续拨号
    $('#batch_call').click(function () {
        $('#stop_continue_call').val('');
        var keyId = getCookie('continue_call_keyId');
        if (!keyId) {
            keyId = 1;
        }
        if (keyId > 1) {
            var id_name = '#user-mobile-1';
            var number = $(id_name).val();
            if (number) {
                CallContinue(1);
            } else {
                CallContinue(keyId);
            }
        } else {
            CallContinue(keyId);
        }
    });

    //停止连续拨号
    $('#batch_hangup').click(function () {
        $('.notice_call').html('停止连续拨号');
        $('#stop_continue_call').val(1);
    });

    //回车13 ，空格32
    $(document).keydown(function (e) {
        if (e.keyCode == 13) {
        }
    });

    //选择不同批次号数据
    $('.excel_batch_no_list').change(function () {
        var url = $(this).val();
        var callstatus = getCookie('callstatus');
        if (callstatus === 'iscalling') {
            alert('拨号中，请稍后重试');
            return false;
        }
        if (url) {
            window.location.href = url;
        }
    });
});

function yFlow(keyId) {
    var clientHeight = $('div .sj_nr_nr_bt li').eq(1).height();
    var scrollheight = keyId * clientHeight;
    $('.div_list_body').scrollTop(scrollheight);
}
