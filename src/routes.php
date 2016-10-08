<?php
// Routes

// Group 0 = All Groups

//Set Group Color
$app->get('/rgbw/color/r/{red}/g/{green}/b/{blue}/{group}/', function ($request, $response, $args) {
	$red = (int)$args['red'];
	$green = (int)$args['green'];
    $blue = (int)$args['blue'];
    $group = (int)$args['group'];
	$output = new Output();
	
	try 
	{
		if ($group > 4  || $group < 0) {throw new Exception('Group out of range');}
		$this->milight->setRgbwActiveGroup($group);
		if ($red > 254 and $green > 254 and $blue > 254)
		{
			$this->milight->rgbwSetGroupToWhite($group);
		}
		else
		{
			$hsl_color = $this->milight->rgbToHsl($red, $green, $blue);
			$this->milight->rgbwSetColorHsv($hsl_color); 	
		}
		$message = 'Set color of group '.$group.' to (Red: '.$red.', Green: '.$green.', Blue: '.$blue.')';
		$response = $output->Response(0, $message, $response);
	} 
	catch (Exception $e) 
	{
		$response = $output->Response(1, $e->getMessage(), $response, $this->logger);
	}
	finally
	{
		return $response;
	}
});


//Turn Group On
$app->get('/rgbw/on/{group}/', function ($request, $response, $args) {

	$group = (int)$args['group'];
	$output = new Output();
	
	try 
	{
		if ($group > 4  || $group < 0) {throw new Exception('Group out of range');}
		$this->milight->setRgbwActiveGroup($group);
		$this->milight->rgbwSendOnToGroup($group);
		
		$message = 'Set '.$group.' to ON';
		$response = $output->Response(0, $message, $response);
	} 
	catch (Exception $e) 
	{
		$response = $output->Response(1, $e->getMessage(), $response, $this->logger);
	}
	finally
	{
		return $response;
	}
});

//Turn Group Off
$app->get('/rgbw/off/{group}/', function ($request, $response, $args) {

	$group = (int)$args['group'];
	$output = new Output();
	
	try 
	{
		if ($group > 4  || $group < 0) {throw new Exception('Group out of range');}
		$this->milight->setRgbwActiveGroup($group);
		$this->milight->rgbwSendOffToGroup($group);
		
		$message = 'Set '.$group.' to OFF';
		$response = $output->Response(0, $message, $response);
	} 
	catch (Exception $e) 
	{
		$response = $output->Response(1, $e->getMessage(), $response, $this->logger);
	}
	finally
	{
		return $response;
	}
});

//Set Group Brightness
$app->get('/rgbw/brightness/{brightness}/{group}/', function ($request, $response, $args) {

    $brightness = (int)$args['brightness'];
	$group = (int)$args['group'];
	$output = new Output();
	
	try 
	{
		if ($group > 4  || $group < 0) {throw new Exception('Group out of range');}
		$this->milight->setRgbwActiveGroup($group);
		$this->milight->rgbwBrightnessPercent($brightness,$group);
		
		$message = 'Set brightness of group '.$group.' to '.$brightness;
		$response = $output->Response(0, $message, $response);
	} 
	catch (Exception $e) 
	{
		$response = $output->Response(1, $e->getMessage(), $response, $this->logger);
	}
	finally
	{
		return $response;
	}
});

// This function exists for Smarthings integration.
$app->get('/rgbw/status/{group}/', function ($request, $response, $args) {

	$group = (int)$args['group'];
	
    // Render index view
    $response->getBody()->write("status on group #". $group);
    return $response;
});




