@extends('layout2')

@section('content')


@if(session()->has('message'))
<div class="alert alert-danger">
<strong>Whoops!</strong> There were some problems with your input.<br><br>
<ul><li>
    {{ session()->get('message') }}
</li></ul>
</div>
    @endif
    <div class="pull-left">
        <a class="btn btn-primary" href="{{ route('item.index') }}">item</a>
    </div>
<form id="repeater-form" action="{{ route('item.update',$item->id) }}" method="POST"  enctype="multipart/form-data">
    @csrf

    <div  class="banner-repeater-default">
        <div data-repeater-list="group">
            <div data-repeater-item>
                <div class="repeater-field col-lg-12 d-flex ">
                    <div class="form-group col-lg-3">
                        <label for="name">first name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="{{ $item->fname }}"  placeholder="Enter name">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="name">last name</label>
                        <input type="text" class="form-control" id="lname" name="lname"  value="{{ $item->lname }}" placeholder="Enter name">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="name">detail</label>
                        <input type="text" class="form-control" id="detail" name="detail" value="{{ $item->detail }}"  placeholder="Enter detail">
                    </div>

                </div>
            </div>


        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
           <label class="bmd-label-floating">Price</label>
           <input type="text" class="form-control" id="priceBalance">
        </div>
     </div>
     <div class="col-md-4">
        <div class="form-group">
           <label class="bmd-label-floating">Discount (%)</label>
           <input type="text" class="form-control" id="priceDiscount">
        </div>
     </div>
     <div class="col-md-4">
        <div class="form-group">
           <label class="bmd-label-floating">Price After Discount</label>
           <input type="text" class="form-control" id="priceResult" name="price">
        </div>
     </div>

    <div class="form-group col-lg-3 mt-4">

        <button class=" btn btn-primary" type="submit" name="submit" id="submit">submit</button>
    </div>
</form>
<script>
$(document).on("change keyup blur", "#priceDiscount", function() {
     var main = $('#priceBalance').val();
     var disc = $('#priceDiscount').val();
     var dec  = (disc / 100).toFixed(2); //its convert 10 into 0.10
     var mult = main * dec; // gives the value for subtract from main value
     var discont = main - mult;
     $('#priceResult').val(discont);
   });



</script>
@endsection

