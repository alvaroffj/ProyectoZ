<?php
include_once 'modelo/MensajeMP.php';
include_once 'modelo/RespuestaMP.php';

class CMensaje {
    protected $cp;
    //protected $layout_pri;
    //protected $layout_res;
    protected $layout;
    protected $menMP;
    protected $repMP;

    function  __construct($cp) {
        $this->cp = $cp;
        $this->layout = "vista/mensaje.phtml";
        //$this->layout_pri = "vista/mensaje.phtml";
        //$this->layout_res= "vista/respuesta.phtml";
        $this->menMP = new MensajeMP();
        $this->repMP = new RespuestaMP();
        $this->setDo();
        $this->setOp();
    }

    function getLayout() {
        return $this->layout;
    }

    function setDo() {
        if(isset($_GET["do"])) {
            $this->cp->showLayout = false;
            $this->do = $_GET["do"];
            switch($this->do) {
                case "reply":
                    $data->idCom = $this->cp->getSession()->get("idCom");
                    $data->idUser = $this->cp->getSession()->get("idUser");
                    $data->idMen = $_POST["idMen"];
                    $data->idMenCom = $_POST["idMenCom"];
                    $data->idMenUser = $_POST["idMenUser"];
                    $data->txtMen = $_POST["txt"];
                    $data->estMen = 1;
                    $this->repMP->insert($data);
                    $this->cp->getSession()->salto("?sec=mensaje");
                    break;
                case "add":
                    $data->idCom = $this->cp->getSession()->get("idCom");
                    $data->idUser = $this->cp->getSession()->get("idUser");
                    $data->idTipoMen = 1;
                    $data->idAlbum = 0;
                    $data->idPri = 1;
                    $data->txtMen = $_POST["txt"];
                    $data->estMen = 1;
                    $data->urlAdj = null;
                    $this->menMP->insert($data);
                    $this->cp->getSession()->salto("?sec=mensaje");
                    break;
            }
        }
    }

    function setOp() {
        if(isset($_GET["op"])){
            $this->op = $_GET["op"];
            switch($this->op) {
                case "reply":
                    $this->mensajes = $this->menMP->fetchReply($_GET["id"]);
                    break;
                default:
                    $this->mensajes = $this->menMP->fetchByComunidad($this->cp->getSession()->get("idCom"));
    //                print_r($this->mensajes);
                    break;
            }
        } else {
            $this->mensajes = $this->menMP->fetchByComunidad($this->cp->getSession()->get("idCom"));
        }
    }

    function getReply($idMen) {
        return $this->repMP->fetchByMensaje($idMen);
    }
}

?>
