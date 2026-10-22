<?php
    $name = "Gia Khanh";
    $score = 7;

    if ($score >= 8) {
        $xeploai = "Gioi";
    } elseif ($score >= 6.5) {
        $xeploai = "Kha";
    } elseif ($score >= 5) {
        $xeploai = "Trung binh";
    } else {
        $xeploai = "Yeu";
    }

    echo "Ten: " . $name . " - Diem: " . $score . " - Xep loai: " . $xeploai;

?>