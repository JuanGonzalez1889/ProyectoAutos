<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Recaptcha;

class StoreAgenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Todos pueden registrar una agencia
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Información de la agencia
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('tenants', 'name'),
                'regex:/^[a-zA-Z0-9\s\-áéíóúÁÉÍÓÚñÑ]+$/', // Solo letras, números, espacios y guiones
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('tenants', 'email'),
                Rule::unique('users', 'email'),
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[\+]?[0-9]{10,15}$/', // Número con o sin código de país
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            
            // Plan de suscripción
            'plan' => [
                'required',
                Rule::in(['basic', 'premium', 'enterprise']),
            ],
            
            // Información del usuario administrador
            'admin_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'admin_password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // Al menos 1 minúscula, 1 mayúscula, 1 número
            ],
            'admin_password_confirmation' => [
                'required',
                'same:admin_password',
            ],
            
            // Legal y términos
            'terms_accepted' => [
                'required',
                'accepted',
            ],
            'privacy_accepted' => [
                'required',
                'accepted',
            ],
            
            // reCAPTCHA
            'g-recaptcha-response' => [
                'required_if:' . app()->environment('production'),
                new Recaptcha(),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Name
            'name.required' => 'El nombre de la agencia es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'name.max' => 'El nombre no puede exceder :max caracteres.',
            'name.unique' => 'Ya existe una agencia con este nombre.',
            'name.regex' => 'El nombre solo puede contener letras, números, espacios y guiones.',
            
            // Email
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.unique' => 'Este email ya está registrado.',
            
            // Phone
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El formato del teléfono no es válido.',
            
            // Plan
            'plan.required' => 'Debes seleccionar un plan.',
            'plan.in' => 'El plan seleccionado no es válido.',
            
            // Admin
            'admin_name.required' => 'El nombre del administrador es obligatorio.',
            'admin_password.required' => 'La contraseña es obligatoria.',
            'admin_password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'admin_password.regex' => 'La contraseña debe contener al menos 1 mayúscula, 1 minúscula y 1 número.',
            'admin_password_confirmation.same' => 'Las contraseñas no coinciden.',
            
            // Legal
            'terms_accepted.required' => 'Debes aceptar los términos y condiciones.',
            'terms_accepted.accepted' => 'Debes aceptar los términos y condiciones.',
            'privacy_accepted.required' => 'Debes aceptar la política de privacidad.',
            'privacy_accepted.accepted' => 'Debes aceptar la política de privacidad.',
            
            // reCAPTCHA
            'g-recaptcha-response.required' => 'Por favor, completa el reCAPTCHA.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre de la agencia',
            'admin_name' => 'nombre del administrador',
            'admin_password' => 'contraseña',
        ];
    }
}
