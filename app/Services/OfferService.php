<?php

namespace App\Services;
use App\Services\IOfferService;
use App\Repository\IOfferRepository;
use App\Utils\Constant;
use App\Models\Offer;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OfferService implements IOfferService {
    private $repository;
    private $trackerRepo;

    private $dropletRepo;

    public function __construct(IOfferRepository $repo) {
        $this->repository = $repo;

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

    public function destroy($id) {
        $this->repository->destroy($id);
    }
}