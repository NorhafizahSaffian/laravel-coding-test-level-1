<!DOCTYPE html>
<html>
	<head>
		<title>Event Create Email Notifications</title>
	
	</head>

	<body>
		<h1>New Event Created Successfully by {{$email}}!</h1>
		<p>{{$events->name}}</p>
		<p>{{$events->startAt}}</p>
		<p>{{$events->endAt}}</p>
	</body>
</html>