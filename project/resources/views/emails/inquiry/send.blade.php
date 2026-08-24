<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>サイトからのお問い合わせ</title>
</head>
<body>
<h2>サイトからのお問い合わせ</h2>
<p><strong>お名前:</strong> {{ $from }}</p>
<p><strong>メールアドレス:</strong> {{ $email }}</p>
<p><strong>お客様の属性:</strong> {{ $iam }}</p>
<p><strong>お問い合わせ内容:</strong><br>{{ $inquiryMessage }}</p>
<p>{{ config('app.name') }}</p>
</body>
</html>
