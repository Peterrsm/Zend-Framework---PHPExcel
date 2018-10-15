<?php

namespace Comparativo\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class OpcoesController extends AbstractActionController
{

    public function indexAction(){

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




        if($this->request->isPost()){
            $destino_imagens = getcwd() . '/public';
            var_dump($destino_imagens);

            $primeiroxls = $_FILES["primeiroxls"]['tmp_name'];
            $segundoxls = $_FILES["segundoxls"]['tmp_name'];
            $nomeprimeiroxls = $_FILES["primeiroxls"]['name'];
            $nomesegundoxls = $_FILES["segundoxls"]['name'];


            $excelReader = \PHPExcel_IOFactory::createReaderForFile($primeiroxls);
            $excelObj = $excelReader->load($primeiroxls);
            $worksheet = $excelObj->getActiveSheet();
            $lastRow = $worksheet->getHighestRow();

            $nomes_abas_1 = $excelObj->getSheetNames();


            /*Segundo XLS*/
            $excelReader = \PHPExcel_IOFactory::createReaderForFile($segundoxls);
            $excelObj = $excelReader->load($segundoxls);
            $worksheet = $excelObj->getActiveSheet();
            $lastRow = $worksheet->getHighestRow();

            $nomes_abas_2 = $excelObj->getSheetNames();


            move_uploaded_file($primeiroxls, $destino_imagens . '/' .  $nomeprimeiroxls);
            move_uploaded_file($segundoxls, $destino_imagens . '/' .  $nomesegundoxls);

        }

        return new ViewModel([
            'primeiroxls' => $primeiroxls,
            'segundoxls' => $segundoxls,
            'nomeprimeiroxls' => $nomeprimeiroxls,
            'nomesegundoxls' => $nomesegundoxls,
            'nomes_abas_1' => $nomes_abas_1,
            'nomes_abas_2' => $nomes_abas_2,
            'destino' => $destino_imagens,
        ]);
    }
}

