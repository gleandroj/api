<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23/10/2017
 * Time: 10:53
 */
namespace Gleandroj\Api\Database\Migrations;

abstract class Migration extends LaravelMigration
{
    public abstract function up();

    public abstract function down();

    public function __call($name, $arguments)
    {
        if($name === 'down' && app()->environment() !== 'production'){
            return parent::__call($name, $arguments);
        }

        return null;
    }
}