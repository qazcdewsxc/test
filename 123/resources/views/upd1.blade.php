<section>
<form method="POST" action="{{route('Upd', $test1Item->id)}}">
    @csrf
    @method('PUT')
  <div>
    <div aria-orientation="vertical">
       <label>Name</label>
       <textarea id="nameCh" name="name">{{$test1Item->name}}</textarea>
    </div>
    <div aria-orientation="vertical">
       <label>Description</label>
       <textarea id="descriptionCh" name="description">{{$test1Item->description}}</textarea>
    </div>
    <button id="change" type="submit">Update</button>
 </div>
</form>    
</section>