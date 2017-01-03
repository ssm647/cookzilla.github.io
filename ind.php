<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Autocomplete textbox using jQuery, PHP and MySQL by CodexWorld</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#searchEngine1" ).autocomplete({
      source: 'search.php'
    });
  });
  </script>
</head>
<body>
 <form action='result.php' method='POST' >
<div class="ui-widget">
  <label for="skills">Search: </label>
  <input id="searchEngine1" name="rtitle">
    <input type="submit" value="Submit">

  
</div>
</form>
</body>
</html>