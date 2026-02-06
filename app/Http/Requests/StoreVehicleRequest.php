<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // La autorización se maneja en middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentYear = date('Y');
        
        return [
            // Información básica
            'marca' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],
            'modelo' => [
                'required',
                'string',
                'min:1',
                'max:100',
            ],
            'anio' => [
                'required',
                'integer',
                'min:1900',
                'max:' . ($currentYear + 1), // Permite vehículos del próximo año
            ],
            'version' => [
                'nullable',
                'string',
                'max:100',
            ],
            
            // Precio y estado
            'precio' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999.99',
            ],
            'moneda' => [
                'required',
                Rule::in(['ARS', 'USD', 'EUR']),
            ],
            'estado' => [
                'required',
                Rule::in(['nuevo', 'usado', 'seminuevo']),
            ],
            
            // Especificaciones técnicas
            'kilometraje' => [
                'nullable',
                'integer',
                'min:0',
                'max:999999',
            ],
            'tipo_combustible' => [
                'nullable',
                Rule::in(['nafta', 'diesel', 'gnc', 'electrico', 'hibrido']),
            ],
            'transmision' => [
                'nullable',
                Rule::in(['manual', 'automatica', 'cvt', 'automatizada']),
            ],
            'tipo_vehiculo' => [
                'nullable',
                Rule::in(['sedan', 'suv', 'pickup', 'coupe', 'hatchback', 'minivan', 'crossover', 'deportivo']),
            ],
            'color' => [
                'nullable',
                'string',
                'max:50',
            ],
            'puertas' => [
                'nullable',
                'integer',
                'min:2',
                'max:5',
            ],
            'cilindrada' => [
                'nullable',
                'string',
                'max:20',
            ],
            'potencia' => [
                'nullable',
                'string',
                'max:20',
            ],
            
            // Descripción y detalles
            'descripcion' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'equipamiento' => [
                'nullable',
                'array',
            ],
            'equipamiento.*' => [
                'string',
                'max:100',
            ],
            
            // Imágenes
            'imagenes' => [
                'nullable',
                'array',
                'max:10', // Máximo 10 imágenes
            ],
            'imagenes.*' => [
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120', // 5MB por imagen
            ],
            'imagen_principal' => [
                'nullable',
                'integer',
                'min:0',
            ],
            
            // Contacto y visibilidad
            'telefono_contacto' => [
                'nullable',
                'string',
                'regex:/^[\+]?[0-9]{10,15}$/',
            ],
            'email_contacto' => [
                'nullable',
                'email:rfc',
            ],
            'destacado' => [
                'nullable',
                'boolean',
            ],
            'disponible' => [
                'nullable',
                'boolean',
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
            // Básicos
            'marca.required' => 'La marca del vehículo es obligatoria.',
            'marca.min' => 'La marca debe tener al menos :min caracteres.',
            'modelo.required' => 'El modelo del vehículo es obligatorio.',
            'anio.required' => 'El año del vehículo es obligatorio.',
            'anio.integer' => 'El año debe ser un número entero.',
            'anio.min' => 'El año no puede ser anterior a :min.',
            'anio.max' => 'El año no puede ser posterior a :max.',
            
            // Precio
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio debe ser mayor a 0.',
            'moneda.required' => 'La moneda es obligatoria.',
            'moneda.in' => 'La moneda seleccionada no es válida.',
            
            // Estado
            'estado.required' => 'El estado del vehículo es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
            
            // Técnicos
            'kilometraje.integer' => 'El kilometraje debe ser un número entero.',
            'kilometraje.min' => 'El kilometraje no puede ser negativo.',
            'tipo_combustible.in' => 'El tipo de combustible seleccionado no es válido.',
            'transmision.in' => 'El tipo de transmisión seleccionado no es válido.',
            'tipo_vehiculo.in' => 'El tipo de vehículo seleccionado no es válido.',
            'puertas.min' => 'El número de puertas debe ser al menos :min.',
            'puertas.max' => 'El número de puertas no puede exceder :max.',
            
            // Descripción
            'descripcion.max' => 'La descripción no puede exceder :max caracteres.',
            
            // Imágenes
            'imagenes.max' => 'No puedes subir más de :max imágenes.',
            'imagenes.*.image' => 'El archivo debe ser una imagen.',
            'imagenes.*.mimes' => 'La imagen debe ser de tipo: :values.',
            'imagenes.*.max' => 'Cada imagen no puede exceder :max KB (5MB).',
            
            // Contacto
            'telefono_contacto.regex' => 'El formato del teléfono no es válido.',
            'email_contacto.email' => 'El email de contacto debe ser válido.',
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
            'anio' => 'año',
            'descripcion' => 'descripción',
            'transmision' => 'transmisión',
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation()
    {
        // Sanitizar inputs para prevenir XSS
        $this->merge([
            'marca' => strip_tags($this->marca),
            'modelo' => strip_tags($this->modelo),
            'descripcion' => strip_tags($this->descripcion, '<p><br><strong><em><ul><li>'),
        ]);
    }
}
