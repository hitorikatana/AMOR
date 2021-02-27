@extends('master')
@section('title','Department Detail')
<div class="content-page">
    <div class="content"> <!--container-->
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0">Department Detail [<a href="javascript:history.back(-1)">List</a>]</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    @if(count($errors)>0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @if(Session('status'))
                      <div class="alert alert-danger" role="alert">
                          {{ Session('status') }}
                      </div>
                    @endif
                    <div class="card">
                        <div class="card-body"><!--content-->
                            @foreach($data as $data)
                            <form action="{{ route('department/edit') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="department_id" value="{{ Crypt::encrypt($data->department_id) }}" />
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Name</label>
                                            <input type="text" class="form-control" name="department_name" autocomplete="off" value="{{ $data->department_name }}" />
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
