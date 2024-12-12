<?php

namespace App\Services;
use App\Services\IOfferTransactionService;
use App\Repository\IOfferRepository;
use App\Repository\IOfferRequestRepository;
use App\Repository\IOfferAssignationRepository;
use App\Models\Offer;
use App\Models\User;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Constants\Constant;
use App\Repository\IUserRepository;

class OfferTransactionService implements IOfferTransactionService {
    private $repository;
    private $repoRequest;
    private $repoAssignation;
    private $repoUser;
    private $mailService;


    public function __construct(
        IOfferRepository $repo, IOfferRequestRepository $repoRequest, IOfferAssignationRepository $repoAssignation, 
        IUserRepository $repoUser,IMailService $mailService
    ) {
        $this->repository = $repo;
        $this->repoRequest = $repoRequest;
        $this->repoAssignation = $repoAssignation;
        $this->repoUser = $repoUser;
        $this->mailService=$mailService;
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

            $offer = $this->repository->findById($data['offer_id']);
            if(!$offer) {
                throw new \Exception("La oferta no existe", 400);
            }

            $offerRequest = $this->repoRequest->getLastOfferRequest($data['offer_id'], $data['user_id']);
            if($offerRequest) {
                throw new \Exception("La oferta ya ha sido solicitada", 201);
            }
            
            $user = $this->repoUser->user($offer->user_id);
            $emailContent = [
                'user'=> $user,
                'offer'=>$offer
            ];
            $this->mailService->sendMailOfferRequest($user->email,(Object)$emailContent);
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

            $offer = $this->repository->findById($data['offer_id']);
            if(!$offer) {
                throw new \Exception("La oferta no existe", 400);
            }

            $offerAssigned = $this->repoAssignation->getLastOfferAssignation($data['offer_id'], $data['user_id']);
            if($offerAssigned) {
                throw new \Exception("La oferta ya ha sido asignada", 201);
            }
            //Actualizar a estado de rechazado
            $this->repoRequest->markAsUnnasignedOtherRequests($data['offer_id'], $data['user_id']);
            $assignOffer = $this->repoAssignation->save($data);

            $user = $this->repoUser->user($data['user_id']);
            $emailContent = [
                'user'=> $user,
                'offer'=>$offer
            ];
            $this->mailService->sendMailOfferaAssignation($user->email, (Object)$emailContent);
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

    function finalizeOffer($data) {
        try
        {
            DB::beginTransaction();
            if (!array_key_exists('offer_id', $data)) {
                throw new \Exception("Falta el id de la oferta", 400);
            }
            Log::info($data['offer_id']);
            $offer = $this->repository->findById($data['offer_id']);
            if(!$offer) {
                throw new \Exception("La oferta no existe", 400);
            }
            //return $offer;
            Log::info($offer);
            $offer->status = Constant::COMPLETED_STATUS;
            $offer->update();
            $offer_assingnation = $this->repoAssignation->findByOfferId($data['offer_id']);
            Log::info($offer_assingnation);
            if(!$offer_assingnation) {
                throw new \Exception("Error al intentar finalizar la oferta", 400);
            }
            $offer_assingnation->status= Constant::COMPLETED_STATUS;
            $offer_assingnation->update();
            $offer_requests = $this->repoRequest->findByOfferId($data['offer_id']);
            foreach ($offer_requests as $offer_request) {
                if ($offer_request->status==Constant::REJECTED_STATUS || $offer_request->status==Constant::DELETED_STATUS) {
                    continue;
                }
                $offer_request->status = $offer_request->user_id==$offer_assingnation['user_id']?Constant::COMPLETED_STATUS:Constant::REJECTED_STATUS;
                $offer_request->save();
            }
            DB::commit();
            return $offer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    function qualifyOffer($data) {
        try
        {
            DB::beginTransaction();
            if (!array_key_exists('offer_id', $data)) {
                throw new \Exception("Falta el id de la oferta", 500);
            }
            if (!array_key_exists('rating', $data)) {
                throw new \Exception("Falta la calificación de la oferta", 500);
            }
            $offer = $this->repository->findById($data['offer_id']);
            if(!$offer) {
                throw new \Exception("La oferta no existe", 500);
            }
            if($offer->status != Constant::COMPLETED_STATUS) {
                throw new \Exception("La oferta aun no está finalizada", 500);
            }
            $offer->rating = $data['rating'];
            Log::info($offer);
            $offer->update();
            $offer_assingnation = $this->repoAssignation->findByOfferId($data['offer_id']);
            if(!$offer_assingnation) {
                throw new \Exception("Error al intentar calificar la oferta", 500);
            }
            $user_assigned = $offer_assingnation->user_id;
            $user = $this->repoUser->user($user_assigned);
            $user_rating = $this->getUserQualification($user_assigned);
            $user->rating = $user_rating;
            $user->update();
            DB::commit();
            return $offer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getUserQualification($user_id) {
        $offers_completed = $this->repository->getCompleted($user_id);
        if (count(value: $offers_completed) == 0) {
            return null;
        }
        $qualification = 0.0;
        foreach ($offers_completed as $offer) {
            $qualification += $offer['rating'];
        }
        $total_rating = $qualification / count($offers_completed);
        return $total_rating;
    }
}   