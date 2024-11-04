<?php

class Usuario extends BaseDatos
{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;

 
    public function __construct($nombreUsuario = "", $email = "", $password = "") {
        parent::__construct();
        $this->id = "";
        $this->nombreUsuario = $nombreUsuario;
        $this->email = $email;
        $this->password = $password;
        $this->mensajeoperacion = "";
    }

    public function setear($id, $nombreUsuario, $password, $email)
    {
        $this->setId($id);
        $this->setNombreUsuario($nombreUsuario);
        $this->setPassword($password);
        $this->setEmail($email);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($valor)
    {
        $this->id = $valor;
    }

    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario($valor)
    {
        $this->nombreUsuario = $valor;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($valor)
    {
        $this->password = $valor;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($valor)
    {
        $this->email = $valor;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeOperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    public function insertar()
    {
        $resp = false;
        $sql = "INSERT INTO usuarios (nombreUsuario, email, password) VALUES ('" . $this->getNombreUsuario() . "', '" . $this->getEmail() . "', '" . $this->getPassword() . "')";

        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;

            } else {
                echo "Error en la inserción: " . $this->getError(); // Error específico si falla
            }
        } else {
            echo "No se pudo iniciar la conexión"; // Error si falla la conexión
        }
        return $resp;
    }

    // para el login del usuario
   

    public function modificar()
    {
        $resp = false;
        $sql = "UPDATE usuarios SET nombreUsuario = '" . $this->getNombreUsuario() . "', password = '" . $this->getPassword() . "', email = '" . $this->getEmail() . "' WHERE id = " . $this->getId();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($this->getError());
            }
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $sql = "DELETE FROM usuarios WHERE id = " . $this->getId();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($this->getError());
            }
        }
        return $resp;
    }

}
