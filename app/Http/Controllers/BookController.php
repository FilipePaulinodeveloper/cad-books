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
    public function index()
    {
        
        $book = $this->book->paginate('6');
        return response()->json($book, 200);

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

        try{

            $book = $this->book->create($data);

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

        try{

            // $book = $this->book->findorfail($id);
            // $book->update($data);

            $this->book->findorfail($id)->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'O livro foi Atualizado com sucesso'
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
                    'msg' => 'Livro foi deletado com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
