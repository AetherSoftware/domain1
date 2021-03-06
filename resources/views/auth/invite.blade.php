@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">邀请注册</div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">{{ session('status') }}</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="get" action="{{ action('Auth\RegisterController@getRegister') }}">
						<!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->

						<div class="form-group">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-6">
								目前本站采用邀请注册 请填写邀请码
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">邀请码</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="invite_code" value="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									确定
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
