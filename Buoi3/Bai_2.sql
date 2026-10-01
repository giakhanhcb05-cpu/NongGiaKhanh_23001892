CREATE DATABASE movie_management;

USE movie_management;

CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Avengers', 100000, 100, 85),
('Avatar', 120000, 80, 65),
('Batman', 90000, 120, 120),
('Spider-Man', 110000, 90, 50),
('Titanic', 95000, 70, 30);

SELECT * FROM movies;

SELECT *
FROM movies
WHERE price > 100000;

SELECT *
FROM movies
WHERE available_seats > 50;

SELECT *
FROM movies
ORDER BY price DESC;

UPDATE movies
SET available_seats = 80
WHERE title = 'Avengers';

SELECT * FROM movies;

DELETE FROM movies
WHERE title = 'Batman';

SELECT * FROM movies;

SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_seats
FROM movies;

SELECT
    title,
    price,
    total_seats - available_seats AS sold_seats,
    (total_seats - available_seats) * price AS revenue
FROM movies;

SELECT
    SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;

SELECT
    id,
    title,
    price,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_seats
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);  