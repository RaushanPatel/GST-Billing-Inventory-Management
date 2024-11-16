@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 text-center" style="font-size: 1.25rem; font-weight: bold;">{{ __('Login') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p class="mt-3">{{ __("New here?") }} <a href="{{ route('register') }}">{{ __('Register') }}</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

