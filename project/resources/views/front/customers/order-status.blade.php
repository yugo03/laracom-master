@php
    $orderStatusLabels = [
        'ordered' => '注文受付',
        'pending' => '支払い確認中',
        'paid' => '支払い完了',
        'on-delivery' => '配送中',
        'error' => 'エラー',
    ];
    $orderStatusLabel = $orderStatusLabels[$status->name] ?? $status->name;
    $orderStatusSteps = ['ordered', 'pending', 'paid', 'on-delivery'];
    $orderStatusCurrentIndex = array_search($status->name, $orderStatusSteps, true);
@endphp

@if(!empty($compact))
    <p class="text-center order-status-badge" style="color: #ffffff; background-color: {{ $status->color }}">{{ $orderStatusLabel }}</p>
@elseif($status->name === 'error')
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-triangle"></i> 注文の処理中に問題が発生しました。お問い合わせください。
    </div>
@else
    <ul class="order-status-steps list-unstyled">
        @foreach($orderStatusSteps as $index => $key)
            <li class="order-status-step @if($orderStatusCurrentIndex !== false && $index <= $orderStatusCurrentIndex) is-complete @endif @if($key === $status->name) is-current @endif">
                <span class="order-status-step-dot"></span>
                <span class="order-status-step-label">{{ $orderStatusLabels[$key] }}</span>
            </li>
        @endforeach
    </ul>
@endif
