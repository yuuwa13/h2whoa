<?php

if (! function_exists('csp_nonce')) {
    /**
     * Return the Content Security Policy nonce for the current request.
     * Used as nonce="{{ csp_nonce() }}" on all <script> and <style> tags.
     */
    function csp_nonce(): string
    {
        return app()->bound('csp-nonce') ? app('csp-nonce') : '';
    }
}
