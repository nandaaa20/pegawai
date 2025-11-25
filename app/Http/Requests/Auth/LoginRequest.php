<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Validasi input
    public function rules(): array
    {
        return [
            'nip'      => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    // Kunci rate-limit berdasarkan nip
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('nip')).'|'.$this->ip());
    }

    // Proses login pakai NIP
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = [
            'nip'      => $this->get('nip'),
            'password' => $this->get('password'),
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nip' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    // Rate limiting
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nip' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
}
