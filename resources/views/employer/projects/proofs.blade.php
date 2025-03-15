@extends('layouts.app')
@section('title',config('app.name').' | Project Proof')

@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
           
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-transparent">
              <h3 class="mb-0">Project Proof</h3>
            </div>
            
          </div>

          <div class="card">
              <div class="card-header">
</div>
<div class="row">
    @if($proofs==NULL)
    <div class="col-md-4 col-xs-12"><h1>No data found</h1></div>
    @else
                      <div class="col-md-12 col-xs-12">
                        <div class="card">
                            <!-- Card body -->
                            <div class="card-body">
                                {!!$proofs->proof!!}
                            </div>
                            </div>
              @endif
                          </div>
              </div>
          </div>
        </div>
        </div>
        </div>
        
      </div>
      <!-- Footer -->
     
    </div>
@endsection