<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\User;
use Validator;
use JWTAuth;


class ArticleController extends Controller
{
    public function all()
    {
        return response()->json(Article::with('user')->paginate(6), 200);
    }

    public function by_user()
    {
        
        $articles = Article::whereHas('user', function($query){
            $user = JWTAuth::parseToken()->authenticate();
            $query->where('users.id', $user->id);
        })->paginate(6);
        return response()->json($articles, 200);
    }

    public function edit()
    {
        $article = Article::find(request()->input('id'));
        return response()->json($article, 200);

    }

    public function store()
    {
        $validator = Validator::make(request()->json()->all(), [
            'title' => 'required|alpha_num',
            'image' => 'required',
            'body' => 'required'
        ]);

        if($validator->fails())
        {
            $errors = array();
            foreach($validator->errors()->all() as $error)
            {
                array_push($errors, $error);
               
            }
            return response()->json(["messages" => $errors], 422);
        }
        else 
        {
            $user = JWTAuth::parseToken()->authenticate();
            $article = new Article();
            $title = request()->input('title');
            $article->title = $title;
            $article->body = request()->input('body');
            $file = request()->input('image');
            $image = base64_decode(substr($file, strpos($file, ",")+1));
            $name = time().".png";
            \File::put(public_path()."/$name", $image);
            $article->main_image = url('/')."/$name";
            $article->alt = $title;
            $article->user_id = $user->id;
            if($article->save())
            {
                return response()->json(["message" => "Created new article"], 201);
            }
        }
    }

    public function update()
    {

        $validator = Validator::make(request()->json()->all(), [
            'title' => 'required|alpha_num'
        ]);

        if($validator->fails())
        {
            $errors = array();
            foreach($validator->errors()->all() as $error)
            {
                array_push($errors, $error);
               
            }
            return response()->json(["messages" => $errors], 422);
        }
        else 
        {
            $user = JWTAuth::parseToken()->authenticate();
            $article = new Article();
            $title = request()->input('title');
            $article->title = $title;
            $article->body = request()->input('body');
            $file = request()->input('image');
            if($file != '')
            {
                $image = base64_decode(substr($file, strpos($file, ",")+1));
                $name = time().".png";
                \File::put(public_path()."/$name", $image);
                $article->main_image = url('/')."/$name";

            }
            $article->alt = $title;
            if($article->update())
            {
                return response()->json(["message" => "Updated article"], 200);
            }
        }

    }

    public function delete()
    {
        $article = Article::find(request()->input('id'));
        if($article->delete())
        {
            return response()->json(['message' => 'Deleted article'], 200);
        }
    }

    public function show()
    {
        $article = Article::find(request()->input('id'));
        if($article == null)
        {
            return response()->json(['message' => 'Article not found'], 404);
        }
        else
        {
            return response()->json($article, 200);
        }
        
    }

    public function upload()
    {
        $file = request()->file('upload');
        $name = time().$file->getClientOriginalName();
        $file->move(public_path(), $name);
        $path = url('/')."/$name";
        $message = '';
        return response()->json(["uploaded" => 1, "fileName" => $name, "url" => $path]);
        
    }

}
