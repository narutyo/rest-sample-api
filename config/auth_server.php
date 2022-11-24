<?php

return [
  'passport_callback'  => env('APP_URL').'/callback',
  'passport_redirect' => env('AUTH_API_BROWSER'),
  'passport_api'  => env('AUTH_API_PRIVATE'),
];
