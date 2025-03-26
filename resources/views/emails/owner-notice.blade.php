<!DOCTYPE html>
<html>
<head>
    <title>Blue Horn</title>
</head>
<body>
    <h1>Hello BlueHorn Admin</h1>
    <p>this is a notice that a payment has been made and it's successful</p>
    <p>the payment details are:</p>
    <p>Name: {{$payload['user']['name'] }}</p>
    <p>Email: {{$payload['user']['email']}}</p>
    <p>Listing Type: {{$payload['listing']['category']['name']}}</p>
    <p>Other details: {{$payload['listing']}}</p>
    <p>Thank you</p>
</body>
</html>