@extends('layouts.front.app')

@section('content')
    <hr>
    <section class="container content t100 b100">
        <div class="col-md-6 col-md-offset-3">
            <div class="section-title">
                <h2>お問い合わせ</h2>
                <p>商品や配送、お取引についてのご質問は下記フォームよりお気軽にお問い合わせください。</p>
            </div>

            @include('layouts.errors-and-messages')

            <form action="{{ route('contact.store') }}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">お名前</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="お名前" required>
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="メールアドレス" required>
                </div>
                <div class="form-group">
                    <label for="iam">お客様の属性</label>
                    <select id="iam" name="iam" class="form-control" required>
                        <option value="">選択してください</option>
                        <option value="一般のお客様" {{ old('iam', request('type') === 'inquiry' ? '一般のお客様' : '') === '一般のお客様' ? 'selected' : '' }}>一般のお客様</option>
                        <option value="卸売・お取引のご相談" {{ old('iam') === '卸売・お取引のご相談' ? 'selected' : '' }}>卸売・お取引のご相談</option>
                        <option value="メディア・取材のお問い合わせ" {{ old('iam') === 'メディア・取材のお問い合わせ' ? 'selected' : '' }}>メディア・取材のお問い合わせ</option>
                        <option value="その他" {{ old('iam') === 'その他' ? 'selected' : '' }}>その他</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">お問い合わせ内容</label>
                    <textarea id="message" name="message" rows="6" class="form-control" placeholder="お問い合わせ内容をご記入ください" required>{{ old('message') }}</textarea>
                </div>
                <div class="row">
                    <button class="btn btn-hero" type="submit" style="margin: 20px 15px 0;">送信する</button>
                </div>
            </form>
        </div>
    </section>
@endsection
