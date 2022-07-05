<?php

if (!function_exists('savePreviewPath')){
    function savePreviewPath(){
        $preview_url = str_replace(url('/'), '', url()->previous());
        if ($preview_url != '/login'){
            session(['url.intended' => $preview_url]);
        }
    }
}

