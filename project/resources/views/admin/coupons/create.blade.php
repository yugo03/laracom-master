@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.coupons.store') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="code">クーポンコード <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" placeholder="例: SUMMER10" class="form-control" value="{{ old('code') }}">
                    </div>
                    <div class="form-group">
                        <label for="type">割引タイプ <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control">
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>定額割引</option>
                            <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>割合割引</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="value">割引額・割引率 <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="value" id="value" placeholder="値を入力" class="form-control" value="{{ old('value') }}">
                    </div>
                    <div class="form-group">
                        <label for="expires_at">有効期限</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at') }}">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> 有効にする
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="first_order_only" value="1" {{ old('first_order_only') ? 'checked' : '' }}> 初回注文限定(注文履歴のない会員のみ利用可)
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-default">戻る</a>
                        <button type="submit" class="btn btn-primary">作成する</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
