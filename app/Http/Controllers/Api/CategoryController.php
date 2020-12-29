<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryImageUploadRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        try{
            $data = $this->categoryRepo->getAll();
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

    public function store(CategoryCreateRequest $request){
        try {

            $data = $this->categoryRepo->createCategory($request);

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

    public function upload(CategoryImageUploadRequest $request){
        $fileName = time(). '.' . $request->file->extension();
        $request->file->move(public_path('uploads/category'), $fileName);
        return $fileName;
    }

    public function deleteImage(Request $request){
        $fileName = $request->iconImage;
        $this->deleteImageFromServer($fileName);
        return 'success';
    }

    public function deleteImageFromServer($fileName){
        $filePath = public_path() . '/uploads/category/'. $fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }
}
