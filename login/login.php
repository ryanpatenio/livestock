<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Binalbagan Environmental & Agriculture Office | Log in</title>
  <link rel="stylesheet" href="../css/style.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap 4.2 -->
  <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script>
		var baseUrl = '/livestock2/includes/routes.php?';
	</script>

  <style>
    body.login-page {
      background-image: url('../image/bg/background.jpg'); /* Adjusted path to your background image */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .login-box {
      background: rgba(0, 0, 0, 0.7); /* Adds a semi-transparent background */
      color: white;
      border-radius: 10px;
    }
    .login-logo h4 {
      color: #fff;
    }
  </style>
</head>
<body class="login-page">
  <div class="login-box bg-primary elevation-4">
    <div class="login-logo pt-3">
      <h4 style="color: #fff; padding: 1rem;">Binalbagan Environmental & Agriculture Office</h4>
    </div>
    <div class="card m-1 mb-2">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><b><i>Sign in to start your session</i></b></p>
        <p id="msg" class="text-red text-center bg-danger w-100"></p>

        <form id="loginForm" method="POST">
          <div class="input-group mb-3 elevation-1">
            <input type="text" name="username" class="form-control" autofocus autocomplete="off" id="inputUsername" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group elevation-1">
            <input type="password" name="password" class="form-control" id="inputPassword" autocomplete="on" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span id="passIcon" class="fas fa-eye-slash"></span>
              </div>
            </div>
          </div>
          <hr>
          <div class="row mb-3">
            <div class="col d-flex d-inline">
              <button type="submit" class="btn bg-primary btn-md w-100 elevation-2"><b>Log In</b></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <script src="../administrator/assets/msg.js"></script>
  <script src="../administrator/assets/sweet.js"></script>
  <script src="login.js"></script>
  <script>
    // $(document).ready(fu nction() {
    //   var attempt = 0;
    //   var increment = 10;
    //   $('#loginForm').on('submit', function(e){
    //     e.preventDefault();
    //     let data = $(this).serialize() + "&attempt=" + attempt;
        
    //     if($('#inputUsername').val() == "" || $('#inputPassword').val() == ""){
    //       $('#msg').text('Please fill all fields').fadeTo(3000,500).slideUp(500);
    //     } else {
    //       $.ajax({
    //         method: 'post',
    //         url: 'action.php',
    //         data: data,
    //         dataType: 'json',
    //         beforeSend: function(){
    //           $('#submitBtn').attr('disabled', true).text('Validating...');
    //         },
    //         success: function(res){
    //           attempt = res.attempt;
    //           if (res.href) {
    //             window.location.href = res.href;
    //           }
    //           if(res.result == "Failed"){
    //             $('#msg').text('Incorrect username OR password!').fadeTo(3000, 500).slideUp(500);
    //             $('#submitBtn').removeAttr('disabled').text('Log In');
    //           }
    //         },
    //         error: function(err){
    //           console.log(err.responseText);
    //         }
    //       });
    //     }
    //   });

    //   $('#passIcon').on('click', function(){
    //     if($('#inputPassword').attr('type') == "password"){
    //       $('#passIcon').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
    //       $('#inputPassword').attr('type','text');
    //     } else {
    //       $('#passIcon').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
    //       $('#inputPassword').attr('type','password');
    //     }
    //   });
    // });
  </script>
</body>
</html>
