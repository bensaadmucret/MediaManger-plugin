<?php

// test post type controller
namespace Inc\Tests\Base;

use PHPUnit\Framework\TestCase;
use Inc\Base\PostTypeController;

class TestPostTypeController extends TestCase
{
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
        $postTypeController = new PostTypeController();
        $postTypeController->register_post_type();
        $postTypeController->register();
        $this->assertEquals('produit', $postTypeController->getPostTypeName());
    }
}
