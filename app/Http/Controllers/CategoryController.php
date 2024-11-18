<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\ICategoryRepository;
use App\Services\IOfferService;

class CategoryController extends BaseController {
    
    private $repository;
    private $service;

    public function __construct(ICategoryRepository $repository) {
        $this->repository = $repository; 
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $resp = $this->repository->list($params);
            return response()->json(['error' => false, 'code' => 29,'data' => ['categories' => $resp], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],$e->getCode());
        }
    }
    // Crear una nueva oferta
    public function save(Request $request)
    {
        try {
            $params = $request->all();
            $resp = $this->repository->save($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => ['category' => $resp], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {

            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],$e->getCode());
        }
    }
}
