<?php 

if (! function_exists('apiUser')) {
    function apiUser()
    {
        return \App\Models\apiUser::user();     
    }
}

if (! function_exists('apiUserCheck')) {
    function apiUserCheck()
    {
        return \App\Models\apiUser::check();     
    }
}