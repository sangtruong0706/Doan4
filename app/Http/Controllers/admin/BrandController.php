<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request){
        $brands = Brand::latest();
        if (!empty($request->get('keyword'))) {
            $brands = $brands->where('name','like','%'.$request->get('keyword').'%');
        }
        $brands = $brands->paginate(10);
        return view('admin.brand.list', compact('brands'));
    }
    public function create(){
        return view("admin.brand.create");
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:brands',
            'slug' => 'required|unique:brands',
        ]);
        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Create brand successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    public function edit(Request $request, $brand_id){
        $brand = Brand::find($brand_id);
        return view("admin.brand.edit", compact("brand"));
    }
    public function update(Request $request, $brand_id){
        $brand = Brand::find($brand_id);
        if (empty($brand)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => "Brand not found"
            ]);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
        ]);
        if ($validator->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
            return response()->json([
                'status' => true,
                'message' => 'Update brand successfully'
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(Request $request, $brand_id){
        $brand = Brand::find($brand_id);
        if (empty($brand)){
            return redirect()->route('brands.index');
        }
        $brand->delete();
        return response()->json([
            'status' => true,
            'message' => 'Brand deleted successfully',
        ]);
    }
}
