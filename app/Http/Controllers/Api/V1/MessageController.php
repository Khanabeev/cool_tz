<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validator = $this->validateMessage($request->only('content'));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Message::create($request->only('content'));

        return response()->json(['success' => 'You Email has been send successfully']);
    }

    private function validateMessage($request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'content' => ['required', 'string', 'max:1000', 'min:3']
        ];
        $message = [
            'content.required' => 'Content is required',
            'content.max' => 'Max characters: 1000',
            'content.min' => 'Min characters: 3',
            'content.string' => 'Content must be a string',
        ];

        return Validator::make($request, $rules, $message);
    }
}
