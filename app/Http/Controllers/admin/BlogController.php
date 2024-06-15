<?php

namespace App\Http\Controllers\admin;

use App\Models\Blog;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function index(Request $request){
        $blogs = Blog::latest();
        if (!empty($request->get('keyword'))) {
            $blogs = $blogs->where('title','like','%'.$request->get('keyword').'%');
        }
        $blogs = $blogs->paginate(10);
        $data['blogs'] = $blogs;
        return view('admin.blog.list', $data);
    }
    public function create() {
        $blog_categories = BlogCategory::get();
        $data['blog_categories'] = $blog_categories;
        return view('admin.blog.create', $data);
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:blogs',
            'blog_category' => 'required',
            'author' => 'required',
        ]);
        if ($validator->passes()) {
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->blog_category_id = $request->blog_category;
            $blog->author = $request->author;
            $blog->save();

            //save image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::findOrFail($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $blog->id . '_' . time() . '.' . $ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/blog/'.$newImageName;
                File::copy($sPath, $dPath);
                //Generate Image Thumbnail
                $dPath = public_path().'/uploads/blog/thumb/'.$newImageName;
                $img = Image::make($sPath);
                $img->resize(420, 240);
                $img->save($dPath);

                $blog->image = $newImageName;
                $blog->save();
            }
            session()->flash('success', 'Create blog successfully');
            return response()->json([
                'status' => true,
                'message' => 'Create blog successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($blog_id) {
        $blog = Blog::find($blog_id);
        $blog_categories = BlogCategory::get();
        if ($blog == null) {
            return response()->json([
                'status' => true,
                'message' => 'Blog not found'
            ]);
        }
        $data['blog'] = $blog;
        $data['blog_categories'] = $blog_categories;
        return view('admin.blog.edit', $data);
    }
    public function update(Request $request, $blog_id){
        $blog = Blog::find($blog_id);
        if (empty($blog)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => "Blog not found"
            ]);
        }
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:blogs,title,'.$blog->id.',id',
            'blog_category' => 'required',
            'author' => 'required',
        ]);
        if ($validator->passes()) {
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->blog_category_id = $request->blog_category;
            $blog->author = $request->author;
            $blog->save();
            $oldImage = $blog->image;

            //save image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::findOrFail($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $blog->id . '_' . time() . '.' . $ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/blog/'.$newImageName;
                File::copy($sPath, $dPath);
                //Generate Image Thumbnail
                $dPath = public_path().'/uploads/blog/thumb/'.$newImageName;
                $img = Image::make($sPath);
                $img->resize(420, 240);
                $img->save($dPath);

                $blog->image = $newImageName;
                $blog->save();
                File::delete(public_path().'/uploads/blog/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/blog/'.$oldImage);
            }
            // $request->session()->flash('success', 'Create category successfully');
            session()->flash('success', 'Update blog successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update blog successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    function destroy(Request $request, $blog_id){
        $blog = Blog::find($blog_id);
        if (empty($blog)){
            return redirect()->route('blogs.index');
        }
        File::delete(public_path().'/uploads/blog/thumb/'.$blog->image);
        File::delete(public_path().'/uploads/blog/'.$blog->image);
        $blog->delete();
        session()->flash('success', 'Delete blog successfully');
        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }
}
