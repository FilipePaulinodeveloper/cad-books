<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $book;

    public function __construct(Book $book)
    {   
       $this->book = $book;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $book = $this->book->paginate('6');            
      
        return response()->json($book, 200);

    }

    public function bookfiltertitle($title)
    {         
        $title = $this->book        
            ->select()
            ->where('title', 'like' , $title.'%' )            
            ->orderBy('title', 'asc')     
            ->paginate('6');

        return response()->json($title , 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)    
    {      
             $data = $request->all();
             $author = $request->get('author_id');
             $category = $request->get('category_id');

             $bookPhoto = $request->file('book_photo');

             try{

                 $book = $this->book->create($data);
                 $book->author()->sync([$author]);
                 $book->category()->sync([$category]);

                 if($bookPhoto){
                     $bookPhoto->store('bookPhoto' , 'public');                               
                    
                 }

                 return response()->json([
                     'data' => [
                         'msg' => 'O livro foi cadastrado com sucesso'
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

            $book = $this->book->findorfail($id);

            return response()->json([
                'data' => [                    
                    'data' => $book
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
    public function update($id, Request $request)    
    {
            $data = $request->all();
            $author = $request->get('author_id');           
            $category = $request->get('category_id');

            $bookPhoto = $request->file('book_photo');
            

        try{

            
            $book = $this->book->findorfail($id);
            $book->update($data);            
            
            $book->author()->sync([$author]);            
            $book->category()->sync([$category]);

            if($bookPhoto){
                $bookPhoto->store('Cover' , 'public');                                
                
            }

            return response()->json([
                'data' => [
                    'msg' => 'Livro foi Atualizada com sucesso'
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
            $this->book->findorfail($id)->delete();

            return response()->json([
                'data' => [
                    'msg' => ' o livro foi deletado com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }        
    }    
}
