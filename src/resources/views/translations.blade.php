@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.edit').' '.trans('backpack::langfilemanager.texts') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-end" bp-section="page-header">
		<h1 bp-section="page-heading" class="mb-2">
			{{ trans('backpack::langfilemanager.translate') }}
		</h1>
		<p class="ms-2 ml-2 mb-2" bp-section="page-subheading">
			{{ trans('backpack::langfilemanager.site_texts') }}.</i>
		</p>
		@if ($crud->hasAccess('list'))
		<p class="ms-2 ml-2 mb-2" bp-section="page-subheading-back-button">
			<small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{
					trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
		</p>
		@endif
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="box">
  	<div class="box-header with-border">
	  <div class="box-title float-right float-end pr-1">
		<small>
			 &nbsp; {{ trans('backpack::langfilemanager.switch_to') }}: &nbsp;
			<select name="language_switch" id="language_switch">
				@foreach ($languages as $lang)
				<option value="{{ url(config('backpack.base.route_prefix', 'admin')."/language/texts/{$lang->abbr}") }}" {{ $currentLang == $lang->abbr ? 'selected' : ''}}>{{ $lang->name }}</option>
				@endforeach
			</select>
		</small>
	  </div>
	</div>
    <div class="box-body">
		<ul class="nav nav-tabs">
			@foreach ($langFiles as $file)
			<li class="nav-item">
				<a class="nav-link {{ $file['active'] ? 'active bg-white' : '' }}" href="{{ $file['url'] }}">{{ $file['name'] }}</a>
			</li>
			@endforeach
		</ul>
		<section class="tab-content bg-white p-3 lang-inputs mb-2">
		@if (!empty($fileArray))
			<form
				method="post"
				id="lang-form"
				class="form-horizontal"
				data-required="{{ trans('admin.language.fields_required') }}"
		  		action="{{ url(config('backpack.base.route_prefix', 'admin')."/language/texts/{$currentLang}/{$currentFile}") }}"
		  		>
				{!! csrf_field() !!}
				<div class="form-group row">
					<div class="col-sm-2">
						<h5>{{ trans('backpack::langfilemanager.key') }}</h5>
					</div>
					<div class="hidden-sm hidden-xs col-md-5">
						<h5>{{ trans('backpack::langfilemanager.language_text', ['language_name' => $browsingLangObj->name]) }}</h5>
					</div>
					<div class="col-sm-10 col-md-5">
						<h5>{{ trans('backpack::langfilemanager.language_translation', ['language_name' => $currentLangObj->name]) }}</h5>
					</div>
				</div>
				{!! $langfile->displayInputs($fileArray) !!}
				<hr>
				<div class="text-center">
					<button type="submit" class="btn btn-success submit">{{ trans('backpack::crud.save') }}</button>
				</div>
				</form>
				@else
					<em>{{ trans('backpack::langfilemanager.empty_file') }}</em>
				@endif
			</section>
    </div><!-- /.card-body -->
    	<p><small>{!! trans('backpack::langfilemanager.rules_text') !!}</small></p>
  </div><!-- /.card -->
@endsection

@section('after_scripts')
	<script>
		jQuery(document).ready(function($) {
			$("#language_switch").change(function() {
				window.location.href = $(this).val();
			})
		});
	</script>
@endsection
