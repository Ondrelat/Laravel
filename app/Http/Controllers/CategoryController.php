<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('Category/Create', [
        ]);
    }

    public function store(Category $category, Request $request)
    { 
        $attributes = $request->validate([
            'name' => ['required', Rule::unique('categories', 'name')],
        ]);
        $attributes['user_id'] = auth()->id();
        $attributes['category_id'] = $category->id;
        $attributes['type'] = $category->type;
        $attributes['base_article_id'] = true;
    
        $attributesArticle['title'] = $attributes['name'];
        $attributesArticle['content'] = $attributes['name'];
        $attributesArticle['user_id'] = auth()->id();
        $attributesArticle['type'] = $category->type;
        $attributesArticle['vote_up'] = 0;
        $attributesArticle['baseArticle'] = true;
        $attributesArticle['vote_down'] = 0;
        $attributesArticle['rank'] = 0;
        $attributesArticle['score'] = 0;
        $attributesArticle['etat'] = "confirm";
    
        $articleCreate = Article::create($attributesArticle);
        $attributes['base_article_id'] = $articleCreate->id;
        Category::create($attributes);   
    
        return redirect('/' . $category->name);
    }


}
