<?php

$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

$totalScore = 0;

foreach ($students as $student) {
    echo "Ho ten: " . $student["name"] . "<br>";
    echo "Tuoi: " . $student["age"] . "<br>";
    echo "Diem: " . $student["score"] . "<br><br>";

    $totalScore += $student["score"];
}

$averageScore = $totalScore / count($students);

echo "Diem trung binh: " . $averageScore;

?>