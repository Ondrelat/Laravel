<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];  

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function articleLikes(){
        return $this->HasMany(ArticleLike::class);
    }

    public function articleTierList(){
        return $this->HasMany(ArticleTierList::class);
    }

    public function calculScore(){
        $ArticleTierList = $this->articleTierList()->get();
        $scoreCalcul = 0;
        $totalScore = 0;
        $NombreVote = 0;
        foreach($ArticleTierList as $article){
            $totalScore += 100 / $article->rank;
            $NombreVote+=1;
        }
        if($NombreVote != 0 || $totalScore != 0){
            $scoreCalcul = $totalScore / $NombreVote;
        }
        else{
            $scoreCalcul = 0;
        }
        $scoreCalcul = ROUND($scoreCalcul);
        return $scoreCalcul;
    }
}
