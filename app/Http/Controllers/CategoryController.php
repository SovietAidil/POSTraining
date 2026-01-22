<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        confirmDelete('Delete Data', 'Are you sure you want to delete this data?');
        return view('category.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'nama_category'=>'required|unique:categories,nama_category,' . $id,
            'description'=>'required|max:100|min:10'
        ],[
            'nama_category.required'=> 'Category Name needs to be filled',
            'nama_category.unique'=> 'Category Name already existed',
            'description.required'=>'Description need to be filled',
            'description.max'=>'Description maximum characters is 100',
            'description.min'=>'Description minimum characters is 10',
        ]);
        Category::updateOrCreate(
        ['id'=> $id],
        [
            'nama_category'=> $request->nama_category,
            'slug'=> Str::slug($request->nama_category),
            'description'=> $request->description,
        ]
    );

    toast()->success('Data has been successfully stored');
    return redirect()->route('master-data.category.index');

    }
    public function destroy(string $id){
        $category = Category::findOrFail($id);
        $category->delete();
        toast()->success('Data has been successfully deleted');
        return redirect()->route('master-data.category.index');
    }
}
