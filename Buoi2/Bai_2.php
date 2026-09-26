<?php

class Movie
{
    public $id;
    public $title;
    public $price;
    public $totalSeats;
    public $availableSeats;

    public function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function bookTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "So luong ve dat phai lon hon 0.<br>";
            return false;
        }

        if ($quantity > $this->availableSeats) {
            echo "So luong ve dat vuot qua so ghe con lai.<br>";
            return false;
        }

        $this->availableSeats -= $quantity;

        $totalPrice = $quantity * $this->price;

        echo "Dat ve thanh cong.<br>";
        echo "Phim: " . $this->title . "<br>";
        echo "So ve vua dat: " . $quantity . "<br>";
        echo "Tong so ve da ban: " . $this->getSoldSeats() . "<br>";
        echo "So ghe con lai: " . $this->availableSeats . "<br>";
        echo "Tong tien: " . $totalPrice . "<br><br>";

        return true;
    }

    public function cancelTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "So luong ve huy phai lon hon 0.<br>";
            return false;
        }

        $soldSeats = $this->getSoldSeats();

        if ($quantity > $soldSeats) {
            echo "Khong the huy nhieu hon so ve da ban.<br>";
            return false;
        }

        $this->availableSeats += $quantity;

        $refund = $quantity * $this->price;

        echo "Huy ve thanh cong.<br>";
        echo "Phim: " . $this->title . "<br>";
        echo "So ve vua huy: " . $quantity . "<br>";
        echo "Tong so ve da ban con lai: " . $this->getSoldSeats() . "<br>";
        echo "So ghe con lai: " . $this->availableSeats . "<br>";
        echo "So tien hoan lai: " . $refund . "<br>";
        echo "Doanh thu hien tai: " . $this->getRevenue() . "<br><br>";

        return true;
    }

    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo()
    {
        echo "Ma phim: " . $this->id . "<br>";
        echo "Ten phim: " . $this->title . "<br>";
        echo "Gia ve: " . $this->price . "<br>";
        echo "Tong so ghe: " . $this->totalSeats . "<br>";
        echo "So ghe con lai: " . $this->availableSeats . "<br>";
        echo "So ve da ban: " . $this->getSoldSeats() . "<br>";
        echo "Doanh thu: " . $this->getRevenue() . "<br><br>";
    }
}


function findMovieById($movies, $id)
{
    if (count($movies) == 0) {
        return null;
    }

    foreach ($movies as $movie) {
        if ($movie->id == $id) {
            return $movie;
        }
    }

    echo "Khong tim thay phim.<br>";
    return null;
}


function getTotalRevenue($movies)
{
    if (count($movies) == 0) {
        return 0;
    }

    $total = 0;

    foreach ($movies as $movie) {
        $total += $movie->getRevenue();
    }

    return $total;
}


function getBestSellingMovie($movies)
{
    if (count($movies) == 0) {
        return null;
    }

    $bestMovie = $movies[0];

    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $bestMovie->getSoldSeats()) {
            $bestMovie = $movie;
        }
    }

    return $bestMovie;
}




$movie1 = new Movie(1, "Avengers", 100000, 100);
$movie2 = new Movie(2, "Avatar", 120000, 80);
$movie3 = new Movie(3, "Batman", 90000, 120);

$movies = [
    $movie1,
    $movie2,
    $movie3
];



echo "<h4>Dat ve cho phim Avengers</h4>";

$avengers = findMovieById($movies, 1);

if ($avengers != null) {
    if ($avengers->bookTicket(20)) {
        echo "Da dat 20 ve cho phim Avengers.<br>";
    }
}



echo "<h4>Dat ve cho phim Avatar</h4>";

$avatar = findMovieById($movies, 2);

if ($avatar != null) {
    $avatar->bookTicket(100);

    if ($avatar->bookTicket(15)) {
        echo "Da dat 15 ve cho phim Avatar.<br>";
    }
}


echo "<h4>Dat ve cho phim Batman</h4>";

$batman = findMovieById($movies, 3);

if ($batman != null) {
    $batman->bookTicket(0);
}


echo "<h4>Huy ve phim Avengers</h4>";

if ($avengers != null) {
    if ($avengers->cancelTicket(5)) {
        echo "Da huy 5 ve cua phim Avengers.<br>";
    }
}



echo "<h4>Huy ve khong hop le cho phim Batman</h4>";

if ($batman != null) {
    $batman->cancelTicket(1);
    $batman->cancelTicket(0);
}



echo "<h4>Thong tin tat ca cac phim</h4>";

foreach ($movies as $movie) {
    $movie->displayInfo();
}



echo "<h4>Tong doanh thu</h4>";

echo "Tong doanh thu: "
    . getTotalRevenue($movies)
    . "<br>";



$emptyMovies = [];


echo "<h4>Phim ban duoc nhieu ve nhat</h4>";

$bestMovie = getBestSellingMovie($movies);

if ($bestMovie != null) {
    $bestMovie->displayInfo();
}



$bestMovieEmpty = getBestSellingMovie($emptyMovies);


echo "<h4>Tim phim khong ton tai</h4>";

$movieNotFound = findMovieById($movies, 999);

if ($movieNotFound == null) {
    echo "Khong tim thay phim <br>";
}

?>