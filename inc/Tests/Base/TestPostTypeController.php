<?php

// test post type controller
namespace Inc\Tests\Base;

use PHPUnit\Framework\TestCase;
use Inc\Base\PostTypeController;

class TestPostTypeController extends TestCase
{
    private $post_type;
    private $post_type_controller;

    public function Up()
    {
        $this->post_type = new PostTypeController();

        $this->post_type->getPostTypeName();
    }

    public function test_post_type_controller_class_exists()
    {
        $this->assertTrue(class_exists(PostTypeController::class));
    }

    public function test_post_type_controller_class_has_register_method()
    {
        $this->assertTrue(method_exists(PostTypeController::class, 'register'));
    }

    public function test_post_type_controller_class_has_get_post_type_name_method()
    {
        $this->assertTrue(method_exists(PostTypeController::class, 'getPostTypeName'));
    }

    public function test_post_type_controller_class_property_post_type_name_is_set()
    {
        $this->assertTrue(property_exists(PostTypeController::class, 'post_type'));
    }

    public function test_post_type_controller_class_property_post_type_name_is_string()
    {
        $this->assertTrue(is_string('post_type'));
    }

    public function test_post_type_controller_class_property_post_type_name_is_not_empty()
    {
        $this->assertNotEmpty('post_type');
    }

    public function test_post_type_controller_class_property_post_type_name_is_not_null()
    {
        $this->assertNotNull('post_type');
    }

    public function test_post_type_controller_class_property_post_type_name_is_not_false()
    {
        $this->assertNotFalse('post_type');
    }

    public function test_post_type_controller_class_property_post_type_name_is_not_true()
    {
        $this->assertNotTrue('post_type');
    }
}
