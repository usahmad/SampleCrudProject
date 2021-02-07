<?php

use Illuminate\Support\Facades\Route;

$current_route = Route::currentRouteName();
?>
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md align-self-start">
    <div class="sidebar-content">
        <div class="card card-sidebar-mobile">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Navigation</h6>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item">
                        <a href="{{route('user.index')}}" class="nav-link {{$current_route === 'user.index' ? 'active' : ''}}">
                            <i class="fas fa-list"></i>
                            <span>List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('user.create')}}" class="nav-link {{$current_route === 'user.create' ? 'active' : ''}}">
                            <i class="fas fa-plus"></i>
                            <span>Create</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
