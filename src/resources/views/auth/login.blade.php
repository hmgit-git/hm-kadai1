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
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email" class="auth-label">メールアドレス</label>
            <input type="email" id="email" name="email" placeholder="例: test@example.com" required>

            <label for="password" class="auth-label">パスワード</label>
            <input type="password" id="password" name="password" placeholder="例: coachtech1106" required>

            <div class="auth-btn-wrap">
                <button type="submit">ログイン</button>
            </div>
        </form>

        @if ($errors->any())
        <div class="form__error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection