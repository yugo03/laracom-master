@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">Create coupon</a>
            </div>
        @if(!$coupons->isEmpty())
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Code</td>
                                <td>Type</td>
                                <td>Value</td>
                                <td>Expires at</td>
                                <td>Active</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ ucfirst($coupon->type) }}</td>
                                <td>{{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 2) }}</td>
                                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $coupon->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
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
                    <p class="alert alert-warning">No coupon created yet. <a href="{{ route('admin.coupons.create') }}">Create one!</a></p>
                </div>
        @endif
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
