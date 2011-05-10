<?php
include_once 'Bd.php';

class MensajeMP {
    protected $_dbTable = "MENSAJE";
    protected $_id = "ID_MENSAJE";
    protected $_bd;

    function  __construct() {
        $this->_bd = new Bd();
    }

    function insert($data) {
        $data->idCom = $this->_bd->limpia($data->idCom);
        $data->idUser = $this->_bd->limpia($data->idUser);
        $data->idTipoMen = $this->_bd->limpia($data->idTipoMen);
        $data->idAlbum = $this->_bd->limpia($data->idAlbum);
        $data->idPri = $this->_bd->limpia($data->idPri);
        $data->txtMen = $this->_bd->limpia($data->txtMen);
        $data->estMen = $this->_bd->limpia($data->estMen);
        $data->urlAdj = $this->_bd->limpia($data->urlAdj);
        
        $fecha = date("Y-m-d H:i:s");
        $sql = "INSERT INTO $this->_dbTable (ID_COMUNIDAD, ID_USUARIO, ID_TIPO_MENSAJE, ID_ALBUM, ID_PRIVACIDAD, TXT_MENSAJE, ESTADO_MENSAJE, FECHA_MENSAJE, URL_ADJUNTO) VALUES
                (".$data->idCom.", ".$data->idUser.", ".$data->idTipoMen.", ".$data->idAlbum.", ".$data->idPri.", '".$data->txtMen."', ".$data->estMen.", '".$fecha."', '".$data->urlAdj."')";
//        echo $sql."<br>";
        $res = $this->_bd->sql($sql);
    }

    function fetchAll() {
        $sql = "SELECT * FROM $this->_dbTable AS M INNER JOIN USUARIO AS U ON M.ID_USUARIO = U.ID_USUARIO AND M.MEN_ID_MENSAJE = 0";
        $res = $this->_bd->sql($sql);
        $arr = array();
        while($row = mysql_fetch_object($res)) {
            $arr[] = $row;
        }
        return $arr;
    }

    function fetchReply($id) {
        $sql = "SELECT * FROM $this->_dbTable AS M INNER JOIN USUARIO AS U ON M.ID_USUARIO = U.ID_USUARIO AND M.MEN_ID_MENSAJE = $id";
        $res = $this->_bd->sql($sql);
        $arr = array();
        while($row = mysql_fetch_object($res)) {
            $arr[] = $row;
        }
        return $arr;
    }

    function fetchByComunidad($idCom) {
        $idCom = $this->_bd->limpia($idCom);
        $sql = "SELECT
                    M.*,
                    U.NOM_USUARIO,
                    U.APE_USUARIO
                FROM $this->_dbTable AS M
                    INNER JOIN USUARIO AS U
                ON M.ID_USUARIO = U.ID_USUARIO
                    AND M.ID_COMUNIDAD = $idCom
                ORDER BY M.FECHA_MENSAJE DESC";
//        echo $sql."<br>";
        $res = $this->_bd->sql($sql);
        $arr = array();
        while($row = mysql_fetch_object($res)) {
            $arr[] = $row;
        }
        return $arr;
    }
}
?>
