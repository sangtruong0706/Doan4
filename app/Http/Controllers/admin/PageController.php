<?php

namespace App\Http\Controllers\admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request) {
        $pages_admin = Page::latest();
        if (!empty($request->get('keyword'))) {
            $pages_admin = $pages_admin->where('slug','like','%'.$request->get('keyword').'%');
        }
        $pages_admin = $pages_admin->paginate(10);
        $data['pages_admin'] = $pages_admin;
        return view('admin.page.list', $data);
    }
    public function create() {
        return view('admin.page.create');
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:pages',
        ]);
        if ($validator->passes()){
            $page = new Page();
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->save();
            session()->flash('success', 'Create page successfully');
            return response()->json([
                'status' => true,
                'message' => 'Create page successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($page_id) {
        $page = Page::where('id',$page_id)->first();
        if ($page == null) {
            session()->flash('error', 'Page not found');
            return redirect()->route("pages.index");
        }
        $data['page'] = $page;
        return view('admin.page.edit', $data);
    }
    public function update(Request $request, $page_id) {
        $page = Page::where('id',$page_id)->first();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,'.$page->id.',id',
        ]);
        if ($validator->passes()){
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->save();
            session()->flash('success', 'Update page successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update page successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy($page_id) {
        $page = Page::where('id', $page_id)->first();
        if ($page == null) {
            session()->flash('error', 'Page not found');
            return response()->json([
                'status' => false,
                'message' => 'Page not found',
            ]);
        }
        $page->delete();
        session()->flash('success', 'Delete page successfully');
        return response()->json([
            'status' => true,
            'message' => 'Page deleted successfully',
        ]);
    }
}
