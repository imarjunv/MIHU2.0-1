@extends('layouts.default') @section('content')
<div class="container">
   @if(Session::has('success'))
   <div class="alert alert-info">
      {{ Session::get('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   @endif
   <script>
      $(document).ready( function () {
       $('#cordunteer').DataTable();
      } );
   </script>
   <style type="text/css">
      body{
      color:white;
      }
   </style>
   <h2 class="display-4" style="color:white;">Staff Volunteers</h2>
   <br>
   <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
         <a class="nav-item nav-link active" id="nav-student-tab" data-toggle="tab" href="#nav-student" role="tab" aria-controls="nav-student" aria-selected="true">Staff</a>
      </div>
      <br>
      @if(!Auth::guest())
      <a class="btn btn-primary " href="{{ url('/staffvolunteer/create') }}" role="button" >Add New +</a>
      <a  id="xlsf" href="{{ URL::to('downloadExcel/staff/xls') }}"><button class="btn btn-info">Download Excel xls</button></a>
      <a id="xlsxf" href="{{ URL::to('downloadExcel/staff/xlsx') }}"><button class="btn btn-info">Download Excel xlsx</button></a>
      <a id="csvf" href="{{ URL::to('downloadExcel/staff/csv') }}"><button class="btn btn-info">Download CSV</button></a>
      @endif
      <br>
      <br>
   </nav>
   <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-student" role="tabpanel" aria-labelledby="nav-student-tab">
         <table id="cordunteer" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;color:white;">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Seva</th>
                  <th>Department</th>
                  @if(!Auth::guest())
                  <th>Update</th>
                  <th>Delete</th>
                  @endif
               </tr>
            </thead>
            <tbody>
               @foreach($staff as $cord)
               <tr>
                  <th>{{ $cord->name}}</th>
                  <th>{{ $cord->seva}}</th>
                  <th>{{ $cord->department}}</th>
                  @if(!Auth::guest())
                  <th><a class="btn btn-warning" href="{{ route('staffvolunteer.edit', $cord->id,'/edit') }}" role="button">Update</a></th>
                  <th>  {{ Form::open(['method' => 'DELETE', 'route' => ['staffvolunteer.destroy', $cord->id]]) }}
                     {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                     {{ Form::close() }}
                  </th>
                  @endif
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection