<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   
    private $category;
    public function __construct(Category $category)
    {
       $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->category->paginate('6');
        return response()->json($category, 200);
    }

    public function categoryfiltername($name)
    {         
        $name = $this->category        
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
    public function store( Request $request)
    {   
       $data = $request->all();
       $categoryPhoto = $request->file('category_photo');

       try{
        $this->category->create($data);

        if($categoryPhoto){
            $categoryPhoto->store('categoryPhoto' , 'public');                                                      
        }else {
            return response()->json(['error' => 'Formato de arquivo não é permitido']);
        }
        return response()->json([
            'data' => [
                'msg' => 'A categoria foi cadastrada com sucesso'
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

            $category = $this->category->findorfail($id);

            return response()->json([
                'data' => [                    
                    'data' => $category
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
              $categoryPhoto = $request->file('category_photo');


        try{

            
            $this->category->findorfail($id)->update($data);
            if($categoryPhoto){
                $categoryPhoto->store('categoryPhoto' , 'public');                           
               
            }
            return response()->json([
                'data' => [
                    'msg' => 'A categoria foi Atualizada com sucesso'
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

            
            $this->category->findorfail($id)->delete();

            return response()->json([
                'data' => [
                    'msg' => 'A categoria foi deletada com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function books($id)
    {
        try{            
           $category = $this->category->findorfail($id);

            return response()->json([
                'data' => $category->books
            ], 200);
            

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

}