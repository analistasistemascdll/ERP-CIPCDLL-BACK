<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Rutas donde se aplica CORS
    'allowed_methods' => ['*'], // Permitir todos los métodos (GET, POST, etc.)
    'allowed_origins' => ['*'], // Permitir todas las URLs (puedes cambiarlo por dominios específicos)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Permitir todos los headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Necesario si usas cookies para autenticación
];
