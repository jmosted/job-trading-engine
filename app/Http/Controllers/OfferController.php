<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\IOfferRepository;
use App\Repository\IOfferImageRepository;
use App\Repository\IOfferAssignationRepository;
use App\Repository\IOfferRequestRepository;
use App\Services\IOfferService;

class OfferController extends BaseController {
    
    private $repository;
    private $service;
    private $offerIRepository;
    private $offerAssignationRepository;
    private $offerRequestRepository;

    public function __construct(IOfferRepository $repository, IOfferService $service, IOfferImageRepository $offerImageRepository, IOfferAssignationRepository $offerAssignationRepository, IOfferRequestRepository $offerRequestRepository) {
        $this->repository = $repository; 
        $this->service = $service;
        $this->offerIRepository = $offerImageRepository;
        $this->offerAssignationRepository = $offerAssignationRepository;
        $this->offerRequestRepository = $offerRequestRepository;
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $offers = $this->repository->list($params);
            return response()->json(['error' => false, 'code' => 29,'data' => ['offers' => $offers], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    // Mostrar una oferta específica por ID
    public function offer(Request $request,$id)
    {
        try {
            $params = $request->all();
            $user = $this->repository->offer($id);
            return response()->json(['error' => false, 'code' => 29,'data' => ['offer' => $user], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    // Crear una nueva oferta
    public function save(Request $request)
    {
        try {
            $params = $request->all();
            $resp = $this->service->save($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => ['offer' => $resp], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    // Eliminar una oferta
    public function remove(Request $request)
    {
        try {
            $params = $request->query();
            $resp = $this->repository->destroy($params['id']);
            return response()->json($resp);
            
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function getByUser(Request $request)
    {
        // Aquí eliminarías la oferta con el ID especificado
        return response()->json(['msg' => 'Ofertas']);
    }

    function getImageByOfferId(Request $request, $offer) {
        try
        {
            $params = $request->all();
            $offer_images = $this->offerIRepository->getByOfferId($offer);
            return response()->json(['error' => false, 'code' => 29,'data' => ['offer_images' => $offer_images], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        } 
    }
}

//0 - delete 1- active 2-assigned