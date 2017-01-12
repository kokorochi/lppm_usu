<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use App\Category_type;
use Illuminate\Support\Facades\Auth;

class CategoryTypeController extends BlankonController {
    private $pageTitle = 'Jenis Sumber Dana';
    protected $deleteQuestion = 'Apakah anda yakin untuk menghapus Jenis Sumber Dana ini?';
    protected $deleteUrl = 'category-types';

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
        $category_types = Category_type::paginate(10);

        return view('category-type.category-type-list', compact('category_types'));
    }

    public function create()
    {
        $category_type = new Category_type();
        $upd_mode = 'create';
        $form_action = url($this->deleteUrl . '/create');

        return view('category-type.category-type-detail', compact('category_type', 'upd_mode', 'form_action'));
    }

    public function store(Requests\StoreCategoryTypeRequest $request)
    {
        $category_type = new Category_type();
        $category_type->category_name = $request->category_name;
        $category_type->created_by = Auth::user()->nidn;
        $category_type->save();

        return redirect()->intended($this->deleteUrl);
    }

    public function edit($id)
    {
        $category_type = Category_type::find($id);
        if ($category_type === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $upd_mode = 'edit';
        $form_action = url($this->deleteUrl, $category_type->id) . '/edit';

        return view('category-type.category-type-detail', compact('category_type', 'upd_mode', 'form_action'));
    }

    public function update(Requests\StoreCategoryTypeRequest $request, $id)
    {
        $category_type = Category_type::find($id);
        if ($category_type === null)
        {
            $this->setCSS404();

            return abort('404');
        }

        $category_type->category_name = $request->category_name;
        $category_type->updated_by = Auth::user()->nidn;
        $category_type->save();

        return redirect()->intended($this->deleteUrl);
    }

    public function destroy($id)
    {
        $category_type = Category_type::find($id);
        if ($category_type === null)
        {
            $this->setCSS404();

            return abort('404');
        }
        $category_type->delete();

        return redirect()->intended($this->deleteUrl);
    }

    private function setCSS404()
    {
        array_push($this->css['themes'], 'admin/css/pages/error-page.css');
        View::share('css', $this->css);
    }
}
