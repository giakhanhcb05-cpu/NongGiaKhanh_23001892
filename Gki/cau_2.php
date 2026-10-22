<?php
    $sanpham = [
        ["ten" => "Ao thun", "gia" => 200000, "soluong" => 2],
        ["ten" => "Quan jeans", "gia" => 400000, "soluong" => 1],
        ["ten" => "Giay the thao", "gia" => 800000, "soluong" => 1],
        ["ten" => "Non bao hiem", "gia" => 300000, "soluong" => 1],
        ["ten" => "Tui xach", "gia" => 500000, "soluong" => 1]
    ];

    function calculateTotal($sanpham)
    {
        $total = 0;

        foreach ($sanpham as $item) {
            $total += $item["gia"] * $item["soluong"];
        }

        return $total;
    }

    function findMaxPrice($sanpham)
    {
        $maxProduct = $sanpham[0];

        foreach ($sanpham as $item) {
            if ($item["gia"] > $maxProduct["gia"]) {
                $maxProduct = $item;
            }
        }
        return $maxProduct;
    }

    $max = findMaxPrice($sanpham);

    echo "Tong tien: " . calculateTotal($sanpham) . " VND<br>";
    echo "San pham gia cao nhat: " . $max["ten"] . " - " . $max["gia"] . " VND";

?>