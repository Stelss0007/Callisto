

<div class="row">
    <div class="col-sm-3">

        <div class="tile-stats tile-red">
            <div class="icon"><i class="entypo-users"></i></div>
            <div class="num" data-start="0" data-end="83" data-postfix="" data-duration="1500" data-delay="0">0</div>

            <h3>Registered users</h3>
            <p>so far in our blog, and our website.</p>
        </div>

    </div>

    <div class="col-sm-3">

        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div class="num" data-start="0" data-end="135" data-postfix="" data-duration="1500" data-delay="600">0</div>

            <h3>Daily Visitors</h3>
            <p>this is the average value.</p>
        </div>

    </div>

    <div class="col-sm-3">

        <div class="tile-stats tile-aqua">
            <div class="icon"><i class="entypo-mail"></i></div>
            <div class="num" data-start="0" data-end="23" data-postfix="" data-duration="1500" data-delay="1200">0</div>

            <h3>New Messages</h3>
            <p>messages per day.</p>
        </div>

    </div>

    <div class="col-sm-3">

        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-rss"></i></div>
            <div class="num" data-start="0" data-end="52" data-postfix="" data-duration="1500" data-delay="1800">0</div>

            <h3>Subscribers</h3>
            <p>on our site right now.</p>
        </div>

    </div>
</div>

