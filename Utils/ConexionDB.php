<?php

if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

class ConexionDB {

    public function getConexion() {

        $host = "localhost"; // 👈 aquí defines el host
        $dbname = "lunapict_tienda";
        $user = "lunapict";
        $password = "Psv@pyimvj78";

        try {
            $cnx = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $password
            );
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $cnx;

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>