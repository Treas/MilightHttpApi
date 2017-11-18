<?php
// Helper Functions
// Each light controller accepts 5 group numbers representing All, Zone 1, Zone 2, Zone 3, and Zone 4
// First Controller (0 index in settings array): 0 = All, 1 = Zone 1, 2 = Zone 2, 3 = Zone 3, 4 = Zone 4
// Second Controller (1 index in settings array): 5 = All, 6 = Zone 1, 7 = Zone 2, 8= ZOne 3, 9 = Zone 4
// You can add as many controllers as you like, following this pattern

function getMilightID($group)
{
   return floor($group / 5);
}

function getGroup($group)
{
    //TODO Check if group number is sane based on length of Milight array, and return -1 if it is not
    while ($group > 4)
    {
        $group = $group - 4;
    }
    return $group;
}

// Routes
// Group 0 = All Groups (Main Controller Only.  TODO: Look into multi controller options)

//Set Group Color
$app->get('/rgbw/color/r/{red}/g/{green}/b/{blue}/{group}/', function ($request, $response, $args) {
	$red = (int)$args['red'];
	$green = (int)$args['green'];
        $blue = (int)$args['blue'];
        $group = getGroup((int)$args['group']);

	$output = new Output();
	try
	{
		if ($group < 0) {throw new Exception('Group out of range');}

		$light = $this->milight[getMilightID($group)];

		$light->setRgbwActiveGroup($group);
		if ($red > 254 and $green > 254 and $blue > 254)
		{
			$light->rgbwSetGroupToWhite($group);
		}
		else
		{
			$hsl_color = $light->rgbToHsl($red, $green, $blue);
			$light->rgbwSetColorHsv($hsl_color);
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

	$group = getGroup((int)$args['group']);
	$output = new Output();

	try
	{
		if ($group < 0) {throw new Exception('Group out of range');}

                $light = $this->milight[getMilightID($group)];

		$light->setRgbwActiveGroup($group);
		$light->rgbwSendOnToGroup($group);
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

	$group = getGroup((int)$args['group']);
	$output = new Output();

	try
	{
		if ($group < 0) {throw new Exception('Group out of range');}

                $light = $this->milight[getMilightID($group)];

		$light->setRgbwActiveGroup($group);
		$light->rgbwSendOffToGroup($group);
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
	$group = getGroup((int)$args['group']);
	$output = new Output();

	try
	{
		if ($group < 0) {throw new Exception('Group out of range');}

                $light = $this->milight[getMilightID($group)];

		$light->setRgbwActiveGroup($group);
		$light->rgbwBrightnessPercent($brightness,$group);
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

	$group = getGroup((int)$args['group']);

    // Render index view
    $response->getBody()->write("status on group #". $group);
    return $response;
});




