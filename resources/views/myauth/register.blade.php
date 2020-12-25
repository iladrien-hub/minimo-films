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
        .auth-errors span {
            display: inline-block;
            margin-bottom: 15px;
            color: #d62a2a;
            font-weight: bold;
        }
    </style>

    <div class="auth-wrapper">
        <div class="auth-content">
            <h2>Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="auth-errors">
                    @error('name')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @enderror
                    @error('email')
                    <span class="invalid-feedback" role="alert"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="minimo-text-input">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    <span>Name</span>
                </div>
                <div class="minimo-text-input">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    <span>Email</span>
                </div>
                <div class="minimo-text-input">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    <span>Password</span>
                </div>
                <div class="minimo-text-input">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    <span>Password Confirm</span>
                </div>
                <button type="submit" class="btn btn-primary minimo-button">
                    {{ __('Register') }}
                </button>
            </form>
        </div>
    </div>
@endsection
