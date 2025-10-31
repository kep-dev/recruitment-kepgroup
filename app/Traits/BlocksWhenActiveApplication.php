<?php

namespace App\Traits;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait BlocksWhenActiveApplication
{
    /** Cache hasil cek di 1 request */
    protected ?bool $___hasActiveApplication = null;

    /**
     * Cek apakah user saat ini punya lamaran aktif.
     */
    protected function hasActiveApplication(?int $userId = null): bool
    {
        if (! $userId) {
            $userId = Auth::id();
        }

        if (! $userId) {
            // Tidak login = dianggap tidak aktif (atau terserah kebijakan Anda)
            return false;
        }

        if ($this->___hasActiveApplication !== null) {
            return $this->___hasActiveApplication;
        }

        return $this->___hasActiveApplication = Application::query()
            ->where('user_id', $userId)
            ->whereRelation('jobVacancy', 'status', true)
            ->whereRelation('jobVacancy', 'end_date', '>', \Carbon\Carbon::now())
            ->exists();
    }

    /**
     * Lempar ValidationException jika masih ada lamaran aktif.
     *
     * $attribute: nama field untuk menaruh pesan error (bisa 'global')
     * $message: pesan kustom (opsional)
     */
    protected function blockIfActive(string $attribute = 'global', ?string $message = null): void
    {
        if ($this->hasActiveApplication()) {
            throw ValidationException::withMessages([
                $attribute => $message ?: 'Anda masih memiliki lamaran yang belum selesai. Silakan selesaikan lamaran terlebih dahulu.',
            ]);
        }
    }

    /**
     * Helper boolean kalau Anda hanya perlu if (...) { return ... }
     */
    protected function canEditProfile(): bool
    {
        return ! $this->hasActiveApplication();
    }

    /**
     * Jalankan closure hanya jika tidak ada lamaran aktif.
     * Berguna untuk membungkus operasi tulis.
     */
    protected function withEditsAllowed(callable $callback, string $attribute = 'global', ?string $message = null)
    {
        $this->blockIfActive($attribute, $message);
        return $callback();
    }
}
