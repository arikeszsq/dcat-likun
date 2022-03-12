<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>拓客</title>
    <script src="/static/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
    <link href="/static/web/common/common.css" rel="stylesheet" type="text/css"/>

</head>
<body>
<div class="top_head"><img src="{{$image}}"/></div>
<div class="top_n01 c">请输入您的基本信息</div>
<div class="top_n02 c">请确认您输入的基本信息是真实有效的</div>

<input type="hidden" id="web_id" value="{{$web_id}}">
<input type="hidden" id="master_id" value="{{$master_id}}">

<div class="con_nr c">
    <div class="con_nra c">
        <ul>
            <li>
                <div class="con_nra_l">公司名称：</div>
                <div class="con_nra_r"><input type="text" class="company_name" name="fname" placeholder="请输入您的公司名称"/>
                </div>
                <div class="c"></div>
                <span class="notice"></span>
            </li>

            <li>
                <div class="con_nra_l">您的姓名：</div>
                <div class="con_nra_r"><input type="text" class="username" name="fname" placeholder="请输入您的姓名"/></div>
                <div class="c"></div>
                <span class="notice"></span>
            </li>

            <li>
                <div class="con_nra_l">联系电话：</div>
                <div class="con_nra_r"><input type="text" class="mobile" name="fname" placeholder="请输入您的电话"/></div>
                <div class="c"></div>
                <span class="notice"></span>
            </li>

        </ul>

        <div class="tijiao">
            <button type="button" class="submit">获取额度</button>
        </div>
        <div class="tijiao_a">
            {{--            <div class="yinshi_a"><input type="checkbox" id="checkbox-id" checked class="agree"/></div>--}}
            {{--            <div class="yinshi_b"><span class="agree_txt">我同意</span><a href="#">《隐私政策》</a></div>--}}
            <div class="wxts">
                温馨提示<br/>
                1、获取额度请本人操作并提供真实有效的信息，相关信息将作为您信用评价的重要因素<br/>
                2、贷款资金不能用于购房、投资等金融监管违禁领域<br/>
                3、我行从未委托第三方收取任何费用，贷款申请无中介费<br/>
                4、如遇问题，请联系金城银行企业金融官方客服
            </div>
        </div>
    </div>
</div>

<script>

    $('.submit').click(function () {
        var company_name = $('.company_name').val();
        var user_name = $('.username').val();
        var mobile = $('.mobile').val();
        var error = 0;
        //
        // if ($('#checkbox-id').is(':checked')) {
        // } else {
        //     $('.agree_txt').css("color", "red");
        //     return false;
        // }

        if (!company_name) {
            $(".company_name").parent().parent().find('.notice').html("请输入公司名称！");
            $(".company_name").focus();
            error++;
        } else {
            $(".company_name").parent().parent().find('.notice').html("");
        }
        if (!user_name) {
            $(".username").parent().parent().find('.notice').html("请输入联系人！");
            $(".username").focus();
            error++;
        } else {
            $(".username").parent().parent().find('.notice').html("");
        }
        if (!(/^1[23456789]\d{9}$/.test(mobile))) {
            $(".mobile").parent().parent().find('.notice').html("请输入合法手机号！");
            $(".mobile").focus();
            error++;
        } else {
            $(".mobile").parent().parent().find('.notice').html("");
        }

        if (error > 0) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: '/api/add',
            data: {
                'master_id': $('#master_id').val(),
                'web_id': $('#web_id').val(),
                'company_name': company_name,
                'user_name': user_name,
                'mobile': mobile,
            },
            success: function (res) {
                if (res.msg_code == 100000) {
                    window.location.href = '/result';
                } else {
                    alert(res.message)
                }
            }
        });
    })
</script>
</body>
</html>
