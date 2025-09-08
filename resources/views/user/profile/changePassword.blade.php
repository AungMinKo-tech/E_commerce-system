@extends('user.layouts.master')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style="border-radius: 6px; overflow: hidden;">
                        <div class="panel-heading"
                            style="background:#f8f9fa; padding: 15px 20px; border-bottom:1px solid #eee;">
                            <h3 class="panel-title" style="margin:0; font-weight:600;">Change Password</h3>
                        </div>
                        <div class="panel-body" style="padding: 20px;">
                            <form id="changePasswordForm" action="{{route('user#changePassword')}}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password"
                                        class="form-control input-lg @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" placeholder="Enter current password">
                                    @error('current_password')
                                        <div class="invalid-feedback text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password"
                                        class="form-control input-lg @error('new_password') is-invalid @enderror"
                                        id="new_password" name="new_password" placeholder="Enter new password">
                                    @error('new_password')
                                        <div class="invalid-feedback text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password"
                                        class="form-control input-lg @error('confirm_password') is-invalid @enderror"
                                        id="confirm_password" name="confirm_password" placeholder="Re-enter new password">
                                    @error('confirm_password')
                                        <div class="invalid-feedback text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="text-right" style="margin-top:10px;">
                                    <a href="{{ route('user#home') }}" class="btn btn-default">Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Update
                                        Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
