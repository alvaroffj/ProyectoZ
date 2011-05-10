<?php
include_once 'Bd.php';

class RespuestaMP {
    protected $_dbTable = "RESPUESTA";
    protected $_id = "ID_RESPUESTA";
    protected $_bd;

    function  __construct() {
        $this->_bd = new Bd();
    }

    function insert($data) {
        $data->idCom = $this->_bd->limpia($data->idCom);
        $data->idUser = $this->_bd->limpia($data->idUser);
        $data->idMenCom = $this->_bd->limpia($data->idMenCom);
        $data->idMenUser = $this->_bd->limpia($data->idMenUser);
        $data->idMen = $this->_bd->limpia($data->idMen);
        $data->txtMen = $this->_bd->limpia($data->txtMen);
        $data->estMen = $this->_bd->limpia($data->estMen);
        $fecha = date("Y-m-d H:i:s");

        $sql = "INSERT INTO $this->_dbTable (ID_COMUNIDAD, ID_USUARIO, MEN_ID_COMUNIDAD, MEN_ID_USUARIO, ID_MENSAJE, TXT_RESPUESTA, ESTADO_RESPUESTA, FECHA_RESPUESTA) VALUES
                (".$data->idCom.", ".$data->idUser.", ".$data->idMenCom.", ".$data->idMenUser.", ".$data->idMen.", '".$data->txtMen."', ".$data->estMen.", '".$fecha."')";
//        echo $sql."<br>";
        $res = $this->_bd->sql($sql);
    }

    function fetchByMensaje($idMen) {
        $idMen = $this->_bd->limpia($idMen);
        
        $sql = "SELECT R.*,
                    U.NOM_USUARIO,
                    U.APE_USUARIO
                FROM $this->_dbTable AS R
                    INNER JOIN USUARIO AS U
                ON
                    R.ID_USUARIO = U.ID_USUARIO
                    AND R.ID_MENSAJE = $idMen";
        
        $res = $this->_bd->sql($sql);
        $arr = array();
        while($row = mysql_fetch_object($res)) {
            $arr[] = $row;
        }
        return $arr;
    }
}
?>
