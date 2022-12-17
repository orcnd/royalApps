<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\apiUser;

use App\Http\Requests\newBookRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('apiAuth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        $me=apiUser::user();   
        return view('crud.view',[
            'title'=>'User Profile',
            'columns'=>[
                'first_name'=>['text'=>'First Name','type'=>'text'],
                'last_name'=>['text'=>'Last Name','type'=>'text'],
                'email'=>['text'=>'E-Mail','type'=>'text'],
                'gender'=>['text'=>'Gender','type'=>'text'],
            ],
            'data'=>$me,
        ]);
    }

    public function authors()
    {
        
        $authors=apiUser::authors();
        if ($authors===false) return abort(403); //something broken we could add a decent error page here
        
        return view('crud.index',[
            'title'=>'Authors',
            'rows'=>$authors->items,
            'columns'=>[
                'id'=>['text'=>'ID','type'=>'text'],
                'first_name'=>['text'=>"First Name",'type'=>'text'],
                'last_name'=>['text'=>'Last Name','type'=>'text'],
                'birthday'=>['text'=>'Birthday','type'=>'date'],
                'gender'=>['text'=>'Gender','type'=>'text'],
                'place_of_birth'=>['text'=>'Place of Birth','type'=>'text'],
            ],
            'rowActions'=>[
                'viewAuthor'=>'View',
            ]
        ]);
    }

    public function viewAuthor($id) { 
        $author=apiUser::author($id);
        if ($author===false) return abort(404); //something broken we could add a decent error page here
        
        return view('viewAuthor',[
            'title'=>'Author',
            'author'=>$author,
        ]);
    }

    public function deleteAuthor($id) {
        $author=apiUser::author($id);
        if ($author===false) return abort(404); //something broken we could add a decent error page here        
        return view('crud.delete',[
            'title'=>'Delete Author - '.$author->first_name . ' ' . $author->last_name,
            'url'=>route('deleteAuthorDestroy',$author->id),
            'columns'=>[
                'birthday'=>['text'=>'Birthday','type'=>'date'],
                'gender'=>['text'=>'Gender','type'=>'text'],
                'place_of_birth'=>['text'=>'Place of Birth','type'=>'text'],
            ],
            'data'=>$author,
        ]);
    }

    public function deleteAuthorDestroy(Request $request, $id) {
        $author=apiUser::author($id);
        if ($author===false) return abort(404); //something broken we could add a decent error page here        
        $deleted=apiUser::deleteAuthor($id);
        if ($deleted===false) return abort(403); //something broken we could add a decent error page here        
        return redirect()->route('authors');
    }

    public function viewBook($id) { 
        $book=apiUser::book($id);
        if ($book===false) return abort(404); //something broken we could add a decent error page here        
        return view('crud.view',[
            'title'=>'Book',
            'columns'=>[
                'title'=>['text'=>'Title','type'=>'text'],
                'author'=>['text'=>'Author','type'=>'author'],
                'release_date'=>['text'=>'Release Date','type'=>'date'],
                'description'=>['text'=>'Description','type'=>'text'],
                'isbn'=>['text'=>'ISBN','type'=>'text'],
                'number_of_pages'=>['text'=>'Number of Pages','type'=>'text'],
            ],
            'data'=>$book,
        ]);
    }

    public function newBook(){
        $authors=apiUser::authors();
        return view('newBook',['authors'=>$authors->items]);
    }

    public function newBookStore(newBookRequest $request){
        $request=$request->all();

        $book=apiUser::newBook((object)[
            'title'=>$request['title'],
            'author'=>(object)['id'=>(int)$request['author_id']],
            'release_date'=>$request['release_date'],
            'description'=>$request['description'],
            'isbn'=>$request['isbn'],
            'number_of_pages'=>(int)$request['number_of_pages'],
        ]);
        if ($book===false) return abort(403); //something broken we could add a decent error page here        
        return redirect()->route('viewAuthor',$request['author_id']);
    }

    public function deleteBook($id) {
        $book=apiUser::book($id);
        if ($book===false) return abort(404); //something broken we could add a decent error page here        
        return view('crud.delete',[
            'title'=>'Delete Book - '.$book->title,
            'url'=>route('deleteBookDestroy',$book->id),
            'columns'=>[
                'author'=>['text'=>'Author','type'=>'author'],
                'release_date'=>['text'=>'Release Date','type'=>'date'],
                'description'=>['text'=>'Description','type'=>'text'],
                'isbn'=>['text'=>'ISBN','type'=>'text'],
                'number_of_pages'=>['text'=>'Number of Pages','type'=>'text'],
            ],
            'data'=>$book,
        ]);
    }

    public function deleteBookDestroy(Request $request, $id) {
        $book=apiUser::book($id);
        if ($book===false) return abort(404); //something broken we could add a decent error page here        
        $deleted=apiUser::deleteBook($id);
        if ($deleted===false) return abort(403); //something broken we could add a decent error page here        
        return redirect()->route('viewAuthor',$book->author_id);
    }
}
