<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Post;
use App\Category;
class PostController extends Controller
{
    public function index(Request $request){
        $query = DB::table("posts")
                    ->join('categories', 'posts.cate_id', '=', 'categories.id')
                    ->select('posts.*', 'categories.name as cate_name', 'categories.slug as cate_slug');

        if($request->cateId != -1) {
            $query->where('posts.cate_id', $request->cateId);
        }

        $result = $query->paginate(12);
        return response()->json($result);
    }

    public function findById(Request $request){
		$result = DB::table("posts")
					->join('categories', 'posts.cate_id', '=', 'categories.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
					->select('posts.*', 'categories.name as cate_name', 'categories.slug as cate_slug', 'users.name as user_name')
                    ->where('posts.id', $request->id)
                    ->first();


    	return response()->json($result);
    }

    public function save(Request $request){
        $model = $request->id != null ? Post::find($request->id) : new Post();
        $model->fill($request->all());
        $path = false;
        if($request->hasFile('feature_image')){
            $path = $request->feature_image->storeAs('uploads', uniqid().'-'.$request->feature_image->getClientOriginalName());
            $model->feature_image = 'http://localhost:8000/'.$path;
        }
        $result = $model->save();
        return response()->json($model);
    }
    public function getAll(Request $req){
        $limit = 16;
        if($req->limit){
            $limit = $req->limit;
        }
        $result = DB::table("posts")
                    ->join('categories', 'posts.cate_id', '=', 'categories.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*', 'categories.name as cate_name', 'categories.slug as cate_slug', 'users.name as user_name')
                    ->orderBy('id','desc')
                    ->paginate($limit);
        return response()->json($result);
    }

    public function getPostCate(Request $request){
    	if($request->cate_id){
            $limit = 16;
            if($request->limit){
                $limit = $request->limit;
            }
            $arr_id = [$request->cate_id];
            $cate_child = $this->parentCate($request->cate_id);
            foreach ($cate_child as $key => $value) {
               array_push($arr_id, $value->id);
            }
    		$model = Post::whereIn('cate_id',$arr_id)->paginate($limit);

            for($i =0 ; $i < count($model); $i++){
                $model[$i]['category'] = $this->getCate($model[$i]->cate_id);
                $model[$i]['timetext'] = '25/07/2018';
            }
    		if(count($model) <= 0){
    			$model = ["success"=>1, "message" => "dữ liệu trống"];
    		}
    	}
    	else{
    		$model = ["success"=>0,"message" => "Chưa truyền id cate vô!"];
    	}

    	return response()->json($model);
    }

    public function getCate($cate_id){
        $model = Category::find($cate_id);
        return $model;
    }

    public function getUser(){
        
    }
    public function getHotPost(Request $req){
        $limit = 16;
        if($req->limit){
            $limit = $req->limit;
        }
        $result = DB::table("posts")
                    ->join('categories', 'posts.cate_id', '=', 'categories.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*', 'categories.name as cate_name', 'categories.slug as cate_slug', 'users.name as user_name')
                    ->where('type','=',1)
                    ->paginate($limit);
        return response()->json($result);
    }

    public function getPostSameCate(Request $req){
        $model = Post::find($req->post_id);
        $limit = 16;
        if($req->limit){
            $limit = $req->limit;
        }
        $arr = [];
        $result = DB::table("posts")
                    ->join('categories', 'posts.cate_id', '=', 'categories.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*', 'categories.name as cate_name', 'categories.slug as cate_slug', 'users.name as user_name')
                    ->where('cate_id','=',$model->cate_id)
                    ->paginate($limit);
        return response()->json($result);
    }

    public function search(Request $req){
        $limit = 16;
        if($req->limit){
            $limit = $req->limit;
        }
        if($req->keyword == ''){
            return '';
        }
        $keyword = "%$req->keyword%";
        $result = DB::table("posts")
                    ->join('categories', 'posts.cate_id', '=', 'categories.id')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*', 'categories.name as cate_name', 'categories.slug as cate_slug', 'users.name as user_name')
                    ->where('title','like',$keyword)
                    ->paginate($limit);
        if(count($result) <= 0){
            $a = ["error" => "Không tìm thấy từ khóa '".$req->keyword."'"];
            return response()->json($a);
        }
        return response()->json($result);
    }

    public function parentCate($cate_id){
        $model = Category::find($cate_id);
        $result = Category::where('parent_id',$model->id)->get();
        return $result;
    }

}
