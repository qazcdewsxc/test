<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
   <table border="1px">
      <tr>
         <th>Name</th>
         <th>Description</th>
      </tr>
      @foreach ($test1 as $item)
      <tr>
         <td>{{$item->name}}</td>
         <td>{{$item->description}}</td>
         <td>
            <form action="{{ route('delete', $item->id) }}" method="POST">
               @csrf
               @method('DELETE')
               <button type="submit">Delete</button>
            </form>
            <form action="{{ route('showUpd', $item->id) }}" method="GET">
               @csrf
               <button type="submit">Change</button>
            </form>
         </td>
      </tr>
      @endforeach
    </table>
   @role('admin')
    <div>
      @include($page)
   </div>
   @endrole
</body>
</html>
