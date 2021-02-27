<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\DepartmentModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Crypt;
Paginator::useBootstrap();

class DepartmentController extends Controller
{
    public function view() {
        $data = DepartmentModel::select('department_id', 'department_name')
                ->orderBy('department_name')
                ->paginate(20);
        return view('department/departmentList', ['data' => $data]);
    }

    public function search(Request $r) {
        $txt_search = $r->input('txt_search');
        $data       = DepartmentModel::select('department_id', 'department_name')
                        ->where('department_name', 'LIKE', '"%".$txt_search."%"')
                        ->paginate(20);
        $data       -> appends(['txt_search' => $txt_search]);
        return view('department/departmentList', ['data'=> $data]);
    }

    public function detail($id) {
        $id             = Crypt::decrypt($id);
        $data           = DepartmentModel::where('department_id',$id)->get();
        return view('department/departmentDetail', ['data' => $data]);
    }

    public function edit(Request $r) {
        $department_id      = Crypt::decrypt($r->input('department_id'));
        $department_name    = $r->input('department_name');

        //validate type data
        $error_message = [
            'department_name.required' => 'Please fill department name'
        ];
        $this->validate($r, [
            'department_name' => 'required|string'
        ], $error_message);

        //any duplicate data?
        $duplicate = DepartmentModel::where('department_name', $r->input('department_name'))
            ->where('department_id', '!=', $department_id)
            ->count();
        if($duplicate>0) {
            return redirect()->back()->with('status','Duplicate department name ya');

            //return Redirect::action('DepartmentController@detail', array('id' => $r->input('department_id')))->with('status','Duplicate department name');
        }

        //success, data updated
        $data = DepartmentModel::find($department_id);
        $data->department_name= $department_name;
        $data->save();
        return redirect('department/list')->with('status', 'Data updated successfully');

    }
}
