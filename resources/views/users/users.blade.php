@extends('master')
@section('title', 'User List')
<div class="content-page">
    <div class="content"> <!--container--> 
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
              @extends('search')
                    <h4 class="mb-1 mt-0">Users [<a href="usersNew">add</a>] [<a href="#" class="right-bar-toggle">search</a>] [<a href="users">all</a>]</h4>
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

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Department</th>
                                            <th>Last Login</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data">
                                        @foreach($user as $a)
                                        <tr>
                                            <td style="vertical-align:middle">{{ $a->full_name }} </td>
                                            <td style="vertical-align:middle">{{ $a->username }}</td>
                                            <td style="vertical-align:middle">{{ $a->department_name }}</td>
                                            <td style="vertical-align:middle">{{ $a->last_login }}</td>
                                            <td style="vertical-align:middle">{{ $a->user_id }}</td>
                                            <td style="vertical-align:middle; text-align:center"><a href="usersDetail/{{ Crypt::encrypt($a->user_id) }}"><i class="uil uil-pen"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br/>
                                {{$user->links()}}
                       
                            </div>
                        </div><!--end content-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> <!-- end container -->