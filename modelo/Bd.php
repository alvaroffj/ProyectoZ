<?php
class Bd {
    var $conex;
    var $pass = "";
    var $user = "";
    var $server = "";
    var $bd = "";
    
    function __construct($user="flawers_z", $pass="proyectoz", $server="localhost", $bd="flawers_z") {
        $this->user = $user;
        $this->pass = $pass;
//        $this->user = "root";
//        $this->pass = "";
        $this->server = $server;
        $this->bd = $bd;
        $this->conecta();
    }

    function conecta() {
        $this->conex = mysql_connect($this->server, $this->user, $this->pass) or die("En este momento no podemos procesar su peticion, intentelo más tarde");
        mysql_select_db($this->bd);
    }

    function get_conex() {
        return $this->conex;
    }

    function sql($sql) {
        $res = mysql_query($sql, $this->get_conex()) or ($res = false);
        return $res;
    }

    function limpia($s) {
        return mysql_real_escape_string($s);
    }

    function code($s) {
//        return utf8_encode($s);
        return $s;
    }

    function decode($s) {
//        return utf8_decode($s);
        return $s;
    }

    function getArrayFull($res) {
        $r = array();
        $i = 0;
        while($row=mysql_fetch_row($res)) {
                $r[$i] = $row;
                $i++;
        }
        return $r;
    }
}
?>
