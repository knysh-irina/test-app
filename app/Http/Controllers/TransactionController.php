<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TransactionController extends Controller
{
    /**
     * @param StoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            $user->transactions()->create($request->validated());

            return response()->json(['created' => true], Response::HTTP_CREATED);
        } catch (Throwable $exception) {

            return response()->json(['created' => false], Response::HTTP_BAD_REQUEST);
        }
    }
}
