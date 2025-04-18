@extends('layouts.master')
@section('title', 'Services Dashboard')

@section('extra_styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('extra_header_block')
    <div class="header-dashboard">
        <h1 class="header-title">Services Dashboard</h1>
        <div class="header-stats">
            <span class="count">{{ count($services) }}</span> Orders Today
        </div>
    </div>
@endsection
@php
@endphp
@section('main_content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="mb-8">
                @if($services)
                    <form action="{{ route('stop_engine') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-custom btn-stop-all-services">
                            <i class="bi bi-stop-fill me-2"></i> Stop All Services
                        </button>
                    </form>
                @else
                   <form action="{{ route('start_engine') }}" method="POST">
                        @csrf
                        <button type="submit" class="server-start-btn server">
                            <i class="bi bi-play-fill me-2 start-icon"></i> Start All Services
                        </button>
                    </form>
                @endif
            </div>

            @if($services)
                <div class="row g-6">
                    @foreach($services as  $key => $service)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="card-service">
                                <div class="card-service-header">
                                    <h3 class="card-service-title">{{ $service['name'] }}</h3>
                                    <span class="badge-status badge-status-{{ $service['state'] == 'running' ? 'running' : ($service['state'] == 'exited' ? 'exited' : 'other') }}">
                                        <i class="dashboard_fa_icon bi bi-{{ $service['state'] == 'running' ? 'cloud-check-fill' : ($service['state'] == 'exited' ? 'x-circle-fill' : 'cloud-check-fill') }}"></i>
                                        {{ ucfirst($service['state']) }}
                                    </span>
                                </div>
                                <div class="card-service-body">
                                    <div class="info-service">
                                        <div>
                                            <div class="info-service-label">Status</div>
                                            <div class="info-service-value">{{ $service['status'] }}</div>
                                        </div>
                                        <div>
                                            <div class="info-service-label">IPAddress</div>
                                            <div class="info-service-value">{{ $service['ip'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-service-footer">
                                    <a href="{{ route('command_execution', $service['id']) }}" class="btn-custom btn-custom-outline">
                                        <i class="bi bi-terminal me-2"></i> Run Command
                                    </a>
                                    <a href="{{ route('view_logs', $service['id']) }}" class="btn-custom btn-custom-outline">
                                        <i class="bi bi-file-text me-2"></i> View Logs
                                    </a>
                                    @if('running' == 'running' && $key==0)
                                    <div style="display: flex; gap: 10px;">
                                        <form  class="col-12" action="{{ route('stop_service', $service['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-custom stop-button"><i class="bi bi-pause-fill me-2 stop-icon"></i>Stop</button>
                                        </form>
                                        <form class="col-12" action="{{ route('restart_service', $service['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-custom server-start-btn"><i class="bi bi-arrow-repeat me-2 start-icon"></i>Restart</button>
                                        </form>
                                    </div>
                                    @elseif($service['state'] == 'exited' || $service['state'] == 'stopped')
                                        <form action="{{ route('start_service', $service['id']) }}" class="col-12" method="POST">
                                            @csrf                                          
                                            <button type="submit" class="btn-custom  server-start-btn server-start-btn-custom"><i class="bi bi-play-fill me-2 start-icon"></i>Start</button>
                                        </form>
                                    @else
                                    <div class="col-12">
                                         <span class="text-muted mt-1 mb-4" style="float: right;">No actions available</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-services-container">
                    <iframe src="https://lottie.host/embed/92787ad9-5de7-4213-8018-d71a7b2c516a/mKe8CyuvzR.json" style="border: none; width: 200px; height: 200px; margin: 0 auto;"></iframe>
                    <h2 class="no-services-title">No Active Services</h2>
                    <p class="no-services-text">Get started by activating your services to manage and process orders efficiently.</p>
                    <form action="{{ route('start_engine') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-custom btn-primary">
                            <i class="bi bi-rocket-takeoff-fill me-2"></i> Activate Services
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Accessibility: Enhance focus styles
            document.querySelectorAll('.btn-custom').forEach(button => {
                button.addEventListener('focus', () => {
                    button.style.outline = `2px solid ${getComputedStyle(document.documentElement).getPropertyValue('--clr-primary')}`;
                    button.style.outlineOffset = '2px';
                });
                button.addEventListener('blur', () => {
                    button.style.outline = 'none';
                });

                // Smooth scroll for anchor links
                if (button.tagName === 'A' && button.getAttribute('href').startsWith('#')) {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        document.querySelector(button.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
                    });
                }
            });
            document.querySelectorAll('.card-service').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
@endsection