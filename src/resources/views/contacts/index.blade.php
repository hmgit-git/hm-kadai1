@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<a href="/login" class="login-button">管理者Login</a>

<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>
    @if ($errors->any())
    <div class="form__error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="form" method="POST" action="{{ route('contacts.confirm') }}">

        @csrf

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__name-group">
                    <input class="form__name-input--text" type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}" />
                    <input class=" form__name-input--text" type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}" />
                </div>
            </div>
        </div>

        <div class=" form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content form__radio-group">
                <label>
                    <input type="radio" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }}> 男性
                </label>
                <label>
                    <input type="radio" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}> 女性
                </label>
                <label>
                    <input type="radio" name="gender" value="3" {{ old('gender') == 3 ? 'checked' : '' }}> その他
                </label>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                    <!--バリデーション-->
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--tel-group" style="display: flex; align-items: center; gap: 8px;">
                    <input type="tel" name="tel1" placeholder="090" maxlength="4" style="width: 100px;" value="{{ old('tel1') }}" />
                    <span>-</span>
                    <input type="tel" name="tel2" placeholder="1234" maxlength="4" style="width: 100px;" value="{{ old('tel2') }}" />
                    <span>-</span>
                    <input type="tel" name="tel3" placeholder="5678" maxlength="4" style="width: 100px;" value="{{ old('tel3') }}" />
                </div>
                <div class="form__error">
                    <!--バリデーションエラー表示 -->
                </div>
            </div>
        </div>


        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}" />
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}" />
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ種別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <select name="category_id" required>
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }} hidden>選択してください</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>



        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@if (session('message'))
<div class="form__thanks">
    {{ session('message') }}
</div>
@endif

@endsection