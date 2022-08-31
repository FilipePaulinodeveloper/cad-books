<?php

namespace App\Http\Controllers;

use App\Models\PublishingCompany;
use Illuminate\Http\Request;

class PublishCompanyController extends Controller
{   
    private $publish_company;
    public function __construct(PublishingCompany $publish_company)
    {
       $this->publish_company = $publish_company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publish_company = $this->publish_company->paginate('6');
        return response()->json($publish_company, 200);
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

        $publish_company = $this->publish_company->create($data);

        return response()->json([
            'data' => [
                'msg' => 'A editora foi cadastrado com sucesso'
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

            $publish_company = $this->publish_company->findorfail($id);

            return response()->json([
                'data' => [                    
                    'data' => $publish_company
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

            
            $this->publish_company->findorfail($id)->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'A editora foi Atualizado com sucesso'
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

            
            $this->publish_company->findorfail($id)->delete();

            return response()->json([
                'data' => [
                    'msg' => 'A editora foi deletada com sucesso'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
