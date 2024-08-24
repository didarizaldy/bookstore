<?php

// Format Rupiah
function formatRupiah($amount)
{

    return "Rp" . number_format($amount, 0, ',', '.');
}

function generateSlug($name)
{
    return strtolower(str_replace(' ', '-', $name));
}
