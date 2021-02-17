@extends('master')
@section('title', 'AMOR Home')
<div class="content-page">
    <div class="content"> <!--container--> 
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0">Users {{Session::get('full_name') }}</h4>
                    {{Session::get('LOGIN') }}
                </div>
            </div>
        </div>
    </div>
</div>