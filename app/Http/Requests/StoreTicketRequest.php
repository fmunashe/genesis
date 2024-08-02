<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreTicketRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'banner' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'ticket_type_id' => 'required',
            'eventName' => 'required',
            'eventVenue' => 'required',
            'price' => 'required',
            'ageRestriction' => 'required',
            'eventDate' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'entrance' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Ops! Some errors occurred',
            'errors' => $validator->errors()->getMessages()
        ]);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
