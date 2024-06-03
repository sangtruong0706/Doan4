<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function productRating(Request $request)
    {
        $keyword = $request->get('keyword');

        $ratings = ProductRating::with('user', 'product')
            ->when($keyword, function ($query) use ($keyword) {
                return $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                })->orWhereHas('product', function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%");
                });
            })
            ->paginate(10);

        $data['ratings'] = $ratings;
        $data['keyword'] = $keyword;

        return view('admin.rating.ratings', $data);
    }

    public function changeRatingStatus(Request $request) {
        $ratingStatus = ProductRating::where('id', $request->id)->first();
        $ratingStatus->status = $request->status;
        $ratingStatus->save();
        session()->flash('success', 'Change rating status successfully');
        return response()->json([
            'status' => true,
            'message' => 'Change rating status successfully'
        ]);
    }
}
