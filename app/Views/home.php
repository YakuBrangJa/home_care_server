<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>
    <h1>Hello world </h1>
  </body>
  <script>
  fetch('home-data')
    .then(response => {
      return response.json();
    })
    .then(data => console.log(data))
  </script>

</html>