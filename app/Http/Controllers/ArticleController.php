<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tagged;
use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleLike;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    public function create(Category $category)
    {
        return Inertia::render('Article/Create', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category, Article $article)
    {
        
        return Inertia::render('Article/Edit', [
            'article' => $article,
        ]);
        
    }

    public function delete(Article $article)
    {
        if(Storage::delete($article->image)) {
            $article->delete();
         }
        return Inertia::render('/', [
        ]);
    }

    public function storeEdit(article $article, Request $request)
    {   

        $attributes = $request->validate([
            'title' => ['required', Rule::unique('articles', 'title')->ignore($article->id)],
            'content' => ['required'],
        ]);
        $article = Article::where('id', $article->id)->update(['title' => $attributes['title']], ['content' => $attributes['content']]);
        if($request->file('image') != null){
            $attributes['image'] = $request->file('image')->store('images', 'public');
            $article = Article::where('id', $article->id)->update(['image' => $attributes['image']]);
        }



        //$article->save();
        return redirect('/');
    }

    public function store(Category $category, Request $request)
    {   

        $attributes = $request->validate([
            'title' => ['required', Rule::unique('articles', 'title')],
            'content' => ['required'],
        ]);

        $attributes['user_id'] = auth()->id();
        $attributes['type'] = $category->type;
        $attributes['etat'] = "attente";
        $attributes['vote_up'] = 0;
        $attributes['baseArticle'] = false;
        $attributes['vote_down'] = 0;
        $attributes['rank'] = 0;
        $attributes['score'] = 0;
        if($request->file('image') != null){
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }
        $article = Article::create($attributes);
        $tagged = array('category_id' => $category->id, 'article_id' => $article->id, 'score' => 0);
        Tagged::create($tagged);
        $CategoryTest = $category;

        while($CategoryTest->id != 1){
            $CategoryTest = Category::find($CategoryTest->category_id);
            $tagged = array('category_id' => $CategoryTest->id, 'article_id' => $article->id, 'score' => 0);
            Tagged::create($tagged);
        }
        return redirect('/');
    }
}
