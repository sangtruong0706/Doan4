<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
// use Image;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }
    public function create(){
        return view("admin.category.create");
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
        ]);
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            //save image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::findOrFail($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath, $dPath);
                //Generate Image Thumbnail
                $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                $img = Image::make($sPath);
                $img->resize(370, 370);
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();
            }
            session()->flash('success', 'Create category successfully');
            return response()->json([
                'status' => true,
                'message' => 'Create category successfully'
            ]);
        }else {
            session()->flash('error', 'Create category successfully');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    public function edit(Request $request, $category_id){
        $category = Category::find($category_id);
        return view("admin.category.edit", compact("category"));
    }
    public function update(Request $request, $category_id){
        $category = Category::find($category_id);
        if (empty($category)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => "Category not found"
            ]);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);
        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();
            $oldImage = $category->image;

            //save image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::findOrFail($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath, $dPath);
                //Generate Image Thumbnail
                $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                $img = Image::make($sPath);
                $img->resize(450, 600);
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();
                File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/category/'.$oldImage);
            }
            // $request->session()->flash('success', 'Create category successfully');
            session()->flash('success', 'Update category successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update category successfully'
            ]);
        }else {
            session()->flash('error', 'Update category failed');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(Request $request, $category_id){
        $category = Category::find($category_id);
        if (empty($category)){
            return redirect()->route('categories.index');
        }
        File::delete(public_path().'/uploads/category/thumb/'.$category->image);
        File::delete(public_path().'/uploads/category/'.$category->image);
        $category->delete();
        session()->flash('success', 'Delete category successfully');
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}
