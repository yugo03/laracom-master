@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">クーポンを作成</a>
            </div>
        @if(!$coupons->isEmpty())
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>コード</td>
                                <td>タイプ</td>
                                <td>割引額・割引率</td>
                                <td>有効期限</td>
                                <td>有効</td>
                                <td>初回限定</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->type === 'percent' ? '割合割引' : '定額割引' }}</td>
                                <td>{{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 2) }}</td>
                                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $coupon->is_active ? 'はい' : 'いいえ' }}</td>
                                <td>{{ $coupon->first_order_only ? 'はい' : 'いいえ' }}</td>
                                <td>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> 編集</a>
                                            <button onclick="return confirm('本当に削除しますか?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> 削除</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $coupons->links() }}
                </div>
                <!-- /.box-body -->
            @else
                <div class="box-body">
                    <p class="alert alert-warning">クーポンがまだ作成されていません。<a href="{{ route('admin.coupons.create') }}">作成する</a></p>
                </div>
        @endif
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
