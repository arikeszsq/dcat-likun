<script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
<link rel="stylesheet" href="/static/call/call.css">
<script src="/static/bootstrap/js/bootstrap.min.js"></script>

<script src="/static/call/addintention.js"></script>
<script src="/static/call/call.js"></script>
<script src="/static/call/ajaxfunction.js"></script>
<script src="/static/call/initandupload.js"></script>
<script src="/static/call/hangupcookienext.js"></script>
<script src="/static/call/callcontinue.js"></script>
<script src="/static/call/searchtelstatus.js"></script>

<div class="con_a_w">
    <div class="con_a">
        <div class="con_a_l">
            <div class="sj_nr">
                <div class="sj_nr_bt">待呼叫资源</div>
                <div class="sj_nr_nr">
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
    $('.nb_type').click(function () {
        $(this).addClass('khlb_user_type').siblings().removeClass('khlb_user_type');
    });
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

    //初始化设备
    var callout_cb;
    init();

    //点击右侧列表，把信息传到表单
    $('.user-info').click(function () {
        var company_name = $(this).data('company_name');
        var user_name = $(this).data('user_name');
        var mobile = $(this).data('mobile');
        $('.form-company-name').val(company_name);
        $('.form-user-name').val(user_name);
        $('.form-mobile').val(mobile);

        var excel_user_id = $(this).data('id');
        $('#excel-user_id').val(excel_user_id);
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
        CallContinue(1);
    });

    //停止连续拨号
    $('#batch_hangup').click(function () {
        hangup();
        $('.notice_call').html('已停止连续拨号');
        $('#stop_continue_call').val(1);
    });

    //主动切换下一张卡拨号
    $('#next').click(function () {
        ws.send(JSON.stringify({action: 'SimNext', cb: new Date().getTime()}));
        ws.onmessage = function (event) {
            console.log("message", event.data);
        };
        ws.onerror = function () {
            console.log("error");
        }
    });


</script>

