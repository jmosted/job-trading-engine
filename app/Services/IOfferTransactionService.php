<?php
namespace App\Services;

interface IOfferTransactionService{
    public function requestOffer($id);
    public function assignOffer($id);
    public function rejectRequestOffer($id);
    public function rejectAssignOffer($id);
    public function destroyRequestOffer($id);
    public function destroyAssignOffer($id);
    public function finalizeOffer($id);
    public function qualifyOffer($id);
}