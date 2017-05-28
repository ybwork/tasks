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

	<form action="/task/store" method="POST" id="form_create" enctype="multipart/form-data" class="form-horizontal">
		<div class="form-group">
			<label for="email">Name:</label>
			<input type="text" name="name" value="<?php isset($_SESSION['name']) ? print $_SESSION['name'] : ''; ?>" class="form-control">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="text" name="email" value="<?php isset($_SESSION['email']) ? print $_SESSION['email'] : ''; ?>" class="form-control">
		</div>
		<div class="form-group">
			<label for="exampleTextarea">Text:</label>
			<textarea name="text" class="form-control" id="exampleTextarea" rows="3"><?php isset($_SESSION['text']) ? print $_SESSION['text'] : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="exampleInputFile">File input</label>
			<input type="file" name="image" id="image" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-success col-md-5">Add</button>
			<div class="col-md-2"></div>
			<button type="button" id="preview" class="btn btn-success col-md-5">Preview</button>
		</div>
	</form>

	<?php unset($_SESSION['name']); ?>
	<?php unset($_SESSION['email']); ?>
	<?php unset($_SESSION['text']); ?>

	<?php if(count($tasks) >= 1): ?>
		<div class="sort btn-group" role="group" aria-label="...">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Sort by
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="/?sort=name">Name</a></li>
					<li><a href="/?sort=email">Email</a></li>
					<li><a href="/?sort=status">Status</a></li>
				</ul>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<?php foreach ($tasks as $task): ?>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<img src="/public/img/<?php echo $task['image']; ?>">
					<div class="caption">
							<label>Status: </label>
						<?php if($task['status'] == 0): ?>
							<span class="label label-danger">Not done</span>
						<?php else: ?>
							<span class="label label-success">Done</span>
						<?php endif; ?>
						<br/>
						<label>Name: <?php echo $task['name']; ?></label>
						<br/>
						<label>Email: <?php echo $task['email']; ?></label>
						<p><?php echo $task['text']; ?></p>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="modal fade" id="preview_modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<div class="col-sm-6 col-md-4">
								<div class="thumbnail">
									<img src="" width="100" height="100">
									<div class="caption">
										<label>Status: </label>
										<span class="label label-danger">Not done</span>
										<br>
										<label>
											Name: 
											<span class="preview_name"></span>
										</label>
											<br>
										<label>
											Email:
											<span class="preview_email"></span>
										</label>
										<p class="preview_text"></p>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="pagin">
	<?php if($count["COUNT(*)"] >= 4): ?>
		<?php echo $pagination->get(); ?>
	<?php endif; ?>
	</div>
</div>
	
<?php include ROOT . '/views/layouts/footer.php'; ?>