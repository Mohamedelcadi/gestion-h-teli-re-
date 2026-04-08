<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin | Hotel Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>

</head>
<style>
	body {
		width: 100%;
		height: 100vh;
		background: #f4f6f9;
		overflow: hidden;
	}
	
	.login-container {
		height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		background: linear-gradient(135deg, rgba(0,0,0,0.02) 0%, rgba(255,255,255,0.1) 100%);
	}
	
	.login-box {
		background: white;
		border-radius: 20px;
		box-shadow: 0 0 40px rgba(0,0,0,0.1);
		overflow: hidden;
		width: 1000px;
		max-width: 90%;
		display: flex;
		animation: slideIn 0.5s ease-out;
	}
	
	.login-left {
		flex: 1;
		background-image: url(../assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
		background-size: cover;
		background-position: center;
		position: relative;
		min-height: 500px;
	}
	
	.login-left::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: linear-gradient(45deg, rgba(0,0,0,0.5), rgba(0,0,0,0.2));
	}
	
	.login-right {
		flex: 1;
		padding: 50px;
	}
	
	.login-header {
		text-align: center;
		margin-bottom: 40px;
	}
	
	.login-header h1 {
		font-size: 2em;
		color: #333;
		margin-bottom: 10px;
	}
	
	.form-group {
		margin-bottom: 25px;
	}
	
	.form-control {
		height: 50px;
		border-radius: 10px;
		border: 2px solid #e1e1e1;
		padding: 10px 15px;
		font-size: 16px;
		transition: all 0.3s ease;
	}
	
	.form-control:focus {
		border-color: #4A90E2;
		box-shadow: 0 0 0 0.2rem rgba(74,144,226,0.25);
	}
	
	.btn-login {
		height: 50px;
		border-radius: 10px;
		background: #4A90E2;
		border: none;
		color: white;
		font-weight: 600;
		font-size: 16px;
		transition: all 0.3s ease;
		width: 100%;
		margin-top: 20px;
	}
	
	.btn-login:hover {
		background: #357ABD;
		transform: translateY(-2px);
	}
	
	.form-label {
		font-weight: 600;
		color: #333;
		margin-bottom: 8px;
	}
	
	.alert {
		border-radius: 10px;
		padding: 15px;
		margin-bottom: 20px;
	}
	
	@keyframes slideIn {
		from {
			opacity: 0;
			transform: translateY(20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	
	@media (max-width: 768px) {
		.login-box {
			flex-direction: column;
		}
		.login-left {
			min-height: 200px;
		}
		.login-right {
			padding: 30px;
		}
	}
</style>

<body>


  <div class="login-container">
  	<div class="login-box">
  		<div class="login-left">
  		</div>
  		<div class="login-right">
  			<div class="login-header">
  				<h1>Welcome Back</h1>
  				<p class="text-muted">Please login to your account</p>
  			</div>
  			<form id="login-form">
  				<div class="form-group">
  					<label for="username" class="form-label">Username</label>
  					<div class="input-group">
  						<span class="input-group-text"><i class="fas fa-user"></i></span>
  						<input type="text" id="username" name="username" class="form-control" placeholder="Enter your username">
  					</div>
  				</div>
  				<div class="form-group">
  					<label for="password" class="form-label">Password</label>
  					<div class="input-group">
  						<span class="input-group-text"><i class="fas fa-lock"></i></span>
  						<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
  					</div>
  				</div>
  				<button type="submit" class="btn btn-login">
  					<i class="fas fa-sign-in-alt me-2"></i> Login
  				</button>
  			</form>
  		</div>
  	</div>
  </div>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="submit"]').attr('disabled',true).html('<i class="fas fa-spinner fa-spin me-2"></i> Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				$('#login-form button[type="submit"]').removeAttr('disabled').html('<i class="fas fa-sign-in-alt me-2"></i> Login');
			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else if(resp == 2){
					location.href ='voting.php';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i> Username or password is incorrect.</div>')
					$('#login-form button[type="submit"]').removeAttr('disabled').html('<i class="fas fa-sign-in-alt me-2"></i> Login');
				}
			}
		})
	})
</script>	
</html>