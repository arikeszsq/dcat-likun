<script src="/static/timepicker/gijgo.min.js" type="text/javascript"></script>
<link href="/static/timepicker/gijgo.min.css" rel="stylesheet" type="text/css"/>
<link href="/static/timepicker/gijgo.min.css" rel="stylesheet" type="text/css"/>
<link href="/static/timepicker/gijgo.min.css" rel="stylesheet" type="text/css"/>

<style>
    .notice_body {
        margin-top: 5px;
    }

    .shadow {
        padding: 5px;
    }

    .font-weight-bold {
        color: white;
    }
</style>

<div class="content" style="margin-left: 10px;">
    <div class="row">
        <div class="col-md-4 col-xs-12" style="margin-top: 10px;">
            <span>开始时间</span>
            <span style="width: 200px;display: inline-block;">
                <input id="start_date" width="180" class="form-control">
            </span>
        </div>
        <div class="col-md-4 col-xs-12" style="margin-top: 10px;">
            <span>结束时间</span>
            <span style="width: 200px;display: inline-block;">
                <input id="end_date" width="180" class="form-control" style="display: inline-block;">
            </span>
        </div>
        <div class="col-md-4 col-xs-12" style="margin-top: 10px;"><a href="#" class="btn btn-primary search-data">查询</a>
        </div>
    </div>
</div>

<div class="header pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">

            <div class="row">

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+今日拨打电话总数</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 call_total">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+今日拨打电话时长</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 talk_time">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+新增意向客户</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 new_intention">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+未接通电话数</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 no_num">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+接通电话次数</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 get_num">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+有效电话次数</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 valid_num">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 notice_body">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">+有效电话时长</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i><span
                                            class="h2 font-weight-bold mb-0 valid_long">0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 start_search_date"></span>
                                <span class="text-danger end_search_date"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    init();

    function init() {
        searchData();
    }

    function searchData() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/admin/search-data",
            data: {
                'start_date': start_date,
                'end_date': end_date,
            },
            success: function (res) {
                if (res.msg_code === 100000) {
                    var data = res.response;
                    $('.call_total').html(data.call_total);
                    $('.talk_time').html(data.talk_time);
                    $('.new_intention').html(data.new_intention);
                    $('.no_num').html(data.no_num);
                    $('.get_num').html(data.get_num);
                    $('.valid_num').html(data.valid_num);
                    $('.valid_long').html(data.valid_long);
                    $('.start_search_date').html(data.start_date);
                    $('.end_search_date').html(data.end_date);
                } else {
                    alert(res.msg)
                }
            }
        });
    }

    $('.search-data').click(function () {
        searchData();
    });


    $('#start_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        modal: true,
        footer: true
    });
    $('#end_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        modal: true,
        footer: true,
    });
</script>
