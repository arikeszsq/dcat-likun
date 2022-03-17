
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

function verifyMobile(mobile) {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/admin/verify-mobile",
        data: {'mobile': mobile},
        success: function (res) {
            var code = res.msg_code;
            if (code === 100000) {
                $('#verify_mobile_can_call').val(1);
            }
            if (code === 200000) {
                $('#verify_mobile_can_call').val(2);
            }
        },
        error:function (res) {
            console.log(res)
        }
    });
}
