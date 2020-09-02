<?php

namespace App\src\Model\DAO;

use App\src\Parameter;
use App\src\Model\User;

/**
 * Class UserDAO
 * @package App\src\Model\DAO
 */
class UserDAO extends DAO
{
    /**
     * @param array $row
     * @return User
     */
    public function buildObject(array $row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);
        $user->setCreatedAt($row['createdAt']);
        $user->setRole($row['roleName']);
        $user->setEmail($row['email']);
        $user->setIsAdmin($row['roleId']);

        return $user;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        $sql = 'SELECT user.id, user.pseudo, user.createdAt, role.id AS roleId, role.name AS roleName, user.email 
                FROM user 
                    INNER JOIN role ON role.id = user.role_id 
                ORDER BY user.id DESC';
        $result = $this->createQuery($sql);
        $users = [];

        foreach ($result as $row) {
            $userId = $row['id'];
            $users[$userId] = $this->buildObject($row);
        }

        $result->closeCursor();
        return $users;
    }

    /**
     * @param string $pseudo
     * @return User
     */
    public function getUser(string $pseudo)
    {
        $sql = 'SELECT user.id, user.pseudo, user.createdAt, role.id AS roleId, role.name AS roleName, user.email 
                FROM user 
                    INNER JOIN role ON role.id = user.role_id 
                WHERE user.pseudo = ? 
                ORDER BY user.id DESC';
        $result = $this->createQuery($sql, [$pseudo]);
        $user = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($user);
    }

    /**
     * @param Parameter $post
     */
    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO user (pseudo, password, createdAt, role_id, email) 
                VALUES (?,?,NOW(),?,?)';
        $this->createQuery($sql, [
            $post->get('pseudo'),
            password_hash($post->get('password'), PASSWORD_BCRYPT),
            2,
            $post->get('email')
        ]);
    }

    /**
     * @param Parameter $post
     * @param string $valueToCheck
     * @param string $fieldToCheck
     * @param string $param
     * @return mixed|string
     */
    public function checkUser(Parameter $post, string $valueToCheck, string $fieldToCheck, string $param)
    {
        $sql = '';

        if ($fieldToCheck === 'pseudo') {
            $sql = 'SELECT COUNT(pseudo) 
                    FROM user 
                    WHERE pseudo = ?';
        } elseif ($fieldToCheck === 'email') {
            $sql = 'SELECT COUNT(email) 
                    FROM user 
                    WHERE email = ?';
        }

        $result = $this->createQuery($sql, [$post->get($valueToCheck)]);
        $isUnique = $result->fetchColumn();

        if ($param === 'register') {
            if ($isUnique && $fieldToCheck === 'pseudo') {
                return '<p>Ce pseudo n\'est pas disponible</p>';
            }
            elseif ($isUnique && $fieldToCheck === 'email') {
                return '<p>Un compte associé à cet e-mail existe déjà ! <a href="../public/index.php?route=login">Je me connecte</a> </p>';
            }
        } elseif($param === 'login') {
            return $isUnique;
        }
    }

    /**
     * @param Parameter $post
     * @param string $field
     * @return array
     */
    public function checkPassword(Parameter $post, string $field)
    {
        if ($field === 'pseudo') {
            $sql = 'SELECT user.id, user.pseudo, user.password, user.role_id AS roleId, role.name AS roleName, user.email, user.createdAt 
                    FROM user 
                        INNER JOIN role ON role.id = user.role_id 
                    WHERE pseudo = ?';
        } elseif($field === 'email') {
            $sql = 'SELECT user.id, user.pseudo, user.password, user.role_id AS roleId, role.name AS roleName, user.email, user.createdAt 
                    FROM user 
                        INNER JOIN role ON role.id = user.role_id 
                    WHERE email = ?';
        }

        $data = $this->createQuery($sql, [$post->get('pseudo')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);

        if ($isPasswordValid) {
            return [
                'result' => $result,
                'isPasswordValid' => $isPasswordValid,
                'user' => $this->buildObject($result)
            ];
        }
    }

    /**
     * @param Parameter $post
     * @param string $pseudo
     */
    public function updatePassword(Parameter $post, string $pseudo)
    {
        $sql = 'UPDATE user 
                SET password = ? 
                WHERE pseudo = ?';
        $this->createQuery($sql, [
            password_hash($post->get('password'), PASSWORD_BCRYPT),
            $pseudo
        ]);
    }

    /**
     * @param Parameter $post
     * @param string $pseudo
     */
    public function updateEmail(Parameter $post, string $pseudo)
    {
        $sql = 'UPDATE user 
                SET email = ? 
                WHERE pseudo = ?';
        $this->createQuery($sql, [
            $post->get('email'),
            $pseudo
        ]);
    }

    /**
     * @param string $userId
     */
    public function deleteUser(string $userId)
    {
        $sql = 'DELETE 
                FROM user 
                WHERE id = ?';
        $this->createQuery($sql, [$userId]);
    }
}