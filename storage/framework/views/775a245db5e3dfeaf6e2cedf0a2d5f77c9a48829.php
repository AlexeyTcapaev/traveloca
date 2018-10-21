<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Traveloca</title>
  <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
</head>
<body>
  <div id="app">
  </div>
  <script src="<?php echo e(mix('js/app.js')); ?>"></script>
</body>
</html>
