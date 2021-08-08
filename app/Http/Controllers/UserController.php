<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class UserController extends Controller
{
    /**
     * @param StoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            User::query()->create($request->validated());

            return response()->json(['created' => true], Response::HTTP_CREATED);
        } catch (Throwable $exception) {

            return response()->json(['created' => false], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @return JsonResponse
     */
    public function getLatest(): JsonResponse
    {
        return response()->json(User::query()
            ->withSum([
                'transactions' => function ($query) {
                    $query->where('type', Transaction::TYPE_DEBIT);
                },
            ], 'amount')
            ->latest('id')
            ->take(10)
            ->get()
            ->toArray());
    }
}
