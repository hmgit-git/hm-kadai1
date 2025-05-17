@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('auth-header-button')
<div class="auth-header__right">
    <a href="{{ route('login') }}" class="auth-link">Login</a>
</div>
@endsection

@section('content')
<div class="auth-wrapper">
    <h2 class="auth-title">Register</h2>
    <div class="auth-form">
        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <label for="name" class="auth-label">お名前</label>
            <input type="text" id="name" name="name" placeholder="例: 山田 太郎" required>
            @error('name')
            <div class="form__error">{{ $message }}</div>
            @enderror

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
                <button type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection