<?php

function rupiah($angka)
{
    $hasil_rupiah = number_format($angka,2,',','.');
    return $hasil_rupiah;
}

?>