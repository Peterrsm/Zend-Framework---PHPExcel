<?php

namespace Comparativo\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ComparativoController extends AbstractActionController
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
            $nomes_abas_1 = $this->request->getPost('nomes_abas_1');
            $nomes_abas_2 = $this->request->getPost('nomes_abas_2');
            $destino = $this->request->getPost('destino');
            $primeiratab = $this->request->getPost('primeiratab');
            $segundatab = $this->request->getPost('segundatab');
            $coluna1 = $this->request->getPost('coluna1');
            $coluna2 = $this->request->getPost('coluna2');

            /* XLS Planilha 1 */
            $tmpfname = $primeiroxls;

            $excelReader = \PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname);
            $worksheet = $excelObj->getSheetByName($primeiratab);
            $lastRow = $worksheet->getHighestRow();

            $column = '0';
            $i = 'A';

            for($j = 1; $j <= 10; $j++){
                if($coluna1 == $worksheet->getCell($i.'1')->getValue()){
                    $column = $i;
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
                    case 'K':
                        $i = 'L';
                        break;
                    case 'L':
                        $i = 'M';
                        break;
                    case 'M':
                        $i = 'N';
                        break;
                    case 'N':
                        $i = 'O';
                        break;
                    case 'O':
                        $i = 'P';
                        break;
                    case 'P':
                        $i = 'Q';
                        break;
                }
            }


            $planilha_1 = array();

            for($row = 1; $row <= $lastRow; $row++){
                $planilha_1[$row] = $worksheet->getCell($column.$row)->getValue();
            }







            /* XLS 2 */
            $tmpfname = $segundoxls;

            $excelReader = \PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname);
            $worksheet = $excelObj->getSheetByName($segundatab);
            $lastRow = $worksheet->getHighestRow();

            $column = '0';
            $i = 'A';

            while($column == '0'){
                if($coluna2 == $worksheet->getCell($i.'1')->getValue()){
                    $column = $i;
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
                    case 'K':
                        $i = 'L';
                        break;
                    case 'L':
                        $i = 'M';
                        break;
                    case 'M':
                        $i = 'N';
                        break;
                    case 'N':
                        $i = 'O';
                        break;
                    case 'O':
                        $i = 'P';
                        break;
                    case 'P':
                        $i = 'Q';
                        break;
                }
            }

            $planilha_2 = array();

            for($row = 1; $row <= $lastRow; $row++){
                $planilha_2[$row] = $worksheet->getCell($column.$row)->getValue();
            }






            //Comparativo Planilha 1 x Planilha 2
            $comparativo_1 = array();

            foreach($planilha_1 as $value){
                if(!in_array($value, $planilha_2) && $value != NULL){
                    array_push($comparativo_1, $value);
                }
            }






            //Comparativo Planilha 2 x Planilha 1
            $comparativo_2 = array();

            foreach($planilha_2 as $value){
                if(!in_array($value, $planilha_1) && $value != NULL){
                    array_push($comparativo_2, $value);
                }
            }

            var_dump($destino);

            $files = glob($destino.'/*'); //get all file names
            foreach($files as $file){
                if(is_file($file))
                unlink($file); //delete file
            }

        }

        return new ViewModel([
            'comparativo_1' => $comparativo_1,
            'comparativo_2' => $comparativo_2,
        ]);
    }
}

