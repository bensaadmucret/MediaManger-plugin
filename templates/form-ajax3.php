<?php

use Inc\Base\CustomFormAjaxShortcode;

$data  = CustomFormAjaxShortcode::get_taxonomy_data();

if (!empty($data)) {
    echo $data;
} else {
    echo 'Veuillez ajouter une taxonomie';
}
