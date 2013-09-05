<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'adfabfaq_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/AdfabFaq/Entity'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'AdfabFaq\Entity'  => 'adfabfaq_entity'
                )
            )
        )
    ),

    'view_manager' => array(
        'template_map' => array(
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view/admin',
        	__DIR__ . '/../view/frontend',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'adfabfaq_admin' => 'AdfabFaq\Controller\AdminController',
            'adfabfaq'       => 'AdfabFaq\Controller\IndexController',
        ),
    ),

    'router' => array(
        'routes' => array(
        	'frontend' => array(
       			'child_routes' => array(
		            'faq' => array(
		                'type' => 'Zend\Mvc\Router\Http\Segment',
		                'options' => array(
		                    'route'    => '/faq',
		                    'defaults' => array(
		                        'controller' => 'adfabfaq',
		                        'action'     => 'index',
		                    ),
		                ),
		            ),
       			),
        	),
            'zfcadmin' => array(
                'child_routes' => array(
                    'adfabfaq_admin' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/faq',
                            'defaults' => array(
                                'controller' => 'adfabfaq_admin',
                                'action'     => 'index',
                            ),
                        ),
                        'child_routes' =>array(
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/list[/:p]',
                                    'defaults' => array(
                                        'controller' => 'adfabfaq_admin',
                                        'action'     => 'list',
                                    ),
                                ),
                            ),
                            'create' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/create/:faqId',
                                    'defaults' => array(
                                        'controller' => 'adfabfaq_admin',
                                        'action'     => 'create',
                                        'faqId'     => 0
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:faqId',
                                    'defaults' => array(
                                        'controller' => 'adfabfaq_admin',
                                        'action'     => 'edit',
                                        'faqId'     => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:faqId',
                                    'defaults' => array(
                                        'controller' => 'adfabfaq_admin',
                                        'action'     => 'remove',
                                        'faqId'     => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type'         => 'phpArray',
                'base_dir'     => __DIR__ . '/../language',
                'pattern'      => '%s.php',
                'text_domain'  => 'adfabfaq'
            ),
        ),
    ),

    'core_layout' => array(
        'AdfabFaq' => array(
            'default_layout' => 'layout/2columns-left',
            'children_views' => array(
                'col_left'  => 'adfab-user/layout/col-user.phtml',
            ),
        ),
    ),

    'navigation' => array(
        'default' => array(
            'AdfabFaq' => array(
                'label' => 'FAQ',
                'route' => 'faq',
            ),
        ),
        'admin' => array(
            'adfabfaqadmin' => array(
                'order' => 90,
                'label' => 'FAQ',
                'route' => 'zfcadmin/adfabfaq_admin/list',
                'resource' => 'faq',
                'privilege' => 'list',
                'pages' => array(
                    'list' => array(
                            'label' => 'Liste des FAQ',
                            'route' => 'zfcadmin/adfabfaq_admin/list',
                            'resource' => 'faq',
                            'privilege' => 'list',
                    ),
                    'create' => array(
                        'label' => 'Nouvelle FAQ',
                        'route' => 'zfcadmin/adfabfaq_admin/create',
                        'resource' => 'faq',
                        'privilege' => 'add',
                    ),
                ),
            ),
        ),
    )
);
