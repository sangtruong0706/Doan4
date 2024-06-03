<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <h1>Hello {{ $formData['user']->name }}</h1>
    <h1>You have requested to change passwrod.</h1>
    <p>Please click the link given below to reset password.</p>
    <a href="{{ route("account.resetPassword", $formData['token']) }}">Click here</a>
    <p>Thanks</p>
</body>
</html>
