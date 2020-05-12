<?php


function getTanggal($date)
{
    $nama_bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
        "September", "Oktober", "November", "Desember"
    ];
    return substr($date, 8, 2) . ' ' . $nama_bulan[(int) substr($date, 5, 2) - 1] . ' ' . substr($date, 0, 4);
}

function getJam($date)
{
    if (substr($date, 11, 2) < 12)
        return substr($date, 11, 2) . ':' . substr($date, 14, 2) . ' AM';
    else
        return (substr($date, 11, 2) - 12) . ':' . substr($date, 14, 2) . ' PM';
}
