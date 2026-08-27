@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <div class="form-group">
                        <label for="code">クーポンコード <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" placeholder="例: SUMMER10" class="form-control" value="{{ $coupon->code }}">
                    </div>
                    <div class="form-group">
                        <label for="type">割引タイプ <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control">
                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>定額割引</option>
                            <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>割合割引</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="value">割引額・割引率 <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="value" id="value" placeholder="値を入力" class="form-control" value="{{ $coupon->value }}">
                    </div>
                    <div class="form-group">
                        <label for="expires_at">有効期限</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}> 有効にする
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="first_order_only" value="1" {{ $coupon->first_order_only ? 'checked' : '' }}> 初回注文限定(注文履歴のない会員のみ利用可)
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-default">戻る</a>
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
