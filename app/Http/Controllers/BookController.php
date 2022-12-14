<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Requests\photoRequest;
use App\Models\Book;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

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
        $book = $this->book->paginate('10'); 
        // $book = $this->book->find(1); 

        // $arquivo = $_SERVER['HTTP_HOST'] .'/'. $book->book_photo;
        
        // dd($arquivo);

       // TENHO QUE ACESSAR O BOOK_PHOTO EM BOOK E CONCATENAR COM O SERVIDOR E A PORTA
        return response()->json($book, 200);

    }

    public function showEdit($id)

    {

        
            $book = $this->book
                ->with('author')
                ->with('category')
                ->find($id)              

            ;
            return response()->json([

                'data' => $book

            ], 200);


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
    public function bookfilterauthor($id)
    {         
        $id = $this->book        
            ->select()
            ->from('author_book')
            ->whereColumn('author_book.book_id', 'books.id')
            ->orderBy('title', 'asc')     
            ->paginate('6');

           
            

        return response()->json($id , 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, photoRequest $photoRequest)    
    {       
        
             $data = $request->all();         
           
             $bookPhoto = $photoRequest->file('book_photo');           

             try{

                $arquivo = '';

                 if($bookPhoto){
                    if($request->file('book_photo')->isValid()){
                        $extension = $bookPhoto->getClientOriginalExtension();
                        $title = $request->get('title');
                        $arquivo = $bookPhoto->storeAs('bookPhoto', "{$title}" .  "." . "{$extension}" );                         
                    }
                 }
                 $data['book_photo'] = $arquivo;   
                 

                 $book = $this->book->create($data);
              
                if (isset($data['category_id']) && count($data['category_id'])) {

                    $book->category()->sync($data['category_id']);
    
                }    
    
    
                if (isset($data['author_id']) && count($data['author_id'])) {
    
                    $book->author()->sync($data['author_id']);
    
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
    public function update($id, Request $request,  photoRequest $photoRequest )     
    {
         
        $data = $request->all();        
      
        $bookPhoto = $photoRequest->file('book_photo');                     
                   

        try{            
           
            $book = Book::findorfail($id);
                            
            $book->fill($request->except('book_photo'));
            
            $arquivo = '';
           

            if($file = $request->hasFile('book_photo')) { 
        
                $file = $request->file('book_photo') ;     
                $fileName = $file->getClientOriginalName() ;  
                $destinationPath = public_path().'/img/book/' ;    
                $file->move($destinationPath,$fileName);   
                $book->book_photo = $fileName ;
      
                
           } 
                $book->save();         

                $data['book_photo'] = $arquivo; 
                      
                    
                    if (isset($data['category_id']) && count($data['category_id'])) {

                       $ids = json_decode(json_encode($data['category_id']), true);
                         $book->category()->sync($ids);    

                        //  $book->category()->sync([2,3]);                      
        
                     }   
        
        
                    if (isset($data['author_id']) && count($data['author_id'])) {
        
                        $book->author()->sync($data['author_id']);
        
                    }


            // $bookimage = Book::find($id); 
            // // This is like $request->all except it doesn't set the image 
            // // You "fill" the new data so that it doesn't call save yet. 
        
            // $bookimage->fill($request->except('book_photo'));
            //  // If there is a file, we set the book_photo 
            //  if($file = $request->hasFile('book_photo')) { 
        
            //       $file = $request->file('book_photo') ;     
            //       $fileName = $file->getClientOriginalName() ;  
            //       $destinationPath = public_path().'/img/book/' ;    
            //       $file->move($destinationPath,$fileName);   
            //       $bookimage->image = $fileName ;
        
                  
            //  } 
            //       // Then we just save 
            //       $bookimage->save(); 
            //       dd($bookimage);     
             
        

                
           

            

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
