<?php

if(!function_exists('module_active')){
    function module_active($name){
        $modules = \Module::allEnabled();
        foreach ($modules as $item){
            if($item->getName() === $name){
                return true;
            }
        }
        return false;
    }
}
