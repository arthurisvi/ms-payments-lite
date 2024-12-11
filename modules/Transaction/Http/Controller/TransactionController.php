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

    public function transfer(TransactionRequest $request)
    {
        $data = $request->validated();

        try {
            $this->transactionService->performTransaction(
                $data['payer'],
                $data['payee'],
                $data['value']
            );

            return $this->response->withStatus(204);
        } catch (\Exception $e) {
            return $this->response->json(['message' => $e->getMessage()], 400);
        }
    }
}