<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class apiUser extends Model
{
    use HasFactory;
    const sessionKey='apiUser';
    const apiUrl='https://symfony-skeleton.q-tests.com/v2/';
    const cacheTimeout=60*8; //8 minutes
    public static function check() {
        if (is_object(session(self::sessionKey))) {
            return true;
        }
        return false;
    }

    public static function user() {
        if (self::check()) {
            $data=session(self::sessionKey);
            return $data->user;
        }
        return false;
    }

    public static function login($email,$pass) {
        self::logout();
        $response=Http::post(self::apiUrl.'token',[
            'email'=>$email,
            'password'=>$pass
        ]);
        
        if ($response->successful()) {
            $responseData=$response->object();
            session([self::sessionKey=>$responseData]);
            return (object)[
                'status'=>true,
                'user'=>$responseData->user
            ];
        }else {
            return (object)[
                'status'=>false,
                //'errors'=>$response->object()->errors
                'errors'=>[
                    'email'=>'Email or password is incorrect'
                ]
            ];
        }
    }

    public static function authors() {
        if (!self::check()) return false;
        $cached=Cache::get('authors');
        if ($cached!=null) return $cached;
        
        $response=self::request('authors','get',[
            'orderBy'=>'id',
            'direction'=>'asc',
            'limit'=>100,
            'page'=>1,
        ]);
        if ($response->successful()) {
            Cache::put('authors',$response->object(),self::cacheTimeout);
            return $response->object();
        }
        return false;
    }

    public static function author($id) {
        $response=self::request('authors/'.$id,'get');
        if ($response->successful()) {
            return $response->object();
        }
        return false;
    }

    public static function deleteAuthor($id) {
        $response=self::request('authors/'.$id,'delete');
        if ($response->successful()) {
            return true;
        }
        return false;
    }

    public static function book($id) {
        if (!self::check()) return false;
        $cached=Cache::get('book_'.$id);
        if ($cached!=null) return $cached;
        $response=self::request('books/'.$id,'get');

        if ($response->successful()) {
            $book=$response->object();
            $author=apiUser::author($book->author->id);
            $book->author=$author->first_name.' '.$author->last_name;
            $book->author_id=$author->id;
            Cache::put('book_'.$id,$book,self::cacheTimeout);
            return $book;
        }
        return false;
    }

    public static function newBook($data) {
        $data->release_date=date('c',strtotime($data->release_date));
        $data->format='string';
        $response=self::request('books','post',$data);
        
        if ($response->successful()) {
            return true;
        }
        return false;
    }

    public static function deleteBook($id) {
        $response=self::request('books/'.$id,'delete');
        echo '<pre>';print_r($response);exit;
        if ($response->successful()) {
            var_dump($response->object());exit;
            return true;
        }
        return false;
    }

    public static function logout() {
        session()->forget(self::sessionKey);
    }

    public static function token() {
        if (self::check()) {
            $data=session(self::sessionKey);
            return $data->token_key;
        }
        return false;
    }

    public static function request($url,$method,$data=false) {
        switch ($method) {
            case 'get':
                $response=Http::withToken(self::token())->get(self::apiUrl.$url);
                break;
            case 'post':
                $response=Http::withToken(self::token())->post(self::apiUrl.$url,$data);
                break;
            case 'put':
                $response=Http::withToken(self::token())->put(self::apiUrl.$url,$data);
                break;
            case 'delete':
                $response=Http::withToken(self::token())->delete(self::apiUrl.$url);
                break;
            default:
                $response=Http::withToken(self::token())->get(self::apiUrl.$url);
                break;
        }
        return $response;
    }
}
