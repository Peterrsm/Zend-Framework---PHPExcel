<?php

namespace Comparativo\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ColunaController extends AbstractActionController
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

        $primeiroxls = $this->request->getPost('primeiroxls');
        $nomeprimeiroxls = $this->request->getPost('nomeprimeiroxls');
        $segundoxls = $this->request->getPost('segundoxls');
        $nomesegundoxls = $this->request->getPost('nomesegundoxls');
        $primeiratab = $this->request->getPost('primeiratab');
        $segundatab = $this->request->getPost('segundatab');
        $destino = $this->request->getPost('destino');
        //var_dump($nomeprimeiroxls);

        $primeiroxls = $destino . '\\' . $nomeprimeiroxls;

        $segundoxls = $destino . '\\' . $nomesegundoxls;

        /*Primeiro XLS*/
        $tmpfname = $primeiroxls;

        $excelReader = \PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheetByName($primeiratab);
        $lastRow = $worksheet->getHighestRow();

        $nomes_abas_1 = $excelObj->getSheetNames();


        $colunas_planilha_1 = array();

        /* Nomes das colunas - Planilha 1 */
        $i = 'A';

        while($i != 'K'){
            if($worksheet->getCell($i.'1')->getValue() != null && $worksheet->getCell($i.'1')->getValue() != ''){

                array_push($colunas_planilha_1, $worksheet->getCell($i.'1')->getValue());
            }

            switch($i){
                case 'A':
                    $i = 'B';
                    break;
                case 'B':
                    $i = 'C';
                    break;
                case 'C':
                    $i = 'D';
                    break;
                case 'D':
                    $i = 'E';
                    break;
                case 'E':
                    $i = 'F';
                    break;
                case 'F':
                    $i = 'G';
                    break;
                case 'G':
                    $i = 'H';
                    break;
                case 'H':
                    $i = 'I';
                    break;
                case 'I':
                    $i = 'J';
                    break;
                case 'J':
                    $i = 'K';
                    break;
            }
        }







        /*Segundo XLS*/
        $tmpfname = $segundoxls;

        $excelReader = \PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        //$worksheet = $excelObj->getActiveSheet();
        $worksheet = $excelObj->getSheetByName($segundatab);
        $lastRow = $worksheet->getHighestRow();

        $nomes_abas_2 = $excelObj->getSheetNames();



        $colunas_planilha_2 = array();

        /* Nomes das colunas - Planilha 2 */
        $i = 'A';

        while($i != 'K'){
            if($worksheet->getCell($i.'1')->getValue() != null && $worksheet->getCell($i.'1')->getValue() != ''){

                array_push($colunas_planilha_2, $worksheet->getCell($i.'1')->getValue());
            }

            switch($i){
                case 'A':
                    $i = 'B';
                    break;
                case 'B':
                    $i = 'C';
                    break;
                case 'C':
                    $i = 'D';
                    break;
                case 'D':
                    $i = 'E';
                    break;
                case 'E':
                    $i = 'F';
                    break;
                case 'F':
                    $i = 'G';
                    break;
                case 'G':
                    $i = 'H';
                    break;
                case 'H':
                    $i = 'I';
                    break;
                case 'I':
                    $i = 'J';
                    break;
                case 'J':
                    $i = 'K';
                    break;
            }
        }
    }






        return new ViewModel([
            'colunas_planilha_2' => $colunas_planilha_2,
            'colunas_planilha_1' => $colunas_planilha_1,
            'primeiroxls' => $primeiroxls,
            'segundoxls' => $segundoxls,
            'nomeprimeiroxls' => $nomeprimeiroxls,
            'nomesegundoxls' => $nomesegundoxls,
            'primeiratab' => $primeiratab,
            'segundatab' => $segundatab,
            'destino' => $destino,
        ]);
    }
}

