<?php

return [
  'passport_callback'  => env('APP_URL').'/callback',
  'passport_redirect' => env('AUTH_API_BROWSER'),
  'passport_api'  => env('AUTH_API_PRIVATE'),
  'passport_client_id'  => env('AUTH_CLIENT_ID'),
  'passport_client_secret'  => env('AUTH_CLIENT_SECRET'),
];
