<?php
namespace Comparativo\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        if(!$user = $this->identity()){
            return $this->redirect()->toUrl('/login');
        }
        $usuario = $this->identity()->getNome();
        $avatar = $this->identity()->getAvatar();
        $setor = $this->identity()->getSetor();
        $this->layout()->setVariable('usuario', $usuario);
        $this->layout()->setVariable('avatar', $avatar);
        $this->layout()->setVariable('setor', $setor);

        /* call data base */
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $verificanotificacao = $entityManager->getRepository('Notificacoes\Entity\notificacao');
        /* end */

        $lista = $verificanotificacao->findAll();

        $this->layout()->setVariable('lista', $lista);

        require_once "Service/Classes/PHPExcel.php";

         return new ViewModel();
    }

}

