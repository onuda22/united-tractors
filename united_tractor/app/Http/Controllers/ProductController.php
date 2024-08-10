<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Response::res(Product::all(), "Data Berhasil Diperoleh", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res($th->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $image = Carbon::now()->format('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'product_category_id' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $input = [
                'name' => $request->name,
                'price' => $request->price,
                'image' => env('APP_URL').'/images'.'/'.$image,
                'product_category_id' => $request->product_category_id
            ];
            Product::create($input);
            $request->file('image')->move('images', $image);
            return Response::res(Product::latest()->first(), "Product Berhasil Dibuat", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Response::res(Product::where('id', $id)->first(), "Data Diperoleh", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res($th->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Check File
            $product = Product::where('id', $id)->first();
            if (!$product) {
                return Response::res('Product not found', 404);
            }

            dd($request->name);

            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'product_category_id' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $input = [
                'name' => $request->name,
                'price' => $request->price,
                'product_category_id' => $request->product_category_id
            ];

            if ($request->hasFile('image')) {
                $image = Carbon::now()->format('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $input['image'] = env('APP_URL').'/images'.'/'.$image;

                $existImagePath = public_path($product->image);
                if (File::exists($existImagePath)) {
                    File::delete($existImagePath);
                }

                $request->file('image')->move(public_path('images'), $image);
            } else {
                $input['image'] = $product->image;
            }

            Product::where('id', $id)->update($input);
            return Response::res(Product::where('id', $id)->first(), "Data Berhasil di Update", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res($th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::where('id', $id)->first();
            if (!$product) {
                return Response::res('Product not found', 404);
            }

            $imagePath = public_path($product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $product->delete();
            return Response::res("Data Berhasil Dihapus", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res($th->getMessage(), 400);
        }
    }
}
