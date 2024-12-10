<?php

declare(strict_types=1);

namespace Modules\Transaction\Http\Request;

use Hyperf\Validation\Request\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric|min:0.1',
            'payer' => 'required|uuid',
            'payee' => 'required|uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'O valor da transferência é obrigatório.',
            'value.numeric' => 'O valor da transferência deve ser um número.',
            'value.min' => 'O valor mínimo para transferência é 0.1.',
            'payer.required' => 'O ID do pagador é obrigatório.',
            'payer.uuid' => 'O ID do pagador deve ser um UUID válido.',
            'payee.required' => 'O ID do recebedor é obrigatório.',
            'payee.uuid' => 'O ID do recebedor deve ser um UUID válido.',
        ];
    }
}
