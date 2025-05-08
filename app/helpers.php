<?php

/**
 * Custom helper functions for Laravel
 */

// Add mb_strimwidth function to the Illuminate\Support namespace if it doesn't exist
namespace Illuminate\Support {
    if (!function_exists('mb_strimwidth')) {
        /**
         * Get truncated string with specified width.
         *
         * @param string $str
         * @param int $start
         * @param int $width
         * @param string $trimmarker
         * @param string $encoding
         * @return string
         */
        function mb_strimwidth($str, $start, $width, $trimmarker = '', $encoding = null)
        {
            // Use the global mb_strimwidth function if it exists
            if (function_exists('\\mb_strimwidth')) {
                return \mb_strimwidth($str, $start, $width, $trimmarker, $encoding);
            }
            
            // Fallback implementation if mb_strimwidth is not available
            $encoding = $encoding ?: mb_internal_encoding();
            $strlen = mb_strlen($str, $encoding);
            
            if ($strlen <= $width) {
                return $str;
            }
            
            $width -= mb_strlen($trimmarker, $encoding);
            return mb_substr($str, $start, $width, $encoding) . $trimmarker;
        }
    }
}
