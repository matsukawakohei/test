<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <title><?php echo $title; ?></title>
</head>

<body>
  <h1>お問い合わせ</h1>
  <div id='wrapper'>
    <?php echo $content; ?>
    <br>
    <p class='footer'>
      Powered by <?php echo Html::anchor('http://test', 'FuelPHP'); ?>
    </p>
  </div>
</body>
</html>
