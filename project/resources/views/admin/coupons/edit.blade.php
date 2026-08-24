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
                        <label for="code">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" placeholder="e.g. SUMMER10" class="form-control" value="{{ $coupon->code }}">
                    </div>
                    <div class="form-group">
                        <label for="type">Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control">
                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed amount</option>
                            <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="value">Value <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="value" id="value" placeholder="Value" class="form-control" value="{{ $coupon->value }}">
                    </div>
                    <div class="form-group">
                        <label for="expires_at">Expires at</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}> Active
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
