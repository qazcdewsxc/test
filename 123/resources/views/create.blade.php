<section>
<form action="{{route('add')}}" method="POST">
    @csrf
  <div>
    <div aria-orientation="vertical">
       <label>Name</label>
       <textarea id="name" name="name"></textarea>
    </div>
    <div aria-orientation="vertical">
       <label>Description</label>
       <textarea id="description" name="description"></textarea>
    </div>
    <button id="add" type="submit">Add</button>
 </div>
  </form>    
</section>