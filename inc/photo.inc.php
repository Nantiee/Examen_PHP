<?php
	session_start();
	include('connexion.inc.php');
	extract($_POST);
	$results = array();
	$userId = $_SESSION['id'];

	require_once('ImageManipulator.php');


	if ($_FILES['new_photo']['error'] > 0) {
	    echo "Error: " . $_FILES['new_photo']['error'] . "<br />";
	} else {
		// array of valid extensions
	    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
	    // get extension of the uploaded file
	    $fileExtension = strrchr($_FILES['new_photo']['name'], ".");
	    // check if file Extension is on the list of allowed ones
	    if (in_array($fileExtension, $validExtensions)) {
	        $newNamePrefix = time() . '_';
	        $manipulator = new ImageManipulator($_FILES['new_photo']['tmp_name']);
	        $width  = $manipulator->getWidth();
	        $height = $manipulator->getHeight();


	        // Base size = 400px
	        $base = 400;
	        if($width>$height){
	        	$width = $base*$width/$height;
	        	$height = $base;
	        }elseif($height>$width){
	        	$height = $base*$height/$width;
	        	$width = $base;
	        }

	        $newImage = $manipulator->resample($width, $height, false);

	        $centreX = round($width / 2);
	        $centreY = round($height / 2);

	        if($width>$height){
	        	$x1 = $centreX - ($height/2); // minSize / 2
				$y1 = $centreY - ($height/2); // minSize / 2

				$x2 = $centreX + ($height/2); // minSize / 2
				$y2 = $centreY + ($height/2); // minSize / 2
	        }elseif($height>$width){
	        	$x1 = $centreX - ($width/2); // minSize / 2
				$y1 = $centreY - ($width/2); // minSize / 2

				$x2 = $centreX + ($width/2); // minSize / 2
				$y2 = $centreY + ($width/2); // minSize / 2
	        }



			echo('x1 : '.$x1);
			echo('y1 : '.$y1);
			echo('x2 : '.$x2);
			echo('y2 : '.$y2);

	        // // center cropping to minSize
	        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);

	        // // saving file to uploads folder
	        $imageName = $userId . $fileExtension;
	        $newPath = '../img/profils/' . $imageName;
	        // $newPath = $_SERVER["DOCUMENT_ROOT"] . "/tfe/nappy/img/profils/" . $parentId;
	        $manipulator->save($newPath);

			$edit_photo = $connexion->prepare('UPDATE nap_users SET	photo = :photo WHERE id = :id');
			$edit_photo->execute(array(
				'photo' => $imageName,
				'id' => $userId
			));
			$_SESSION['photo'] = $imageName;


			echo json_encode('ok');




	        echo 'Done ...';
	    } else {
	        echo 'You must upload an image...';
	    }
	}









	// move_uploaded_file($_FILES['new_photo']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/tfe/nappy/img/profils/" . $parentId);

?>