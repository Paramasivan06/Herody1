<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\IncompletedGig;
use App\Gig;

class RejectProofs implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id)
    {
        $this->id = $id;
        return $this;
    }
    public function view():View
    {
        
        $proofs = IncompletedGig::where(['job_id' => $this->id])->get();
        return view('employer.gigs.allrejectproof', [
            'proofs' => $proofs,
            'id' =>$this->id,
        ]);
    }
}



