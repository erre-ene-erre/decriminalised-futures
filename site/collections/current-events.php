<?php
return function($site){
    return $site
        -> children() -> template('event') -> filter(
            fn ($child) => $child -> datestart() -> toDate() > time() || $child -> dateend() -> toDate() > time()
        ) -> listed();
};