function addTention() {

    var excel_user_id = $('#excel-user_id').val();


    var select_tag_ids = '0';
    $('.nb_tag').each(function () {
        var select_val = $(this).data('select');
        if (select_val === 1) {
            var id_val = $(this).data('id');
            select_tag_ids += ',' + id_val;
        }
    });

    var company_name = $('.form-company-name').val();
    var user_name = $('.form-user-name').val();
    var mobile = $('.form-mobile').val();
    var source = $('.form-source').val();
    var type = $('.khlb_user_type').data('id');
    var bak = $('.form-bak').val();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/admin/add-intention",
        data: {
            'company_name': company_name,
            'user_name': user_name,
            'mobile': mobile,
            'type': type,
            'source': source,
            'select_tag_ids': select_tag_ids,
            'bak': bak,
            'excel_user_id': excel_user_id,
        },
        success: function (res) {
            if (res.msg_code === 100000) {
                $('.notice_call').html('添加意向客户成功');
                setTimeout(function () {
                    $('.notice_call').html('');
                }, 3000);
            } else {
                $('.notice_call').html('意向客户添加失败');
                setTimeout(function () {
                    $('.notice_call').html('');
                }, 3000);
            }
        }
    });
}
