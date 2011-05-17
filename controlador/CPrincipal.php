<?php
include_once 'util/session.php';
include_once 'util/paginacion.php';

class CPrincipal {
    protected $_CSec;
    protected $ss;
    protected $usuarioMP;
    public $layout = "vista/layout.phtml";
    public $showLayout = true;
    public $thisLayout = true;
    public $loged = false;
    public $usuario;

    function __construct() {
        $this->ss = new session();
        //prueba
//        print_r($_SESSION);
        if ($this->checkLogin()) {
            $this->setSec();
        } else {
            include_once 'CLog.php';
            $this->_CSec = new CLog($this);
        }
    }

    public function getLayout() {
        if($this->thisLayout) return $this->layout;
        else return $this->_CSec->getLayout();
    }

    function getCSec() {
        return $this->_CSec;
    }

    function getSession() {
        return $this->ss;
    }

    function checkLogin() {
        return ($this->ss->existe("idUser"));
//        return true;
    }

    function error($e) {
        switch($e) {
            case '404':
                $this->showLayout = false;
                echo "error 404<br>";
                break;
        }
    }

    function setSec() {
        $this->sec = $_GET["sec"];
        $this->showLayout = true;
        $this->thisLayout = true;
//        echo $this->sec."<br>";
        switch($this->sec) {
            case 'log':
                include_once 'CLog.php';
                $this->_CSec = new CLog($this);
                break;
            case 'mensaje':
                include_once 'CMensaje.php';
                $this->_CSec = new CMensaje($this);
                break;
            default:
//                echo "loged<br>";
                break;
        }
    }

}
?>
