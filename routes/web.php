<?php

use App\Models\User;
use Inertia\Inertia;
use App\Models\Article;
use App\Models\Taggeds;
use App\Models\Category;
use App\Models\TierList;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TierListController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth');

//Tout ça concerne la partie classment
Route::get('/TierList/deleteTierlist/{TierList}', [TierListController::class, 'deleteTierList']);
Route::get('/TierList/ListeClassement/{user:name}', [TierListController::class, 'showAll']);
Route::get('/TierList/{category:name}/{user:name}/{search}', [TierListController::class, 'add_article']);
Route::get('/TierList/{category:name}/{user:name}', [TierListController::class, 'create_get']);
Route::get('/TierList/delete/{category:name}/{user:name}/{article:title}', [TierListController::class, 'delete']);
Route::match(['post', 'get'],'/TierList/update', [TierListController::class, 'update']);

//Tout ça la partie catégorie
Route::get('/{category:name}/article/create', [ArticleController::class, 'create']);
Route::post('/{category:name}/article/create', [ArticleController::class, 'store']);

//Tout ça la partie article
Route::get('/{article:title}/article/edit', [ArticleController::class, 'edit'])->middleware('can:admin');
Route::middleware('can:admin')->group(function () {
    Route::post('/category/{category:name}', [CategoryController::class, 'store']);
    Route::get('/{article:title}/article/edit', [ArticleController::class, 'edit']);
    Route::post('/{article:title}/article/edit', [ArticleController::class, 'storeEdit']);
});

Route::get('/Users/create', function () {
    return Inertia::render('Users/Create');
});

    Route::get('/{category:name?}', function (Category $category = null) {

        //Va sur la page de la bonne catégorie
        if($category == null ){
            $category = Category::find(1);
            if($category==null){
                dd("Aucune catégorie dans la base de donnée");
            }
        }
        else{
            $category = Category::where('id', $category->id)->get()->first();
        }
        //Cherche toutes les catégories enfants
        $categories = Category::with('allChildrenCategories')->first();
        $categories->allChildrenCategories; 
        $categories->allChildrenCategories->first()->allChildrenCategories;

        //Vérifier si on a déjà ajouter à la tierList
        $isTierListExist=false;
        if(auth()->user()){
            $user = auth()->user();
            $TierListUser = TierList::where('category_id', $category->id)->where('user_id', $user->id)->get()->first();
            if($TierListUser != null){
                $isTierListExist=true;
            }
        }

        //$categories = Category::find($category->id)->categories;
        return Inertia::render('Classement', [
            'articles' => Article::query()
            ->select()
            ->join('taggeds', 'articles.id', '=', 'taggeds.article_id')
            ->where('taggeds.category_id', $category->id)
            ->where('articles.etat', 'confirm')
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
                'image' => $article->image,
                'countVote' => $article->vote_up
            ]),
            'isTierListExist' => $isTierListExist,
            'filters' => Request::only(['search']),
            'categories' => $categories,
            'category' => $category,
            'can' => [
                'createUser' => false
            ],
        ]);
    });

    Route::get('users', function () {
        return Inertia::render('Users/Index', [
            'users' => User::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name
            ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => true
            ]
        ]);
    });
    
    Route::post('/users', function () {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('login');
    });

 

    Route::get('/logout', function () {
        dd('loging the user out');
    });
    
Route::middleware('auth')->group(function (){
});