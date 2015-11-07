<?php

namespace FM\TinyMCEBundle\Tests\Form\Type;

use FM\TinyMCEBundle\Tests\AppKernel;
use FM\TinyMCEBundle\Form\Type\TinyMCEType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class TinyMCETypeTest
 * @package FM\TinyMCEBundle\Tests
 */
class TinyMCETypeTest extends TypeTestCase
{
    /**
     * @var AppKernel
     */
    protected static $kernel;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected static $container;

    /**
     * @var TinyMCEType
     */
    private $tinyMCEtype;

    public static function setUpBeforeClass()
    {
        self::$kernel = new AppKernel('dev', true);
        self::$kernel->boot();
        self::$container = self::$kernel->getContainer();
    }

    /**
     * {@inheritdooc}
     */
    protected function setUp()
    {
        parent::setUp();
        $params = self::$kernel->getContainer()->get('service_container')->getParameter('fm_tinymce');
        $this->tinyMCEtype = new TinyMCEType($params);

        $this->factory = Forms::createFormFactoryBuilder()
            ->addType($this->tinyMCEtype)
            ->getFormFactory();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->container);
        unset($this->factory);
        unset($this->tinyMCEtype);
    }

    public function testEnableWithDefaultValue()
    {
        $form = $this->factory->create('tinymce', null, array('instance' => 'default'));
        $view = $form->createView();
        $this->assertArrayHasKey('enable', $view->vars);
        $this->assertTrue($view->vars['enable']);
    }

    public function testBasePathDefaultValue()
    {
        $form = $this->factory->create('tinymce', null, array('instance' => 'default'));
        $view = $form->createView();
        $this->assertArrayHasKey('base_path', $view->vars);
        $this->assertSame('bundles/fmtinymce/', $view->vars['base_path']);
    }


}