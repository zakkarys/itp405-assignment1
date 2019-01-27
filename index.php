<?php
    $pdo = new PDO('sqlite:chinook.db');

    $sql = " SELECT genres.GenreId, genres.Name
        FROM genres";

    $statement = $pdo->prepare($sql);

    $statement->execute();

    $genres = $statement->fetchAll(PDO::FETCH_OBJ);
    
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assignment1 | Zakkary Smith | PDO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

</head>

<body>

    <table>

        <tr>
            <th>Genres</th>
        </tr>

        <?php foreach($genres as $genre) : ?>

            <tr>

                <td>
                    <?php 
                        $name = $genre->Name;
                        $link = "<a href='tracks.php?genre=".$name."'>".$name."</a>";
                        echo $link;
                    ?>
                </td>

            </tr>

        <?php endforeach ?>

        <?php if(count($genres) === 0) : ?>

            <tr>
                <td>No Genre Found!</td>
            </tr>

        <?php endif ?>
    </table>

</body>

</html>