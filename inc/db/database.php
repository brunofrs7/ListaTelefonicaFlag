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
        if ($email == "user1@gmail.com" && $password == "user1") {
            $_SESSION['id'] = 1;
            return [
                'status' => 'success',
            ];
        } else {
            $_SESSION['error'] = 'Invalid credentials';
            return [
                'status' => 'error',
            ];
        }
    }
}
