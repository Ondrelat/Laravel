<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagged extends Model
{
    use HasFactory;
   
    protected $guarded = [];
    
    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function calculScore(){
        $category = $this->category()->get()->first();
        $article = $this->article()->get()->first();

        //On fait la moyenne des utilisateur ici. Donc tout les utilisateur qui ajouter cette article dans leur article_tier_lists
        $ArticleTierList = DB::table('article_tier_lists')->select(DB::raw("SUM(100 / article_tier_lists.rank) as totalRank"), DB::raw("COUNT(article_tier_lists.id) as count"))
                                            ->join("tier_lists", "tier_lists.id", "=", "article_tier_lists.tier_list_id")
                                            ->join("categories", "categories.id", "=", "tier_lists.category_id") 
                                            ->where("categories.id", $category->id)
                                            ->where("article_id", $article->id)
                                          ->get();
        $score = $ArticleTierList[0]->totalRank / $ArticleTierList[0]->count;
        $score = ROUND($score, 2);
        return $score;
    }

}
