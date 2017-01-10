<?php

namespace App\Http\Controllers;

use App\ModelSDM\Employee;
use App\ModelSDM\Lecturer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Announce;
use Illuminate\Support\Facades\File;
use View;

class AnnouncesController extends BlankonController {
    private $pageTitle = 'Pengumuman';
    protected $deleteQuestion = 'Apakah anda yakin untuk menghapus Pengumuman ini?';
    protected $deleteUrl = 'announces';

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'showSingleList']);
        $this->middleware('isOperator', ['except' => 'showSingleList']);
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/animate.css/animate.min.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/summernote/dist/summernote.css');
        array_push($this->css['pages'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css');

        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/summernote/dist/summernote.min.js');
        array_push($this->js['plugins'], 'global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js');

        array_push($this->js['scripts'], 'admin/js/pages/blankon.form.wysiwyg.js');
        array_push($this->js['scripts'], 'admin/js/customize.js');

        View::share('css', $this->css);
        View::share('js', $this->js);
        View::share('title', $this->pageTitle . ' | ' . $this->mainTitle);
        View::share('pageTitle', $this->pageTitle);
        View::share('deleteQuestion', $this->deleteQuestion);
        View::share('deleteUrl', $this->deleteUrl);
    }

    public function index()
    {
        $announces = Announce::paginate(10);

        $i = 1;
        foreach ($announces as $announce)
        {
            $announce->no = $i;
            $announce->title = substr($announce->title, 0, 40);
            $announce->content = substr(strip_tags($announce->content), 0, 100);
            $i = $i + 1;
        }

        return view('announce/announce-list', compact('announces'));
    }

    public function create()
    {
        $announce = new Announce();
        $form_action = url('announces/create');
        $upd_mode = 'create';
        return view('announce/announce-detail', compact(
            'announce',
            'form_action',
            'upd_mode'
        ));
    }

    public function edit($id)
    {
        $announce = Announce::find($id);
        if($announce === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $form_action = url('announces/' . $announce->id . '/edit');
        $upd_mode = 'edit';
        return view('announce/announce-detail', compact(
            'announce',
            'form_action',
            'upd_mode'
        ));
    }

    public function showSingleList($id)
    {
        $announce = Announce::find($id);
        if (empty($announce))
        {
            $this->setCSS404();

            return abort(404);
        }
        $user_info = $this->getEmployee($announce->created_by);
        if($user_info !== null)
        {
            $announce->created_by_name = $user_info->full_name;
        }

        return view('announce/announce-single', compact('announce'));
    }

    public function store(Requests\StoreAnnounceRequest $request)
    {
        $store = new Announce;
        $this->setAnnounceFields($request, $store);
        $store->created_by = Auth::user()->nidn;
        $store->save();

        if ($request->hasFile('image_name'))
        {
            $store->image_name = md5($request->file('image_name')->getClientOriginalName() . Carbon::now()->toDateTimeString() . $store->id) . '.' . $request->file('image_name')->extension();
            $path = public_path('images/upload/announces');
            $request->file('image_name')->move($path, $store->image_name);
        }

        return redirect()->intended('/announces/');
    }

    public function update(Requests\StoreAnnounceRequest $request, $id)
    {
        $store = Announce::find($id);
        $this->setAnnounceFields($request, $store);
        $store->updated_by = Auth::user()->nidn;
        $path = public_path('images/upload/announces');

        if ($request->delete_image === 'x' ||
            ($request->hasFile('image_name') && $store->image_name !== null)
        )
        {
//            dd($path . $store->image_name);
            File::delete($path . DIRECTORY_SEPARATOR . $store->image_name);
            $store->image_name = null;
        }

        if ($request->hasFile('image_name'))
        {
            $store->image_name = md5($request->file('image_name')->getClientOriginalName() . Carbon::now()->toDateTimeString()) . '.' . $request->file('image_name')->extension();
            $request->file('image_name')->move($path, $store->image_name);
        }
        $store->save();

        return redirect()->intended('/announces/');
    }

    public function destroy($id)
    {
        $announce = Announce::find($id);
        $path = public_path('images/upload/announces');
        if($announce->image_name !== null) File::delete($path . DIRECTORY_SEPARATOR . $announce->image_name);

        Announce::find($id)->delete();

        return redirect()->intended('/announces/');
    }

    private function setAnnounceFields(Requests\StoreAnnounceRequest $request, $store)
    {
        $store->title = $request->title;
        $store->content = $request->content;
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }
}
