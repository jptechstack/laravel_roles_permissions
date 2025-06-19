<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index() {

       $articles = Article::lastet()->paginate(25);

       return view('articles.list', [
        'articles' =>  $articles
       ]);

    }

    public function create() {

        return view('articles.create');

    }

    public function store( Request $request) {

        $validador = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'author' => 'required|min:5'
        ]);

        if($validador->passes()) {

            $article = new Article();
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            return redirect()->routes('articles.index')->with('success', 'Articles added successfully.');

        } else {
            return redirect()->routes('articles.create')->withInput()->withErrors($validador);
        }

    }

    public function show($id) {

    }

    public function edit($id) {

    }

    public function update( Request $request, $id) {

    }

    public function destroy($id) {

    }
}
