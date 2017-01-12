<!--
START @SIDEBAR LEFT
           |=========================================================================================================================|
           |  TABLE OF CONTENTS (Apply to sidebar left class)                                                                        |
           |=========================================================================================================================|
           |  01. sidebar-box               |  Variant style sidebar left with box icon                                              |
           |  02. sidebar-rounded           |  Variant style sidebar left with rounded icon                                          |
           |  03. sidebar-circle            |  Variant style sidebar left with circle icon                                           |
           |=========================================================================================================================|

-->
<aside id="sidebar-left" class="{{ $sidebarClass or 'sidebar-circle' }}">

    <!-- Start left navigation - profile shortcut -->
    @if(Auth::user())
        <div class="sidebar-content">
            <div class="media">
                <a class="pull-left has-notif avatar" href="{{url('page/profile')}}">
                    <img src="{{ $user_info->photo }}" alt="admin">
                    <i class="online"></i>
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Selamat datang, <span>{{ $user_info->full_name }}</span></h4>
                    <small>{{ Auth::user()->nidn }}</small>
                </div>
            </div>
        </div><!-- /.sidebar-content -->
@endif
<!--/ End left navigation -  profile shortcut -->

    <!-- Start left navigation - menu -->
    <ul class="sidebar-menu">

        <!-- Start navigation - dashboard -->
        <li {!! Request::is('/', '/') ? 'class="active"' : null !!}>
            <a href="{{url('/')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Beranda</span>
                {!! Request::is('/', '/') ? '<span class="selected"></span>' : null !!}
            </a>
        </li>
        <!--/ End navigation - dashboard -->

        <!-- Start navigation - login -->
        @if(!Auth::user())
            <li {!! Request::is('user', 'user/login') ? 'class="active"' : null !!}>
                <a href="{{url('user/login')}}">
                    <span class="icon"><i class="fa fa-sign-in"></i></span>
                    <span class="text">Masuk</span>
                    {!! Request::is('user', 'user/login') ? '<span class="selected"></span>' : null !!}
                </a>
            </li>
        @endif
    <!--/ End navigation - login -->

        <!-- Start category - Operator -->
        @can('operator-menu')
            <li class="sidebar-category">
                <span>Operator</span>
                <span class="pull-right"><i class="fa fa-suitcase"></i></span>
            </li>

            <!-- Start navigation - Announces -->
            <li {!! Request::is('announces','announces/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-bullhorn"></i></span>
                    <span class="text">Pengumuman</span>
                    <span class="arrow"></span>
                    {!! Request::is('announces', 'announces/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('announces','announces/create')? 'class="active"' : null !!}>
                        <a href="{{url('announces/create')}}">Tambah</a>
                    </li>
                    <li {!! Request::is('announces','announces/list')? 'class="active"' : null !!}>
                        <a href="{{url('announces/')}}">Daftar</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - announces -->

            <!-- Start navigation - Appraisal -->
            <li {!! Request::is('appraisals','appraisals/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-star"></i></span>
                    <span class="text">Aspek Penilaian</span>
                    <span class="arrow"></span>
                    {!! Request::is('appraisals', 'appraisals/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('appraisals','appraisals/create')? 'class="active"' : null !!}>
                        <a href="{{url('appraisals/create')}}">Tambah</a>
                    </li>
                    <li {!! Request::is('appraisals','appraisals/')? 'class="active"' : null !!}>
                        <a href="{{url('appraisals/')}}">Daftar</a>
                    </li>
                </ul>
            </li>
            <!-- End navigation - Appraisal -->

            <!-- Start navigation - Funding Sources -->
            <li {!! Request::is('category-types','category-types/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-money"></i></span>
                    <span class="text">Sumber Dana</span>
                    <span class="arrow"></span>
                    {!! Request::is('category-types', 'category-types/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('category-types','category-types/create')? 'class="active"' : null !!}>
                        <a href="{{url('category-types/create')}}">Tambah</a>
                    </li>
                    <li {!! Request::is('category-types','category-types/list')? 'class="active"' : null !!}>
                        <a href="{{url('category-types/')}}">Daftar</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - Funding Sources -->

            <!-- Start navigation - Dedication Types -->
            <li {!! Request::is('dedication-types','dedication-types/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-file-archive-o"></i></span>
                    <span class="text">Jenis Pengabdian</span>
                    <span class="arrow"></span>
                    {!! Request::is('dedication-types', 'dedication-types/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('dedication-types','dedication-types/create')? 'class="active"' : null !!}>
                        <a href="{{url('dedication-types/create')}}">Tambah</a>
                    </li>
                    <li {!! Request::is('dedication-types','dedication-types/list')? 'class="active"' : null !!}>
                        <a href="{{url('dedication-types/')}}">Daftar</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - Dedication Types -->

            <!-- Start navigation - Period -->
            <li {!! Request::is('periods','periods/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-calendar"></i></span>
                    <span class="text">Periode</span>
                    <span class="arrow"></span>
                    {!! Request::is('periods', 'periods/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('periods','periods/create')? 'class="active"' : null !!}>
                        <a href="{{url('periods/create')}}">Tambah</a>
                    </li>
                    <li {!! Request::is('periods','periods/')? 'class="active"' : null !!}>
                        <a href="{{url('periods/')}}">Daftar</a>
                    </li>
                </ul>
            </li>
            <!-- End navigation - Period -->

            <!-- Start navigation - Reviewer -->
            <li {!! Request::is('reviewers','reviewers/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-balance-scale"></i></span>
                    <span class="text">Reviewer</span>
                    <span class="arrow"></span>
                    {!! Request::is('reviewers', 'reviewers/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('reviewers','reviewers/create')? 'class="active"' : null !!}>
                        <a href="{{url('reviewers/create')}}">Tambah</a>
                    </li>
                    <li {!! Request::is('reviewers','reviewers/')? 'class="active"' : null !!}>
                        <a href="{{url('reviewers/')}}">Daftar</a>
                    </li>
                    <li {!! Request::is('reviewers','reviewers/assign')? 'class="active"' : null !!}>
                        <a href="{{url('reviewers/assign')}}">Penentuan</a>
                    </li>
                </ul>
            </li>
            <!-- End navigation - Reviewer -->

            <!-- Start navigation - Update Usulan -->
            <li {!! Request::is('approve-proposes','approve-proposes/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-check-square-o"></i></span>
                    <span class="text">Approve Usulan</span>
                    <span class="arrow"></span>
                    {!! Request::is('approve-proposes', 'approve-proposes/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('approve-proposes','approve-proposes/')? 'class="active"' : null !!}>
                        <a href="{{url('approve-proposes/')}}">Daftar Usulan</a>
                    </li>
                </ul>
            </li>
            <!-- End navigation - Update Usulan -->

            <!-- Start navigation - Usulan -->
            {{--<li {!! Request::is('proposes','proposes/*')? 'class="submenu active"' : 'class="submenu"' !!}>--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<span class="icon"><i class="fa fa-file-powerpoint-o"></i></span>--}}
                    {{--<span class="text">Usulan</span>--}}
                    {{--<span class="arrow"></span>--}}
                    {{--{!! Request::is('proposes', 'proposes/*') ? '<span class="selected"></span>' : null !!}--}}
                {{--</a>--}}
                {{--<ul>--}}
                    {{--<li {!! Request::is('proposes','proposes/')? 'class="active"' : null !!}>--}}
                        {{--<a href="{{url('proposes/')}}">List</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <!-- End navigation - Usulan -->

            <!-- Start navigation - Dedication -->
            <li {!! Request::is('dedications','dedications/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-black-tie"></i></span>
                    <span class="text">Pengabdian</span>
                    <span class="arrow"></span>
                    {!! Request::is('dedications', 'dedications/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('dedications','dedications/')? 'class="active"' : null !!}>
                        <a href="{{url('dedications/approve-list')}}">Daftar Pengabdian</a>
                    </li>
                </ul>
            </li>
            <!-- End navigation - Dedication -->
        @endcan
    <!-- End category - Operator -->

        <!-- Start category - Lecturer -->
        @can('lecturer-menu')
            <li class="sidebar-category">
                <span>Dosen</span>
                <span class="pull-right"><i class="fa fa-user"></i></span>
            </li>

            <!-- Start navigation - Proposes -->
            <li {!! Request::is('proposes','proposes/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-file-powerpoint-o"></i></span>
                    <span class="text">Usulan</span>
                    <span class="arrow"></span>
                    {!! Request::is('proposes', 'proposes/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('proposes','proposes/create')? 'class="active"' : null !!}>
                        <a href="{{url('proposes/create')}}">Pengajuan</a>
                    </li>
                    <li {!! Request::is('proposes','proposes/')? 'class="active"' : null !!}>
                        <a href="{{url('proposes/')}}">Daftar Pengajuan</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - Proposes -->

            <!-- Start navigation - Dedication -->
            <li {!! Request::is('dedications','dedications/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-black-tie"></i></span>
                    <span class="text">Pengabdian</span>
                    <span class="arrow"></span>
                    {!! Request::is('dedications', 'dedications/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('dedications','dedications/')? 'class="active"' : null !!}>
                        <a href="{{url('dedications/')}}">Daftar Pengabdian</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - Dedication -->
        @endcan
    <!-- End category - Lecturer -->

    <!-- Start category - Reviewer -->
        @can('reviewer-menu')
            <li class="sidebar-category">
                <span>Reviewer</span>
                <span class="pull-right"><i class="fa fa-balance-scale"></i></span>
            </li>

            <!-- Start navigation - Review Proposes -->
            <li {!! Request::is('review-proposes','review-proposes/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-pencil"></i></span>
                    <span class="text">Review</span>
                    <span class="arrow"></span>
                    {!! Request::is('review-proposes', 'review-proposes/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('review-proposes','review-proposes/')? 'class="active"' : null !!}>
                        <a href="{{url('review-proposes/')}}">Usulan</a>
                    </li>
                    <li {!! Request::is('review-proposes','review-proposes/dedication-list')? 'class="active"' : null !!}>
                        <a href="{{url('review-proposes/dedication-list')}}">Pengabdian</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - Review Proposes -->
        @endcan
    <!-- End category - Reviewer -->

        @can('super')
        <!-- Start category - Testing -->
            <li class="sidebar-category">
                <span>Testing</span>
                <span class="pull-right"><i class="fa fa-user"></i></span>
            </li>
            <!-- Start navigation - Proposes -->
            <li {!! Request::is('files','files/*')? 'class="submenu active"' : 'class="submenu"' !!}>
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-file-powerpoint-o"></i></span>
                    <span class="text">Files</span>
                    <span class="arrow"></span>
                    {!! Request::is('files', 'files/*') ? '<span class="selected"></span>' : null !!}
                </a>
                <ul>
                    <li {!! Request::is('files','files/upload')? 'class="active"' : null !!}>
                        <a href="{{url('files/upload')}}">Upload</a>
                    </li>
                </ul>
            </li>
            <!--/ End navigation - Proposes -->

            <!-- End category - Testing -->
        @endcan


    </ul><!-- /.sidebar-menu -->
    <!--/ End left navigation - menu -->

    <!-- Start left navigation - footer -->
    <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
        {{--<a id="setting" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting"><i class="fa fa-cog"></i></a>--}}
        <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
           data-title="Fullscreen"><i class="fa fa-desktop"></i></a>
        {{--<a id="lock-screen" data-url="lock-screen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen"><i class="fa fa-lock"></i></a>--}}
        {{--<a id="logout" data-url="signin" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fa fa-power-off"></i></a>--}}
    </div><!-- /.sidebar-footer -->
    <!--/ End left navigation - footer -->

</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->
