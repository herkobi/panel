<?php

namespace App\Actions\Admin\Tools\Language;

use App\Models\Language;
use App\Services\Admin\Tools\LanguageService;
use App\Events\Admin\Tools\Language\Create as Event;
use App\Traits\AuthUser;

class Create
{
    use AuthUser;

    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
        $this->initializeAuthUser();
    }

    public function execute(array $data): Language
    {
        $language = $this->languageService->createLanguage($data);
        event(new Event($language, $this->user));
        return $language;
    }
}
