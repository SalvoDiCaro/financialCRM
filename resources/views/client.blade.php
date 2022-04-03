@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>User Salvatore</h2>
        </div>
</div>
</div>

<table class="table table-bordered">
 <tr>
   <th>Id</th>
   <th>Name</th>
   <th>Email</th>
 </tr>
 @foreach ($data as $key => $user1)
  <tr>
    <td>{{ $user1['id'] }}</td>
    <td>{{ $user1['name'] }}</td>
    <td>{{ $user1['email'] }}</td>
 @endforeach
 </tr>
</table>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <h2>User Samuele</h2>
        </div>
</div>
</div>

 <table class="table table-bordered">
 <tr>
   <th>Id</th>
   <th>Name</th>
   <th>Email</th>
 </tr>
 @foreach ($data1 as $key => $user2)
 <tr>
    <td>{{ $user2['id'] }}</td>
    <td>{{ $user2['name'] }}</td>
    <td>{{ $user2['email'] }}</td>
 @endforeach
 </tr>

</table>
@endsection

