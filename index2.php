<!doctype html>  
<html lang="en">  
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.indigo-pink.min.css">
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="../js/css/testCss.css" media="all" rel="stylesheet" />
    <title>New React App</title>
  </head>
  <body>
    <section id="react"></section>
    <div id="youtubeContainer"></div>
    <?php
      if (null !== getenv('ENVIRONMENT'))
      {
        if (getenv('ENVIRONMENT') == 'staging' OR getenv('ENVIRONMENT') == 'production')
        {
          echo('<script src="../build/a.bundle.js"></script>');
        }
        else
        {
          echo('<script src="http://localhost:8080/a.bundle.js"></script>');
        }
      }
    ?>
  </body>
</html>  