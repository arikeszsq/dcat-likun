<?php

namespace App\Admin\Extensions;



use Dcat\Admin\Admin;

class CheckRow
{
    protected $row;
    protected $id;
    protected $mobile;
    protected $table_name;

    public function __construct($row,$table_name)
    {
        $this->row = $row;
        $this->id = $row['id'];
        $this->mobile = $row['mobile'];
        $this->table_name = $table_name;
    }

    protected function script()
    {
        return <<<SCRIPT
        var callout_cb;
        init();

        function init() {
            getWebsocket();
        }

        $('.call_mobile').on('click', function () {
            var id = $(this).data('id');
            let number = $(this).data('mobile');
            var table_name = $(this).data('table_name');
            if (!number) {
                alert('请先选择需要拨打的用户号码');
                return false;
            }
            if (!ws) {
                alert("控件未初始化");
                return false;
            }

            console.log('开始拨号：' + number);
            callout_cb = 'CallOut_cb_' + new Date().getTime();

            ws.send(JSON.stringify({
                action: 'CallOut',
                number: ''+ number,
                cb: callout_cb
            }));

            ws.onmessage = function (event) {
                console.log('check_row_on_message', event.data);
                var data = JSON.parse(event.data);
                var message = data.message;
                var name = data.name;
                var record='';
                if (message == 'update' && name == 'Call') {
                    var param = data.param;
                    console.log(param);
                    if (param.status == 'CallStart') {
                        record=param.time;
                        ajaxRecordSync(id, record, table_name);
                        uploadFile();
                    } else if (param.status == 'CallEnd') {
                        console.log("通话结束/或者挂断事件");
                        var cdr = param.CDR;
                        ajaxSync(id, cdr, table_name);
                    }
                }
            };
            ws.onerror = function () {
                console.log("error");
            }
        });


        function ajaxRecordSync(id, record,table_name) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/admin/add-call-record",
                data: { 'id': id, 'record': record ,'table_name': table_name}
            });
        }

        function ajaxSync(id, cdr,table_name) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/admin/call-back",
                data: { 'id': id, 'cdr': cdr ,'table_name': table_name}
            });
        }

        $('.hang_mobile').on('click', function () {
            ws.send(JSON.stringify({ action: 'Hangup', cb: new Date().getTime() }));
            ws.onmessage = function (event) {
                console.log("hangup_message", event.data);
            };
            ws.onerror = function () {
                console.log("error");
            }
        });

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
SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
//        Admin::js('/static/js/app.js');

        return "<a class='text-success call_mobile' data-id='{$this->id}' data-mobile='{$this->mobile}' data-table_name='{$this->table_name}'>拨号<i class=\"fa fa-phone\" aria-hidden=\"true\"></i></a>&nbsp;
<a class='text-danger hang_mobile' data-mobile='{$this->mobile}'>挂机<i class=\"fa fa-close\" aria-hidden=\"true\"></i></a>";

    }

    public function __toString()
    {
        return $this->render();
    }
}
