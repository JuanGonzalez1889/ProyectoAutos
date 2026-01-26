<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Validate the given request with the given rules.
     */
    protected function validate(\Illuminate\Http\Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = app('validator')->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
