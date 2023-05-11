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




    <table id="dataTable" class="table table-bordered">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">status</th>
                <th scope="col">Action</th>
             </tr>
        </thead>
        <tbody></tbody>
    </table>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add books</h5>

              </div>
            <div class="modal-body" >

                <table id="datatables" class="table">
                    <thead>

                       <tr>
                           <th scope="col">#</th>
                           <th scope="col">Id</th>
                           <th scope="col">Fname</th>
                           <th scope="col">Lname</th>
                           <th scope="col">Detail</th>
                           <th scope="col">Price</th>
                           {{-- <th scope="col">Product name</th> --}}
                           <th scope="col">Action</th>
                        </tr>
                   </thead>
                   <tbody>
                   </tbody>
                 </table>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" name="submit" id="savebtn"
              >Save changes</button>
            </div>
          </div>
        </div>
    </div>



<script>
   $(document).ready(function() {

        $('#dataTable').DataTable({
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

                    return "<img src=\"/image/" + data + "\" height=\"50\"/>";
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
//                     return `<div class="form-check form-switch">
//   <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">

// </div>`;
                     return
     '<div class="form-check form-switch"><input data-id='+id+' class="toggle-class form-check-input"  role="switch" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" '+checked+' ></div>';

                }
            },
            { data: 'id', name: 'action',
            render: function( data, type, full, meta ) {
                //console.log(data);
                var url = '{{ route("edit", '') }}'+'/'+data;
                //console.log("url ---> ",url);
                return  '<button class="btn btn-danger" onclick="deleteConfirmation('+data+')"></i>Delete</button><a class="btn btn-primary" href='+url+'></i>edit</a><button type="button" id="show" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'+data+'">show</button>';

        }
        },

        ],


            "order": [
            [0, 'desc']
            ],
            'columnDefs': [{
            'targets': [5], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            },
           {
            "visible": false,
            "targets": [0]
           }]
        });



    });

</script>

<script>
    var table1 = $('#datatables').DataTable();
    $('body').on('click', '#show', function() {
        var id=$(this).data("id");
        console.log(id);
        table1.destroy();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        table1= $('#datatables').DataTable({


            searching: true,
            processing: true,
            serverSide: true,
            pagination: true,
            sorting: true,
             ajax:{
                url:"{{ route('index.indexjson') }}",
                type: 'POST',
                data: {

                    product_id:id,

                },
             },
             dom: 'Blfrtip',
             buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                       columns: [1,2,3,4,5,6] // Column index which needs to export
                   }
               },
               {
                   extend: 'csv',
                   exportOptions: {
                       columns: [0,1,2,3,4,5,6] // Column index which needs to export
                   }
               },
               {
                   extend: 'excel',
               }
             ],
             dataType: 'json',
             columns: [
                {
                  data: 'id',
                  render: function (data,type, row) {


                  return '<input type="checkbox" class="checkbox" name="item[]" value="'+data+'">';
                  }
                },
                 { data: 'id', name: 'id' },

                 { data: 'fname', name: 'fname' },
                 { data: 'lname', name: 'lname' },
                 { data: 'detail', name: 'detail' },
                 { data: 'price', name: 'price' },
                //  { data: 'product_data',
                //     render: function (data,type, row) {
                //       return data.name;
                //  },
                //  },

                 {
                  data: 'id',
                  render: function (data,type, row) {
                    var url = '{{ route("item.edit", '') }}'+'/'+data;
                    //console.log(url);
                  return '<button class="btn btn-danger" onclick="deleteRecord(' + data + ')">Delete</button><a href='+url+' class="btn btn-primary">Edit</a>';
                  }
                },
                ],
                "order": [
        [0, 'desc']
        ],
        'columnDefs': [{
        'targets': [5], // column index (start from 0)
        'orderable': false, // set orderable false for selected columns
        },
       {
        "visible": false,
        "targets": [0]
       }]


    });



});
    </script>

          <script>
            $(function(){
                $('#datepicker').datepicker();
            });
        </script>
          <script>
            $(function(){
                $('#datepickers').datepicker();
            });
        </script>
<script>
   $(document).on('click', '#delete-btn', function (e) {
    e.preventDefault();
    var ids = [];

    $('input[name="item[]"]:checked').each(function () {
        ids.push($(this).val());
    });


        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'

            }).then((result) => {
                if (result.isConfirmed) {

                 $.ajax({
                url: "{{ route('item.multi-delete')}}",
                type: 'POST',
                data: {
                    id: ids,
                    _token: $('input[name=_token]').val()
                },

                success: function (data) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your selected items have been deleted.",
                        icon: 'warning',
                      }).then((result) => {
                        window.location.href='{{ route('item.index') }}'
                      });
                },

            });
        };
        });

});

</script>
        <script>
            function deleteRecord(id)
            {
                 $.ajaxSetup({
                   headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
                $.ajax({
                   url:"{{ route('item.delete') }}",
                   type: "DELETE",
                   dataType: 'JSON',
                   data: {
                     '_token': "{{ csrf_token() }}",
                     'id': id
                    },
                    success: function () {
                     $('#datatable').DataTable().ajax.reload();
                     },

                });
            }
        </script>

<script>



    $('body').on('click', '#filter', function(e) {

        table1.ajax.reload( null, false );
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
         Swal.fire({
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
            reverseButtons: !0,
           }).then(function (e) {
            if (e == true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('delete') }}",

                    data: {
                      _token: CSRF_TOKEN,
                      id:id,
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
