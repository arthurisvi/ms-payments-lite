<?php

declare(strict_types=1);

namespace Modules\Transaction\Http\Controller;

use App\Controller\AbstractController;
use Modules\Transaction\Service\TransactionService;
use Modules\Transaction\Http\Request\TransactionRequest;

class TransactionController extends AbstractController
{
   public function __construct(
        private TransactionService $transactionService,
    ) {}

    public function transfer(TransactionRequest $request) {
        $data = $request->validated();

        $transactionId = $this->transactionService->performTransaction(
            $data['payer'],
            $data['payee'],
            $data['value']
        );

        if (!$transactionId) {
            return $this->response
            ->withStatus(400)
            ->json([
                'error' => [
                    'code' => 0,
                    'message' => 'Não foi possível realizar a transação.'
                ]
            ], 400);
        }

        return $this->response
            ->withStatus(201)
            ->json([
                'data' => [
                    'id' => $transactionId
                ]
        ], 201);
    }
}