<?php

namespace App\Http\Controllers;

use App\ModelSDM\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Announce;
use View;

class HomeController extends BlankonController
{
    public function __construct()
    {
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/dropzone/downloads/css/dropzone.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jquery.gritter/css/jquery.gritter.css');

        array_push($this->js['plugins'], 'global/plugins/bower_components/masonry/dist/masonry.pkgd.min.js');

        array_push($this->js['scripts'], 'admin/js/pages/blankon.blog.js');
        array_push($this->js['scripts'], 'admin/js/jquery.infinitescroll.js');
        array_push($this->js['scripts'], 'admin/js/custom-infinitescroll.js');
        array_push($this->js['scripts'], 'admin/js/customize.js');

        View::share('css', $this->css);
        View::share('js', $this->js);
        View::share('title', $this->mainTitle);
    }

    public function index()
    {
        $announces = Announce::orderBy('id', 'DESC')->paginate(4);
        foreach ($announces as $announce) {
            $title_overlength = false;
            $content_overlength = false;
            if(strlen($announce->title) > 30) $title_overlength = true;
            if(strlen($announce->content) > 200) $content_overlength = true;
            $announce->title = substr($announce->title, 0, 30);
            if($title_overlength) $announce->title = $announce->title . '...';
            $announce->content = strip_tags($announce->content);
            $announce->content = substr($announce->content, 0, 200);
            if($content_overlength) $announce->content = $announce->content . '...';
        }

        foreach ($announces as $announce)
        {
            $employee = Employee::where('number_of_employee_holding', $announce->created_by)->first();
            if($employee !== null)
            {
                $announce->created_by_name = $employee->full_name;
            }
            else{
                $announce->created_by_name = $announce->created_by;
            }
        }

        return view('home/index', compact('announces'));
    }
}
