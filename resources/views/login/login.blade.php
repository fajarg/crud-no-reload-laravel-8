@extends('layouts.app')

@section('content')
<div class="container">
<div id="success_message"></div>
<ul id="saveform_errList"></ul>
    <form>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="email form-control" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="password form-control">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="validate btn btn-primary">Submit</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.validate', function(e) {
            e.preventDefault();

            let data = {
                'email': $('.email').val(),
                'password': $('.password').val(),
            }

            // console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "/valid",
                data: data,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $("#saveform_errList").html("");
                        $("#saveform_errList").addClass("alert alert-danger");
                        $.each(response.errors, function(key, errValues) {
                            $("#saveform_errList").append('<li>' + errValues + '</li>')
                        });
                    } else {
                        $("#saveform_errList").html("");
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);
                        $("#AddStudentModal").find("input").val("");
                    }
                }
            });
        });
    });
</script>
@endsection