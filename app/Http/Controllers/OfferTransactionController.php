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
use App\Services\IOfferTransactionService;

class OfferTransactionController extends BaseController {
    
    private $repository;
    private $service;
    private $offerIRepository;
    private $offerAssignationRepository;
    private $offerRequestRepository;
    private $offerTransactionService;
    public function __construct(IOfferRepository $repository, IOfferService $service, IOfferImageRepository $offerImageRepository, IOfferAssignationRepository $offerAssignationRepository, IOfferRequestRepository $offerRequestRepository, IOfferTransactionService $offerTransactionService) {
        $this->repository = $repository; 
        $this->service = $service;
        $this->offerIRepository = $offerImageRepository;
        $this->offerAssignationRepository = $offerAssignationRepository;
        $this->offerRequestRepository = $offerRequestRepository;
        $this->offerTransactionService = $offerTransactionService;
    }

    public function requestOffer(Request $request)
    {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->requestOffer($params);        
            return response()->json(['error' => false, 'code' => 29,'data' =>  $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    public function assignOffer(Request $request)
    {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->assignOffer($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    public function rejectRequestOffer(Request $request)
    {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->rejectRequestOffer($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function rejectAssignOffer(Request $request) {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->rejectAssignOffer($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function listRequestOffer(Request $request) {
        try {
            $params = $request->all();
            $resp = $this->offerRequestRepository->list($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function listAssignOffer(Request $request) {
        try {
            $params = $request->all();
            $resp = $this->offerAssignationRepository->list($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function deleteRequestOffer(Request $request, $id) {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->destroyRequestOffer($id);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function deleteAssignOffer(Request $request, $id) {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->destroyAssignOffer($id);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function finalizeOffer(Request $request) {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->finalizeOffer($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }

    function qualifyOffer(Request $request) {
        try {
            $params = $request->all();
            $resp = $this->offerTransactionService->qualifyOffer($params);        
            return response()->json(['error' => false, 'code' => 29,'data' => $resp, 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => false, 'code' => 10,'data' => null, 'type'=>'1','msg' => $e->getMessage()],500);
        }
    }
}