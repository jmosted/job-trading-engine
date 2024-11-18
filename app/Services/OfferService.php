<?php

namespace App\Services;
use App\Services\IOfferService;
use App\Repository\IOfferRepository;
use App\Repository\IOfferRequestRepository;
use App\Repository\IOfferAssignationRepository;
use App\Models\Offer;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Constants\Constant;

class OfferService implements IOfferService {
    private $repository;
    private $repoRequest;
    private $repoAssignation;


    public function __construct(IOfferRepository $repo, IOfferRequestRepository $repoRequest, IOfferAssignationRepository $repoAssignation) {
        $this->repository = $repo;
        $this->repoRequest = $repoRequest;
        $this->repoAssignation = $repoAssignation;
    }

    public function list($params) {
        return $this->repository->list($params);
    }

    public function save($payload) {
        try {
            DB::beginTransaction();
            $offer = $this->repository->save($payload);
            DB::commit();
            return $offer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function requestOffer($data) {
        try
        {
            DB::beginTransaction();
            if (!array_key_exists('offer_id', $data)) {
                throw new \Exception("Falta el id de la oferta", 400);
            }
            if (!array_key_exists('user_id', $data)) {
                throw new \Exception("Falta el id del usuario", 400);
            }
            $offerRequest = $this->repoRequest->getLastOfferRequest($data['offer_id'], $data['user_id']);
            if($offerRequest) {
                throw new \Exception("La oferta ya ha sido solicitada", 201);
            }
            $requestOffer = $this->repoRequest->save($data);
            DB::commit();
            return $requestOffer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    

    public function assignOffer($data) {
        try
        {
            DB::beginTransaction();
            if (!array_key_exists('offer_id', $data)) {
                throw new \Exception("Falta el id de la oferta", 400);
            }
            if (!array_key_exists('user_id', $data)) {
                throw new \Exception("Falta el id del usuario", 400);
            }
            $offerAssigned = $this->repoAssignation->getLastOfferAssignation($data['offer_id'], $data['user_id']);
            if($offerAssigned) {
                throw new \Exception("La oferta ya ha sido asignada", 201);
            }
            //Actualizar a estado de rechazado
            $this->repoRequest->markAsUnnasignedOtherRequests($data['offer_id'], $data['user_id']);
            $assignOffer = $this->repoAssignation->save($data);
            DB::commit();
            return $assignOffer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function rejectRequestOffer($data) {
        try
        {
            DB::beginTransaction();
            if (!array_key_exists('id', $data)) {
                throw new \Exception("Falta el id de la oferta", 400);
            }
            $offerRequest = $this->repoRequest->findById($data['id']);
            if(!$offerRequest) {
                throw new \Exception("La solicitud no existe", 400);
            }
            $offerRequest::update(['status'=>Constant::REJECTED_STATUS]);
            $this->repoRequest->markAsCratedOtherRequests($offerRequest['offer_id'], $offerRequest['user_id']);
            //Actualizar a estado de rechazado
            $offerRequest['status'] = Constant::REJECTED_STATUS;
            DB::commit();
            return $offerRequest;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function rejectAssignOffer($data) {
        try
        {
            DB::beginTransaction();
            if (!array_key_exists('id', $data)) {
                throw new \Exception("Falta el id de la oferta", 400);
            }
            $offerAssign = $this->repoAssignation->findById($data['id']);
            if(!$offerAssign) {
                throw new \Exception("La solicitud no existe", 400);
            }
            $offerAssign::update(['status'=>Constant::REJECTED_STATUS]);
            $this->repoRequest->markAsCratedOtherRequests($offerAssign['offer_id'], $offerAssign['user_id']);
            //Actualizar a estado de rechazado
            $offerAssign['status'] = Constant::REJECTED_STATUS;
            DB::commit();
            return $offerAssign;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function destroyRequestOffer($data) {
        $this->repoRequest->destroy($data);
    }

    public function destroyAssignOffer($data) {
        $this->repoAssignation->destroy($data);
    }
    public function destroy($id) {
        $this->repository->destroy($id);
    }
}   