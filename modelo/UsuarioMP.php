<?php
include_once 'Bd.php';

class UsuarioMP {
    protected $_dbTable = "USUARIO";
    protected $_id = "ID_USUARIO";
    protected $_bd;

    function __construct() {
        $this->_bd = new Bd();
    }

    function fetchAll() {
        $entries = array();
        $sql = "SELECT * FROM ".$this->_dbTable." ORDER BY ".$this->_id." DESC";
        $res = $this->_bd->sql($sql);
        while($row = mysql_fetch_object($res)) {
            $entries[] = $row;
        }
        return $entries;
    }

    function find($id) {
        $id = $this->_bd->limpia($id);
        $sql = "SELECT * FROM ".$this->_dbTable." WHERE ".$this->_id." = $id";
        $res = $this->_bd->sql($sql);
        $row = mysql_fetch_object($res);
        return $row;
    }

    function findByUser($user, $attr=null) {
        if($attr == null) {
            $sAttr = "*";
        } else {
            $sAttr = implode(",",$attr);
        }
        $user = $this->_bd->limpia($user);
        $sql = "SELECT $sAttr FROM ".$this->_dbTable." WHERE USER_USUARIO = '$user'";
        $res = $this->_bd->sql($sql);
        $row = mysql_fetch_object($res);
        return $row;
    }

    function insert($data) {
        $data["nom"] = $this->_bd->limpia($data["nom"]);
        $data["ape"] = $this->_bd->limpia($data["ape"]);
        $data["user"] = $this->_bd->limpia($data["user"]);
        $data["pass"] = md5($this->_bd->limpia($data["pass"]));

        $sql = "INSERT INTO $this->_dbTable (NOM_USUARIO, APE_USUARIO, USER_USUARIO, PASS_USUARIO) VALUES
                ('".$data["nom"]."', '".$data["ape"]."', '".$data["user"]."', '".$data["pass"]."')";
//        echo $sql."<br>";
        $res = $this->_bd->sql($sql);
        return mysql_insert_id();
    }

    public function updatePass($idUser, $pass) {
        $idUser = $this->_bd->limpia($idUser);
        $pass = md5($pass);
        $sql = "UPDATE $this->_dbTable SET PASS_USUARIO = '".$pass."'
                WHERE ID_USUARIO = $idUser";
        $res = $this->_bd->sql($sql);
    }

    public function updatePerfil($data) {
        $data["id"] = $this->_bd->code($this->_bd->limpia($data["id"]));
        $data["user"] = $this->_bd->code($this->_bd->limpia($data["user"]));
        $data["pass"] = $this->_bd->code($this->_bd->limpia($data["pass"]));
        $data["email"] = $this->_bd->code($this->_bd->limpia($data["email"]));
        $data["nombre"] = $this->_bd->code($this->_bd->limpia($data["nombre"]));
        $data["apellido"] = $this->_bd->code($this->_bd->limpia($data["apellido"]));

        if($data["pass"]!="") {
            $pass = "PASS_USUARIO = '".md5($data["pass"])."', ";
        } else $pass = "";
        $sql = "UPDATE ".$this->_dbTable." SET
                    NOM_USUARIO = '".$data["nombre"]."',
                    APE_USUARIO = '".$data["apellido"]."',
                    USER_USUARIO = '".$data["user"]."',
                    $pass
                    EMAIL_USUARIO = '".$data["email"]."'
                WHERE ".$this->_id." = ".$data["id"];
        echo $sql."<br>";
        if($this->_bd->sql($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function validaCuenta($user, $pass, $q=null) {
        if($q!=null) {
            $q = "AND $q";
        }
        $sql = "SELECT * FROM ".$this->_dbTable." WHERE USER_USUARIO = '".$this->_bd->limpia($user)."' AND PASS_USUARIO = '".md5($this->_bd->limpia($pass))."' $q";
        $res = $this->_bd->sql($sql);
        $row = mysql_fetch_object($res);
        $n = mysql_num_rows($res);
        if($n==1) {
            return $row;
        } else return null;
    }
}
?>
