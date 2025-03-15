<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Project;

class AllProjects implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $projects = Project::get();
        
        return view('admin.exports.allprojects', [
            'projects' => $projects,
        ]);
    }
}
