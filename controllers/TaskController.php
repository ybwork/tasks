<?php

class TaskController
{
    public $limit = 3;

	/**
	 * Return all tasks
	 *
	 * @return {array} $tasks - all tasks depending on the sort
	 */
	public function index()
	{
        if (!$_GET) {
			$page = 1;
	    	$sort_param = 'id';
	    	$index = '?page=';
        } else {        	
			if (isset($_GET['page']) && isset($_GET['sort'])) {
				$page = $_GET['page'];
	    		$sort_param = $_GET['sort'];
	    		$index = "?sort=$sort_param&page=";
			} elseif (isset($_GET['page']) && !isset($_GET['sort'])) {
				$page = $_GET['page'];
				$sort_param = 'id';
				$index = '?page=';
			} elseif (!isset($_GET['page']) && isset($_GET['sort'])) {
				$page = 1;
				$sort_param = $_GET['sort'];
				$index = "?sort=$sort_param&page=";
			}
        }

		$tasks = Task::get_all($this->limit, $page, $sort_param);

        $count = Task::count();
        $pagination = new Paginator($count['COUNT(*)'], $page, $this->limit, $index);

		require_once(ROOT . '/views/task/index.php');
		return $tasks;
	}

	/**
	 * Sends data for create tasks
	 *
	 */
	public function store()
	{
		$name = '';
		$email = '';
		$text = '';
		$file = '';
		$status = 0;

		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$text = $_POST['text'];
			$file = $_FILES['image'];

			$errors = [];
			
			if (!$name) {
				$errors[] = 'Field name cannot be empty';
			}

			if (!$email) {
				$errors[] = 'Field email cannot be empty';
			} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'Incorrect syntax for email';
			}

			if (!$text) {
				$errors[] = 'Field text cannot be empty';
			}

			if (!$file['name']) {
				$errors[] = 'Field image cannot be empty';
			} else {			
				if(exif_imagetype($file['tmp_name']) != IMAGETYPE_GIF && exif_imagetype($file['tmp_name']) != IMAGETYPE_JPEG && exif_imagetype($file['tmp_name']) != IMAGETYPE_PNG) {
					$errors[] = 'Not correct type file (image can only be of GIF, JPEG or PNG format)';
				}
			}
			
			if (!$errors) {
				$image = $this->download_image($file);
				$result = Task::store($name, $email, $text, $image, $status);
				$_SESSION['success'] = "Task was created successfully";

				header("Location: /"); 
			} else {
				$_SESSION['errors'] = $errors;
				$_SESSION['name'] = $name;
				$_SESSION['email'] = $email;
				$_SESSION['text'] = $text;

				header("Location: /");
			}
		}

		return true;
	}

	/**
	 * Return page for edit task and data select task
	 *
	 * @return {array} $task - select task
	 */
	public function edit()
	{
		$current_url = $_SERVER['REQUEST_URI'];
        $id = preg_replace("/[^0-9]/", '', $current_url);

		$task = Task::edit($id);

		require_once(ROOT . '/views/task/edit.php');
		return $task;
	}

	/**
	 * Sends data for update tasks
	 *
	 */
	public function update()
	{
		$text = '';

		if (isset($_POST['submit'])) {
			$id = $_POST['id'];
			$text = $_POST['text'];

			$errors = [];
			
			if (!$text) {
				$errors[] = 'Field text cannot be empty';
			}

			if (!$errors) {
				Task::update($id, $text);
				$_SESSION['success'] = "Task was updated successfully";

				header("Location: /admin"); 
			} else {
				$_SESSION['errors'] = $errors;
				
				header("Location: /admin/task/edit/$id");
			}
		}

		return true;
	}

	/**
	 * Sends values to change task status
	 *
	 */
	public function mark()
	{
		if (isset($_POST['submit'])) {
			$id = $_POST['id'];
			$text = $_POST['text'];
			$status = 1;

			Task::update($id, $text, $status);
			header("Location: /admin");
		}
	}

	/**
	 * Record file in the directory
	 *
	 * @param {array} $file - info about download file
	 * @return {string} $file - it is name file
	 */
	public function download_image($file) {
		$max_width = 320;
		$max_height = 240;
		/*
			list - присваивает переменным из списка значения
			getimagesize - получение размера изображения
		*/
		list($width, $height, $type, $attr) = getimagesize($file['tmp_name']);

		if ($width > $max_width || $height > $max_height) {
			$target_filename = $file['tmp_name'];
			$fn = $file['tmp_name'];
			$size = getimagesize($fn);
			$ratio = $size[0] / $size[1];

			if($ratio > 1) {
				$width = $max_width;
				$height = $max_height / $ratio;
			} else {
				$width = $max_width * $ratio;
				$height = $max_height;
			}
			/*
				imagecreatefromstring - Создание нового изображения из потока представленного строкой
				file_get_contents - Читает содержимое файла в строку
			*/
			$src = imagecreatefromstring(file_get_contents($fn));
			// Создание нового полноцветного изображения
			$dst = imagecreatetruecolor($width, $height);
			// Копирование и изменение размера изображения с ресемплированием
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			// Вывод PNG изображения в браузер или файл
			imagepng($dst, $target_filename);
		}

		$path = "public/img/" . $file['name'];
		move_uploaded_file($file['tmp_name'], $path);

		return $file['name'];
	}
}