@extends('layouts.admin') 
@section('content')
    @include('inc.msg')
<!-- Counts Section -->
<section class="dashboard-counts section-padding">
    <div class="container-fluid">
        <div class="row">
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="name"><strong class="text-uppercase">New Clients</strong><span>
                        <select class="form-control-sm" name="search_clients" id="search_clients">
                            <option disabled >Select options</option>
                            <option value="1" selected>Last 1 day</option>
                            <option value="2">Last 2 days</option>
                            <option value="3">Last 3 days</option>
                            <option value="4">Last 4 days</option>
                            <option value="5">Last 5 days</option>
                            <option value="6">Last 6 days</option>
                            <option value="7">Last 7 days</option>
                            <option value="15">Last 15 days</option>
                            <option value="1m">Last 1 month</option>
                            <option value="6m">Last 6 months</option>
                            <option value="1y">Last 1 year</option>
                        </select>
                    </span>
                        <div class="count-number" id="total-clients"></div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-check"></i></div>
                    <div class="name"><strong class="text-uppercase">New Blogs</strong><span>
                        <select class="form-control-sm" name="search_blogs" id="search_blogs">
                            <option disabled >Select options</option>
                            <option value="1" selected>Last 1 day</option>
                            <option value="2">Last 2 days</option>
                            <option value="3">Last 3 days</option>
                            <option value="4">Last 4 days</option>
                            <option value="5">Last 5 days</option>
                            <option value="6">Last 6 days</option>
                            <option value="7">Last 7 days</option>
                            <option value="15">Last 15 days</option>
                            <option value="1m">Last 1 month</option>
                            <option value="6m">Last 6 months</option>
                            <option value="1y">Last 1 year</option>
                        </select>
                    </span>
                        <div class="count-number" id="total-blogs"></div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Work Orders</strong><span>Last 5 days</span>
                        <div class="count-number">400</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-bill"></i></div>
                    <div class="name"><strong class="text-uppercase">New Invoices</strong><span>Last 2 days</span>
                        <div class="count-number">123</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-list"></i></div>
                    <div class="name"><strong class="text-uppercase">Open Cases</strong><span>Last 3 months</span>
                        <div class="count-number">92</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-list-1"></i></div>
                    <div class="name"><strong class="text-uppercase">New Cases</strong><span>Last 7 days</span>
                        <div class="count-number">70</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Counts Section Ends -->
<!-- Header Section-->
<section class="dashboard-header section-padding">
    <div class="container-fluid">
        <div class="row d-flex align-items-md-stretch">
            <!-- Pie Chart-->
            <div class="col-lg-6 col-md-12">
                <div class="card project-progress">
                    <h2 class="display h4">Number of users</h2>
                    <div class="pie-chart">
                        <canvas id="pieChart-users" width="300" height="300"> </canvas>
                    </div>
                </div>
            </div>
            <!-- Line Chart -->
            <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
                <div class="card sales-report">
                    <h2 class="display h4">Blogs per day</h2>
                    <div class="line-chart">
                        <canvas id="blogPerDay"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        function fetch_new_clients(query='1') { 
            $.ajax({
                type: "GET",
                url: "{{route('admin.getNewClients')}}",
                data: {query:query},
                dataType: "json",
                success: function (response) {
                    $('#total-clients').html(response.total_data);
                }
            });
        }
        function fetch_new_blogs(query='1') { 
            $.ajax({
                type: "GET",
                url: "{{route('admin.getNewBlogs')}}",
                data: {query:query},
                dataType: "json",
                success: function (response) {
                    $('#total-blogs').html(response.total_data);
                }
            });
        }

        function fetch_UserCount() { 
            $.ajax({
                type: "GET",
                url: "{{route('admin.getUserCount')}}",
                data: {query:''},
                dataType: "json",
                success: function (response) {
                    var brandPrimary = "#FFCE56";
                    var PIECHARTEXMPLE = $("#pieChart-users");
                    var pieChartExample = new Chart(PIECHARTEXMPLE, {
                        type: "doughnut",
                        data: {
                            labels: ["ADMIN", "USER"],
                            datasets: [
                                {
                                    data: [response.admin,response.user],
                                    borderWidth: [1, 1],
                                    backgroundColor: [
                                        brandPrimary,
                                        "rgba(75,192,192,1)"
                                    ],
                                    hoverBackgroundColor: [
                                        brandPrimary,
                                        "rgba(75,192,192,1)"
                                    ]
                                }
                            ]
                        }
                    });
                }
            });
        }
        function fetch_BlogsPerDay() { 
            $.ajax({
                type: "GET",
                url: "{{route('admin.getPerDay')}}",
                data: {query:''},
                dataType: "json",
                success: function (response) {
                    console.log(response.weekdays);
                    var brandPrimary = "#33b35a";
                    var LINECHART = $("#blogPerDay");
                    var myLineChart = new Chart(LINECHART, {
                        type: "line",
                        options: {
                            legend: {
                                display: true
                            }
                        },
                        data: {
                            labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                            datasets: [{
                                    label: "Number of Users",
                                    fill: true,
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(77, 193, 75, 0.4)",
                                    borderColor: brandPrimary,
                                    borderCapStyle: "butt",
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: "miter",
                                    borderWidth: 2,
                                    pointBorderColor: 'rgba(0,0,255,1)',
                                    pointBackgroundColor: "#fff",
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: brandPrimary,
                                    pointHoverBorderColor: "rgba(220,220,220,1)",
                                    pointHoverBorderWidth: 2,
                                    pointRadius: 1,
                                    pointHitRadius: 0,
                                    data: [response.usersPerDay['Sun'], response.usersPerDay['Mon'], response.usersPerDay['Tue'], response.usersPerDay['Wed'], response.usersPerDay['Thu'], response.usersPerDay['Fri'], response.usersPerDay['Sat']],
                                    spanGaps: false
                                },
                                {
                                    label: "Number of Blogs",
                                    fill: true,
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(75,192,192,0.4)",
                                    borderColor: "rgba(75,192,192,1)",
                                    borderCapStyle: "butt",
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: "miter",
                                    borderWidth: 2,
                                    pointBorderColor: "rgba(255,0,0,1)",
                                    pointBackgroundColor: "#fff",
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                    pointHoverBorderColor: "rgba(220,220,220,1)",
                                    pointHoverBorderWidth: 2,
                                    pointRadius: 1,
                                    pointHitRadius: 10,
                                    data: [response.blogsPerDay['Sun'], response.blogsPerDay['Mon'], response.blogsPerDay['Tue'], response.blogsPerDay['Wed'], response.blogsPerDay['Thu'], response.blogsPerDay['Fri'], response.blogsPerDay['Sat']],
                                    spanGaps: false
                                }
                            ]
                        }
                    });
                    //line chart ends
                }
            });
        }

        fetch_new_clients();
        fetch_new_blogs();
        fetch_UserCount();
        fetch_BlogsPerDay();

        $('#search_clients').on('change', function () {
            console.log($(this).val());
            var query = $(this).val();
            fetch_new_clients(query);
        });
        $('#search_blogs').on('change', function () {
            console.log($(this).val());
            var query = $(this).val();
            fetch_new_blogs(query);
        });

    });

</script>
@endsection