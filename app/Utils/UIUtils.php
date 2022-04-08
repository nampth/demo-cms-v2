<?php
/**
 * Created by PhpStorm.
 * User: Nampth
 * Date: 3/18/2021
 * Time: 9:47 AM
 */

namespace App\Utils;


use Illuminate\Support\Facades\Auth;

class UIUtils
{
    public static function include_route_files($folder)
    {
        try {
            $rdi = new \RecursiveDirectoryIterator($folder);
            $it = new \RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}