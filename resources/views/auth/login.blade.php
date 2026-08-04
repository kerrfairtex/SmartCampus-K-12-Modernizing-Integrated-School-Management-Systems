@extends('layouts.landing')

@section('title', __('Login'))

@section('content')
<div class="sc-auth-page">
    <div class="sc-auth-brand">
        <a href="{{ url('/') }}" class="sc-logo" style="color: #fff;">
            <div class="sc-logo-mark">SC</div>
            <div class="sc-logo-text" style="color: #fff;">
                SmartCampus
                <small style="color: rgba(255,255,255,0.7);">K–12 Management System</small>
            </div>
        </a>
        <h1>Welcome back</h1>
        <p>Sign in to manage enrollment, attendance, quarterly grades, and school administration for your Philippine K–12 institution.</p>
    </div>

    <div class="sc-auth-form-wrap">
        <div class="sc-auth-card">
            <h2>@lang('Sign In')</h2>
            <p class="sc-auth-sub">Enter your credentials to access the portal</p>

            @if ($errors->any())
                <div class="sc-alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="sc-form-group">
                    <label for="email">@lang('E-Mail Or Phone Number')</label>
                    <input id="email" type="text" class="sc-form-control" name="email"
                           value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <div class="sc-form-error">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="sc-form-group">
                    <label for="password">@lang('Password')</label>
                    <input id="password" type="password" class="sc-form-control" name="password" required>
                    @if ($errors->has('password'))
                        <div class="sc-form-error">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <button type="submit" class="sc-btn sc-btn-primary" style="width: 100%; margin-top: 8px;">
                    @lang('Login')
                </button>
            </form>

            <div class="sc-auth-back">
                <a href="{{ url('/') }}">← Back to home</a>
            </div>
        </div>
    </div>
</div>
@endsection
