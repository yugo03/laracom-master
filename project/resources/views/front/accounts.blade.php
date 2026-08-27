@extends('layouts.front.app')

@section('content')
    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="box-body">
                @include('layouts.errors-and-messages')
            </div>
            <div class="col-md-12">
                <h2> <i class="fa fa-home"></i> マイページ</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link @if(request()->input('tab') != 'orders' && request()->input('tab') != 'address') active @endif" href="#profile" aria-controls="profile" role="tab" data-bs-toggle="tab">プロフィール</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link @if(request()->input('tab') == 'orders') active @endif" href="#orders" aria-controls="orders" role="tab" data-bs-toggle="tab">注文履歴</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link @if(request()->input('tab') == 'address') active @endif" href="#address" aria-controls="address" role="tab" data-bs-toggle="tab">住所</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content customer-order-list">
                        <div role="tabpanel" class="tab-pane fade @if(request()->input('tab') != 'orders' && request()->input('tab') != 'address') show active @endif" id="profile">
                            {{$customer->name}} <br /><small>{{$customer->email}}</small>

                            <h4 style="margin-top:25px;">利用可能なクーポン</h4>
                            @if($availableCoupons->isEmpty())
                                <p class="text-muted">現在ご利用いただけるクーポンはありません。</p>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>クーポンコード</th>
                                            <th>内容</th>
                                            <th>有効期限</th>
                                            <th>条件</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($availableCoupons as $coupon)
                                            <tr>
                                                <td><strong>{{ $coupon->code }}</strong></td>
                                                <td>{{ $coupon->type === 'percent' ? $coupon->value . '% OFF' : config('cart.currency') . ' ' . number_format($coupon->value, 2) . ' OFF' }}</td>
                                                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d H:i') : '無期限' }}</td>
                                                <td>@if($coupon->first_order_only) 初回注文限定 @else - @endif</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p class="text-muted">カート画面のクーポンコード欄にコードを入力するとご利用いただけます。</p>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade @if(request()->input('tab') == 'orders') show active @endif" id="orders">
                            @if(!$orders->isEmpty())
                                <table class="table">
                                <tbody>
                                <tr>
                                    <td>日付</td>
                                    <td>合計</td>
                                    <td>ステータス</td>
                                </tr>
                                </tbody>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#order_modal_{{$order['id']}}" title="注文を表示" href="javascript: void(0)">{{ date('Y年m月d日 H:i', strtotime($order['created_at'])) }}</a>
                                            <!-- Button trigger modal -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="order_modal_{{$order['id']}}" tabindex="-1" role="dialog" aria-labelledby="MyOrders">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">注文番号 #{{$order['reference']}}</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <thead>
                                                                    <th>お届け先</th>
                                                                    <th>お支払い方法</th>
                                                                    <th>合計</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <address>
                                                                                <strong>{{$order['address']->alias}}</strong><br />
                                                                                {{$order['address']->address_1}} {{$order['address']->address_2}}<br>
                                                                            </address>
                                                                        </td>
                                                                        <td>{{$order['payment']}}</td>
                                                                        <td>{{ config('cart.currency_symbol') }} {{$order['total']}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            @include('front.customers.order-status', ['status' => $order['status']])
                                                            <hr>
                                                            <p>注文内容:</p>
                                                            <table class="table">
                                                              <thead>
                                                                  <th>商品名</th>
                                                                  <th>数量</th>
                                                                  <th>価格</th>
                                                                  <th>画像</th>
                                                                  <th>鑑定書</th>
                                                              </thead>
                                                              <tbody>
                                                              @foreach ($order['products'] as $product)
                                                                  <tr>
                                                                      <td>{{$product['name']}}</td>
                                                                      <td>{{$product['pivot']['quantity']}}</td>
                                                                      <td>{{$product['price']}}</td>
                                                                      <td><img src="{{ asset("storage/".$product['cover']) }}" width=50px height=50px alt="{{ $product['name'] }}" class="img-orderDetail"></td>
                                                                      <td>
                                                                          @if(!empty($product['certificate']))
                                                                              <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#certificate_modal_{{$order['id']}}_{{$product['id']}}">
                                                                                  <i class="fa fa-certificate"></i> 表示
                                                                              </a>
                                                                              <div class="modal fade" id="certificate_modal_{{$order['id']}}_{{$product['id']}}" tabindex="-1" role="dialog">
                                                                                  <div class="modal-dialog" role="document">
                                                                                      <div class="modal-content">
                                                                                          <div class="modal-header">
                                                                                              <h4 class="modal-title">鑑定書 - {{ $product['name'] }}</h4>
                                                                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                          </div>
                                                                                          <div class="modal-body">
                                                                                              <table class="table">
                                                                                                  @if(!empty($product['certificate']['appraiser_name']))
                                                                                                      <tr><td>鑑定士</td><td>{{ $product['certificate']['appraiser_name'] }}</td></tr>
                                                                                                  @endif
                                                                                                  @if(!empty($product['certificate']['grade']))
                                                                                                      <tr><td>グレード</td><td>{{ $product['certificate']['grade'] }}</td></tr>
                                                                                                  @endif
                                                                                                  @if(!empty($product['certificate']['serial_number']))
                                                                                                      <tr><td>シリアル番号</td><td>{{ $product['certificate']['serial_number'] }}</td></tr>
                                                                                                  @endif
                                                                                                  @if(!empty($product['certificate']['appraised_at']))
                                                                                                      <tr><td>鑑定日</td><td>{{ date('Y-m-d', strtotime($product['certificate']['appraised_at'])) }}</td></tr>
                                                                                                  @endif
                                                                                                  @if(!empty($product['certificate']['notes']))
                                                                                                      <tr><td>備考</td><td>{{ $product['certificate']['notes'] }}</td></tr>
                                                                                                  @endif
                                                                                              </table>
                                                                                              @if(!empty($product['certificate']['file']))
                                                                                                  <a href="{{ asset('storage/'.$product['certificate']['file']) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                                                      <i class="fa fa-file"></i> 鑑定書ファイルを見る
                                                                                                  </a>
                                                                                              @endif
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>
                                                                          @else
                                                                              -
                                                                          @endif
                                                                      </td>
                                                                  </tr>
                                                              @endforeach
                                                              </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">閉じる</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="label @if($order['total'] != $order['total_paid']) label-danger @else label-success @endif">{{ config('cart.currency') }} {{ $order['total'] }}</span></td>
                                        <td>@include('front.customers.order-status', ['status' => $order['status'], 'compact' => true])</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                {{ $orders->links() }}
                            @else
                                <p class="alert alert-warning">まだ注文がありません。<a href="{{ route('home') }}">今すぐ買い物する!</a></p>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade @if(request()->input('tab') == 'address') show active @endif" id="address">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('customer.address.create', auth()->user()->id) }}" class="btn btn-primary">住所を登録する</a>
                                </div>
                            </div>
                            @if(!$addresses->isEmpty())
                                <table class="table">
                                <thead>
                                    <th>名前</th>
                                    <th>住所1</th>
                                    <th>住所2</th>
                                    <th>市区町村</th>
                                    @if(isset($address->province))
                                    <th>都道府県</th>
                                    @endif
                                    <th>州</th>
                                    <th>国</th>
                                    <th>郵便番号</th>
                                    <th>電話番号</th>
                                    <th>操作</th>
                                </thead>
                                <tbody>
                                    @foreach($addresses as $address)
                                        <tr>
                                            <td>{{$address->alias}}</td>
                                            <td>{{$address->address_1}}</td>
                                            <td>{{$address->address_2}}</td>
                                            <td>{{$address->city}}</td>
                                            @if(isset($address->province))
                                            <td>{{$address->province->name}}</td>
                                            @endif
                                            <td>{{$address->state_code}}</td>
                                            <td>{{$address->country->name}}</td>
                                            <td>{{$address->zip}}</td>
                                            <td>{{$address->phone}}</td>
                                            <td>
                                                <form method="post" action="{{ route('customer.address.destroy', [auth()->user()->id, $address->id]) }}" class="form-horizontal">
                                                    <div class="btn-group">
                                                        <input type="hidden" name="_method" value="delete">
                                                        {{ csrf_field() }}
                                                        <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}" class="btn btn-primary"> <i class="fa fa-pencil"></i> 編集</a>
                                                        <button onclick="return confirm('本当に削除しますか?')" type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> 削除</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <br /> <p class="alert alert-warning">まだ住所が登録されていません。</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
