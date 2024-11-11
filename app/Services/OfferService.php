<?php

namespace App\Services;
use App\Services\IOfferService;
use App\Repository\IOfferRepository;
use App\Repository\IOfferRequestRepository;
use App\Repository\IOfferAssignationRepository;
use App\Utils\Constant;
use App\Models\Offer;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

            DB::commit();
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
                throw new \Exception("Falta el id de la oferta", 500);
            }
            if (!array_key_exists('user_id', $data)) {
                throw new \Exception("Falta el id del usuario", 500);
            }
            $offerRequest = $this->repoRequest->getLastOfferRequest($data['offer_id'], $data['user_id']);
            if($offerRequest) {
                throw new \Exception("La oferta ya ha sido solicitada", 500);
            }
            $this->repoRequest->save($data);
            DB::commit();
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
                throw new \Exception("Falta el id de la oferta", 500);
            }
            if (!array_key_exists('user_id', $data)) {
                throw new \Exception("Falta el id del usuario", 500);
            }
            $offerAssigned = $this->repoAssignation->getLastOfferAssignation($data['offer_id'], $data['user_id']);
            if($offerAssigned) {
                throw new \Exception("La oferta ya ha sido asignada", 500);
            }
            $this->repoAssignation->save($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($id) {
        $this->repository->destroy($id);
    }
}   