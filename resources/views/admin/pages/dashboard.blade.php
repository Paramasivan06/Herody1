<?php
    $missions = \App\Campaign::get();
?>
@extends('admin.master')

@section('title', 'Admin Dashboard')
@section('body')


    <h2 class="mb-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="d-flex border">
                <div class="badge-danger text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fas fa-3x fa-fw fa-pause"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <a href="{{route('admin.campaign.pendings')}}" style="text-decoration: none;"><p class="text-uppercase text-secondary mb-0">Pending Gigs</p></a>
                    <h3 class="font-weight-bold mb-0">{{count($pendingCampaigns)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex border">
                <div class="bg-warning text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-spinner"></i>

                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <a href="{{route('admin.campaign.all')}}" style="text-decoration: none;"><p class="text-uppercase text-secondary mb-0">In-Progress Gigs</p></a>
                    <h3 class="font-weight-bold mb-0">{{count($InProOrdersCampaigns)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex border">
                <div class="bg-success text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fas fa-3x fa-fw fa-check"></i>

                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <a href="{{route('admin.campaign.log')}}" style="text-decoration: none;"><p class="text-uppercase text-secondary mb-0">Complete Gigs</p></a>

                    <h3 class="font-weight-bold mb-0">{{count($LogCampaigns)}}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="d-flex border">
                <div class="customs_bd text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-users"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <a href="{{route('admin.member.all')}}" style="text-decoration: none;"><p class="text-uppercase text-secondary mb-0">All Members</p></a>

                    <h3 class="font-weight-bold mb-0">{{count($allUsers)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex border">
                <div class="customs_bd text-light p-4">
                    <div class="d-flex align-items-center h-100">
                         <i class="fa fa-3x fa-fw fa-list"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <a href="{{route('admin.show.withdraw.request')}}" style="text-decoration: none;"><p class="text-uppercase text-secondary mb-0"> Withdraw Request</p></a>
                    <h3 class="font-weight-bold mb-0">{{count($withdrawRequest)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex border">
                <div class="badge-warning text-light p-4">
                    <div class="d-flex align-items-center h-100">
                         <i class="fas fa-3x fa-fw fa-spinner"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <a href="{{route('admin.missions')}}" style="text-decoration: none;"><p class="text-uppercase text-secondary mb-0"> Campaigns</p></a>
                    <h3 class="font-weight-bold mb-0">{{count($missions)}}</h3>
                </div>
            </div>
        </div>
    </div>


@endsection