<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\CreateUserService;
use App\Services\DeleteUserService;
use App\Services\RetrieveUserService;
use App\Services\UpdateUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $createUserService = new CreateUserService();
        $result = $createUserService->execute($request->all());
        return response()->json($result, 201);
    }

    public function retrieveUser(Request $request, $id)
    {
        $retrieveUserService = new RetrieveUserService();
        $result = $retrieveUserService->execute($id);
        return response()->json($result, 200);
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        $validatedData = $request->validated();

        $updateUserService = new UpdateUserService();
        $result = $updateUserService->execute($validatedData, $id);
        return response()->json($result, 201);
    }


    public function deleteUser(Request $request, $id)
    {
        $retrieveUserService = new DeleteUserService();
        $retrieveUserService->delete($id);

        return response()->json([], 204);
    }
}
