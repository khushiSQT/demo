@extends('layout2')

@section('content')


@if(session()->has('message'))
<div class="alert alert-danger">
<strong>Whoops!</strong> There were some problems with your input.<br><br>
<ul><li>
    {{ session()->get('message') }}
</li></ul>
</div>+
    @endif
    <div class="pull-left">
        <a class="btn btn-primary" href="{{ route('item.index') }}">item</a>
    </div>
<form id="repeater-form" action="{{ route('item.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf

    <div  class="banner-repeater-default">
        <div data-repeater-list="group">
            <div data-repeater-item>
                <div class="repeater-field col-lg-12 d-flex ">
                    <div class="form-group col-lg-3">
                        <select  class="block w-full mt-1 rounded-md" name="p_name">
                            @foreach ($abc as $a)
                            <option  value="{{ $a->id }}" >
                                {{ $a->name }}
                            </option>
                            @endforeach
                        </select>

                     </div>
                    <div class="form-group col-lg-3">
                        <label for="name">first name</label>
                        <input type="text" class="form-control" id="fname" name="[0][fname]"  placeholder="Enter name">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="name">last name</label>
                        <input type="text" class="form-control" id="lname" name="[0][lname]"  placeholder="Enter name">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="name">detail</label>
                        <input type="text" class="form-control" id="detail" name="[0][detail]"  placeholder="Enter detail">
                    </div>
                    <div class="form-group col-lg-3 mt-4">
                    <button class="remove-field btn btn-primary" data-repeater-delete type="button" >Remove</button>
                    </div>
                </div>
            </div>


        </div>







        <div class="form-group col-lg-3 mt-4">
            <button class="add-field btn btn-primary"  data-repeater-create type="button" id="add-btn">add-btn</button>
            <button class=" btn btn-primary" type="submit" name="submit" >submit</button>
        </div>
    </div>





</form>

<script>
// $(document).ready(function () {
//     $('.add-field').click(function () {
//             var field = $('.repeater-field').first().clone();
//             field.find('input').val('');
//             $('#repeater-container').append(field);
//         });

//         // Remove field
//         $(document).on('click', '.remove-field', function () {
//             $(this).closest('.repeater-field').remove();
//         });



// });
$(document).ready(function () {
   // var no_of_banner = 0;
   $('.banner-repeater-default').repeater({

    //   hide: function(deleteElement) {
    //      $(this).slideUp(deleteElement);
    //      // no_of_banner--;
    //   },
    //   show: function(setIndexes) {
    //      $(this).slideDown();

    //   }

   });
});
</script>
@endsection

