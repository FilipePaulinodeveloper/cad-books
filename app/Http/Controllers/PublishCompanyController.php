<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoPublishCompanyRequest;
use App\Models\PublishingCompany;
use Illuminate\Http\Request;

class PublishCompanyController extends Controller
{   
    private $publishing_company;
    public function __construct(PublishingCompany $publishing_company)
    {
       $this->publishing_company = $publishing_company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishing_company = $this->publishing_company->paginate('6');
        return response()->json($publishing_company, 200);
    }

    public function publishcompanyfiltername($name)
    {         
        $name = $this->publishing_company        
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
    public function store( Request $request, PhotoPublishCompanyRequest $photoPublishCompanyRequest)
    {   
       $data = $request->all();
       $publishingCompanyPhoto = $photoPublishCompanyRequest->file('publishing_company_photo');


       try{

        $arquivo = '';
        
         if($publishingCompanyPhoto){
            if($request->file('publishing_company_photo')->isValid()){
                $extension = $publishingCompanyPhoto->getClientOriginalExtension();
                $name = $request->get('name');
              $arquivo = $publishingCompanyPhoto->storeAs('publishingCompanyPhoto', "{$name}" .  "." . "{$extension}" ); 

            }
         }   

         $data['publishing_company_photo'] = $arquivo;
         
         $this->publishing_company->create($data);

        return response()->json([
            'data' => [
                'msg' => 'A editora foi cadastrada com sucesso'
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

            $publishing_company = $this->publishing_company->findorfail($id);

            return response()->json([
                'data' => [                    
                    'data' => $publishing_company
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
    public function update($id, Request $request, PhotoPublishCompanyRequest $photoPublishCompanyRequest)    
    {
            $data = $request->all();
            $publishingCompanyPhoto = $photoPublishCompanyRequest->file('publishing_company_photo');

        try{            
          $arquivo = '';

          if($publishingCompanyPhoto){
            if($request->file('publishing_company_photo')->isValid()){
                $extension = $publishingCompanyPhoto->getClientOriginalExtension();
                $name = $request->get('name');
                $arquivo =  $publishingCompanyPhoto->storeAs('publishingCompanyPhoto', "{$name}" .  "." . "{$extension}" ); 

            }
         }    

         $data['publishing_company_photo'] = $arquivo;

         $this->publishing_company->findorfail($id)->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'A editora foi Atualizada com sucesso'
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

            
            $this->publishing_company->findorfail($id)->delete();

            return response()->json([
                'data' => [
                    'msg' => 'A editora foi deletada com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function books($id)
    {
        try{            
           $publishing_company = $this->publishing_company->findorfail($id);

            return response()->json([
                'data' => $publishing_company->books
            ], 200);
            

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
