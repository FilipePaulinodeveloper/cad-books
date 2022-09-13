<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoAuthorRequest;
use App\Http\Requests\photoRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{   
    private $author;
    public function __construct(Author $author)
    {
       $this->author = $author;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $author = $this->author->paginate('6');
        return response()->json($author, 200);
    }

    public function authorfiltername($name)
    {         
        $name = $this->author        
            ->select()
            ->where('name', 'like' , $name.'%' )            
            ->orderBy('name', 'asc')     
            ->paginate('6');

        return response()->json($name , 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request, PhotoAuthorRequest $photoAuthorRequest )
    {      
        $data = $request->all();      

        $authorPhoto = $photoAuthorRequest->file('author_photo');   

        try{
            $arquivo = '';

            if($authorPhoto){
                if($request->file('author_photo')->isValid()){
                    $extension = $authorPhoto->getClientOriginalExtension();
                    $name = $request->get('name');
                   $arquivo =  $authorPhoto->storeAs('authorPhoto', "{$name}" .  "." . "{$extension}" ); 

                }
             } 
            
             $data['author_photo'] = $arquivo;

            $this->author->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'O Author foi cadastrado com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }

        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            $author = $this->author->findorfail($id);

            return response()->json([
                'data' => [                    
                    'data' => $author
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, PhotoAuthorRequest $photoAuthorRequest)    
    {
              $data = $request->all();
              $authorPhoto = $photoAuthorRequest->file('author_photo');   

        try{
            
            $arquivo = '';
           
            if($authorPhoto){
                if($request->file('author_photo')->isValid()){
                    $extension = $authorPhoto->getClientOriginalExtension();
                    $name = $request->get('name');
                   $arquivo = $authorPhoto->storeAs('authorPhoto', "{$name}" .  "." . "{$extension}" ); 

                }
             }   
             
             $data['author_photo'] = $arquivo;

             $this->author->findorfail($id)->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'O Author foi Atualizado com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            $this->author->findorfail($id)->delete();

            return response()->json([
                'data' => [
                    'msg' => 'O Author foi removido com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function books($id)
    {
        try{            
           // $author = $this->author->findorfail($id);
           $author = $this->author->with("books")->findorfail($id);

            return response()->json([
                'data' => $author
            ], 200);
            
            
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
   
}
