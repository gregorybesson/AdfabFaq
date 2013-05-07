<?php

namespace AdfabFaq;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $translator = $serviceManager->get('translator');
        AbstractValidator::setDefaultTranslator($translator,'adfabcore');
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'adfabfaq_doctrine_em' => 'doctrine.entitymanager.orm_default',
            ),

            'invokables' => array(
                'adfabfaq_faq_service' => 'AdfabFaq\Service\Faq',
            ),

            'factories' => array(
                'adfabfaq_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');

                    return new Options\ModuleOptions(isset($config['adfabfaq']) ? $config['adfabfaq'] : array());
                },
                'adfabfaq_faq_mapper' => function ($sm) {
                    return new \AdfabFaq\Mapper\Faq(
                        $sm->get('adfabfaq_doctrine_em'),
                        $sm->get('adfabfaq_module_options')
                    );
                },
                'adfabfaq_faq_form' => function($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('adfabfaq_module_options');
                    $form = new Form\Faq(null, $translator);
                    $faq = new Entity\Faq();
                    $form->setInputFilter($faq->getInputFilter());

                    return $form;
                },
            ),
        );
    }
}
