<?php
include_once 'modelo/UsuarioMP.php';

class CLog {
    protected $cp;
    protected $usuMP;
    protected $login;
    protected $layout;

    function __construct($cp) {
        $this->cp = $cp;
        $this->usuMP = new UsuarioMP();
        $this->layout = "vista/login.phtml";
        $this->cp->thisLayout = false;
        $this->setDo();
        $this->setOp();
    }

    function logout() {
        $this->cp->getSession()->kill();
        $this->cp->getSession()->salto("index.php");
    }

    function getLayout() {
        return $this->layout;
    }

    function recuperar() {
        $usu = $this->usuMP->findByUser($_POST["user"]);
        if($usu!=null) {
            include_once '../modelo/class.phpmailer-lite.php';
            $nomFrom = "Mantenedor RSPro.cl";
            $mail = new PHPMailerLite();
            $mail->IsMail();
            $mail->SetFrom("no-reply@jnr.cl", $nomFrom);
            $mail->Subject = "Recuperar Clave - $nomFrom";
            $mail->AddAddress($usu->EMAIL_USUARIO, $nomFrom);
            $pass = $this->genPass();
            $body = "El usuario es <b>".$usu->USER_USUARIO."</b> y su nueva contraseña <b>".$pass."</b><br><br>
                - $nomFrom";
            $mail->MsgHTML($body);
            $success = $mail->Send();
            if($success) {
                $this->usuMP->updatePass($usu->ID_USUARIO, $pass);
                $this->cp->getSession()->salto("?sec=log&e=2");
            } else {
                $this->cp->getSession()->salto("?sec=log&op=rec&e=2");
            }
        } else {
            $this->cp->getSession()->salto("?sec=log&op=rec&e=1");
        }
    }

    function genPass($n=5) {
        $letras = "023456789ABCDEFJHIJKLMNOPQRSTUVWXYZabcdefjhijkmnopqrstuvwxyz";
        $pass = "";
        for($i=0; $i<$n; $i++) {
            $pass .= substr($letras,rand(0,61),1);
        }
        return $pass;
    }

    function checkLogin($data) {
        $this->login = $this->usuMP->validaCuenta($data["user"], $data["pass"]);
        if($this->login != null) {
            $this->cp->getSession()->set("user", $this->login->USER_USUARIO);
            $this->cp->getSession()->set("idUser", $this->login->ID_USUARIO);
            $this->cp->getSession()->set("nomUser", $this->login->NOM_USUARIO);
            $this->cp->getSession()->set("apeUser", $this->login->APE_USUARIO);
            $this->cp->getSession()->set("idCom", $this->login->ID_COMUNIDAD);
            $this->cp->getSession()->salto("index.php");
        } else {
            $this->cp->getSession()->salto("?&e=1");
        }
    }

    function registrar() {
        $usuAux = $this->usuMP->findByUser($_POST["user"], array("ID_USUARIO"));
        if($usuAux != null) {
            $this->cp->getSession()->salto("?sec=log&op=reg&e=1");
        } else {
            $idUs = $this->usuMP->insert($_POST);
            if($idUs>0) {
                $data = array("user"=>$_POST["user"], "pass"=>$_POST["pass"]);
                $this->checkLogin($data);
            }
        }
    }

    function setDo() {
        $do = $_GET["do"];
        switch($do) {
            case 'in':
                $this->checkLogin($_POST);
                break;
            case 'out':
                $this->logout();
                break;
            case 'rec':
                $this->recuperar();
                break;
            case 'reg':
                $this->registrar();
                break;
            default:
                break;
        }
    }

    function setOp() {
        $op = $_GET["op"];
        switch($op) {
            case 'rec':
                $this->layout = "vista/login_recuperar.phtml";
                break;
            case 'reg':
                $this->layout = "vista/login_registrar.phtml";
                break;
            default:
                break;
        }
    }
}
?>
