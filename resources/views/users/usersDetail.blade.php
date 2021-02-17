@extends('master')
@section('title','User Detail')
<div class="content-page">
    <div class="content"> <!--container--> 
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0">User Detail [<a href="javascript:history.back(-1)">List</a>]</h4>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body"><!--content-->

                            <div class="alert alert-info" role="alert">
                                Password must have minimum 6 characters, consist of lowercase, uppercase and number
                            </div>
                            @foreach($user as $user)
                            <form action="/users/edit" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Name</label>
                                            <input type="text" class="form-control" name="full_name" autocomplete="off" value="{{ $user->full_name }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Username</label>
                                            <input type="text" class="form-control" name="username" value="{{ $user->username }}"  />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Active Status</label>
                                            <select class="form-control" required name="active_status">
                                                <option value="1" selected="selected">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Department</label>
                                            <select class="form-control" name="department_id">
                                                <option value=""> -- Choose -- </option>
                                                @foreach($department_id as $department_id)
                                                <option value="{{ $department_id -> department_id }}" {{ $user->department_id == $department_id -> department_id ? 'selected' : ''}}>{{ $department_id -> department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Group ID</label>
                                        <select class="form-control" name="group_id">
                                        <option value=""> -- Choose -- </option>
                                        @foreach($group_id as $group_id)
                                        <option value="{{ $group_id -> group_id }}" {{ $user->group_id == $group_id->group_id ? 'selected' : ''}}> {{ $group_id -> group_name }} </option>
                                        @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Superior</label>
                                        <select class="form-control" name="parent_user_id">
                                        <option value=""> -- Choose -- </option>
                                        @foreach($user_id as $user_id)
                                        <option value="{{ $user_id -> user_id }}" {{ $user->parent_user_id == $user_id->user_id ? 'selected' : ''}}> {{ $user_id -> full_name}} </option>
                                        @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Region</label>
                                        <select class="form-control" name="region_id">
                                        <option value=""> -- Choose -- </option>
                                        @foreach($region_id  as $region_id)
                                        <option value="{{ $region_id -> region_id }}" {{ $user->region_id == $region_id->region_id ? 'selected' : '' }}> {{ $region_id -> region_name}} </option>
                                        @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Password</label>
                                        <input type="password" class="form-control" name="txt_password" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Confirm Password</label>
                                        <input type="password" class="form-control" name="txt_password2" autocomplete="off" />
                                        </div>
                                    </div>
                                    </div>
                                    <p>&nbsp;</p>
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Module Access</label>
                                        <br/>
                                        @foreach($nav_menu_id as $nav_menu_id)
                                        <input type="checkbox" name="nav_menu_id[]" value="{{ $nav_menu_id -> nav_menu_id }}" {{ $nav_menu_id->ada > 0 ? 'checked' : ''}}><i class="dark-white"></i> {{  $nav_menu_id -> nav_header_name}} - {{ $nav_menu_id -> nav_menu_name }}<br/>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Save" />
                            </form>
                            @endforeach

                        </div><!--end content-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- end container -->