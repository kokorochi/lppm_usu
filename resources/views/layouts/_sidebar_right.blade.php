<!-- START @SIDEBAR RIGHT -->
<aside id="sidebar-right">

    <div class="panel panel-tab">
        <div class="panel-heading no-padding">
            <div class="pull-right">
                <ul class="nav nav-tabs">
                    {{--<li>--}}
                        {{--<a href="#sidebar-profile" data-toggle="tab">--}}
                            {{--<i class="fa fa-user"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#sidebar-layout" data-toggle="tab">--}}
                            {{--<i class="fa fa-cogs"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li class="active">
                        <a href="#sidebar-setting" data-toggle="tab">
                            <i class="fa fa-paint-brush"></i>
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="#sidebar-chat" data-toggle="tab">--}}
                            {{--<i class="fa fa-comments"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body no-padding">
            <div class="tab-content">

                {{--<div class="tab-pane" id="sidebar-layout">--}}
                    {{--<div class="sidebar-layout">--}}

                        {{--<!-- Start right navigation - menu -->--}}
                        {{--<ul class="sidebar-menu niceScroll">--}}

                            {{--<!--/ Start navigation - reset settings -->--}}
                            {{--<li>--}}
                                {{--<a id="reset-setting" href="javascript:void(0);" class="btn btn-inverse btn-block"><i class="fa fa-refresh fa-spin"></i> RESET SETTINGS</a>--}}
                            {{--</li>--}}
                            {{--<!--/ End navigation - reset settings -->--}}

                            {{--<!-- Start category layout -->--}}
                            {{--<li class="sidebar-category">--}}
                                {{--<span>LAYOUT</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-toggle-on"></i></span>--}}
                            {{--</li>--}}
                            {{--<!--/ End category layout -->--}}

                            {{--<!--/ Start navigation - layout -->--}}
                            {{--<li>--}}
                                {{--<ul class="list-unstyled layout-setting">--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="layout-fluid" type="radio" name="layout" value="">--}}
                                            {{--<label for="layout-fluid">Fluid</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="layout-boxed" type="radio" name="layout" value="page-boxed">--}}
                                            {{--<label for="layout-boxed">Boxed</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<!--/ End navigation - layout -->--}}

                            {{--<!-- Start category header -->--}}
                            {{--<li class="sidebar-category">--}}
                                {{--<span>HEADER</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-toggle-on"></i></span>--}}
                            {{--</li>--}}
                            {{--<!--/ End category header -->--}}

                            {{--<!--/ Start navigation - header -->--}}
                            {{--<li>--}}
                                {{--<ul class="list-unstyled header-layout-setting">--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="header-default" type="radio" name="header" value="">--}}
                                            {{--<label for="header-default">Default</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="header-fixed" type="radio" name="header" value="page-header-fixed">--}}
                                            {{--<label for="header-fixed">Fixed</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<!--/ End navigation - header -->--}}

                            {{--<!-- Start category sidebar -->--}}
                            {{--<li class="sidebar-category">--}}
                                {{--<span>SIDEBAR</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-toggle-on"></i></span>--}}
                            {{--</li>--}}
                            {{--<!--/ End category sidebar -->--}}

                            {{--<!--/ Start navigation - sidebar -->--}}
                            {{--<li>--}}
                                {{--<ul class="list-unstyled sidebar-layout-setting">--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="sidebar-default" type="radio" name="sidebar" value="">--}}
                                            {{--<label for="sidebar-default">Default</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="sidebar-fixed" type="radio" name="sidebar" value="page-sidebar-fixed">--}}
                                            {{--<label for="sidebar-fixed">Fixed</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<!--/ End navigation - sidebar -->--}}

                            {{--<!-- Start category sidebar type -->--}}
                            {{--<li class="sidebar-category">--}}
                                {{--<span>SIDEBAR TYPE</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-toggle-on"></i></span>--}}
                            {{--</li>--}}
                            {{--<!--/ End category sidebar type -->--}}

                            {{--<!--/ Start navigation - sidebar -->--}}
                            {{--<li>--}}
                                {{--<ul class="list-unstyled sidebar-type-setting">--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="sidebar-type-default" type="radio" name="sidebarType" value="">--}}
                                            {{--<label for="sidebar-type-default">Default</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="sidebar-type-box" type="radio" name="sidebarType" value="sidebar-box">--}}
                                            {{--<label for="sidebar-type-box">Box</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="sidebar-type-rounded" type="radio" name="sidebarType" value="sidebar-rounded">--}}
                                            {{--<label for="sidebar-type-rounded">Rounded</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="sidebar-type-circle" type="radio" name="sidebarType" value="sidebar-circle">--}}
                                            {{--<label for="sidebar-type-circle">Circle</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<!--/ End navigation - sidebar -->--}}

                            {{--<!-- Start category footer -->--}}
                            {{--<li class="sidebar-category">--}}
                                {{--<span>FOOTER</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-toggle-on"></i></span>--}}
                            {{--</li>--}}
                            {{--<!--/ End category footer -->--}}

                            {{--<!--/ Start navigation - footer -->--}}
                            {{--<li>--}}
                                {{--<ul class="list-unstyled footer-layout-setting">--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="footer-default" type="radio" name="footer" value="">--}}
                                            {{--<label for="footer-default">Default</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="rdio rdio-theme">--}}
                                            {{--<input id="footer-fixed" type="radio" name="footer" value="page-footer-fixed">--}}
                                            {{--<label for="footer-fixed">Fixed</label>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<!--/ End navigation - footer -->--}}

                        {{--</ul>--}}
                        {{--<!-- Start right navigation - menu -->--}}
                    {{--</div>--}}
                {{--</div><!-- /#sidebar-layout -->--}}
                <div class="tab-pane in active" id="sidebar-setting">
                    <div class="sidebar-setting">
                        <!-- Start right navigation - menu -->
                        <ul class="sidebar-menu">

                            <!-- Start category color schemes -->
                            <li class="sidebar-category">
                                <span>COLOR SCHEMES</span>
                                <span class="pull-right"><i class="fa fa-tint"></i></span>
                            </li>
                            <!--/ End category color schemes -->

                            <!-- Start navigation - themes -->
                            <li>
                                <div class="sidebar-themes color-schemes">

                                    <a class="theme" href="javascript:void(0);" style="background-color: #81b71a" data-toggle="tooltip" data-placement="right" data-original-title="Default"><span class="hide">default</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #00B1E1" data-toggle="tooltip" data-placement="top" data-original-title="Blue"><span class="hide">blue</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #37BC9B" data-toggle="tooltip" data-placement="top" data-original-title="Cyan"><span class="hide">cyan</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #8CC152" data-toggle="tooltip" data-placement="top" data-original-title="Green"><span class="hide">green</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #E9573F" data-toggle="tooltip" data-placement="top" data-original-title="Red"><span class="hide">red</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #F6BB42" data-toggle="tooltip" data-placement="top" data-original-title="Yellow"><span class="hide">yellow</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #906094" data-toggle="tooltip" data-placement="top" data-original-title="Purple"><span class="hide">purple</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #D39174" data-toggle="tooltip" data-placement="top" data-original-title="Brown"><span class="hide">brown</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #9FB478" data-toggle="tooltip" data-placement="left" data-original-title="Green Army"><span class="hide">green-army</span></a>

                                    <a class="theme" href="javascript:void(0);" style="background-color: #63D3E9" data-toggle="tooltip" data-placement="right" data-original-title="Blue Sea"><span class="hide">blue-sea</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #5577B4" data-toggle="tooltip" data-placement="top" data-original-title="Blue Gray"><span class="hide">blue-gray</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #AF86B9" data-toggle="tooltip" data-placement="top" data-original-title="Purple Gray"><span class="hide">purple-gray</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #CC6788" data-toggle="tooltip" data-placement="top" data-original-title="Purple Wine"><span class="hide">purple-wine</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #F06F6F" data-toggle="tooltip" data-placement="top" data-original-title="Alizarin Crimson"><span class="hide">alizarin-crimson</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #979797" data-toggle="tooltip" data-placement="top" data-original-title="Black And White"><span class="hide">black-and-white</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #8BC4B9" data-toggle="tooltip" data-placement="top" data-original-title="Amazon"><span class="hide">amazon</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #B0B069" data-toggle="tooltip" data-placement="top" data-original-title="Amber"><span class="hide">amber</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #A9C784" data-toggle="tooltip" data-placement="left" data-original-title="Android green"><span class="hide">android-green</span></a>

                                    <a class="theme" href="javascript:void(0);" style="background-color: #B3998A" data-toggle="tooltip" data-placement="right" data-original-title="Antique brass"><span class="hide">antique-brass</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #8D8D6E" data-toggle="tooltip" data-placement="top" data-original-title="Antique Bronze"><span class="hide">antique-bronze</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #B0B69D" data-toggle="tooltip" data-placement="top" data-original-title="Artichoke"><span class="hide">artichoke</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #F19B69" data-toggle="tooltip" data-placement="top" data-original-title="Atomic Tangerine"><span class="hide">atomic-tangerine</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #98777B" data-toggle="tooltip" data-placement="top" data-original-title="Bazaar"><span class="hide">bazaar</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #C3A961" data-toggle="tooltip" data-placement="top" data-original-title="Bistre Brown"><span class="hide">bistre-brown</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #D6725E" data-toggle="tooltip" data-placement="top" data-original-title="Bittersweet"><span class="hide">bittersweet</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #7789D1" data-toggle="tooltip" data-placement="top" data-original-title="Blueberry"><span class="hide">blueberry</span></a>
                                    <a class="theme" href="javascript:void(0);" style="background-color: #6FA362" data-toggle="tooltip" data-placement="left" data-original-title="Bud Green"><span class="hide">bud-green</span></a>

                                </div>
                            </li>
                            <!--/ End navigation - themes -->

                            <!-- Start category navbar color -->
                            <li class="sidebar-category">
                                <span>NAVBAR COLOR</span>
                                <span class="pull-right"><i class="fa fa-tint"></i></span>
                            </li>
                            <!--/ End category navbar color -->

                            <!-- Start navigation - navbar color -->
                            <li>
                                <div class="sidebar-themes navbar-color">

                                    <a class="theme bg-dark" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Dark"><span class="hide">dark</span></a>
                                    <a class="theme bg-light" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Light"><span class="hide">light</span></a>
                                    <a class="theme bg-primary" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Primary"><span class="hide">primary</span></a>
                                    <a class="theme bg-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Success"><span class="hide">success</span></a>
                                    <a class="theme bg-info" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Info"><span class="hide">info</span></a>
                                    <a class="theme bg-warning" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Warning"><span class="hide">warning</span></a>
                                    <a class="theme bg-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>

                                </div><!-- /.navbar-color -->
                            </li>
                            <!--/ End navigation - navbar color -->

                            <!-- Start category sidebar color -->
                            <li class="sidebar-category">
                                <span>SIDEBAR COLOR</span>
                                <span class="pull-right"><i class="fa fa-tint"></i></span>
                            </li>
                            <!--/ End category sidebar color -->

                            <!-- Start navigation - sidebar color -->
                            <li>
                                <div class="sidebar-themes sidebar-color">

                                    <a class="theme bg-dark" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Dark"><span class="hide">dark</span></a>
                                    <a class="theme bg-light" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Light"><span class="hide">light</span></a>
                                    <a class="theme bg-primary" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Primary"><span class="hide">primary</span></a>
                                    <a class="theme bg-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Success"><span class="hide">success</span></a>
                                    <a class="theme bg-info" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Info"><span class="hide">info</span></a>
                                    <a class="theme bg-warning" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Warning"><span class="hide">warning</span></a>
                                    <a class="theme bg-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>

                                </div><!-- /.sidebar-color -->
                            </li>
                            <!--/ End navigation - sidebar color -->

                        </ul>
                        <!-- Start right navigation - menu -->
                    </div>
                </div><!-- /#sidebar-setting -->
            </div>
        </div>
    </div>

</aside><!-- /#sidebar-right -->
<!--/ END SIDEBAR RIGHT -->
