<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DepartmentModel;

class DepartmentRule implements Rule
{

    protected $department_id;
    protected $department_name;

    public function __construct($department_id, $department_name)
    {
        $this->department_id = $department_id;
        $this->department_name = $department_name;
    }

    public function passes($attribute, $value)
    {
        $data = DepartmentModel::where('department_name','=',"'$this->department_name'")
                ->where('department_id', '!=', $this->department_id)
                ->get();

        foreach($data as $data) {
            return $data[0]->department_name;
        }

        return in_array(strtoupper($attribute, $value), [
            $data[0]->department_name
        ]);
        exit();

    }

    public function message()
    {
        return 'Duplicate data. Please type another value.';
    }
}
