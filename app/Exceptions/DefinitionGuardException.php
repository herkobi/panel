<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class DefinitionGuardException extends RuntimeException
{
    public function render(Request $request): RedirectResponse
    {
        return back()->with('toast', [
            'type' => 'warning',
            'message' => $this->getMessage(),
        ]);
    }
}
