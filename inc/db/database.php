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
    }

    public function signup($email, $name, $password)
    {
        $password_enc = password_hash($password, PASSWORD_DEFAULT);
        $email_link = functions::generateLink();

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

    // =============================================================
    //  contacts
    // =============================================================

    public function selectContactsByUserID()
    {
    }

    public function selectContactsByID()
    {
    }

    public function insertContact()
    {
    }

    public function updateContact()
    {
    }

    public function updateContactRemoveImage()
    {
    }

    public function deleteContact()
    {
    }
}
