<h3>Kategoriler</h3>
<ul class="list-group">
    @foreach(\App\Models\Category::all() as $k => $v)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{route('category.index', ['selflink' => $v['selflink']])}}">{{$v['name']}}</a>
            <span class="badge badge-primary badge-pill">{{\App\Models\QuestionCategory::getCount($v['id'])}}</span>
        </li>
    @endforeach
</ul>