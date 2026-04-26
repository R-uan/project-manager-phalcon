<!DOCTYPE html>
<html lang="en" class="h-full">

	<head>
		<title>Acme</title>
		<meta charset="UTF-8">
		{{ assets.outputCss('css') }}
		<script src="https://cdn.tailwindcss.com"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body class="h-full">
		<header>
			<ul>
				<li>
					<a href="/organization">Organizations</a>
					<a href="/user/profile">Profile</a>
				</li>
			</ul>
		</header>
		{{ content() }}
		{{ assets.outputJs('js') }}
	</body>

</html>
