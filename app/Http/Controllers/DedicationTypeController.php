<?php

namespace App\Http\Controllers;

use App\Dedication_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use View;

class DedicationTypeController extends BlankonController
{
    private $pageTitle = 'Jenis Pengabdian';
    protected $deleteQuestion = 'Apakah anda yakin untuk menghapus Jenis Pengabdian ini?';
    protected $deleteUrl = 'dedication-types';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isOperator');
        parent::__construct();

        array_push($this->css['pages'], 'global/plugins/bower_components/fontawesome/css/font-awesome.min.css');

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
        $dedication_types = Dedication_type::paginate(10);

        return view('dedication-type.dedication-type-list', compact('dedication_types'));
    }

    public function create()
    {
        $dedication_type = new Dedication_type();
        $upd_mode = 'create';

        return view('dedication-type.dedication-type-detail', compact('dedication_type', 'upd_mode'));
    }

    public function store(Requests\StoreDedicationTypeRequest $request)
    {
        $dedication_types = new Dedication_type();
        $dedication_types->dedication_name = $request->dedication_name;
        $dedication_types->created_by = Auth::user()->nidn;
        $dedication_types->save();

        return redirect()->intended($this->deleteUrl);
    }

    public function edit($id)
    {
        $dedication_type = Dedication_type::find($id);
        if ($dedication_type === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $upd_mode = 'edit';

        return view('dedication-type.dedication-type-detail', compact('dedication_type', 'upd_mode'));
    }

    public function update(Requests\StoreDedicationTypeRequest $request, $id)
    {
        $dedication_type = Dedication_type::find($id);
        if ($dedication_type === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $dedication_type->dedication_name = $request->dedication_name;
        $dedication_type->updated_by = Auth::user()->nidn;
        $dedication_type->save();

        return redirect()->intended($this->deleteUrl);
    }

    public function destroy($id)
    {
        $dedication_type = Dedication_type::find($id);
        if ($dedication_type === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $dedication_type->delete();

        return redirect()->intended($this->deleteUrl);
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }
}
