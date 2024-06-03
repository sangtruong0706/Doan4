@extends('client.layouts.app')
@section('content')
<div class="header_height"></div>
<div class="breadcrumb_section">
   <div class="container">
      <div class="grid">
         <div class="grid__item one-whole">
            <div class="breadcrumb_item">
               <!-- /snippets/breadcrumb.liquid -->
               <ul>
                  <li><a href="{{ route("client.home") }}" title="Back to the frontpage">Home</a></li>
                  <li>Change Password</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('client.account.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2>Change Password</h2>
                        </div>
                        <form action="" method="post" name="changePasswordForm" id="changePasswordForm">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="input-full form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">New Password</label>
                                        <input type="password" name="new_password" id="new_password" placeholder="New Password" class="input-full form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="input-full form-control">
                                        <p></p>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-dark">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('customJs')
    <script>
        $("#changePasswordForm").submit(function(event) {
            event.preventDefault();
            $.ajax ({
                url: '{{ route("account.changePassword") }}',
                type: 'post',
                dataType: 'json',
                data: $(this).serializeArray(),
                success: function (response) {
                    if (response.status == false) {
                        var error = response['errors'];
                        $("input[type='text'], select").removeClass('is-invalid');
                        $(".p_error").removeClass('invalid-feedback').html('');
                        $.each(error, function(key,value){
                            $(`#${key}`).addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(value);
                        });
                    }else {
                        $("input[type='text'], select").removeClass('is-invalid');
                        $("textarea[type='text'], select").removeClass('is-invalid');
                        $(".p_error").removeClass('invalid-feedback').html('');
                        // window.location.href = '{{ route("account.profile") }}';
                        window.location.reload();
                    }
                }
            })
        })
    </script>
@endsection
