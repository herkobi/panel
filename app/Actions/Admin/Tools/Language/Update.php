<?php

namespace App\Actions\Admin\Tools\Language;

use App\Services\Admin\Tools\LanguageService;
use App\Events\Admin\Tools\Language\Update as Event;
use App\Models\Language;
use App\Traits\AuthUser;

class Update
{
    use AuthUser;

    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
        $this->initializeAuthUser();
    }

    public function execute(string $id, array $data): Language
    {
        $oldLanguage = $this->languageService->getLanguageById($id);
        $language = $this->languageService->updateLanguage($id, $data);
        $newLanguage = $this->languageService->getLanguageById($id);
        event(new Event($language, $this->user, $oldLanguage, $newLanguage));
        return $language;
    }
}
