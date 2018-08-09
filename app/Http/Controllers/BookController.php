<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Book;
class BookController extends Controller
{
    public function index(Request $request){
        $query = DB::table("books")
                    ->join('categories', 'books.cate_id', '=', 'categories.id')
                    ->select('books.*', 'categories.name as cate_name', 'categories.slug as cate_slug');

        if($request->cateId != -1) {
            $query->where('books.cate_id', $request->cateId);
        }

        $result = $query->paginate(12);
        return response()->json($result);
    }

    public function findById(Request $request){
		$result = DB::table("books")
					->join('categories', 'books.cate_id', '=', 'categories.id')
					->select('books.*', 'categories.name as cate_name', 'categories.slug as cate_slug')
                    ->where('books.id', $request->id)
                    ->first();


    	return response()->json($result);
    }

    public function save(Request $request){
        $model = $request->id != null ? Book::find($request->id) : new Book();
        $model->fill($request->all());
        $path = false;
        if($request->hasFile('feature_image')){
            $path = $request->feature_image->storeAs('uploads', uniqid().'-'.$request->feature_image->getClientOriginalName());
            $model->feature_image = 'http://localhost:8000/'.$path;
        }
        $result = $model->save();
        return response()->json($model);
    }
    public function getAll(){
        $model = Book::all();
        return response()->json($model);
    }
}
