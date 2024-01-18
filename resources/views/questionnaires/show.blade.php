<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投票画面</title>
</head>

<body>
    <div>
        選択肢
        @foreach($options as $option)
        <div>
            {{ $option->option_name}}
        </div>
        @endforeach
    </div>
</body>

</html>