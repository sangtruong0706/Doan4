<?php

namespace App\Http\Controllers\client;

use App\Models\Page;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index () {
        $data = [];
        $categories_index = Category::whereIn('name', ['Mens', 'Womans', 'Sports'])->get();
        $features_products = Product::orderBy('id','DESC')
                                    ->with('brand')
                                    ->with('productImages')
                                    ->where('is_feature', 'Yes')
                                    ->where('status', '1')
                                    ->take(4)
                                    ->get();

        $latest_products = Product::orderBy('id','DESC')
                                    ->with('brand')
                                    ->with('productImages')
                                    ->where('status', '1')
                                    ->take(4)
                                    ->get();
        $pages = Page::orderBy('id','DESC')->get();
        $blogs = Blog::orderBy('id','asc')->take(2)->get();
        $data['categories_index'] = $categories_index;
        $data['features_products'] = $features_products;
        $data['latest_products'] = $latest_products;
        $data['pages'] = $pages;
        $data['blogs'] = $blogs;
        return view('client.home', $data);
    }
    public function collection() {
        // Load categories with a maximum of 4 products each
        $categories = Category::with(['products'])->get();

        $brands = Brand::with(['products'])->get();
        // dd($brands);
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('client.collection', $data);
    }
    public function blog(Request $request, $categorySlug = null) {
        $categorySelected = '';
        $blogs = Blog::latest(); // Sắp xếp bài viết theo thứ tự mới nhất
        $blog_categories = BlogCategory::orderBy('id', 'DESC')->get();

        // Lọc theo danh mục
        if (!empty($categorySlug)) {
            if ($categorySlug == 'all'){
                $blogs = Blog::latest();
            }
            $cate_blog = BlogCategory::where('slug', $categorySlug)->first();
            if ($cate_blog) {
                $blogs->where('blog_category_id', $cate_blog->id); // Sửa lại điều kiện lọc
                $categorySelected = $cate_blog->id;
            }
        }

        $blogs = $blogs->paginate(8);
        $data['blogs'] = $blogs;
        $data['blog_categories'] = $blog_categories;
        $data['categorySelected'] = $categorySelected;
        return view('client.blog', $data);
    }

    public function blogDetail($blog_id) {
        $blog = Blog::find($blog_id);
        $blog_categories = BlogCategory::orderBy('id', 'DESC')->get();
        $data['blog'] = $blog;
        $data['blog_categories'] = $blog_categories;
        $data['categorySelected'] = $blog->blog_category_id;
        return view('client.blog-detail',$data);
    }
    public function autocompleteSearch(Request $request) {
        $query = $request->get('query');
        $filterResult = Product::where('title', 'LIKE', '%'. $query. '%')->get();
        return response()->json($filterResult);
    }
    public function addToWishList(Request $request) {
        if (Auth::check() == false) {

            session(['url.intended' => url()->previous()]);

            return response()->json([
                'status' => false,
                'message' => 'Please login to add this product wishlist',
            ]);
        }
        Wishlist::updateOrCreate(
            [
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
            ]
            );
        // $wishlist = new Wishlist();
        // $wishlist->user_id = Auth::user()->id;
        // $wishlist->product_id = $request->product_id;
        // $wishlist->save();
        // session()->flash('success', 'Product wishlist added successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product wishlist added successfully',
        ]);
    }
    public function page($slug) {
        $page = Page::where('slug', $slug)->first();
        $data['page'] = $page;
        // dd($page);
        return view('client.pages.page',$data);
    }
    public function sendContactEmail(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->passes()) {
            // Send mail here
            $mailData = [
                'name' =>$request->name,
                'email' =>$request->email,
                'subject' =>$request->subject,
                'message' =>$request->message,
                'mail_subject' => 'You have received a contact email',
            ];
            $admin = User::where('id', 1)->first();
            Mail::to($admin->email)->send(new ContactEmail($mailData));
            session()->flash('success', "Thank for contact us, we will get back to you soon");
            return response()->json([
                'status' => true,
                'message' => 'send email successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
}
