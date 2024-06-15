<?php

namespace App\Http\Controllers\admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{
    public function index(Request $request){
        $blog_categories = BlogCategory::latest();
        if (!empty($request->get('keyword'))) {
            $blog_categories = $blog_categories->where('name','like','%'.$request->get('keyword').'%');
        }
        $blog_categories = $blog_categories->paginate(10);
        $data['blog_categories'] = $blog_categories;
        return view('admin.blog-category.list', $data);
    }
    public function create() {
        return view('admin.blog-category.create');
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:blog_categories',
            'slug' => 'required',
        ]);
        if ($validator->passes()) {
            $blog_cate = new BlogCategory();
            $blog_cate->name = $request->name;
            $blog_cate->slug = $request->slug;
            $blog_cate->status = $request->status;
            $blog_cate->save();
            session()->flash('success', 'Create blog category successfully');
            return response()->json([
                'status' => true,
                'message' => 'Create blog category successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    public function edit(Request $request, $blog_cate_id){
        $blog_cate = BlogCategory::find($blog_cate_id);
        return view("admin.blog-category.edit", compact("blog_cate"));
    }
    public function update(Request $request, $blog_cate_id){
        $blog_cate = BlogCategory::find($blog_cate_id);
        if (empty($blog_cate)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => "Blog category not found"
            ]);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:blog_categories,name,'.$blog_cate->id.',id',
            'slug' => 'required'
        ]);
        if ($validator->passes()) {
            $blog_cate->name = $request->name;
            $blog_cate->slug = $request->slug;
            $blog_cate->status = $request->status;
            $blog_cate->save();
            session()->flash('success', 'Update blog category successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update blog category successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(Request $request, $blog_cate_id){
        $blog_cate = BlogCategory::find($blog_cate_id);
        if (empty($blog_cate)){
            return redirect()->route('blog-category.index');
        }
        $blog_cate->delete();
        session()->flash('success', 'Delete blog category successfully');
        return response()->json([
            'status' => true,
            'message' => 'Blog category deleted successfully',
        ]);
    }
}
