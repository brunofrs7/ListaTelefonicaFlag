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

            $results = $stmt->fetchAll(PDO::FETCH_CLASS);
            return [
                'status' => 'success',
                'data' => $results,
                'lastID' => $lastID
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
        $params = [':email' => $email];

        $sql = "SELECT * FROM user WHERE email = :email";
        $result = $this->query($sql, $params);

        if ($result['status'] == 'error') {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

        if (count($result['data']) == 0) {
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

        // check is password in correct for the selected user
        if(!password_verify($password, $result['data'][0]->password)){
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

        if($result['data'][0]->email_valid == 0){
            $_SESSION['warning'] = 'Please check your email to validate account';
            header('Location: ?p=signin');
            exit;
        }

        
        if($result['data'][0]->deleted_at != null){
            $_SESSION['error'] = 'Invalid credentials';
            header('Location: ?p=signin');
            exit;
        }

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

    public function validate()
    {
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
