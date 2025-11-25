@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/confirm.css')}}">
@endsection

@section('content')
<h1 class="page-title">Confirm</h1>
<div class="confirm-table">
    <form action="/thanks" method="post">
        @csrf
        <table class="confirm-table">
            <tr class="table-line">
                <th class="column-name">お名前</th>
                <td class="table-cell">
                    <input class="read-input" name="full-name" type="text" value="{{ $fullName }}" readonly>
                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}" readonly>
                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">性別</th>
                <td class="table-cell">
                    <input class="read-input" name="gender" value="{{$contact['gender']}}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">メールアドレス</th>
                <td class="table-cell">
                    <input class="read-input" name="email" type="email" value="{{$contact['email']}}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">電話番号</th>
                <td class="table-cell">
                    <input class="read-input" name="tel" type="tel" value="{{ $entireTel }}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">住所</th>
                <td class="table-cell">
                    <input class="read-input" name="address" type="text" value="{{$contact['address']}}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">建物名</th>
                <td class="table-cell">
                    <input class="read-input" name="building" type="text" value="{{$contact['building']}}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">お問い合わせの種類</th>
                <td class="table-cell">
                    <input class="read-input" name="category_id" type="text" value="{{$contact['category_id']}}" readonly>
                </td>
            </tr>
            <tr class="table-line">
                <th class="column-name">お問い合わせ内容</th>
                <td class="table-cell">
                    <textarea class="read-input" name="detail" readonly>{{$contact['detail']}}</textarea>
                </td>
            </tr>
        </table>
        <div class="buttons">
            <button class="toThanks" type="submit" name="action" value="post">送信</button>
            <button class="toFix" type="submit" name="action" value="modify">修正</button>
        </div>
    </form>
</div>
@endsection