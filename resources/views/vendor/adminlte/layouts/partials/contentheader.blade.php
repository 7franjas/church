<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('content_header', 'Page Header here')
        <small>@yield('content_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('adminlte_lang::message.level') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.here') }}</li>
    </ol>
</section>