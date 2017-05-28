<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="container">
	<?php if(isset($_SESSION['errors'])): ?>
		<?php foreach ($_SESSION['errors'] as $error): ?>
			<div class="alert alert-danger alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<?php echo $error; ?>
			</div>               
		<?php endforeach; ?>
	<?php elseif(isset($_SESSION['success'])): ?>
		<div class="alert alert-success alert-dismissable">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<?php echo $_SESSION['success']; ?>
		</div>               
	<?php endif; ?>

	<?php unset($_SESSION['errors']); ?>
	<?php unset($_SESSION['success']); ?>

	<form action="/admin/task/update" method="POST" class="form-horizontal">
		<div class="form-group">
			<label for="exampleTextarea">Text:</label>
			<?php foreach ($task as $t): ?>
				<input type="hidden" name="id" value="<?php echo $t['id'] ?>">
				<textarea name="text" class="form-control" id="exampleTextarea" rows="3"><?php echo $t['text'] ?></textarea>
			<?php endforeach; ?>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-success col-md-12">Update</button>
		</div>
	</form>
</div>
	
<?php include ROOT . '/views/layouts/footer.php'; ?>