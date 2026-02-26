<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletTransaction\FilterWalletTransactionRequest;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use src\WalletTransactionContext\Application\DTOs\FilterWalletTransactions;
use src\WalletTransactionContext\Application\Queries\GetAllWalletTransactionsQueryInterface;
use src\WalletTransactionContext\Application\Queries\GetWalletTransactionQueryInerface;

class WalletTransactionController extends Controller
{
    public function __construct(
        private GetAllWalletTransactionsQueryInterface $getAllWalletTransactionsQueryInterface,
        private GetWalletTransactionQueryInerface $getWalletTransactionQueryInerface,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(FilterWalletTransactionRequest $request)
    {
        $data = $request->validated();
        $result = $this->getAllWalletTransactionsQueryInterface->execute(
            new FilterWalletTransactions(
                $data['wallet_id'] ?? null,
                $data['min_amount'] ?? null,
                $data['max_amount'] ?? null,
                $data['type'] ?? null

            )
        );
        return self::success($result);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return self::success(null , 'not implemented yet!' , 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $walletTransactionId)
    {
        $walletTransaction = $this->getWalletTransactionQueryInerface->execute($walletTransactionId);
        return self::success($walletTransaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WalletTransaction $walletTransaction)
    {
        return self::success(null , 'not implemented yet!',501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WalletTransaction $walletTransaction)
    {
        return self::success(null , 'not implemented yet!' , 501);
    }
}
