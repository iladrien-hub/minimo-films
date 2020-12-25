@extends("app")

@section("content")
    <style>
        .auth-wrapper {
            padding: 10px;
        }
        .auth-content {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #333;
            border-radius: 2px;
        }
        .auth-content h2 {
            margin-bottom: 25px;
            color: #333 !important;
            text-align: center;
        }
        .minimo-checkbox {
            margin: 15px 0;
        }
        .auth-errors span {
            display: inline-block;
            margin-bottom: 15px;
            color: #d62a2a;
            font-weight: bold;
        }
    </style>

    <div class="auth-wrapper">
        <div class="auth-content">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="auth-errors">
                    @error('email')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @enderror
                    @error('password')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="minimo-text-input">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span>Email</span>
                </div>
                <div class="minimo-text-input">
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <span>Password</span>
                    </div>
                </div>
                <div class="minimo-checkbox">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <button type="submit" class="btn btn-primary minimo-button">
                        {{ __('Login') }}
                    </button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
