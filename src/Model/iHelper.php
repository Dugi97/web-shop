<?php
/**
 * Created by PhpStorm.
 * User: kule
 * Date: 2.1.19.
 * Time: 17.29
 */

namespace App\Model;


interface iHelper
{
    /**
     * This will return random code for hash password
     *
     * @return mixed
     */
    static function randomCode();

    /**
     * This will return random code for product sku
     *
     * @return mixed
     */
    static function skuCode();
}