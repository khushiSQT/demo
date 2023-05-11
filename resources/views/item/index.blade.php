@extends('layout2')

@section('content')


<div class="pull-left ">
    <a class="btn btn-primary" href="{{ route('item.create') }}">item</a>
    <a class="btn btn-primary" href="{{ route('item.multiepledit') }}">Edit all</a>
    <button type="submit" class="btn btn-danger" id="delete-btn">Delete</button>
</div>
<div class="pull-left pt-4 pb-2">
    <label>Name:</label>
    <input type="text" id="name" name="fname">
    <label for="date" class="col-1 col-form-label">Date</label>
		<div class="col-3">
		<div class="input-group date" id="datepicker">
			<input type="text" class="form-control" id="created_at" name="created_at">
			<span class="input-group-append">
			<span class="input-group-text bg-light d-block">
				<i class="fa fa-calendar"></i>
			</span>
			</span>
		</div>

		</div>
        <label for="date" class="col-1 col-form-label">Date</label>
		<div class="col-3">
		<div class="input-group date" id="datepickers">
			<input type="text" class="form-control" id="updated_at" name="updated_at">
			<span class="input-group-append">
			<span class="input-group-text bg-light d-block">
				<i class="fa fa-calendar"></i>
			</span>
			</span>
		</div>

		</div>
    <button type="submit" class="btn btn-primary" id="filter">submit</button>
</div>

         <table id="datatable" class="table">
             <thead>

                <tr>

                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Fname</th>
                    <th scope="col">Lname</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Price</th>
                    <th scope="col">Product name</th>
                    <th scope="col">Action</th>
                 </tr>
            </thead>
            <tbody>
            </tbody>
          </table>


    <script>
        var table1 = '';
        $(document).ready(function() {
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            table1= $('#datatable').DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                pagination: true,
                sorting: true,
                 ajax:{
                    url:"{{ route('index.indexjson') }}",
                    type: 'POST',
                    data: function(data){
                        //console.log(data);
                        data.created_at=$('#created_at').val(),
                        data.updated_at=$('#updated_at').val(),
                        data.fname = $('#name').val(),

                        data._token= "{{ csrf_token() }}"
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
                     { data: 'product_data',
                        render: function (data,type, row) {
                          return data.name;
                     },
                     },
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





@endsection

