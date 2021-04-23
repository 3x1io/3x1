@extends('brackets/admin-ui::admin.layout.default')

@section('body')

    <div class="welcome-quote">

	    <blockquote>
		    {{ explode(" - ", $inspiration)[0] }}
		    <cite>
			    {{ explode(" - ", $inspiration)[1] }}
		    </cite>
	    </blockquote>

    </div>

@endsection