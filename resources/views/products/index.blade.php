@extends('layout2')

@section('content')


<div class="pull-left">
                <a class="btn btn-primary" href="{{ route('products.create') }}"> Create New Product</a>
            </div>
            @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
            <table class="table table-striped  mt-5" id="data-table">
  <thead>

    <tr>
      <th scope="col">Id</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <!-- <tbody>
    @foreach($product as $pro)
    <tr>
        <td>{{ ++$i }}</td>
      <td><img src="images/{{$pro->image}}" class="rounded-circle" height="44" width="44"/></td>
      <td>{{$pro->name}}</td>

      <td>{{number_format($pro->price,2)}}</td>

      <td>
                <form action="{{ route('products.destroy',$pro->id) }}" method="POST">
                   <a href="{{route('products.edit',$pro->id)}}" class="btn btn-info"> <i class='fa fa-edit'></i>Edit</a>
                    @csrf
                    @method('DELETE')
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'><i class='fa fa-trash '></i>Delete</button>
                </form>
            </td>
    </tr>
    @endforeach
  </tbody> -->
</table>




<script>
    $(function () {

        $('#data-table').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            pagination: true,
            sorting: true,
            ajax: {
                    url: "{{ route('product-list-json') }}",
                    type: 'POST',
                    data : {
                        _token: "{{ csrf_token() }}"
                    }
                },

            dataType: 'json',
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'image', name: 'image',
                render: function( data, type, full, meta ) {
                    return "<img src=\"/images/" + data + "\" height=\"50\"/>";
                }
            },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            {
                data:'id',name:'status',
                render:function(data, type, full, meta)
                {
                //console.log(full.status);
                    var id=data;
                    var checked = full.status ? 'checked' : '';
                    //console.log(id);
                    return '<input data-id='+id+' class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" '+checked+' >';

                }
            },
            { data: 'id', name: 'action',
            render: function( data, type, full, meta ) {
                // console.log(data);
                var url = '{{ route("edit", '') }}'+'/'+data;
                //console.log("url ---> ",url);
                return  '<button class="btn btn-danger" onclick="deleteConfirmation('+data+')"></i>Delete</button><a class="btn btn-primary" href='+url+'></i>edit</a>';

        }
        },

        ]
        });
    });

</script>

<script>
 $(document).ready(function(){

    // $('.toggle-class').change(function() {
        $('body').on('change', '.toggle-class', function(e) {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var id = $(this).data('id');
         console.log("--> ",id);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{ route('changeStatus') }}',
           // headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            data: {
               '_token': "{{ csrf_token() }}",
              'status': status,
               'id': id
              },

            success: function(data){
               // console.log("data",data);
                if(data.success)
                {
                    toastr.success(data.success);
                }
            },
        });
    })
  })
</script>

<script type="text/javascript">
    function deleteConfirmation(id) {
        swal({
            title: "Delete?",
            icon: 'question',
            text: "Please ensure and then confirm!",
            type: "warning",
            icon: "warning",
              buttons: true,
              dangerMode: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e == true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('delete') }}",

                    data: {
                      _token: CSRF_TOKEN,
                      id:id
                    },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {

                            swal("Done!", results.message, "success");


                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });

            } else {
                e.dismiss;
            }

        }, function (dismiss) {
            return false;
        })
    }

</script>



<!-- <script type="text/javascript">

     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });

</script>          -->

@endsection
