<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\FilterGetAllWalletsRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;
use src\WalletContext\Application\DTOs\WalletFilter;
use src\WalletContext\Application\Queries\GetAllWalletsQueryInterface;
use src\WalletContext\Application\Queries\GetWalletDetailsQueryInterface;

class WalletController extends Controller
{
    public function __construct(
        private GetAllWalletsQueryInterface $getAllWalletsQuery,
        private GetWalletDetailsQueryInterface $getWalletDetailsQuery
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(FilterGetAllWalletsRequest $request)
    {
        $data = $this->getAllWalletsQuery->execute(
            new WalletFilter(
                $request->validated()['min_cost'] ?? null,
                $request->validated()['max_cost'] ?? null,
            )
        );
        return self::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return self::success(null , 'Not implemented yet', 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $walletId)
    {
        $wallet = $this->getWalletDetailsQuery->execute($walletId);
        return self::success($wallet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        return self::success(null , 'Not implemented yet', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        return self::success(null , 'Not implemented yet', 501);
    }
}
