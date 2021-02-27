@extends('master')
@section('title', 'Department Name')
<div class="content-page">
    <div class="content"> <!--container-->
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
              @extends('search')
                    <h4 class="mb-1 mt-0">Department [<a href="departmentNew">add</a>] [<a href="#" class="right-bar-toggle">search</a>] [<a href="department">all</a>]</h4>
                </div>
            </div>

            <div class="right-bar"><!--search-->
                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="right-bar-toggle float-right">
                        <i data-feather="x-circle"></i>
                    </a>
                    <p>&nbsp;</p>
                    <form action="search" method="get">
                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                            <div class="toast-header">
                                <strong class="mr-auto">Search</strong>
                            </div>
                            <div class="toast-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="type name, etc" name="txt_search" />
                                </div>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body"><!--content-->

                            @if(Session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session('status') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Department Name</th>
                                            <th style="text-align: right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data">
                                        @foreach($data as $a)
                                        <tr>
                                            <td style="vertical-align:middle">{{ $a->department_name }}</td>
                                            <td style="vertical-align:middle; text-align:right"><a href="departmentDetail/{{ Crypt::encrypt($a->department_id) }}"><i class="uil uil-pen"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br/>
                                {{ $data->links() }}

                            </div>
                        </div><!--end content-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- end container -->
