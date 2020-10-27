<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all(); //Get all articles

        return view('articles.index')->with('articles', $articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:120',
            'lavage_price' => 'required',
            'repassage_price' => 'required',
            'nettoyage_price' => 'required',
            'description' => 'nullable',
        ]);

        $article = new Article();
        $article->title = $request->input('title');
        $article->lavage_price = $request->input('lavage_price');
        $article->repassage_price = $request->input('repassage_price');
        $article->nettoyage_price = $request->input('nettoyage_price');
        $article->description = $request->input('description');

        $article->save();

        //Redirect to the articles.index view and display message
        return redirect()->route('articles.index')
            ->with('success',
             'Article ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id); //Find article of id = $id

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id); //Find article of id = $id

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:120',
            'repassage_price' => 'required',
            'nettoyage_price' => 'required',
            'lavage_price' => 'required',
            'description' => 'nullable',
        ]);

        $article = Article::findOrFail($id);

        $article->title = $request->input('title');
        $article->lavage_price = $request->input('lavage_price');
        $article->repassage_price = $request->input('repassage_price');
        $article->nettoyage_price = $request->input('nettoyage_price');
        $article->description = $request->input('description');

        $article->save();

        //Redirect to the articles.index view and display message
        return redirect()->route('articles.index')
            ->with('success',
             'Article edité avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success',
             'Article supprimé avec succès');
    }
}
