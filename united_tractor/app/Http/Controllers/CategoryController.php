<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return Response::res($categories, "Berhasil", 200);
        } catch (\Throwable $th) {
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
            $input = [
                'name' => $request->name
            ];
            Category::create($input);
            return Response::res(Category::latest()->first(), "Category Berhasil Dibuat", 200);
        } catch (\Throwable $th) {
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
            return Response::res(Category::where('id', $id)->first(), "Data Diperoleh", 200);
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
            $input = [
                'name' => $request->name
            ];
            Category::where('id', $id)->update($input);
            return Response::res(Category::where('id', $id)->first(), "Data Berhasil di Update", 200);
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
            Category::where('id', $id)->delete();
            return Response::res("Data Berhasil di hapus", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res($th->getMessage(), 400);
        }
    }
}
