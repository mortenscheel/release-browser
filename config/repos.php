<?php

return [
    'default' => collect(preg_split('/[,\s]/', env('DEFAULT_REPOS', '')))->map(fn($repo) => trim($repo))->filter()->values()->all()
];
