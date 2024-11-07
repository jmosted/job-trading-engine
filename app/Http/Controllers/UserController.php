<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\IUserRepository;
use \Illuminate\Support\Facades\Log;


class UserController extends BaseController {

    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository=$repository;
    }
    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $users = $this->repository->list($params);
            return response()->json(['error' => false, 'code' => 29,'data' => ['users' => $users], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    public function user(Request $request, $id) {
        try {
            $params = $request->all();
            Log::info($id);
            $user = $this->repository->user($id);
            return response()->json(['error' => false, 'code' => 29,'data' => ['users' => $user], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    public function update(Request $request) {
        try {
            $params = $request->all();
            $user = $this->repository->save($params);
            return response()->json(['error' => false, 'code' => 29,'data' => ['user' => $user], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    public function destroy(Request $request) {
        try {
            $params = $request->all();
            $user = $this->repository->destroy($params);
            return response()->json(['error' => false, 'code' => 29,'data' => ['user' => $user], 'type'=>'1','msg' => 'Procesado correctamente']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }
}
