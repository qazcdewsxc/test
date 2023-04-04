<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
   <table border="1px">
      <tr>
         <th>Name</th>
         <th>Description</th>
         <th>User Name</th>
      </tr>
      @foreach ($items as $item)
      <tr>
         <td>{{$item->test1->name}}</td>
         <td>{{$item->test1->description}}</td>
         <td>{{$item->name}}</td>
      </tr>
      @endforeach
    </table>
</body>
</html>