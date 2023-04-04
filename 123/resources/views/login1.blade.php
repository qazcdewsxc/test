<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

</head>
<body>
<div aria-orientation="horizontal">
    <form action="{{route('sL')}}" method="POST">
        @csrf
        <button id="logBt" name="logBt" type="submit">Log in</button>
    </form>
    <form action="{{route('sReg')}}" method="POST">
        @csrf
        <button id="regBt" name="regBt" type="submit">Registration</button>
    </form>
</div>
</body>
</html>