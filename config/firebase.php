<?php

return [
    'auth_url' => 'https://www.googleapis.com/auth/firebase.messaging',
    'send_url' => 'https://fcm.googleapis.com/v1/projects/',
    'project_id' => env('FIREBASE_PROJECT_ID',null),
    'credentials' => env('FIREBASE_CREDENTIALS',null),
];
