<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/61ac9e26a1.js" crossorigin="anonymous"></script>
    <script src="{{ mix('/js/manifest.js') }}" defer></script>
    <script src="{{ mix('/js/vendor.js') }}" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>    
  </head>
  <body class="bg-gray-200">
      @inertia
  </body>
</html>
