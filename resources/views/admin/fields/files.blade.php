@foreach($model->files as $file)
<a href="{{Storage::disk('admin')->url($file)}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> {{pathinfo($file)['basename']}}</a><br>
@endforeach