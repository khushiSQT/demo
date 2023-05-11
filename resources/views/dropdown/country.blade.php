@extends('layout2')

@section('content')




<select class="form-select" id="country">
    @foreach ($data as $con)
    <option value="{{ $con->id }}">{{ $con->country_name }}</option>
    @endforeach
  </select>

  <div class="form-group mb-3">
    <select id="state" class=" form-control" >

    </select>
  </div>
  <div class="form-group">
    <select id="city-dd" class="form-control">

    </select>
  </div>


  <script>
     $(document).ready(function () {
        $('#country').on('change', function () {

            var id= this.value;
            //console.log(id);
            $("#state").html('');
            $.ajax({
                url: "{{route('dropdown.state')}}",
                type:"POST",
                data:{
                    country_id: id,
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (result) {
                    //console.log(result);
                        var html = '';
                        $.each(result, function (key, value) {

                            console.log(value.states_name);
                            html +=  '<option value="' + value
                                .id + '">' + value.states_name + '</option>';
                        });
                            $("#state").html(html);

                },
            });

        });
    });

        $('body').on('change', '#state', function () {

            var id = this.value;
                //console.log(id);

                $("#city-dd").html('');
                $.ajax({
                    url: "{{route('dropdown.city')}}",
                    type: "POST",
                    data: {
                        state_id: id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                            var html='';
                        $.each(result, function (key, value) {
                            console.log(value);
                            html+='<option value="' + value
                                .id + '">' + value.city_name + '</option>';
                        });
                        $('#city-dd').html(html);
                    }
                });

        });



  </script>

@endsection
