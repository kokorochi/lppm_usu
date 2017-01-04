<?php

namespace App\Http\Controllers;

use App\ModelSDM\Lecturer;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\File\File;
use View;
use Illuminate\Support\Facades\Storage;

class TestingController extends BlankonController {
    public function __construct()
    {
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/summernote/dist/summernote.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.min.css');

        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/holderjs/holder.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-maxlength/bootstrap-maxlength.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jquery-autosize/jquery.autosize.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js');

        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.wysiwyg.js');
//        array_push($this->js['scripts'], 'code.jquery.com/jquery-1.11.2.min.js');
        array_push($this->js['scripts'], 'admin/js/customize.js');
        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.element.js');
    }

    public function index()
    {
//        return (public_path('images'));
//        $path = public_path('images\upload\testing');
//        $visibility = Storage::getVisibility('images/1.jpg');

//        return $visibility;
//        $file = File::
//        response()->download($file);

//        return response()::file('1.jpg');

//        return response()->download($path, '1.jpg', ['Content-Type' => 'image/jpg']);
    }

    public function upload()
    {
        View::share('css', $this->css);
        View::share('js', $this->js);
        View::share('title', 'Upload Files');
        View::share('assetUrl', $this->assetUrl);

        return view('testing.file-upload');
    }

    public function storeUpload(Request $request)
    {
//        $imageName = '1' . '.' .
//            $request->file('image')->getClientOriginalExtension();
//
//        $request->file('image')->move(
//            public_path('images\upload\testing') , $imageName
//        );

//        $path = $request->file('image')->storeAs('images', $imageName);

        $visibility = Storage::getVisibility('images/1.jpg');

        $path = Storage::url('images/');

        $path = storage_path() . '/app/images/1.jpg';
//        return $path;

        $content = Storage::get('images/1.jpg');

//        return $content;

        return response()->download($path, '1.jpg', ['Content-Type' => 'image/jpg']);

    }

    public function initiateLecturer()
    {
        $lecturers = Lecturer::all();
        $clone_lecturers = new Collection();
        foreach ($lecturers as $lecturer)
        {
            if($lecturer->employee_card_serial_number !== null && $lecturer->employee_card_serial_number !== '')
            {
                $clone_lecturer = new User();
                $clone_lecturer->nidn = $lecturer->employee_card_serial_number;
                $clone_lecturer->password = $lecturer->password;
                $clone_lecturers->add($clone_lecturer);
            }
        }
        $clone_lecturers->unique('nidn');
        foreach ($clone_lecturers as $clone_lecturer)
        {
            $user = User::where('nidn', $clone_lecturer->nidn)->first();
            if($user === null)
            {
                $user = new User();
                $user->nidn = $clone_lecturer->nidn;
                $user->password = $clone_lecturer->password;
                $user->save();
            }
        }
    }
}
