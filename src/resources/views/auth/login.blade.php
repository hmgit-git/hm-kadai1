@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

{{-- ★ここでボタンだけ追加 --}}
@section('auth-header-button')
<div class="auth-header__right">
    <a href="{{ route('register') }}" class="auth-link">Register</a>
</div>
@endsection

@section('content')
<div class="auth-wrapper">
    <h2 class="auth-title">Login</h2>
    <div class="auth-form">
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <label for="email" class="auth-label">メールアドレス</label>
            <input type="email" id="email" name="email" placeholder="例: test@example.com" required>
            @error('email')
            <div class="form__error">{{ $message }}</div>
            @enderror

            <label for="password" class="auth-label">パスワード</label>
            <input type="password" id="password" name="password" placeholder="例: coachtech1106" required>
            @error('password')
            <div class="form__error">{{ $message }}</div>
            @enderror

            <div class="auth-btn-wrap">
                <button type="submit">ログイン</button>
            </div>
        </form>

    </div>
</div>
@endsection