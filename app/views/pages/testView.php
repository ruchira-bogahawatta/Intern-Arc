<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing View</title>
</head>
<body>
    <h2>
    THIS IS TEST VIEW
    </h2>
    <h2><?php echo $data['data']; ?></h2>
    <h2><?php print_r ($data['name']); ?></h2>

    <form action="<?php echo URLROOT . "profiles/test" ?> " >
        <input type="file" id="myFile" name="my_file">
        <button type="submit">submit</button>
    </form>
</body>
</html>