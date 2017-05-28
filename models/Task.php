<?php

class Task
{
	/**
	 * Takes tasks from the database (depending on the sort)
	 *
	 * @param {number} $limit - number task for each page
	 * @param {number} $page - current page
	 * @param {string} $sort_param - param for sort
	 * @return {array} all tasks
	 */
	public static function get_all($limit, $page, $sort_param)
	{			
		$tasks = [];

		$db = Db::get_connection();
		$offset = ($page - 1) * $limit;
		/*
			Выполняет SQL запрос и возвращает результирующий набор в виде объекта PDOStatemen

			Первое число после LIMIT означает, с какой записи надо формировать результат выборки, а второе число означает, какое количество записей всего должно быть.
		*/
		$query = $db->query("SELECT id, name, email, text, image, status FROM tasks ORDER BY $sort_param DESC LIMIT $offset, $limit");

		$i = 0;	
		while ($row = $query->fetch()) { 
			$tasks[$i] ['id'] = $row['id'];
			$tasks[$i] ['name'] = $row['name'];
			$tasks[$i] ['email'] = $row['email'];
			$tasks[$i] ['text'] = $row['text'];
			$tasks[$i] ['image'] = $row['image'];
			$tasks[$i] ['status'] = $row['status'];
			$i++;
		}

		return $tasks;
	}

	/**
	 * Takes tasks in database where status = 0
	 *
	 * @return {array} not done tasks
	 */
	public static function get_not_done()
	{			
		$tasks = []; 

		$db = Db::get_connection();
		$query = $db->query('SELECT t.id, t.name, t.email, t.text, t.image, t.status FROM tasks t WHERE t.status = 0 ORDER BY id DESC');

		$i = 0;	
		while ($row = $query->fetch()) { 
			$tasks[$i] ['id'] = $row['id'];
			$tasks[$i] ['name'] = $row['name'];
			$tasks[$i] ['email'] = $row['email'];
			$tasks[$i] ['text'] = $row['text'];
			$tasks[$i] ['image'] = $row['image'];
			$tasks[$i] ['status'] = $row['status'];
			$i++;
		}

		return $tasks;
	}

	/**
	 * Add task in database
	 *
	 * @param {string} $name - name task
	 * @param {string} $email - email user
	 * @param {string} $text - overview task
	 * @param {string} $image - path to image
	 * @param {integer} $status - done or not done task
	 */
	public static function store($name, $email, $text, $image, $status) {

		$db = Db::get_connection();
		$sql = "INSERT INTO tasks (name, email, text, image, status) VALUES (:name, :email, :text, :image, :status)";
		$query = $db->prepare($sql);
		$query->bindParam(':name', $name, PDO::PARAM_STR);		
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':text', $text, PDO::PARAM_STR);
		$query->bindParam(':image', $image, PDO::PARAM_STR);
		$query->bindParam(':status', $status, PDO::PARAM_STR);

		if ($query->execute()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get select task
	 *
	 * @param {integer} $id - task id
	 * @return {array} select task
	 */
	public static function edit($id)
	{			
		$task = []; 

		$db = Db::get_connection();
		$query = $db->query("SELECT t.id, t.name, t.email, t.text, t.image, t.status FROM tasks t WHERE t.id = $id");

		$i = 0;	
		while ($row = $query->fetch()) { 
			$task[$i] ['id'] = $row['id'];
			$task[$i] ['name'] = $row['name'];
			$task[$i] ['email'] = $row['email'];
			$task[$i] ['text'] = $row['text'];
			$task[$i] ['image'] = $row['image'];
			$task[$i] ['status'] = $row['status'];
			$i++;
		}

		return $task;
	}

	/**
	 * Update select task
	 *
	 * @param {integer} $id - task id
	 * @param {string} $text - new text
	 * @param {integer} $status - status for task
	 */
	public static function update($id, $text, $status=0) 
	{
		$db = Db::get_connection();
		$sql = "UPDATE tasks SET text = :text, status = :status WHERE id = :id";

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);		
		$query->bindParam(':text', $text, PDO::PARAM_STR);		
		$query->bindParam(':status', $status, PDO::PARAM_STR);		
		$result = $query->execute();

		if (!$result) {
			return false;
		} else {
			return true;			
		}
	}

	/**
	 * Considers the total number of tasks
	 *
	 * @return {integer} total number of tasks
	 */
	public static function count()
	{			
		$tasks = []; 

		$db = Db::get_connection();
		$query = $db->query("SELECT COUNT(*) FROM tasks");
		$row = $query->fetch();

		return $row;
	}
}