<?php

class database
{
    private function query($sql, $params = [])
    {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $lastID = $pdo->lastInsertId();
            $affectedRows = $stmt->rowCount();

            $results = $stmt->fetchAll(PDO::FETCH_CLASS);

            return [
                'status' => 'success',
                'data' => $results,
                'lastID' => $lastID,
                'affectedRows' => $affectedRows
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'data' => $e->getMessage()
            ];
        }
    }

    // ==============================================================================
    // users
    // ==============================================================================

    public function signin($email, $password)
    {
        // check user in database
        $params = [
            ':email' => $email
        ];

        $sql = "SELECT * FROM user WHERE email = :email AND deleted_at IS NULL";
        $result = $this->query($sql, $params);

        // for debug
        //echo "<pre>";
        //die(print_r($result));

        // check if the query return an error
        if ($result['status'] == 'error') {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

        // check if there isn't a user with this email
        if (count($result['data']) == 0) {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

        // check is password in correct for the selected user
        if (!password_verify($password, $result['data'][0]->password)) {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

        // check if the account have been validated by email click
        if ($result['data'][0]->email_valid == 0) {
            $_SESSION['warning'] = 'Please check your email to validate account';
            header('Location: ?p=signin');
            exit;
        }

        // check if the account has not been deleted 
        /*if ($result['data'][0]->deleted_at != null) {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }*/

        $_SESSION['id'] = $result['data'][0]->id;
        //$_SESSION['name'] = $result['data'][0]->name;
        //$_SESSION['email'] = $result['data'][0]->email;
    }

    public function signup($email, $name, $password, $email_link)
    {
        $password_enc = password_hash($password, PASSWORD_DEFAULT);
        //$email_link = functions::generateLink();

        $params = [
            ':email'        => $email,
            ':name'         => $name,
            ':password'     => $password_enc,
            ':email_link'   => $email_link,
        ];

        $sql = "INSERT INTO user (email, password, name, email_link, created_at)
                VALUES (:email, :password, :name, :email_link, NOW())";

        return $this->query($sql, $params);
    }

    public function validateSignupLinkExists($email_link)
    {
        $params = [
            ':email_link' => $email_link,
        ];

        $sql = "SELECT COUNT(email_link) AS quantity FROM user WHERE email_link = :email_link";

        $res = $this->query($sql, $params);

        if ($res['data'][0]->quantity == 0) {
            return true;
        }
        return false;
    }

    public function validateRecoverLinkExists($email_recover)
    {
        $params = [
            ':email_recover' => $email_recover,
        ];

        $sql = "SELECT COUNT(email_recover) AS quantity FROM user WHERE email_recover = :email_recover";

        $res = $this->query($sql, $params);

        if ($res['data'][0]->quantity == 0) {
            return true;
        }
        return false;
    }
    public function userEmailExists($email)
    {
        $params = [
            ':email' => $email,
        ];

        $sql = "SELECT COUNT(email) AS quantity FROM user WHERE email = :email";

        $res = $this->query($sql, $params);

        if ($res['data'][0]->quantity == 1) {
            return true;
        }
        return false;
    }
    public function recoverLinkExists($email_recover)
    {
        $params = [
            ':email_recover' => $email_recover,
        ];

        $sql = "SELECT COUNT(email_recover) AS quantity FROM user WHERE email_recover = :email_recover";

        $res = $this->query($sql, $params);

        if ($res['data'][0]->quantity == 1) {
            return true;
        }
        return false;
    }

    public function validate($email_link)
    {
        $params = [
            ':email_link'   => $email_link,
        ];

        $sql = "UPDATE user 
                SET email_link = NULL, email_valid = 1, email_validated_at = NOW()
                WHERE email_link = :email_link";

        return $this->query($sql, $params);
    }

    public function selectUserByID($id)
    {
        $params = [
            ':id' => $id
        ];

        $sql = "SELECT name, email, photo FROM user WHERE id = :id AND deleted_at IS NULL";
        return $this->query($sql, $params);
    }

    public function generateRecoverPasswordLink($email, $email_recover)
    {
        $params = [
            ':email'           => $email,
            ':email_recover'   => $email_recover,
        ];

        $sql = "UPDATE user 
                SET email_recover = :email_recover, updated_at = NOW()
                WHERE email = :email";

        return $this->query($sql, $params);
    }

    public function updateImageUser($id)
    {
        $params = [
            ':id'        => $id,
            ':photo'     => "$id.png"
        ];

        $sql = "UPDATE user 
                SET photo = :photo, updated_at = NOW()
                WHERE id = :id ";

        return $this->query($sql, $params);
    }

    public function updatePasswordUser($id, $new_password)
    {
        $password_enc = password_hash($new_password, PASSWORD_DEFAULT);

        $params = [
            ':id'        => $id,
            ':password'  => $password_enc,
        ];

        $sql = "UPDATE user 
                SET password = :password, updated_at = NOW()
                WHERE id = :id ";

        return $this->query($sql, $params);
    }

    public function updatePassword($email_recover, $new_password)
    {
        $password_enc = password_hash($new_password, PASSWORD_DEFAULT);

        $params = [
            ':password'        => $password_enc,
            ':email_recover'   => $email_recover,
        ];

        $sql = "UPDATE user 
                SET email_recover = NULL, password = :password, updated_at = NOW()
                WHERE email_recover = :email_recover ";

        return $this->query($sql, $params);
    }

    public function updateUser($id, $name, $email)
    {
        $params = [
            ':id'     => $id,
            ':name'   => $name,
            ':email'  => $email,
        ];

        $sql = "UPDATE user 
                SET name = :name, email = :email, updated_at = NOW()
                WHERE id = :id ";

        return $this->query($sql, $params);
    }

    public function updateUserRemovePhoto($id)
    {
        $params = [
            ':id' => $id,
        ];

        $sql = "UPDATE user 
                SET photo = NULL, updated_at = NOW()
                WHERE id = :id";
        return $this->query($sql, $params);
    }

    public function softDeleteUser($id)
    {
        $params = [
            ':id'     => $id,
        ];

        $sql = "UPDATE user 
                SET deleted_at = NOW()
                WHERE id = :id ";

        return $this->query($sql, $params);
    }

    public function deleteUser($id)
    {
        $params = [
            ':id'     => $id,
        ];

        $sql = "DELETE user 
                WHERE id = :id ";

        return $this->query($sql, $params);
    }

    // =============================================================
    //  contacts
    // =============================================================

    public function selectContactsByUserID($user_id, $search = null)
    {
        if ($search == null) {
            $params = [
                ':user_id' => $user_id
            ];

            $sql = "SELECT * FROM contact WHERE user_id = :user_id AND deleted_at IS NULL ORDER BY name ASC";
        } else {
            $params = [
                ':user_id' => $user_id,
                ':search' => "%$search%"
            ];

            $sql = "SELECT * FROM contact 
                    WHERE user_id = :user_id 
                    AND deleted_at IS NULL 
                    AND (name LIKE :search OR email LIKE :search OR phone LIKE :search)
                    ORDER BY name ASC";
        }
        return $this->query($sql, $params);
    }

    public function selectContactByID($id, $user_id)
    {
        $params = [
            ':id' => $id,
            ':user_id' => $user_id
        ];
        $sql = "SELECT * FROM contact WHERE id = :id AND user_id = :user_id AND deleted_at IS NULL";
        return $this->query($sql, $params);
    }

    public function insertContact($name, $phone, $email, $user_id)
    {
        $params = [
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':user_id' => $user_id
        ];

        $sql = "INSERT INTO contact (name, phone, email, created_at, user_id)
                VALUES (:name, :phone, :email, NOW(), :user_id)";
        return $this->query($sql, $params);
    }

    public function insertPhoto($id)
    {
        $params = [
            ':id' => $id,
            ':photo' => "$id.png"
        ];

        $sql = "UPDATE contact
                SET photo = :photo 
                WHERE id = :id";

        return $this->query($sql, $params);
    }

    public function updateContact($id, $name, $phone, $email, $user_id, $photo = null)
    {
        if ($photo != null) {
            $params = [
                ':id' => $id,
                ':name' => $name,
                ':phone' => $phone,
                ':email' => $email,
                ':photo' => $photo,
                ':user_id' => $user_id
            ];

            $sql = "UPDATE contact 
                SET name = :name, phone = :phone, email = :email, photo = :photo, updated_at = NOW()
                WHERE id = :id AND user_id = :user_id";
        } else {
            $params = [
                ':id' => $id,
                ':name' => $name,
                ':phone' => $phone,
                ':email' => $email,
                ':user_id' => $user_id
            ];

            $sql = "UPDATE contact 
                SET name = :name, phone = :phone, email = :email, updated_at = NOW()
                WHERE id = :id AND user_id = :user_id";
        }

        return $this->query($sql, $params);
    }

    public function updateContactRemovePhoto($id, $user_id)
    {
        $params = [
            ':id' => $id,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE contact 
                SET photo = NULL, updated_at = NOW()
                WHERE id = :id AND user_id = :user_id";
        return $this->query($sql, $params);
    }

    public function softDeleteContact($id, $user_id)
    {
        $params = [
            ':id' => $id,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE contact 
                SET deleted_at = NOW(), photo = NULL
                WHERE id = :id AND user_id = :user_id";

        return $this->query($sql, $params);
    }

    public function deleteContact($id, $user_id)
    {
        $params = [
            ':id' => $id,
            ':user_id' => $user_id
        ];

        $sql = "DELETE FROM contact
                WHERE id = :id AND user_id = :user_id";

        return $this->query($sql, $params);
    }
}
