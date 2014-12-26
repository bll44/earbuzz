<!DOCYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>
		<div>
			<p>
				Click to reset password {{ URL::to('password/reset', array($token)) }}.
			</p>
			<p>
				This link will expire in {{ Config::get('auth.reminder.expire', 60 )}} minutes.
			</p>
		</div>
	</body>