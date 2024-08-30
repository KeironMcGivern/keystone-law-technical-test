<?php

use App\Domain\PinnedLink\Enums\Tags;

return [

    Tags::key() => [
        Tags::API->value => 'Api',
        Tags::LARAVEL->value => 'Laravel',
        Tags::PHP->value => 'PHP',
        Tags::VUE->value => 'Vue',
        Tags::VUEJS->value => 'Vue.js'
    ],

];
