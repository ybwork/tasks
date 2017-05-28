<?php include ROOT . '/views/layouts/header.php'; ?>

	<div class="container">
	    <?php if (isset($errors)): ?>
            <?php foreach ($errors as $error): ?>
            	<div class="alert alert-danger">
					<?php echo $error; ?>
				</div>
            <?php endforeach; ?>
	    <?php endif; ?>

		<form action="/admin/login" method="POST" class="form-horizontal">
			<div class="form-group">
				<label for="email">Login:</label>
				<input type="text" name="login" value="<?php isset($login) ? print $login : ''; ?>" class="form-control">
			</div>
			<div class="form-group">
				<label for="pwd">Password:</label>
				<input type="password" name="password" value="<?php isset($password) ? print $password : ''; ?>" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" name="submit" class="btn btn-success col-md-12">Go</button>
			</div>
		</form>
	</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>