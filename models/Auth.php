<?php

class Auth
{
    /**
     * Check data user and return user id
     *
     * @param {string} $login - user login
     * @param {string} $password - user password
     * @return {number} $user['id']
     */
    public static function check_user($login, $password) {

        $db = Db::get_connection();

        $sql = 'SELECT id, login, password FROM users WHERE login = :login';
        /*
            Подготавливает запрос к выполнению и возвращает ассоциированный с этим запросом объект
        */
        $query = $db->prepare($sql);
        $query->bindParam(':login', $login, PDO::PARAM_INT);
        /*
            Запускает подготовленный запрос на выполнение
        */
        $query->execute();
        /*
            Извлекает следующую строку из результирующего набора объекта PDOStatement
        */
        $user = $query->fetch();

        if ($login != $user['login']) {
            return false;
        }
        if (!password_verify($password, $user['password'])) {
			return false;
        }

        return $user['id'];
    }

    /**
     * Checks login user or not
     *
     * @return {boolean}
     */
    public static function is_guest()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
        	return false;
        }
    }
}