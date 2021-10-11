@extends('layouts.app')

@section('content')
<!-- Add student modal -->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="saveform_errList"></ul>

                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="text" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Course</label>
                    <input type="text" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_student">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- end of Add student modal -->

<!-- Edit student modal -->
<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit & Update Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="updateform_errList"></ul>

                <input type="hidden" id="edit_stud_id">

                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" id="edit_name" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="text" id="edit_email" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" id="edit_phone" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Course</label>
                    <input type="text" id="edit_course" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update_student">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- end of Edit student modal -->


<!-- Delete student modal -->
<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="delete_stud_id">
                <h4>Are you sure want to delete this data?</h4>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_student_btn">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of Delete student modal -->

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div id="success_message"></div>
            <div class="card">
                <div class="card-header">
                    <h4>Students Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-primary float-end btn-sm">Add Student</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered tabled-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        fetchstudent();

        function fetchstudent() {
            $.ajax({
                type: "GET",
                url: "/fetch-students",
                dataType: "json",
                success: function(response) {
                    $('tbody').html("");
                    // console.log(response.students);
                    $.each(response.students, function(key, item) {
                        $('tbody').append(`
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.name}</td>
                                <td>${item.email}</td>
                                <td>${item.phone}</td>
                                <td>${item.course}</td>
                                <td><button type="button" value="${item.id}" class="edit_student btn btn-primary btn-sm">edit</button></td>
                                <td><button type="button" value="${item.id}" class="delete_student btn btn-danger btn-sm">delete</button></td>
                            </tr>
                        `);
                    });
                }
            });
        }

        $(document).on("click", ".delete_student", function(e) {
            e.preventDefault();
            let stud_id = $(this).val();
            // alert(stud_id);
            $('#delete_stud_id').val(stud_id);
            $('#DeleteStudentModal').modal('show');
        });

        $(document).on("click", ".delete_student_btn", function(e) {
            e.preventDefault();
            let stud_id = $('#delete_stud_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-student/" + stud_id,
                success: function(response) {
                    // console.log(response);
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#DeleteStudentModal').modal('hide');
                    fetchstudent();
                }
            });
        });

        $(document).on('click', '.edit_student', function(e) {
            e.preventDefault();
            let stud_id = $(this).val();
            // console.log(stud_id);
            $('#EditStudentModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-student/" + stud_id,
                success: function(response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                    } else {
                        $('#edit_name').val(response.student.name);
                        $('#edit_email').val(response.student.email);
                        $('#edit_phone').val(response.student.phone);
                        $('#edit_course').val(response.student.course);
                        $('#edit_stud_id').val(stud_id);
                    }
                }
            });
        });

        $(document).on('click', '.update_student', function(e) {
            e.preventDefault();

            $(this).text("Updating");

            let stud_id = $('#edit_stud_id').val();
            let data = {
                'name': $('#edit_name').val(),
                'email': $('#edit_email').val(),
                'phone': $('#edit_phone').val(),
                'course': $('#edit_course').val(),
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/update-student/" + stud_id,
                data: data,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $("#updateform_errList").html("");
                        $("#updateform_errList").addClass("alert alert-danger");
                        $.each(response.errors, function(key, errValues) {
                            $("#updateform_errList").append('<li>' + errValues + '</li>')
                        });
                        $(".update_student").text("Update");

                    } else if (response.status == 404) {
                        $("#updateform_errList").html("");
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);
                        $(".update_student").text("Update");

                    } else {
                        $("#updateform_errList").html("");
                        $("#success_message").html("");
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);

                        $("#EditStudentModal").modal("hide");
                        $(".update_student").text("Update");
                        fetchstudent();
                    }
                }
            });
        });

        $(document).on('click', '.add_student', function(e) {
            e.preventDefault();

            let data = {
                'name': $('.name').val(),
                'email': $('.email').val(),
                'phone': $('.phone').val(),
                'course': $('.course').val()
            }

            // console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/students",
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
                        $("#AddStudentModal").modal("hide");
                        $("#AddStudentModal").find("input").val("");
                        fetchstudent();
                    }
                }
            });
        });
    });
</script>
@endsection