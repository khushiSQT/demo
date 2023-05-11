@extends('layout2')
@section('content')

<div class="pull-left">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add book
      </button>

</div>
<form method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
    @csrf
    <div id="myTable" class="row">


    </div>
    <div class="form-group col-lg-3 mt-4">

        <button class=" btn btn-primary" type="submit" name="submit" id="submit">submit</button>
    </div>
</form>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add books</h5>

          </div>
        <div class="modal-body" >

              <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control" id="name" name="name"  placeholder="Enter name">
                </div>

                <div class="form-group">
                <label for="price">price</label>
                <input type="number" class="form-control" id="price" name="price"  placeholder="Enter price">
                </div>

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
       $(document).ready(function(){

                var count =0;
                $("#savebtn").click(function(event){

                        event.preventDefault();
                        count++;

                    var name = $("#name").val();
                    var price = $("#price").val();
                    var row = `<div class="row" id="row_${count}">
                                    <div class="col-md-3">
                                        <input type="text" value="${name}" name="name">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" value="${price}" name="price">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="delete-button btn btn-primary"
                                          data-id="${count}" >remove</button>
                                    </div>
                                </div>`;
                    //console.log(row);
                    $('#myTable').append(row);

                });

            });


  </script>
  <script>

        $('body').on('click', '.delete-button', function() {
               var count = $(this).attr('data-id');
               //console.log('===> ',count);
                $(`#row_${count}`).remove();
            });


  </script>
@endsection
