@extends('layout2')
@section('content')
@if ($message = Session::get('success'))
<script type="text/javascript">
    toastr.success("{{ session("success") }}");
  </script>
@endif

<table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($user as $detail)
        <tr>
            <th>{{ ++$i }}</th>
            <td>{{ $detail->name }}</td>
            <td>{{ $detail->email }}</td>
            <td><div class="form-check form-switch"><input data-id="{{ $detail->id }}"
                 class="toggle-class form-check-input"  role="switch" type="checkbox"
                  data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                   data-on="Active" data-off="InActive"  {{ $detail->status ? 'checked' : '' }}></div></td>
            <td><a class="btn btn-primary" href="{{ route('user.edit',$detail->id) }}">Edit</a></td>
          </tr>

        @endforeach


    </tbody>
  </table>

  <script>
    $(function() {
      $('.toggle-class').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');

          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('changeStatus') }}',
              data: {'status': status, 'id': id},
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>
@endsection
