<?php
return function($site){
    return $site
        -> children() -> template('event') -> sortBy('datestart', 'desc') ->listed();
};