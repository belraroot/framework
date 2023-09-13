<?php

namespace Codecomodo;

function parse_flare($file)
{
    $flare = file_get_contents($file);

    $key = null;

    $content = <<<EOD
    if (strpos($flare, '{{ $key }}')) {
        str_replace("{{ $key }}", "<?php esc($key); ?>", $flare);
    }
    
    if (strpos($flare, '@foreach')) {
        str_replace("@foreach($key)", "<?php foreach($key) { ?>", $flare);
        str_replace("@endforeach", "<?php } ?>", $flare);
    }

    if (strpos($flare, '@if')) {
        str_replace("@if($key)", "<?php if($key) { ?>", $flare);
        str_replace("@elseif($key)", "<?php } else if($key) { ?>", $flare);
        str_replace("@else", "<?php } else { ?>", $flare);
        str_replace("@endif", "<?php } ?>", $flare);
    }
    EOD;

    return $content;
}