@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<form method="POST" action="{{ route('logout') }}" style="text-align: right; margin-bottom: 16px;">
    @csrf
    <button type="submit" class="logout-btn">Logout</button>
</form>

<div class="admin-dashboard">
    <h2 class="admin-title">Admin</h2>

    <form method="GET" action="{{ route('admin.index') }}" class="search-form">
        <div class="search-row">
            <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください">

            <select name="gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>

            <select name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->content }}</option>
                @endforeach
            </select>

            <input type="date" name="contact_date">

            <button type="submit">検索</button>
            <a href="{{ route('admin.index') }}" class="reset-btn">リセット</a>
        </div>

        <div class="search-row second-row">
            <div class="left">
                <a href="{{ route('admin.export') }}" class="export-btn">CSV</a>
                <a href="{{ route('admin.export.excel') }}" class="export-btn">Excel</a>
            </div>
            <div class="right">
                {{ $contacts->links() }}
            </div>
        </div>
    </form>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせ種別</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                <td>
                    @if ($contact->gender == 1) 男性
                    @elseif ($contact->gender == 2) 女性
                    @else その他
                    @endif
                </td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->category->content ?? '-' }}</td>
                <td>
                    <a href="#" class="detail-btn"
                        data-id="{{ $contact->id }}"
                        data-name="{{ $contact->last_name }} {{ $contact->first_name }}"
                        data-gender="{{ $contact->gender }}"
                        data-email="{{ $contact->email }}"
                        data-category="{{ $contact->category->content ?? '-' }}"
                        data-detail="{{ $contact->detail }}">
                        詳細
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="detailModal" class="modal-overlay" style="display:none;">
        <div class="modal-window">
            <span class="modal-close">×</span>
            <h2>お問い合わせ詳細</h2>
            <table class="modal-table">
                <tr>
                    <th>お名前</th>
                    <td id="modal-name"></td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td id="modal-gender"></td>
                </tr>
                <tr>
                    <th>メール</th>
                    <td id="modal-email"></td>
                </tr>
                <tr>
                    <th>種別</th>
                    <td id="modal-category"></td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td id="modal-detail"></td>
                </tr>
            </table>
            <div style="text-align: center;">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">削除</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // イベントバインドを document に変更（これ重要！）
        $(document).on('click', '.detail-btn', function(e) {
            e.preventDefault();

            $('#modal-name').text($(this).data('name'));
            $('#modal-gender').text(getGenderLabel($(this).data('gender')));
            $('#modal-email').text($(this).data('email'));
            $('#modal-category').text($(this).data('category'));
            $('#modal-detail').text($(this).data('detail'));
            $('#deleteForm').attr('action', '/admin/' + $(this).data('id'));

            $('#detailModal').fadeIn();
        });

        // ×ボタンで閉じる
        $(document).on('click', '.modal-close', function() {
            $('#detailModal').fadeOut();
        });

        // 性別ラベル関数
        function getGenderLabel(val) {
            switch (val) {
                case 1:
                case '1':
                    return '男性';
                case 2:
                case '2':
                    return '女性';
                default:
                    return 'その他';
            }
        }
    });
    $('#deleteForm').on('submit', function(e) {
        if (!confirm('本当に削除してもよろしいですか？')) {
            e.preventDefault(); // 送信キャンセル
        }
    });
</script>
@endsection