<?php
namespace App\Interfaces;

use Carbon\Carbon;
use DateTime;

interface DateTimeProvider {
    public function now(): DateTime;
    public function today() : Carbon;
}