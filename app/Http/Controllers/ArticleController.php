<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view articles')->only('index');
        $this->middleware('permission:edit articles')->only('edit');
        $this->middleware('permission:create articles')->only('create');
        $this->middleware('permission:delete articles')->only('destroy');
    }

    public function index() {

       $articles = Article::latest()->paginate(25);

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

        if ($validador->fails()) {
            return redirect()->route('articles.index')->withInput()->withErrors($validador);
        }

        $article = new Article();
        $article->title = $request->title;
        $article->text = $request->text;
        $article->author = $request->author;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Articles added successfully.');

    }

    public function edit($id) {

        $article = Article::findOrFail($id);

        return view('articles.edit', [
            'articles' => $article
        ]);
    }

    public function update( Request $request, $id) {

        $article = Article::findOrFail($id);

        $validador = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'author' => 'required|min:5'
        ]);

        if($validador->fails()) {
            return redirect()->route('articles.create')->withInput()->withErrors($validador);


        }
        
        $article->title = $request->title;
        $article->text = $request->text;
        $article->author = $request->author;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Articles added successfully.');
    }

    public function destroy(Request $request) {

        $article = Article::find($request->id);

        if ($article == null) {

            session()->flash('error','Articles not found');
            return response()->json([
                'status' => false
            ]);
        }

        $article->delete();

        session()->flash('success','Articles deleted successfully');
        return response()->json([
            'status' => true
        ]);

    }
}
