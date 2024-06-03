<?php

namespace App\Http\Controllers\admin;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductDetail;

use function Laravel\Prompts\error;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::latest('id')->with('productImages')->with('productDetails');
        //search
        if (!empty($request->get('keyword'))) {
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
        }

        $products = $products->paginate(10);
        $data['products'] = $products;
        return view('admin.product.list', $data);
    }

    public function create() {
        $data = [];
        $sizes = Size::orderBy('id', 'asc')->get();
        $colors = Color::orderBy('id', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();

        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view("admin.product.create", $data );
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required|numeric',
            'product_code' => 'required',
            'quantities' =>'required',
            'is_feature' => 'required|in:Yes,No',
            'status' => 'required',
            'category' => 'required|numeric',
            'brand' => 'required|numeric',
        ]);

        if ($validator->passes()){
            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->product_code = $request->product_code;
            $product->status = $request->status;
            $product->is_feature = $request->is_feature;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;

            $product->save();
            // them chi tiet san pham
            foreach ($request->quantities as $sizeId => $colors) {
                foreach ($colors as $colorId => $quantity) {
                    $productDetail = new ProductDetail();
                    $productDetail->product_id = $product->id;
                    $productDetail->size_id = $sizeId;
                    $productDetail->color_id = $colorId;
                    $productDetail->quantity = $quantity;
                    $productDetail->save();
                }
            }
            // save gallery images
            if (!empty($request->image_array)){
                foreach($request->image_array as $temp_image_id) {

                    $temImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.', $temImageInfo->name);
                    //171543077.jpg
                    $ext = last($extArray); // like jpg,gif,png

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = "NULL";
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
                    // product_id = 1; product-image-id = 1
                    // name image = 4-1-23444.jpg
                    $productImage->image = $imageName;
                    $productImage->save();

                    //Generate product thumbnail
                    //Large Image
                    $sourcePath = public_path().'/temp/'.$temImageInfo->name;
                    $destPath = public_path().'/uploads/product/large/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($destPath);

                    //Small Image
                    $destPath = public_path().'/uploads/product/small/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->fit(460, 460);
                    $image->save($destPath);
                }
            }
            session()->flash('success', 'Product added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully'
            ]);

        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request) {
        $product = Product::findOrFail($id);
        if(empty($product)){
            return redirect()->route('products.index')->with('errors','Product not found');
        }
        $data = [];
        $sizes = Size::orderBy('id', 'asc')->get();
        $colors = Color::orderBy('id', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        //fetch product images
        $productImages = ProductImage::where('product_id', $product->id)->get();

        $data['product'] = $product;
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['productImages'] = $productImages;

        return view('admin.product.edit', $data);
    }

    public function update ($id, Request $request) {
        $product = Product::find($id);
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'description' => 'required',
            'price' => 'required|numeric',
            'product_code' => 'required',
            'quantities' =>'required',
            'is_feature' => 'required|in:Yes,No',
            'status' => 'required',
            'category' => 'required|numeric',
            'brand' => 'required|numeric',
        ]);

        if ($validator->passes()){
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->product_code = $request->product_code;
            $product->status = $request->status;
            $product->is_feature = $request->is_feature;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;

            $product->save();
            // cap nhat chi tiet san pham
            foreach ($request->quantities as $sizeId => $colors) {
                foreach ($colors as $colorId => $quantity) {
                    // Tìm chi tiết sản phẩm tương ứng hoặc tạo mới nếu chưa tồn tại
                    $productDetail = ProductDetail::where('product_id', $id)
                        ->where('size_id', $sizeId)
                        ->where('color_id', $colorId)
                        ->firstOrCreate([
                            'product_id' => $id,
                            'size_id' => $sizeId,
                            'color_id' => $colorId,
                        ]);

                    // Cập nhật số lượng của chi tiết sản phẩm
                    $productDetail->quantity = $quantity;
                    $productDetail->save();
                }
            }
            session()->flash('success', 'Product added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update product successfully'
            ]);

        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy ($id, Request $request) {
        $product = Product::find($id);
        if (empty($product)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $productImages = ProductImage::where('product_id', $id)->get();
        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                File::delete(public_path('uploads/product/large/'.$productImage->image));
                File::delete(public_path('uploads/product/small/'.$productImage->image));
            }
            ProductImage::where('product_id', $id)->delete();
        }
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => "Product deleted successfully",
        ]);
    }
}
