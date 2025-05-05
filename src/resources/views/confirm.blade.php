@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')


<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>
    <div class="confirm-table">
        <table class="confirm-table__inner">
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お名前</th>
                <td class="confirm-table__text">
                    {{ $input['last_name'] }} {{ $input['first_name'] }}
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">性別</th>
                <td class="confirm-table__text">
                    @if($input['gender'] == 1) 男性
                    @elseif($input['gender'] == 2) 女性
                    @else その他
                    @endif
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">メールアドレス</th>
                <td class="confirm-table__text">
                    {{ $input['email'] }}
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">電話番号</th>
                <td class="confirm-table__text">
                    {{ $input['tel1'] }}-{{ $input['tel2'] }}-{{ $input['tel3'] }}
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">住所</th>
                <td class="confirm-table__text">
                    {{ $input['address'] }}
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">建物名</th>
                <td class="confirm-table__text">
                    {{ $input['building'] }}
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせの種類</th>
                <td class="confirm-table__text">
                    @switch($input['category_id'])
                    @case(1) 資料請求 @break
                    @case(2) ご質問 @break
                    @case(3) その他 @break
                    @endswitch
                </td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせ内容</th>
                <td class="confirm-table__text">
                    {{ $input['detail'] }}
                </td>
            </tr>
        </table>
    </div>

    <div class="form__button">

        <form method="POST" action="{{ route('contacts.store') }}">
            @csrf
            @foreach($input as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit">送信</button>
        </form>

        <form method="POST" action="{{ route('contacts.index') }}">
            @csrf
            @foreach($input as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit">修正</button>
        </form>
    </div>
</div>
@endsection