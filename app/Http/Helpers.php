<?php

if (! function_exists('getSpecializationColor')) {
    function getSpecializationColor($specialization)
    {
        switch ($specialization) {
            case 'contemporary':
                return 'bg-green-500';
            case 'modern':
                return 'bg-blue-500';
            case 'classic':
                return 'bg-red-500';
            case 'minimalist':
                return 'bg-yellow-500';
            case 'rustic':
                return 'bg-brown-500';
            default:
                return 'bg-gray-500';
        }
    }
}
