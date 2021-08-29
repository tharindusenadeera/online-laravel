<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('assets/img/avatar5.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Management </li>


            <li @if (\Request::is('users')) class="active" @endif><a href="{{ url('users') }}"><i class="fa fa-users"></i><span>Users</span></a></li>

            <li @if (\Request::is('menu-item') || \Request::is('menu-option') || \Request::is('menu-option-category') || \Request::is('category')) class=" active treeview" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-cutlery"></i> <span>Menu</span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li @if (\Request::is('menu-item')) class="active" @endif><a href="{{ url('menu-item') }}"><i class="fa fa-circle-o"></i>Menu Item</a>
                    </li>

                    <li @if (\Request::is('menu-option')) class="active" @endif><a href="{{ url('menu-option') }}"><i class="fa fa-circle-o"></i>Menu
                            Option</a></li>

                    <li @if (\Request::is('menu-option-category')) class="active" @endif><a
                            href="{{ url('menu-option-category') }}"><i class="fa fa-circle-o"></i>Menu Option
                            category</a></li>

                    <li @if (\Request::is('category')) class="active" @endif><a href="{{ url('category') }}"><i class="fa fa-circle-o"></i>Menu
                            Category</a>
                    </li>

                </ul>
            </li>

            <li @if (\Request::is('city')) class="active" @endif><a href="{{ url('city') }}"><i class="fa fa-map-marker"></i><span>City</span></a></li>
            <li @if (\Request::is('addon')) class="active" @endif><a href="{{ url('addon') }}"><i class="fa fa-map-marker"></i><span>Add-Ons</span></a></li>

            <li @if (\Request::is('kitchen') || \Request::is('kitchen/orders/placed') || \Request::is('kitchen/orders/prepared') || \Request::is('kitchen/orders/draft')) class=" active treeview" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-cutlery"></i> <span>Kitchen</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li @if (\Request::is('kitchen')) class="active" @endif><a href="{{ url('kitchen') }}"><i class="fa fa-circle-o"></i>Kitchen</a></li>
                    <li @if (\Request::is('kitchen/orders/placed')) class="active" @endif><a href="{{ url('kitchen/orders/placed') }}"><i class="fa fa-list-alt"></i> Placed Orders</a></li>
                    <li @if (\Request::is('kitchen/orders/prepared')) class="active" @endif><a href="{{ url('kitchen/orders/prepared') }}"><i class="fa fa-check-square-o"></i> Prepared Orders</a></li>
                    <li @if (\Request::is('kitchen/orders/draft')) class="active" @endif><a href="{{ url('kitchen/orders/draft') }}"><i class="fa fa-pencil-square-o"></i> Draft Orders</a></li>

                </ul>
            </li>

            <li @if (\Request::is('report/daily-order-summary')) class=" active treeview" @else class="treeview" @endif>
                <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>Reports</span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li @if (\Request::is('report/daily-order-summary')) class="active" @endif><a href="{{ url('report/daily-order-summary') }}"><i class="fa fa-circle-o"></i>Daily Order
                    Summary</a></li>

                </ul>
            </li>

            <li class="header">Add-Ons </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<div class="control-sidebar-bg"></div>
