@extends('master')
@section('title','Add New User')
<div class="content-page">
    <div class="content"> <!--container-->
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0">New User [<a href="javascript:history.back(-1)">List</a>]</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body"><!--content-->

                            <div class="alert alert-info" role="alert">
                                Password must have minimum 6 characters, consist of lowercase, uppercase and number
                            </div>

                            @if(count($errors)>0)
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(Session::get('danger'))
                                <div class="alert alert-danger" role="alert">{{ Session::get('danger') }}</div>
                            @endif


                            <form action="add" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Name</label>
                                            <input type="text" class="form-control" name="full_name" autocomplete="off" value="{{ old('full_name') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Username</label>
                                            <input type="text" class="form-control" name="username" value="{{ old('username') }}"  />
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
                                                <option value="{{ $department_id -> department_id }}" {{ old('department_id')==$department_id -> department_id ? 'selected' : '' }}>{{ $department_id -> department_name }}</option>
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
                                        <option value="{{ $group_id -> group_id }}" {{ old('group_id')==$group_id -> group_id ? 'selected' : '' }}> {{ $group_id -> group_name }} </option>
                                        @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Superior</label>
                                        <select class="form-control" name="parent_user_id">
                                        <option value=""> -- Choose -- </option>
                                        @foreach($parent_user_id as $parent_user_id)
                                        <option value="{{ $parent_user_id -> user_id }}" {{ old('parent_user_id')==$parent_user_id -> user_id ? 'selected' : '' }}> {{ $parent_user_id -> full_name}} </option>
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
                                        <option value="{{ $region_id -> region_id }}" {{ old('region_id')==$region_id -> region_id ? 'selected' : '' }}> {{ $region_id -> region_name}} </option>
                                        @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Password</label>
                                        <input type="password" class="form-control" name="password" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" autocomplete="off" />
                                        </div>
                                    </div>
                                    </div>
                                    <p>&nbsp;</p>
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="bmd-label-floating">Module Access</label>
                                        <br/>
                                        @foreach($nav_id as $nav_id)
                                        <input type="checkbox" name="nav_id[]" value="{{ $nav_id -> nav_id }}" {{ old('nav_id') == $nav_id->nav_id ? 'checked' : '' }}><i class="dark-white"></i> {{ $nav_id -> nav_name }}<br/>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Save" />
                            </form>

                        </div><!--end content-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- end container -->
