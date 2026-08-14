@extends('layouts.app')

@section('title', __('Login'))

@section('content')
<style>
    :root {
        --navy: #0B3D5C;
        --teal: #2A9D8F;
        --sand: #E8DCC4;
        --coral: #E76F51;
        --ink: #142B3A;
        --shell: #FDFBF7;
    }
    .login-wrap {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--sand);
        padding: 3rem 1.25rem;
        font-family: 'Public Sans', -apple-system, sans-serif;
    }
    .login-card {
        width: 100%;
        max-width: 380px;
        background: var(--shell);
        border-radius: 8px;
        padding: 2.25rem 2rem;
        border: 1px solid rgba(11,61,92,0.08);
        box-shadow: 0 4px 24px rgba(11,61,92,0.06);
    }
        font-size: 0.7rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--teal);
        margin-bottom: 0.5rem;
    }
    .login-card h1 {
        font-family: 'Fraunces', serif;
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 1.5rem;
    }
    .alert-danger {
        background: #FDECEA;
        border: 1px solid #E76F51;
        color: #9A3412;
        border-radius: 6px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.25rem;
        font-size: 0.85rem;
    }
    .alert-danger ul { margin: 0; padding-left: 1.1rem; }
    .field { margin-bottom: 1.25rem; }
    .field label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 0.4rem;
    }
    .field input {
        width: 100%;
        padding: 0.7rem 0.85rem;
        border: 1.5px solid #D8CDB8;
        border-radius: 5px;
        font-size: 0.95rem;
        font-family: inherit;
        color: var(--ink);
        background: var(--shell);
        transition: border-color 0.15s ease;
    }
    .field input:focus {
        outline: none;
        border-color: var(--teal);
    }
    .field-error input { border-color: var(--coral); }
    .field-error .help-text { color: var(--coral); font-size: 0.8rem; margin-top: 0.35rem; }
    .login-btn {
        width: 100%;
        background: var(--coral);
        color: var(--shell);
        border: none;
        border-radius: 5px;
        padding: 0.85rem;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: opacity 0.15s ease;
    }
    .login-btn:hover { opacity: 0.9; }
</style>

<div class="login-wrap">
    <div class="login-card">

        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="field {{ $errors->has('email') ? 'field-error' : '' }}">
                <label for="email">{{ __('E-Mail Or Phone Number') }}</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <div class="help-text">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="field {{ $errors->has('password') ? 'field-error' : '' }}">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required>
                @if ($errors->has('password'))
                    <div class="help-text">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <button type="submit" class="login-btn">{{ __('Log in') }}</button>
        </form>
    </div>
</div>
@endsection
