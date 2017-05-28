<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="container">
	<?php if(isset($_SESSION['success'])): ?>
		<div class="alert alert-success alert-dismissable">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <?php echo $_SESSION['success']; ?>
		</div>               
			
		<?php unset($_SESSION['success']); ?>
	<?php endif; ?>

	<?php if(count($tasks) != 0): ?>
		<table class="table table-condensed">
			<thead>
			  <tr>
				<th>Name</th>
				<th>Email</th>
				<th>Text</th>
				<th>Image</th>
				<th>Action</th>
			  </tr>
			</thead>
			<tbody>
				<?php foreach ($tasks as $task): ?>
				  <tr>
					<td><?php echo $task['name']; ?></td>
					<td><?php echo $task['email']; ?></td>
					<td><?php echo $task['text']; ?></td>
					<td><img src="/public/img/<?php echo $task['image']; ?>" width="100" height="100"></td>
					<td>
						<form action="/admin/task/mark" method="POST">
							<input type="hidden" name="id" value="<?php echo $task['id']; ?>">
							<input type="hidden" name="text" value="<?php echo $task['text']; ?>">
							<input type="hidden" name="status" value="1">
							<button type="submit" name="submit" class="btn btn-success">Done</button>
						</form>
						<br/>
						<a href="admin/task/edit/<?php echo $task['id']; ?>" class="btn btn-info">Edit</a>
					</td>
				  </tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>