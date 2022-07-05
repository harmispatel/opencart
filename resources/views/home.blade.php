<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hii</title>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>You Are Normal User</h1>
            </div>
        </div>
    </div>


    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="text-center bg-red">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>


</body>
</html>
