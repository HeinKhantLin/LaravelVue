<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function __construct(TagRepository $tagRepo){
        $this->tagRepo = $tagRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->tagRepo->getAll();
            return response()->json([
                'data' => $data,
                'msg' => 'Data get successfully.'
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'msg'  => $e->getMessage()
            ],$e->getCode());
        } 
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = $this->tagRepo->createTag($request);

            return response()->json([
                'data' => $data,
                'msg' => 'Data added successfully.'
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'msg'  => $e->getMessage()
            ],$e->getCode());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
