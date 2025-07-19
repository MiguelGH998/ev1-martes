<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Mensajes personalizados para esta validación
    public $messages = [
        'username.unique' => 'Este nombre de usuario (email) ya está en uso. Por favor, elige otro.',
        'username.required' => 'El nombre de usuario (email) es requerido.',
        'username.min' => 'El nombre de usuario (email) debe tener al menos 3 caracteres.',
        'username.max' => 'El nombre de usuario (email) no debe exceder los 255 caracteres.',
        'username.email' => 'El nombre de usuario (email) debe ser un correo electrónico válido.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password.max' => 'La contraseña no debe exceder los 255 caracteres.',        
        'password.required' => 'La contraseña es requerida.',
        'password.confirmation' => 'Las contraseñas no coinciden.',
        'password.confirmation.required' => 'La confirmación de la contraseña es requerida.',
        
    ];
}
