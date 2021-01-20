<!DOCTYPE html>
<html>

<head>
  <title>Google reCAPTCHA v3 using PHP</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js?render=<YOUR_SITE_KEY>"></script>
  <style>
    body {
      font-family: arial;
      margin: 20px;
    }
  </style>
</head>

<body>
  <div class="col-md-6">
    <h4>Google reCAPTCHA v3 in PHP - <a href="https://www.cluemediator.com/" target="_blank">Clue Mediator</a></h4>
    <form id="myform" method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" id="email" required>
      </div>
      <input type="submit" class="btn btn-primary" value="Submit" />
    </form>
    <p id="message" class="mt-3"></p>
  </div>
  <script>
    $('#myform').submit(function (e) {
      e.preventDefault();
      var name = $('#name').val();
      var email = $('#email').val();
      // needs for recaptcha ready
      grecaptcha.ready(function () {
        // do request for recaptcha token       
        grecaptcha.execute('<YOUR_SITE_KEY>', { action: 'contact' }).then(function (token) {
          // add token to form             
          $.post("recaptcha-validate.php", { name: name, email: email, token: token }, function (result) {
            var data = JSON.parse(result);
            $('#message').text(data.msg);
          });
        });;
      });
    });
  </script>
</body>

</html>