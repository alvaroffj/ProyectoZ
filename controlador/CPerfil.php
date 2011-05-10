<?php
include_once '../modelo/UsuarioMP.php';

class CPerfil {
    protected $cp;
    protected $usuMP;
    protected $layout;

    function __construct($cp) {
        $this->cp = $cp;
        $this->usuMP = new UsuarioMP();
        $this->layout = "vista/perfil.phtml";
        $this->op = "mod";
        $this->setDo();
        $this->obj = $this->usuMP->find($this->cp->getSession()->get("user_idUser"));
    }

    function getLayout() {
        return $this->layout;
    }

    function setDo() {
        $do = $_GET["do"];
        switch($do) {
            case 'mod':
                if(count($_POST)>1) {
                    $this->cp->showLayout = false;
                    $this->usuMP->updatePerfil($_POST);
                    $this->cp->getSession()->salto("?sec=per&e=0");
                }
                break;
            case 'del':
                break;
            default:
                break;
        }
    }
}
?>
