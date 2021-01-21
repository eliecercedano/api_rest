<?php

function hasPermission ($permission) {
    return (Auth::user() && (Auth::user()->hasRole('admin2') || Auth::user()->isAbleTo($permission)));
}
