<?php
return array(
	'router' => array(
        'routes' => array(
            'comparativo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/comparativo[/:controller[/:action][/:id]][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Comparativo\Controller',
                        'controller' => 'Comparativo\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	'controllers' => array(
        'invokables' => array(
            'Comparativo\Controller\Index' => 'Comparativo\Controller\IndexController',
            'Comparativo\Controller\Opcoes' => 'Comparativo\Controller\OpcoesController',
            'Comparativo\Controller\Coluna' => 'Comparativo\Controller\ColunaController',
            'Comparativo\Controller\Comparativo' => 'Comparativo\Controller\ComparativoController',
        ),
    ),
	'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,

        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'comparativo/index/index' => __DIR__.'/../view/comparativo/index/index.phtml',

        ),

        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),

    ),
    'controller_plugins'=> array(
        'invokables'=> array(
            'PHPExcel' => 'Comparativo\Service\Classes\PHPExcel'
        )
    ),


/*
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
              'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
              'cache' => 'array',
              'paths' => array(__DIR__ . '/../src/Comparativo/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Comparativo\Entity' => 'application_entities'
                ),
            ),
        ),

    ),
*/
);