<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well">
            <h2><i class="icon-history"></i> Cache</h2>
        </div>
        <div class="box-content">
            <h1>Cache <small>{#cache_description#}</small></h1>
            <p>
                <b>Vars:</b> {$cache_size.cache_var_size|size_format}<br>
                <b>Templates:</b> {$cache_size.cache_tpl_size|size_format}<br>
                <b>Compilation:</b> {$cache_size.cache_cpl_size|size_format}<br>
                <b>{#cache_all#}:</b> {$cache_size.cache_all|size_format}<br>
            </p>
            <p class="left">
                <a href="/admin/main/clear_cache/all" class="btn btn-large btn-primary">
                    <i class="icon-eraser icon-white"></i> {#sys_delete_all#}
                </a> 
                <a href="/admin/main/clear_cache/vars" class="btn btn-large">
                    <i class="icon-eraser"></i> {#sys_delete_all_vars#}
                </a>
                <a href="/admin/main/clear_cache/templates" class="btn btn-large">
                    <i class="icon-eraser"></i> {#sys_delete_all_templates#}
                </a>
                <a href="/admin/main/clear_cache/compiles" class="btn btn-large">
                    <i class="icon-eraser"></i> {#sys_delete_all_compile#}
                </a>
            </p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<br />

<div class="row">
    <div class="col-sm-8">

        <div class="panel panel-primary" id="charts_env">

            <div class="panel-heading">
                <div class="panel-title">Site Stats</div>

                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#area-chart" data-toggle="tab">Area Chart</a></li>
                        <li class="active"><a href="#line-chart" data-toggle="tab">Line Charts</a></li>
                        <li class=""><a href="#pie-chart" data-toggle="tab">Pie Chart</a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">

                <div class="tab-content">

                    <div class="tab-pane" id="area-chart">							
                        <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
                    </div>

                    <div class="tab-pane active" id="line-chart">
                        <div id="line-chart-demo" class="morrischart" style="height: 300px"></div>
                    </div>

                    <div class="tab-pane" id="pie-chart">
                        <div id="donut-chart-demo" class="morrischart" style="height: 300px;"></div>
                    </div>

                </div>

            </div>

            <table class="table table-bordered table-responsive">

                <thead>
                    <tr>
                        <th width="50%" class="col-padding-1">
                <div class="pull-left">
                    <div class="h4 no-margin">Pageviews</div>
                    <small>54,127</small>
                </div>
                <span class="pull-right pageviews">4,3,5,4,5,6,5</span>

                </th>
                <th width="50%" class="col-padding-1">
                <div class="pull-left">
                    <div class="h4 no-margin">Unique Visitors</div>
                    <small>25,127</small>
                </div>
                <span class="pull-right uniquevisitors">2,3,5,4,3,4,5</span>
                </th>
                </tr>
                </thead>

            </table>

        </div>	

    </div>

    <div class="col-sm-4">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        Real Time Stats
                        <br />
                        <small>current server uptime</small>
                    </h4>
                </div>

                <div class="panel-options">
                    <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                    <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div id="rickshaw-chart-demo">
                    <div id="rickshaw-legend"></div>
                </div>
            </div>
        </div>

    </div>
</div>


<br />

<div class="row">

    <div class="col-sm-4">

        <div class="panel panel-primary">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="padding-bottom-none text-center">
                            <br />
                            <br />
                            <span class="monthly-sales"></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="panel-heading">
                            <h4>Monthly Sales</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="col-sm-8">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Latest Updated Profiles</div>

                <div class="panel-options">
                    <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                    <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                </div>
            </div>

            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Activity</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Art Ramadani</td>
                        <td>CEO</td>
                        <td class="text-center"><span class="inlinebar">4,3,5,4,5,6</span></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Filan Fisteku</td>
                        <td>Member</td>
                        <td class="text-center"><span class="inlinebar-2">1,3,4,5,3,5</span></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Arlind Nushi</td>
                        <td>Co-founder</td>
                        <td class="text-center"><span class="inlinebar-3">5,3,2,5,4,5</span></td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

<br />




<div class="row">

    <div class="col-sm-3">
        <div class="tile-block" id="todo_tasks">

            <div class="tile-header">
                <i class="entypo-list"></i>

                <a href="#">
                    Tasks
                    <span>To do list, tick one.</span>
                </a>
            </div>

            <div class="tile-content">

                <input type="text" class="form-control" placeholder="Add Task" />


                <ul class="todo-list">
                    <li>
                        <div class="checkbox checkbox-replace color-white">
                            <input type="checkbox" />
                            <label>Website Design</label>
                        </div>
                    </li>

                    <li>
                        <div class="checkbox checkbox-replace color-white">
                            <input type="checkbox" id="task-2" checked />
                            <label>Slicing</label>
                        </div>
                    </li>

                    <li>
                        <div class="checkbox checkbox-replace color-white">
                            <input type="checkbox" id="task-3" />
                            <label>WordPress Integration</label>
                        </div>
                    </li>

                    <li>
                        <div class="checkbox checkbox-replace color-white">
                            <input type="checkbox" id="task-4" />
                            <label>SEO Optimize</label>
                        </div>
                    </li>

                    <li>
                        <div class="checkbox checkbox-replace color-white">
                            <input type="checkbox" id="task-5" checked="" />
                            <label>Minify &amp; Compress</label>
                        </div>
                    </li>
                </ul>

            </div>

            <div class="tile-footer">
                <a href="#">View all tasks</a>
            </div>

        </div>
    </div>

    <div class="col-sm-9">



        <div class="tile-group">

            <div class="tile-left">
                <div class="tile-entry">
                    <h3>Map</h3>
                    <span>top visitors location</span>
                </div>

                <div class="tile-entry">
                    <img src="/themes/admin/images/sample-al.png" alt="" class="pull-right op" />

                    <h4>Albania</h4>
                    <span>25%</span>
                </div>

                <div class="tile-entry">
                    <img src="/themes/admin/images/sample-it.png" alt="" class="pull-right op" />

                    <h4>Italy</h4>
                    <span>18%</span>
                </div>

                <div class="tile-entry">
                    <img src="/themes/admin/images/sample-au.png" alt="" class="pull-right op" />

                    <h4>Austria</h4>
                    <span>15%</span>
                </div>
            </div>

            <div class="tile-right">

                <div id="map-2" class="map"></div>

            </div>

        </div>

    </div>

</div>

<script src="/themes/admin/js/jquery.sparkline.min.js"></script>
<script src="/themes/admin/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/themes/admin/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="/themes/admin/js/rickshaw/vendor/d3.v3.js"></script>
<script src="/themes/admin/js/rickshaw/rickshaw.min.js"></script>
<script src="/themes/admin/js/raphael-min.js"></script>
<script src="/themes/admin/js/morris.min.js"></script>
<script src="/themes/admin/js/toastr.js"></script>
{appJsLoad modname=main}