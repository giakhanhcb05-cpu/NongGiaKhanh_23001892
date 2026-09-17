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

function findBestStudent($students)
{
    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student["score"] > $bestStudent["score"]) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function findWorstStudent($students)
{
    $worstStudent = $students[0];

    foreach ($students as $student) {
        if ($student["score"] < $worstStudent["score"]) {
            $worstStudent = $student;
        }
    }

    return $worstStudent;
}

function countPassedStudents($students)
{
    $count = 0;

    foreach ($students as $student) {
        if ($student["score"] >= 5) {
            $count++;
        }
    }

    return $count;
}

function findStudentByName($students, $name)
{
    foreach ($students as $student) {
        if ($student["name"] == $name) {
            return $student;
        }
    }

    return null;
}


$bestStudent = findBestStudent($students);

echo "Sinh vien diem cao nhat:<br>";
echo "Ho ten: " . $bestStudent["name"] . "<br>";
echo "Tuoi: " . $bestStudent["age"] . "<br>";
echo "Diem: " . $bestStudent["score"] . "<br><br>";


$worstStudent = findWorstStudent($students);

echo "Sinh vien diem thap nhat:<br>";
echo "Ho ten: " . $worstStudent["name"] . "<br>";
echo "Tuoi: " . $worstStudent["age"] . "<br>";
echo "Diem: " . $worstStudent["score"] . "<br><br>";


echo "So sinh vien dat: " . countPassedStudents($students) . "<br><br>";

$name = "Tran Thi Binh";

$foundStudent = findStudentByName($students, $name);

if ($foundStudent != null) {
    echo "Tim thay sinh vien:<br>";
    echo "Ho ten: " . $foundStudent["name"] . "<br>";
    echo "Tuoi: " . $foundStudent["age"] . "<br>";
    echo "Diem: " . $foundStudent["score"];
} else {
    echo "Khong tim thay sinh vien";
}

?>