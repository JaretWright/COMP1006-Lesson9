<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving Album...</title>
</head>

<body>
<?php
    $albumID = $_POST['albumID'];
    $title = $_POST['title'];
    $year = $_POST['year'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];

    //step 1 - connect to the database
    require_once ('db.php');

    //step 2 - create the SQL command to INSERT or UPDATE a record
    if (!empty($albumID)){
        $sql = "UPDATE albums  
                   SET title = :title,
                       year = :year,
                       artist = :artist,
                       genre = :genre
                WHERE albumID = :albumID";}
    else {
        $sql = "INSERT INTO albums (title,   year,  artist,  genre) 
                        VALUES (:title, :year, :artist, :genre);";
    }


    //step 3 - prepare the SQL command and bind the arguments to prevent SQL injection
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':title', $title, PDO::PARAM_STR, 50);
    $cmd->bindParam(':year', $year, PDO::PARAM_INT, 4);
    $cmd->bindParam(':artist', $artist, PDO::PARAM_STR, 50);
    $cmd->bindParam(':genre', $genre, PDO::PARAM_STR, 20);

    if (!empty($albumID))
        $cmd->bindParam(':albumID', $albumID, PDO::PARAM_INT);

    //step 4 - execute
    $cmd->execute();

    //step 5 - disconnect from database
    $conn = null;

    //step 6 - redirect to the albums page
    header('location:albums.php');
?>
</body>

</html>
