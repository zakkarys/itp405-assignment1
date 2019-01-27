<?php

    $pdo = new PDO('sqlite:chinook.db');
    
    class Track {
        public $trackname = "";
        public $albumtitle = "";
        public $artistname = "";
        public $price = "";
    }
  
    $list = array();
    
    $genre = "";

    if(isset($_GET['genre'])) {
        $genre = $_GET['genre'];
    }
    
    $sql = "SELECT tracks.Name, tracks.UnitPrice, tracks.AlbumId
            FROM tracks";

    if(isset($_GET['genre'])) {
        $sql_addition = "
            INNER JOIN genres
            ON ? = genres.Name
            AND genres.GenreId = tracks.GenreId
        ";
        $sql .= $sql_addition;
    }
    $statement = $pdo->prepare($sql);

    if(isset($_GET['genre'])) {
        $statement->bindParam(1, $_GET['genre']);
    }

    $statement->execute();

    $tracks = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach($tracks as $track) {
        $albumId = $track->AlbumId;
        $sqltwo = "SELECT albums.Title, albums.ArtistId, artists.Name
            FROM albums
            INNER JOIN artists
            ON albums.AlbumId = ?
            AND albums.ArtistId = artists.ArtistId";

        $statement = $pdo->prepare($sqltwo);

        $statement->bindParam(1, $albumId);

        $statement->execute();

        $albums = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach($albums as $album) {
    
            $solotrack = new Track();
            $solotrack->trackname = $track->Name;
            $solotrack->albumtitle = $album->Title;
            $solotrack->artistname = $album->Name;
            $solotrack->price = $track->UnitPrice;
            $sololist[] = $solotrack;
        }
    }
    
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tracks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

</head>
<body>

    <table class="table">
        
        <tr>
            <th>Track Name</th>
            <th>Album Title</th>
            <th>Artist Name</th>
            <th>Price</th>
        
        </tr>
        
        <?php foreach($trackList as $item) : ?>
            
            <tr>
                <td>
                    <?php echo $item->trackname ?>
                </td>
                <td>
                    <?php echo $item->albumtitle ?>
                </td>
                <td>
                    <?php echo $item->artistname ?>
                </td>
                <td>
                    <?php echo $item->price ?>
                </td>
            
            </tr>
        
        <?php endforeach ?>
        
        <?php if(count($list) === 0) : ?>
            
            <tr>
                <td colspan="4">No Tracks Found!</td>
            
            </tr>
        
        <?php endif ?>
   
    </table>

</body>

</html>