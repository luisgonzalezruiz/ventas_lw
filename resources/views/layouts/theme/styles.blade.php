
{{-- <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet"> --}}

<link href="{{ asset('theme/css/loader.css') }}" rel="stylesheet" type="text/css" />

{{-- <link href="{{ asset('theme/css/main.css') }}" rel="stylesheet" type="text/css" /> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link href="{{ asset('theme/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link href="{{ asset('theme/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('theme/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" class="dashboard-sales" />
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

{{-- <link href="{{ asset('theme/plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css"> --}}
<link href="{{ asset('extra/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css" />

<!-- Styles -->
<link href="{{ asset('theme/css/custom.css') }}" rel="stylesheet" type="text/css" />

<style>
    aside {
        display: none !important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #3b3f5c;
        border-color: #3b3f5c;
    }

    @media (max-width: 480px) {
        .mtmobile {
            margin-bottom: 20px !important;
        }

        .mbmobile {
            margin-bottom: 10px !important;
        }

        .hideonsm {
            display: none !important;
        }

        .inblock {
            display: block;
        }

    }

    /*
    .sidebar-theme #compactSidebar{
        background: #191e3a !important;
    }
    .header-container .sidebarCollapse {
         color: #3b3f5c !important;
    } */



</style>

@livewireStyles
