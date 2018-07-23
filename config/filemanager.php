<?php
return [
  'title' => 'My Blog',
  'posts_per_page' => 5,
  'uploads' => [
    'storage' => 'file-upload',
    'webpath' => env('FILE_UPLOAD_URL'),
  ],
];
