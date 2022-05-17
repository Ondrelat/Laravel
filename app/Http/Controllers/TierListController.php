<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Tagged;
use App\Models\Article;
use App\Models\Category;
use App\Models\TierList;
use App\Models\ArticleTierList;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;


class TierListController extends Controller
{
    public function create_get(Category $category)
    {
        $user = auth()->user();
        $TierList = TierList::where("user_id", $user->id)
                            ->where("category_id", $category->id)->get()->first();
        if($TierList == null){
            $TierList = new TierList;
            $TierList->user_id = $user->id;
            $TierList->category_id = $category->id;
            $TierList->save();
        }   
        if($category == null){
            $category = Category::find(1);
        }
        $categories = Category::find($category->id)->categories;

        if(auth()->user()){
            return Inertia::render('TierList', [
                'articles' => Article::query()
                ->select('article_tier_lists.id as t_id', 'article_tier_lists.rank as t_rank' , 'articles.*')
                ->join('article_tier_lists', 'articles.id', '=', 'article_tier_lists.article_id')
                ->join('tier_lists', 'tier_lists.id', '=', 'article_tier_lists.tier_list_id')
                ->join('taggeds', 'articles.id', '=', 'taggeds.article_id')
                ->where('taggeds.category_id', $category->id)
                ->where('tier_lists.user_id', $user->id)
                ->where('tier_lists.id', $TierList->id)
                ->orderBy('article_tier_lists.rank')
                ->paginate(10000)
                ->withQueryString()
                ->through(fn($article) => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'score' => $article->score,
                    'etat' => $article->etat,
                    'rank' => $article->t_rank,
                    'article_tier_list_id' => $article->t_id,
                    'category_id' => $category->id
                ]),         
                'searchArticles' => Article::query()
                ->join('taggeds', 'articles.id', '=', 'taggeds.article_id')
                ->where('taggeds.category_id', $category->id)
                ->orderBy('articles.score', 'DESC')
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($article) => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'score' => $article->score,
                    'etat' => $article->etat,
                    'rank' => $article->rank
                ]),
                'filters' => Request::only(['search']),
                'categories' => $categories,
                'category' => $category,
                'can' => [
                    'createUser' => false
                ]
            ]);
        }
    }

    public function add_article(Category $category, $user, $articleSearch)
    {
        $user = User::where("name", $user)->get()->first();

        $TierList = TierList::where("user_id", $user->id)
        ->where("category_id", $category->id)->get()->first();

        $article = Article::where("title", $articleSearch)->get()->first();

        $article->vote_up += 1;


        $ArticleTierList = ArticleTierList::where("article_id", $article->id)->where("tier_list_id", $TierList->id)->get()->first();
        if($ArticleTierList != null){
            return redirect('TierList/' . $category->name . '/' . $user->name);
        }

        if($article == null){
            $article = new Article;
            $article->user_id = $user->id;
            $article->title = $articleSearch;
            $article->content = "";
            $article->baseArticle = false;
            $article->rank = 0;
            $article->score = 0;
            $article->vote_up = 0;
            $article->vote_down = 0;
            $article->type = $category->type;
            $article->etat = "wait";
            $article->save();
            $tagged = new Tagged;
            $tagged->article_id = $article->id;
            $tagged->category_id = $category->id;
            $tagged->save();
        }

        $TierListArticle = new ArticleTierList;

        //affectationz
        $TierListArticle->tier_list_id = $TierList->id;
        $TierListArticle->article_id = $article->id;

        $TierListArticle->rank = ArticleTierList::where('tier_list_id', $TierList->id)->max('rank')+1;
        $TierListArticle->save();
        if(!isset($tagged)){
            $tagged = Tagged::where("article_id", $article->id)->where("category_id", $category->id)->get()->first();
        }
        $tagged->score = $tagged->calculScore($category);
        $tagged->save();
        $article->save();
        return redirect('TierList/' . $category->name . '/' . $user->name);
    }

    public function delete(Category $category, $user, $articleSearch)
    {
        $user = User::where("name", $user)->get()->first();
        $article = Article::where("title", $articleSearch)->get()->first();
        $article->vote_up -= 1;
        $TierList = TierList::where("user_id", $user->id)
        ->where("category_id", $category->id)->get()->first();
        $ArticleTierList = ArticleTierList::where("tier_list_id", $TierList->id)
        ->where("article_id", $article->id)->get()->first();


        $ArticleTierList->delete();
        $article->save();
        
        $tagged = Tagged::where("article_id", $article->id)->where("category_id", $category->id)->get()->first();
        $tagged->score = $tagged->calculScore();
        $tagged->save();

        $AllArticleTierList = ArticleTierList::where("tier_list_id", $TierList->id)->get();
        $value = 0;

        foreach($AllArticleTierList as $articleTemp){
            $value += 1;
            $articleTemp->rank = $value;
            $articleTemp->save();
            $articleOther = Article::where("id", $articleTemp->article_id)->get()->first();
            $tagged = Tagged::where("article_id", $articleOther->id)->where("category_id", $category->id)->get()->first();
            $tagged->score = $tagged->calculScore();
            $tagged->save();
            $articleOther->save();
        }
        return redirect('TierList/' . $category->name . '/' . $user->name);
    }

    
    public function deleteTierList($tierlist_id)
    {
        $user = auth()->user();
        $TierList = TierList::where("id", $tierlist_id)
        ->where("user_id", $user->id)->get()->first();
        $ArticleTierList = ArticleTierList::where("tier_list_id", $TierList->id)->get();
        $category = Category::where("id", $TierList->category_id);
        foreach($ArticleTierList as $artcleTemp){
            $artcleTemp->delete();
            $tagged = Tagged::where("article_id", $artcleTemp->id)->where("category_id", $category->id)->get()->first();
            $tagged->score = $tagged->calculScore();
            $tagged->save();
        }
        $TierList->delete();
        return redirect('TierList/ListeClassement/' . $user->name);

    }

    public function update(\Illuminate\Http\Request $request)
    {
        dd($request);
        $user = auth()->user();
        $value = 0;
        $category = Category::where("id", $request[0]['category_id'])->get()->first();
        foreach($request->all() as $articleTemp){
            $value += 1;
            $articleTierList = ArticleTierList::where("id", $articleTemp["article_tier_list_id"])->get()->first();
            $articleTierList->rank = $value;
            $articleTierList->save();
            $article = Article::where("id", $articleTemp["id"])->get()->first();

            $tagged = Tagged::where("article_id", $article->id)->where("category_id", $category->id)->get()->first();
            $tagged->score = $tagged->calculScore();
            $tagged->save();


            $article->save();
        }
        $articleTierList = Category::where("id", $articleTemp["category_id"])->get()->first();
        return redirect('TierList/' . $articleTierList->name .  '/' . $user->name);
    }

    public function showAll($user)
    {
        $user = User::where("name", $user)->get()->first();
        //$ArticleTierList = TierList::where("user_id", $user->id)->get();
        return Inertia::render('TierListAll', [
            'tier_lists' => TierList::query()
            ->select('categories.name as c_title', DB::raw('count(*) as countArticle'), 'tier_lists.*')
            ->where('tier_lists.user_id', $user->id)
            ->join('categories', 'tier_lists.category_id' , '=', 'categories.id')
            ->join('article_tier_lists', 'tier_lists.id', '=', 'article_tier_lists.tier_list_id')
            ->groupBy('tier_lists.id')
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($article) => [
                'id' => $article->id,
                'name' =>  $article->c_title,
                'countArticle' => $article->countArticle
            ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => false
            ]
        ])
        ;
    }
}
